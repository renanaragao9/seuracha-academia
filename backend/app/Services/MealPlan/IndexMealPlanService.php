<?php

namespace App\Services\MealPlan;

use App\Models\MealPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexMealPlanService
{
    public function run(User $user): Collection
    {
        return MealPlan::query()
            ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
            ->withCount('meals')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();
    }
}
