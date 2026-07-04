<?php

namespace App\Policies;

class SaleItemPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'sale_item';
    }
}
