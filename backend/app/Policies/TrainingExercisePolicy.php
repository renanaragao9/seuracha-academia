<?php

namespace App\Policies;

class TrainingExercisePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'training_exercise';
    }
}
