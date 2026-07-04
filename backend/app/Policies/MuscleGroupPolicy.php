<?php

namespace App\Policies;

class MuscleGroupPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'muscle_group';
    }
}
