<?php

namespace App\Policies;

class ExercisePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'exercise';
    }
}
