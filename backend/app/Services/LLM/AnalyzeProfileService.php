<?php

namespace App\Services\LLM;

use App\Models\Assessment;
use App\Models\Student;
use App\Models\User;
use App\Prompts\ProfileAnalysisPrompt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use MoeMizrak\LaravelOpenrouter\DTO\ChatData;
use MoeMizrak\LaravelOpenrouter\DTO\MessageData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;

class AnalyzeProfileService
{
    public function handle(User $user, string $model): array
    {
        $student = Student::where('user_id', $user->id)
            ->with(['trainingSheets.divisions.exercises'])
            ->first();

        if (! $student) {
            return ['message' => 'Não foi possível localizar seu perfil de aluno. Entre em contato com o administrador.'];
        }

        $profileData = $this->gatherStudentData($student);
        $userContext = ProfileAnalysisPrompt::userContext($profileData);

        $analysis = $this->sendToLLM(
            ProfileAnalysisPrompt::system(),
            $userContext,
            $model
        );

        return ['message' => $analysis];
    }

    private function sendToLLM(string $systemPrompt, string $userMessage, string $model): string
    {
        $response = LaravelOpenRouter::chatRequest(
            new ChatData(
                model: $model,
                messages: [
                    new MessageData(role: RoleType::SYSTEM, content: $systemPrompt),
                    new MessageData(role: RoleType::USER, content: $userMessage),
                ],
                temperature: config('llm.temperature', 0.7),
                max_tokens: config('llm.max_tokens', 2000),
            )
        );

        $choice = $response->choices[0];

        return \is_array($choice)
            ? $choice['message']['content']
            : $choice->message->content;
    }

    private function gatherStudentData(Student $student): array
    {
        $sheets = $student->trainingSheets;

        $workouts = $student->workoutLogs()
            ->with(['sheetDivision.trainingDivision', 'logExercises'])
            ->where('started_at', '>=', Carbon::now()->subDays(30))
            ->orderByDesc('started_at')
            ->get();

        $assessments = $student->assessments()
            ->with('items.measurementType')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return [
            'student' => [
                'name' => $student->name,
                'birth_date' => $student->birth_date?->format('d/m/Y') ?? 'N/A',
                'gender' => $student->gender ? __('students.genders.'.$student->gender) : 'N/A',
                'weight' => $student->weight ?? 'N/A',
                'height' => $student->height ?? 'N/A',
                'status' => $student->status ? __('students.statuses.'.$student->status) : 'N/A',
                'entry_date' => $student->entry_date?->format('d/m/Y') ?? 'N/A',
            ],
            'training_sheets' => [
                'total' => $sheets->count(),
                'active' => $sheets->where('is_active', true)->count(),
                'items' => $sheets->map(fn ($s) => [
                    'name' => $s->name,
                    'status' => $s->is_active ? 'Ativa' : 'Inativa',
                    'divisions' => $s->divisions->count(),
                    'exercises' => $s->divisions->sum(fn ($d) => $d->exercises->count()),
                ])->toArray(),
            ],
            'recent_workouts' => [
                'total' => $workouts->count(),
                'days' => 30,
                'avg_per_week' => $this->calcAvgWorkoutsPerWeek($workouts, $student->entry_date),
                'avg_duration' => (int) round($workouts->avg('duration_minutes') ?? 0),
                'items' => $workouts->map(fn ($w) => [
                    'date' => $w->started_at->format('d/m/Y H:i'),
                    'division' => $w->sheetDivision?->trainingDivision?->name ?? 'N/A',
                    'duration' => $w->duration_minutes ?? 0,
                    'exercises_count' => $w->logExercises->count(),
                ])->toArray(),
            ],
            'assessments' => [
                'total' => $assessments->count(),
                'items' => $assessments->map(fn (Assessment $a) => [
                    'name' => $a->name,
                    'date' => $a->created_at->format('d/m/Y'),
                    'measurements' => $a->items->map(fn ($i) => [
                        'type' => $i->measurementType?->name ?? 'N/A',
                        'value' => $i->value,
                        'unit' => $i->unit ?? '',
                    ])->toArray(),
                ])->toArray(),
            ],
        ];
    }

    private function calcAvgWorkoutsPerWeek(Collection $workouts, mixed $entryDate): string
    {
        if ($workouts->isEmpty()) {
            return '0';
        }

        $startDate = $entryDate
            ? max($entryDate, Carbon::now()->subDays(30))
            : Carbon::now()->subDays(30);

        $weeks = max(1, (int) ceil(Carbon::now()->diffInDays($startDate) / 7));

        return number_format($workouts->count() / $weeks, 1);
    }
}
