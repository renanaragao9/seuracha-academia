<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use App\Notifications\Student\StudentWellcome;
use Illuminate\Support\Facades\Hash;

class StudentObserver
{
    public function created(Student $student): void
    {
        if ($student->email) {
            $role = Role::where('name', 'Estudante')->first();

            $user = User::create([
                'name' => $student->name,
                'email' => $student->email,
                'phone' => $student->phone,
                'image_path' => $student->image_path,
                'password' => Hash::make('12345678'),
                'status' => $student->status === 'active' ? 'active' : 'inactive',
                'role_id' => $role?->id,
            ]);

            $student->user_id = $user->id;
            $student->saveQuietly();
        }

        $student->notify(new StudentWellcome($student));
    }

    public function updated(Student $student): void
    {
        $user = User::where('email', $student->getOriginal('email'))->first();

        if (! $user) {
            if ($student->email) {
                $role = Role::where('name', 'Estudante')->first();

                $user = User::create([
                    'name' => $student->name,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'image_path' => $student->image_path,
                    'password' => Hash::make('12345678'),
                    'status' => $student->status === 'active' ? 'active' : 'inactive',
                    'role_id' => $role?->id,
                ]);

                $student->user_id = $user->id;
                $student->saveQuietly();
            }

            return;
        }

        $data = [];

        if ($student->isDirty('name')) {
            $data['name'] = $student->name;
        }

        if ($student->isDirty('email')) {
            $data['email'] = $student->email;
        }

        if ($student->isDirty('phone')) {
            $data['phone'] = $student->phone;
        }

        if ($student->isDirty('image_path')) {
            $data['image_path'] = $student->image_path;
        }

        if ($student->isDirty('status')) {
            $data['status'] = $student->status === 'active' ? 'active' : 'inactive';
        }

        if (! empty($data)) {
            $user->update($data);
        }
    }
}
