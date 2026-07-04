<?php

namespace App\Policies;

class ItemTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'item_type';
    }
}
