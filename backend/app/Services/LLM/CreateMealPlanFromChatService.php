<?php

namespace App\Services\LLM;

use App\Models\MealPlanTemplate;
use App\Models\Student;
use App\Models\User;
use App\Services\MealPlan\CreateMealPlanFromTemplateService;
use Illuminate\Support\Facades\Log;

class CreateMealPlanFromChatService
{
    public function __construct(
        private readonly CreateMealPlanFromTemplateService $createMealPlanFromTemplateService,
    ) {}

    public function handle(array $parsed, User $user): array
    {
        $templateId = (int) ($parsed['template_id'] ?? 0);

        if ($templateId <= 0 || ! MealPlanTemplate::find($templateId)) {
            Log::warning('CreateMealPlanFromChat: template_id inválido.', ['template_id' => $templateId]);

            return ['message' => $parsed['message'] ?? 'Desculpe, não encontrei um plano alimentar adequado. Pode me dar mais detalhes sobre seu objetivo?'];
        }

        $student = Student::where('user_id', $user->id)->first();

        if (! $student) {
            return ['message' => $parsed['message'] ?? 'Seu plano alimentar está pronto! Mas não foi possível vinculá-lo ao seu perfil. Entre em contato com o administrador.'];
        }

        $plan = $this->createMealPlanFromTemplateService->run($templateId, $student, $user->id);

        return [
            'message' => $parsed['message'] ?? 'Seu plano alimentar foi criado com sucesso!',
            'meal_plan' => [
                'id' => $plan->id,
                'name' => $plan->name,
                'created_at' => $plan->created_at->toISOString(),
            ],
        ];
    }
}
