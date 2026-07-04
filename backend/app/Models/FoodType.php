<?php

namespace App\Models;

class FoodType extends BaseModel
{
    protected $table = 'food_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
