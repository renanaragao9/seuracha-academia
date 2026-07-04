<?php

namespace App\Policies;

class BookingTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'booking_type';
    }
}
