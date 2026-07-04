<?php

namespace App\Policies;

class PlanTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'plan_type';
    }
}
