<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerRegistration extends BaseModel
{
    protected $table = 'customer_registrations';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'plan_type_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function planType(): BelongsTo
    {
        return $this->belongsTo(PlanType::class);
    }
}
