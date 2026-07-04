<?php

namespace App\Models;

class ExpenseType extends BaseModel
{
    protected $table = 'expense_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
