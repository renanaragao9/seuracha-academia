<?php

namespace App\Policies;

class PaymentTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'payment_type';
    }
}
