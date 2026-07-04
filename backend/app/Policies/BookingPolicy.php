<?php

namespace App\Policies;

class BookingPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'booking';
    }
}
