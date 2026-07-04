<?php

namespace App\Policies;

class MealPlanFoodPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'meal_plan_food';
    }
}
