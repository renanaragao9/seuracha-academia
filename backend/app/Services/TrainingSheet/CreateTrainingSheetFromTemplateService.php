<?php

namespace App\Services\TrainingSheet;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\TrainingDivision;
use App\Models\TrainingExercise;
use App\Models\TrainingPlanTemplate;
use App\Models\TrainingSheet;
use App\Models\TrainingSheetDivision;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTrainingSheetFromTemplateService
{
    public function run(int $templateId, Student $student, int $createdBy): TrainingSheet
    {
        $template = TrainingPlanTemplate::findOrFail($templateId);

        return DB::transaction(function () use ($template, $student, $createdBy) {
            $templateData = $template->template_data;
            $divisions = $templateData['divisions'] ?? [];

            $sheet = TrainingSheet::create([
                'student_id' => $student->id,
                'created_by' => $createdBy,
                'updated_by' => $createdBy,
                'name' => $template->name,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => Carbon::now()->addMonths(3)->endOfMonth()->toDateString(),
                'is_active' => true,
            ]);

            foreach ($divisions as $divisionData) {
                $divisionName = $divisionData['training_division_name'] ?? null;
                $divisionOrder = $divisionData['order'] ?? 1;

                $trainingDivision = TrainingDivision::where('name', $divisionName)->first();

                if (! $trainingDivision) {
                    Log::warning("TrainingDivision not found: {$divisionName}, skipping.");
                    continue;
                }

                $sheetDivision = TrainingSheetDivision::create([
                    'training_sheet_id' => $sheet->id,
                    'training_division_id' => $trainingDivision->id,
                    'order' => $divisionOrder,
                ]);

                $exercises = $divisionData['exercises'] ?? [];

                foreach ($exercises as $exerciseData) {
                    $exerciseName = $exerciseData['exercise_name'] ?? null;

                    if (! $exerciseName) {
                        continue;
                    }

                    $exercise = Exercise::where('name', $exerciseName)->first();

                    if (! $exercise) {
                        Log::warning("Exercise not found: {$exerciseName}, skipping.");
                        continue;
                    }

                    TrainingExercise::create([
                        'training_sheet_division_id' => $sheetDivision->id,
                        'exercise_id' => $exercise->id,
                        'series' => $exerciseData['series'] ?? 3,
                        'repetitions' => (string) ($exerciseData['repetitions'] ?? '10'),
                        'rest_seconds' => $exerciseData['rest_seconds'] ?? 60,
                        'load' => null,
                        'observation' => $exerciseData['observation'] ?? null,
                        'order' => $exerciseData['order'] ?? 1,
                    ]);
                }
            }

            $sheet->load(['divisions.exercises.exercise', 'divisions.trainingDivision', 'student']);

            return $sheet;
        });
    }
}
