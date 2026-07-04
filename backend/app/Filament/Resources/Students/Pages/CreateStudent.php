<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use App\Models\Student;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = [];

        if ($name = request()->query('name')) {
            $data['name'] = $name;
        }

        if ($email = request()->query('email')) {
            $data['email'] = $email;
        }

        if ($phone = request()->query('phone')) {
            $data['phone'] = $phone;
        }

        $data['code'] = $this->generateCode();
        $data['entry_date'] = now()->format('Y-m-d');

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    private function generateCode(): string
    {
        $lastStudent = Student::withTrashed()
            ->where('code', 'like', 'ALU-%')
            ->orderBy('code', 'desc')
            ->first();

        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->code, 4);
            return 'ALU-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return 'ALU-0001';
    }
}
