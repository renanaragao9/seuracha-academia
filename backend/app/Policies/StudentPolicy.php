<?php

namespace App\Policies;

class StudentPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'student';
    }
}
