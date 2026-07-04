<?php

namespace App\Policies;

class ExpensePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'expense';
    }
}
