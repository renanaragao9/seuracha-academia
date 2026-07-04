<?php

namespace App\Policies;

class PostPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'post';
    }
}
