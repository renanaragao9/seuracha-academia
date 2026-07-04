<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingStudent;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexBookingService
{
    public function run(User $user): Collection
    {
        return Booking::query()
            ->with('bookingType')
            ->withCount('bookingStudents')
            ->addSelect(['is_registered' => BookingStudent::selectRaw('1')
                ->whereColumn('booking_id', 'bookings.id')
                ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
                ->limit(1),
            ])
            ->where('start_date', '>=', now())
            ->where('status', 'confirmed')
            ->orderBy('start_date')
            ->get();
    }
}
