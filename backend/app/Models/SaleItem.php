<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;

class SaleItem extends BaseModel
{
    protected $table = 'sale_items';

    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'subtotal' => 'float',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model): void {
            if ($model->unit_price !== null && $model->quantity !== null) {
                $model->subtotal = round((float) $model->unit_price * (int) $model->quantity, 2);
            }
        });

        static::saved(function (self $model): void {
            $model->load('sale');
            $model->sale?->recalculateTotals();
        });

        static::deleted(function (self $model): void {
            $model->load('sale');
            $model->sale?->recalculateTotals();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Item de venda registrado',
                'updated' => 'Item de venda atualizado',
                'deleted' => 'Item de venda excluído',
                default => $eventName,
            });
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
