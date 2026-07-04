<?php

namespace App\Policies;

class FieldTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'field_type';
    }
}
