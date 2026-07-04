<?php

namespace App\Policies;

class AssessmentPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'assessment';
    }
}
