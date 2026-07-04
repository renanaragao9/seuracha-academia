<?php

namespace App\Services\Student;

use App\Models\Student;

class ShowStudentService
{
    public function run(array $data): Student
    {
        return Student::query()
            ->where('code', $data['code'])
            ->when(
                ! empty($data['email']),
                fn ($query) => $query->where('email', $data['email'])
            )
            ->when(
                ! empty($data['phone']),
                fn ($query) => $query->where('phone', $data['phone'])
            )
            ->firstOr(function () {
                abort(404, 'Aluno não encontrado.');
            });
    }
}
