<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class BookingStudent extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'booking_students';

    protected $fillable = [
        'booking_id',
        'student_id',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Aluno adicionado à reserva',
                'updated' => 'Registro de aluno em reserva atualizado',
                'deleted' => 'Aluno removido da reserva',
                default => $eventName,
            });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public static function isStudentAlreadyBooked(int $studentId, int $bookingId): bool
    {
        return static::query()
            ->where('student_id', $studentId)
            ->where('booking_id', $bookingId)
            ->exists();
    }

    public static function hasAvailableVacancies(int $bookingId): bool
    {
        $booking = Booking::find($bookingId);

        if (! $booking || $booking->vacancies <= 0) {
            return false;
        }

        $currentCount = static::query()
            ->where('booking_id', $bookingId)
            ->count();

        return $currentCount < $booking->vacancies;
    }
}
