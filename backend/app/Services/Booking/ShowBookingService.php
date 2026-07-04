<?php

namespace App\Services\Booking;

use App\Models\Booking;

class ShowBookingService
{
    public function run(Booking $booking): Booking
    {
        return $booking->load([
            'bookingType',
            'bookingStudents.student',
            'user',
        ])->loadCount('bookingStudents');
    }
}
