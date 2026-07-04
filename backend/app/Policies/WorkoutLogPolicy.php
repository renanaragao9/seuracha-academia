<?php

namespace App\Policies;

class WorkoutLogPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'workout_log';
    }
}
