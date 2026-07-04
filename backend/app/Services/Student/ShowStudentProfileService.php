<?php

namespace App\Services\Student;

use App\Models\Student;
use App\Models\User;

class ShowStudentProfileService
{
    public function run(User $user): Student
    {
        $student = Student::where('user_id', $user->id)->firstOr(function () {
            abort(404, 'Nenhum aluno vinculado à sua conta.');
        });

        $student->load('user')->loadCount([
            'trainingSheets',
            'assessments',
            'workoutLogs',
            'mealPlans',
            'monthlyFees',
            'sales',
            'bookingStudents',
        ]);

        return $student;
    }
}
