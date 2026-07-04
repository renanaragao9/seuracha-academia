<?php

namespace App\Policies;

class TrainingSheetDivisionPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'training_sheet_division';
    }
}
