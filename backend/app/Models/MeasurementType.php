<?php

namespace App\Models;

class MeasurementType extends BaseModel
{
    protected $table = 'measurement_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
