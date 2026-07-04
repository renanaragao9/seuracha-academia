<?php

namespace App\Models;

class MuscleGroup extends BaseModel
{
    protected $table = 'muscle_groups';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
