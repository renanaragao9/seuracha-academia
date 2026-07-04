<?php

namespace App\Services\LLM;

use App\Models\Student;
use App\Models\TrainingPlanTemplate;
use App\Models\TrainingSheet;
use App\Models\User;
use App\Services\TrainingSheet\CreateTrainingSheetFromTemplateService;
use Illuminate\Support\Facades\Log;

class CreateTrainingPlanFromChatService
{
    public function __construct(
        private readonly CreateTrainingSheetFromTemplateService $createTrainingSheetService,
    ) {}

    public function handle(array $parsed, User $user): array
    {
        $templateId = (int) ($parsed['template_id'] ?? 0);

        if ($templateId <= 0 || ! TrainingPlanTemplate::find($templateId)) {
            Log::warning('CreateTrainingPlanFromChat: template_id inválido.', ['template_id' => $templateId]);

            return ['message' => $parsed['message'] ?? 'Desculpe, não encontrei um plano adequado. Pode me dar mais detalhes sobre seu objetivo?'];
        }

        $student = Student::where('user_id', $user->id)->first();

        if (! $student) {
            return ['message' => $parsed['message'] ?? 'Seu plano de treino está pronto! Mas não foi possível vinculá-lo ao seu perfil. Entre em contato com o administrador.'];
        }

        $this->deactivateActiveSheets($student);

        $sheet = $this->createTrainingSheetService->run($templateId, $student, $user->id);

        return [
            'message' => $parsed['message'] ?? 'Seu plano de treino foi criado com sucesso!',
            'training_sheet' => [
                'id' => $sheet->id,
                'name' => $sheet->name,
                'created_at' => $sheet->created_at->toISOString(),
            ],
        ];
    }

    private function deactivateActiveSheets(Student $student): void
    {
        $count = $student->trainingSheets()->where('is_active', true)->update(['is_active' => false]);

        if ($count > 0) {
            Log::info('CreateTrainingPlanFromChat: fichas anteriores inativadas.', [
                'student_id' => $student->id,
                'count' => $count,
            ]);
        }
    }
}
