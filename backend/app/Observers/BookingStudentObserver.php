<?php

namespace App\Observers;

use App\Models\BookingStudent;

class BookingStudentObserver
{
    public function creating(BookingStudent $bookingStudent): void
    {
        if (BookingStudent::isStudentAlreadyBooked($bookingStudent->student_id, $bookingStudent->booking_id)) {
            throw new \Exception('Este aluno já possui uma reserva ativa.');
        }

        if (! BookingStudent::hasAvailableVacancies($bookingStudent->booking_id)) {
            throw new \Exception('A reserva atingiu o limite de vagas.');
        }
    }

    public function updating(BookingStudent $bookingStudent): void
    {
        if ($bookingStudent->isDirty('booking_id')) {
            if (! BookingStudent::hasAvailableVacancies($bookingStudent->booking_id)) {
                throw new \Exception('A reserva de destino atingiu o limite de vagas.');
            }
        }

        if ($bookingStudent->isDirty('student_id')) {
            if (BookingStudent::isStudentAlreadyBooked($bookingStudent->student_id, $bookingStudent->booking_id)) {
                throw new \Exception('Este aluno já possui uma reserva ativa.');
            }
        }
    }
}
