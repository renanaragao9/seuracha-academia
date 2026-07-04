<?php

namespace App\Models;

class PaymentType extends BaseModel
{
    protected $table = 'payment_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
