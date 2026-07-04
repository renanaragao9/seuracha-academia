<?php

namespace App\Services\TrainingSheet;

use App\Models\TrainingSheet;
use App\Models\User;

class ShowTrainingSheetService
{
    public function run(TrainingSheet $sheet, User $user): TrainingSheet
    {
        if ($sheet->student->user_id !== $user->id) {
            abort(404, 'Ficha de treino não encontrada.');
        }

        return $sheet->load([
            'divisions.trainingDivision',
            'divisions.exercises.exercise',
            'workoutLogs.sheetDivision.trainingDivision',
            'workoutLogs.validator',
            'workoutLogs.logExercises.exercise',
        ]);
    }
}
