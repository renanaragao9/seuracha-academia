<?php

namespace App\Filament\Resources\MonthlyFees\Pages;

use App\Filament\Resources\MonthlyFees\MonthlyFeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMonthlyFee extends CreateRecord
{
    protected static string $resource = MonthlyFeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = [];

        if ($studentId = request()->query('student_id')) {
            $data['student_id'] = $studentId;
        }

        $this->form->fill($data);

        $this->callHook('afterFill');
    }
}
