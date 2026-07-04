<?php

namespace App\Policies;

class PostTypePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'post_type';
    }
}
