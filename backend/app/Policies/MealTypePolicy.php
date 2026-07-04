<?php

namespace App\Policies;

class MealTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'meal_type';
    }
}
