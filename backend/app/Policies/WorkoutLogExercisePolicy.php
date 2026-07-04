<?php

namespace App\Policies;

class WorkoutLogExercisePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'workout_log_exercise';
    }
}
