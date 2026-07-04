<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingStudent;
use App\Models\Student;
use App\Models\User;

class RegisterBookingService
{
    public function run(User $user, Booking $booking): Booking
    {
        $student = Student::query()->where('user_id', $user->id)->firstOrFail();

        if (BookingStudent::isStudentAlreadyBooked($student->id, $booking->id)) {
            abort(422, 'Você já está registrado neste agendamento.');
        }

        if (! BookingStudent::hasAvailableVacancies($booking->id)) {
            abort(422, 'Este agendamento não possui vagas disponíveis.');
        }

        BookingStudent::query()->create([
            'booking_id' => $booking->id,
            'student_id' => $student->id,
            'status' => 'confirmed',
        ]);

        $booking->load('bookingStudents.student')->loadCount('bookingStudents');

        return $booking;
    }
}
