<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;

class Sale extends BaseModel
{
    protected $table = 'sales';

    protected $fillable = [
        'uuid',
        'status',
        'observation',
        'date_sale',
        'amount_price',
        'discount_amount',
        'total_amount',
        'user_id',
        'student_id',
    ];

    protected $casts = [
        'date_sale' => 'datetime',
        'amount_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Venda registrada',
                'updated' => 'Venda atualizada',
                'deleted' => 'Venda excluída',
                default => $eventName,
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function recalculateTotals(): void
    {
        $amount = $this->saleItems()->sum('subtotal');

        $this->update([
            'amount_price' => $amount,
            'total_amount' => max(0, $amount - $this->discount_amount),
        ]);
    }
}
