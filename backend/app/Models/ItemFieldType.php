<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;

class ItemFieldType extends BaseModel
{
    protected $table = 'item_field_type';

    protected $fillable = [
        'item_id',
        'field_type_id',
        'value',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Campo do item adicionado',
                'updated' => 'Campo do item atualizado',
                'deleted' => 'Campo do item removido',
                default => $eventName,
            });
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FieldType::class);
    }
}
