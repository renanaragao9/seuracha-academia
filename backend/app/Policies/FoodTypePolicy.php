<?php

namespace App\Policies;

class FoodTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'food_type';
    }
}
