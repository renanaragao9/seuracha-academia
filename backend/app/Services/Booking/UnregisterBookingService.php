<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingStudent;
use App\Models\Student;
use App\Models\User;

class UnregisterBookingService
{
    public function run(User $user, Booking $booking): Booking
    {
        $student = Student::query()->where('user_id', $user->id)->firstOrFail();

        $bookingStudent = BookingStudent::query()
            ->where('booking_id', $booking->id)
            ->where('student_id', $student->id)
            ->first();

        if (! $bookingStudent) {
            abort(422, 'Você não está registrado neste agendamento.');
        }

        $bookingStudent->delete();

        $booking->load('bookingStudents.student')->loadCount('bookingStudents');

        return $booking;
    }
}
