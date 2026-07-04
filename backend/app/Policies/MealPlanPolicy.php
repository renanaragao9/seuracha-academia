<?php

namespace App\Policies;

class MealPlanPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'meal_plan';
    }
}
