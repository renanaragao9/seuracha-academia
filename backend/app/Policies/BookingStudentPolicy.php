<?php

namespace App\Policies;

class BookingStudentPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'booking_student';
    }
}
