<?php

namespace App\Services\Student;

use App\Models\Student;
use App\Models\User;

class UpdateStudentProfileImageService
{
    public function run(User $user, array $data): Student
    {
        $student = Student::where('user_id', $user->id)->firstOr(function () {
            abort(404, 'Nenhum aluno vinculado à sua conta.');
        });

        $path = $data['image']->store('users/photos', 'public');

        $user->image_path = $path;
        $user->save();

        return $student;
    }
}
