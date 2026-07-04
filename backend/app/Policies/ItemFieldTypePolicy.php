<?php

namespace App\Policies;

class ItemFieldTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'item_field_type';
    }
}
