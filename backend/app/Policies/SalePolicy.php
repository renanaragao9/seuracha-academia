<?php

namespace App\Policies;

class SalePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'sale';
    }
}
