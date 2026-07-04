<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\Support\LogOptions;

class Booking extends BaseModel
{
    protected $table = 'bookings';

    protected $fillable = [
        'status',
        'description',
        'full_addresses',
        'start_date',
        'end_date',
        'vacancies',
        'booking_type_id',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'vacancies' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Agendamento registrado',
                'updated' => 'Agendamento atualizado',
                'deleted' => 'Agendamento excluído',
                default => $eventName,
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookingType(): BelongsTo
    {
        return $this->belongsTo(BookingType::class);
    }

    public function bookingStudents(): HasMany
    {
        return $this->hasMany(BookingStudent::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, BookingStudent::class);
    }
}
