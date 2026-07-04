<?php

namespace App\Services\Assessment;

use App\Models\Assessment;
use App\Models\User;

class ShowAssessmentService
{
    public function run(Assessment $assessment, User $user): Assessment
    {
        if ($assessment->student->user_id !== $user->id) {
            abort(404, 'Avaliação não encontrada.');
        }

        return $assessment->load('items.measurementType');
    }
}
