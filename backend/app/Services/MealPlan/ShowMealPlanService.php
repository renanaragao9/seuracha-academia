<?php

namespace App\Services\MealPlan;

use App\Models\MealPlan;
use App\Models\User;

class ShowMealPlanService
{
    public function run(MealPlan $mealPlan, User $user): MealPlan
    {
        if ($mealPlan->student->user_id !== $user->id) {
            abort(404, 'Plano alimentar não encontrado.');
        }

        return $mealPlan->load(['meals.mealType', 'meals.foods.food']);
    }
}
