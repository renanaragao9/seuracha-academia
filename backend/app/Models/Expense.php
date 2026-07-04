<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;

class Expense extends BaseModel
{
    protected $table = 'expenses';

    protected $fillable = [
        'type',
        'status',
        'description',
        'date_maturity',
        'total_amount',
        'expense_type_id',
        'user_id',
    ];

    protected $casts = [
        'date_maturity' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Despesa registrada',
                'updated' => 'Despesa atualizada',
                'deleted' => 'Despesa excluída',
                default => $eventName,
            });
    }

    public function expenseType(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
