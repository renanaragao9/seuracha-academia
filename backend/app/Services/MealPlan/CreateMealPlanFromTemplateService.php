<?php

namespace App\Services\MealPlan;

use App\Models\Food;
use App\Models\MealPlan;
use App\Models\MealPlanFood;
use App\Models\MealPlanMeal;
use App\Models\MealPlanTemplate;
use App\Models\MealType;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateMealPlanFromTemplateService
{
    public function run(int $templateId, Student $student, int $createdBy): MealPlan
    {
        $template = MealPlanTemplate::findOrFail($templateId);

        return DB::transaction(function () use ($template, $student, $createdBy) {
            $templateData = $template->template_data;
            $meals = $templateData['meals'] ?? [];

            $mealTypes = MealType::where('is_active', true)->pluck('id', 'name');
            $foods = Food::where('is_active', true)->pluck('id', 'name');

            $this->deactivateActivePlans($student);

            $plan = MealPlan::create([
                'student_id' => $student->id,
                'created_by' => $createdBy,
                'updated_by' => $createdBy,
                'name' => $template->name,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => Carbon::now()->addMonths(3)->endOfMonth()->toDateString(),
                'is_active' => true,
            ]);

            foreach ($meals as $mealData) {
                $mealTypeId = $mealTypes[$mealData['meal_type_name'] ?? ''] ?? null;

                if (! $mealTypeId) {
                    Log::warning('CreateMealPlanFromTemplate: MealType não encontrado.', [
                        'name' => $mealData['meal_type_name'] ?? '',
                    ]);
                    continue;
                }

                $meal = MealPlanMeal::create([
                    'meal_plan_id' => $plan->id,
                    'meal_type_id' => $mealTypeId,
                    'order' => $mealData['order'] ?? 1,
                ]);

                foreach ($mealData['foods'] ?? [] as $idx => $foodData) {
                    $foodId = $foods[$foodData['food_name'] ?? ''] ?? null;

                    if (! $foodId) {
                        Log::warning('CreateMealPlanFromTemplate: Food não encontrado.', [
                            'name' => $foodData['food_name'] ?? '',
                        ]);
                        continue;
                    }

                    MealPlanFood::create([
                        'meal_plan_meal_id' => $meal->id,
                        'food_id' => $foodId,
                        'quantity' => $foodData['quantity'] ?? 1,
                        'unit' => $foodData['unit'] ?? '',
                        'observation' => $foodData['observation'] ?? null,
                        'order' => $idx + 1,
                    ]);
                }
            }

            $plan->load(['meals.foods.food', 'meals.mealType', 'student']);

            return $plan;
        });
    }

    private function deactivateActivePlans(Student $student): void
    {
        $count = $student->mealPlans()->where('is_active', true)->update(['is_active' => false]);

        if ($count > 0) {
            Log::info('CreateMealPlanFromTemplate: planos anteriores inativados.', [
                'student_id' => $student->id,
                'count' => $count,
            ]);
        }
    }
}
