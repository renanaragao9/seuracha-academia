<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MealPlanMeal extends Model
{
    protected $table = 'meal_plan_meals';

    protected $fillable = [
        'meal_plan_id',
        'meal_type_id',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function mealType(): BelongsTo
    {
        return $this->belongsTo(MealType::class);
    }

    public function foods(): HasMany
    {
        return $this->hasMany(MealPlanFood::class)->orderBy('order');
    }
}
