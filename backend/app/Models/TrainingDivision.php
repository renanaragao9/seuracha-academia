<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingDivision extends BaseModel
{
    protected $table = 'training_divisions';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sheetDivisions(): HasMany
    {
        return $this->hasMany(TrainingSheetDivision::class);
    }
}
