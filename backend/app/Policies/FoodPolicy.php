<?php

namespace App\Policies;

class FoodPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'food';
    }
}
