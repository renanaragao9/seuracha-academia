<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingStudent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MyBookingService
{
    public function run(User $user): Collection
    {
        $student = Student::query()->where('user_id', $user->id)->first();

        if (! $student) {
            return new Collection();
        }

        return Booking::query()
            ->whereHas('bookingStudents', fn ($q) => $q->where('student_id', $student->id))
            ->with('bookingType')
            ->withCount('bookingStudents')
            ->addSelect(['is_registered' => BookingStudent::selectRaw('1')
                ->whereColumn('booking_id', 'bookings.id')
                ->where('student_id', $student->id)
                ->limit(1),
            ])
            ->orderByDesc('start_date')
            ->get();
    }
}
