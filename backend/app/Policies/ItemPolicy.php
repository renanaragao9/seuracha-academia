<?php

namespace App\Policies;

class ItemPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'item';
    }
}
