<?php

namespace App\Models;

class PlanType extends BaseModel
{
    protected $table = 'plan_types';

    protected $fillable = [
        'name',
        'description',
        'amount_base',
        'period_days',
        'is_active',
    ];

    protected $casts = [
        'amount_base' => 'decimal:2',
        'period_days' => 'integer',
        'is_active' => 'boolean',
    ];
}
