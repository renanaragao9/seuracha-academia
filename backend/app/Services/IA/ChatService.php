<?php

namespace App\Services\IA;

use App\Helpers\IaExtractHelper;
use App\Models\User;
use App\Prompts\ChatPrompt;
use App\Services\LLM\AnalyzeProfileService;
use App\Services\LLM\CreateMealPlanFromChatService;
use App\Services\LLM\CreateTrainingPlanFromChatService;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use MoeMizrak\LaravelOpenrouter\DTO\ChatData;
use MoeMizrak\LaravelOpenrouter\DTO\MessageData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;

class ChatService
{
    public function __construct(
        private readonly CreateTrainingPlanFromChatService $createTrainingPlanFromChat,
        private readonly AnalyzeProfileService $analyzeProfile,
        private readonly CreateMealPlanFromChatService $createMealPlanFromChat,
    ) {}

    public function run(array $data, User $user): array
    {
        $model = $data['model'] ?? config('llm.default_model', 'openai/gpt-4o-mini');
        $systemPrompt = $data['system_prompt'] ?? ChatPrompt::system();
        $history = $data['messages'] ?? [];

        try {
            $content = $this->callLLM($systemPrompt, $data['message'], $model, $history);
            $parsed = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['message' => $content];
            }

            return match ($parsed['action'] ?? null) {
                'create_training_plan' => $this->createTrainingPlanFromChat->handle($parsed, $user),
                'profile_analysis' => $this->analyzeProfile->handle($user, $model),
                'create_meal_plan' => $this->createMealPlanFromChat->handle($parsed, $user),
                default => ['message' => $content],
            };
        } catch (ConnectException $e) {
            Log::warning('IA Chat Timeout: '.$e->getMessage());
            throw new \RuntimeException('O serviço de IA demorou muito para responder. Tente novamente em instantes.');
        } catch (\Exception $e) {
            Log::error('IA Chat Error: '.$e->getMessage());
            throw $e;
        }
    }

    public function callLLM(string $systemPrompt, string $userMessage, string $model, array $history = []): string
    {
        $messages = [
            new MessageData(role: RoleType::SYSTEM, content: $systemPrompt),
        ];

        foreach ($history as $msg) {
            $role = $msg['role'] === 'user' ? RoleType::USER : RoleType::ASSISTANT;
            $messages[] = new MessageData(role: $role, content: $msg['content']);
        }

        $messages[] = new MessageData(role: RoleType::USER, content: $userMessage);

        $response = LaravelOpenRouter::chatRequest(
            new ChatData(
                model: $model,
                messages: $messages,
                temperature: config('llm.temperature', 0.7),
                max_tokens: config('llm.max_tokens', 2000),
            )
        );

        $choice = $response->choices[0];

        $content = \is_array($choice)
            ? $choice['message']['content']
            : $choice->message->content;

        return IaExtractHelper::extractJsonFromContent($content);
    }
}
