<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Cast;

class MealPlanTemplate extends BaseModel
{
    protected $table = 'meal_plan_templates';

    protected $fillable = [
        'name',
        'description',
        'goal',
        'template_data',
        'is_active',
    ];

    #[Cast]
    protected function casts(): array
    {
        return [
            'template_data' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getSummaryForLLM(): string
    {
        $meals = collect($this->template_data['meals'] ?? []);
        $totalFoods = $meals->sum(fn ($m) => count($m['foods'] ?? []));

        return sprintf(
            "ID %d: '%s' — %s | Objetivo: %s | %d refeições/dia | %d alimentos",
            $this->id,
            $this->name,
            $this->description,
            $this->goal_label,
            $meals->count(),
            $totalFoods
        );
    }

    public function getGoalLabelAttribute(): string
    {
        return match ($this->goal) {
            'emagrecimento' => 'Emagrecimento',
            'hipertrofia' => 'Hipertrofia',
            'equilibrado' => 'Equilibrado',
            'lowcarb' => 'Low Carb',
            'vegetariano' => 'Vegetariano',
            default => $this->goal ?? 'Geral',
        };
    }
}
