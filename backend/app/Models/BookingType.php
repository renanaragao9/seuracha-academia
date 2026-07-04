<?php

namespace App\Models;

class BookingType extends BaseModel
{
    protected $table = 'booking_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
