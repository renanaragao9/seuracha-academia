<?php

namespace App\Policies;

class CustomerRegistrationPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'customer_registration';
    }
}
