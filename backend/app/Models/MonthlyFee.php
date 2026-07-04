<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyFee extends BaseModel
{
    protected $table = 'monthly_fees';

    protected $fillable = [
        'uuid',
        'status',
        'date_payment',
        'start_date',
        'end_date',
        'full_payment',
        'discount_payment',
        'amount_paid',
        'student_id',
        'payment_type_id',
        'plan_type_id',
        'user_id',
    ];

    protected $casts = [
        'date_payment' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'full_payment' => 'decimal:2',
        'discount_payment' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function planType(): BelongsTo
    {
        return $this->belongsTo(PlanType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFinalPaymentAttribute(): float
    {
        return (float) $this->full_payment - (float) $this->discount_payment;
    }
}
