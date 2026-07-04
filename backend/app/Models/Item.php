<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;

class Item extends BaseModel
{
    protected $table = 'items';

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'total_price',
        'promotion_price',
        'item_type_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'promotion_price' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Item registrado',
                'updated' => 'Item atualizado',
                'deleted' => 'Item excluído',
                default => $eventName,
            });
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function itemFieldTypes(): HasMany
    {
        return $this->hasMany(ItemFieldType::class);
    }
}
