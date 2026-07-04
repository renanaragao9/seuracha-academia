<?php

namespace App\Models;

class MealType extends BaseModel
{
    protected $table = 'meal_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
