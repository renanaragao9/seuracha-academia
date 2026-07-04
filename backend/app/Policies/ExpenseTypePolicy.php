<?php

namespace App\Policies;

class ExpenseTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'expense_type';
    }
}
