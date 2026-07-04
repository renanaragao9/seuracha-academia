<?php

namespace App\Policies;

class TrainingSheetPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'training_sheet';
    }
}
