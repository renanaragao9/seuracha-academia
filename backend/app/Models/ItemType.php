<?php

namespace App\Models;

class ItemType extends BaseModel
{
    protected $table = 'item_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
