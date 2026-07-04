<?php

namespace App\Policies;

class TrainingDivisionPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'training_division';
    }
}
