<?php

namespace App\Services\WorkoutLog;

use App\Models\Student;
use App\Models\TrainingSheet;
use App\Models\TrainingSheetDivision;
use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use Illuminate\Support\Facades\DB;

class StoreWorkoutLogService
{
    public function run(User $user, array $data): ?WorkoutLog
    {
        $student = Student::query()
            ->where('user_id', $user->id)
            ->first();

        if (! $student) {
            return null;
        }

        $sheet = TrainingSheet::query()
            ->where('id', $data['training_sheet_id'])
            ->where('student_id', $student->id)
            ->first();

        if (! $sheet) {
            return null;
        }

        $sheetDivision = TrainingSheetDivision::query()
            ->where('id', $data['training_sheet_division_id'])
            ->where('training_sheet_id', $sheet->id)
            ->first();

        if (! $sheetDivision) {
            return null;
        }

        return DB::transaction(function () use ($data, $student, $sheet, $sheetDivision): WorkoutLog {
            $workoutLog = WorkoutLog::query()->create([
                'student_id' => $student->id,
                'training_sheet_id' => $sheet->id,
                'training_sheet_division_id' => $sheetDivision->id,
                'validated_by' => null,
                'started_at' => $data['started_at'],
                'finished_at' => $data['finished_at'] ?? null,
                'duration_minutes' => $data['duration_minutes'] ?? null,
            ]);

            foreach ($data['exercises'] as $exercise) {
                WorkoutLogExercise::query()->create([
                    'workout_log_id' => $workoutLog->id,
                    'exercise_id' => $exercise['exercise_id'],
                    'performed_series' => $exercise['performed_series'] ?? null,
                    'performed_repetitions' => $exercise['performed_repetitions'] ?? null,
                    'performed_load' => $exercise['performed_load'] ?? null,
                    'completed' => $exercise['completed'],
                    'observation' => $exercise['observation'] ?? null,
                ]);
            }

            return $workoutLog->load([
                'sheetDivision.trainingDivision',
                'validator',
                'logExercises.exercise',
            ]);
        });
    }
}
