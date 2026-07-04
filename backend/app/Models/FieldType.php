<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldType extends BaseModel
{
    protected $table = 'field_types';

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function itemFieldTypes(): HasMany
    {
        return $this->hasMany(ItemFieldType::class);
    }
}
