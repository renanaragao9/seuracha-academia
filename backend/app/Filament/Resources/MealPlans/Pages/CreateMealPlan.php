<?php

namespace App\Filament\Resources\MealPlans\Pages;

use App\Filament\Resources\MealPlans\MealPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMealPlan extends CreateRecord
{
    protected static string $resource = MealPlanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = auth()->id();

        $data['created_by'] = $userId;
        $data['updated_by'] = $userId;

        return $data;
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = [
            'is_active' => true,
        ];

        if ($studentId = request()->query('student_id')) {
            $data['student_id'] = $studentId;
        }

        $this->form->fill($data);

        $this->callHook('afterFill');
    }
}
