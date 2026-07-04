<?php

namespace App\Services\Student;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangeStudentPasswordService
{
    public function run(User $user, array $data): void
    {
        if (! Hash::check($data['current_password'], $user->password)) {
            abort(422, 'A senha atual está incorreta.');
        }

        $user->password = $data['password'];
        $user->save();
    }
}
