<?php

namespace App\Policies;

class ConfigurationPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'configuration';
    }
}
