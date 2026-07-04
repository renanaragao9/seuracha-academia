<?php

namespace App\Policies;

class EquipmentTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'equipment_type';
    }
}
