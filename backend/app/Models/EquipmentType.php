<?php

namespace App\Models;

class EquipmentType extends BaseModel
{
    protected $table = 'equipment_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
