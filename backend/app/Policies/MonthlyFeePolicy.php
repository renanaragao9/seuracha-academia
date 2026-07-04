<?php

namespace App\Policies;

class MonthlyFeePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'monthly_fee';
    }
}
