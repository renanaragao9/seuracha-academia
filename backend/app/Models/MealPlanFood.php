<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealPlanFood extends Model
{
    protected $table = 'meal_plan_foods';

    protected $fillable = [
        'meal_plan_meal_id',
        'food_id',
        'quantity',
        'unit',
        'observation',
        'order',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'order' => 'integer',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(MealPlanMeal::class, 'meal_plan_meal_id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
