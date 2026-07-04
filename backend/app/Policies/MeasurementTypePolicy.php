<?php

namespace App\Policies;

class MeasurementTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'measurement_type';
    }
}
