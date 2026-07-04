<?php

namespace App\Policies;

class MealPlanMealPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'meal_plan_meal';
    }
}
