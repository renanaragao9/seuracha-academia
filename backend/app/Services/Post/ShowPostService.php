<?php

namespace App\Services\Post;

use App\Models\Post;

class ShowPostService
{
    public function run(Post $post): Post
    {
        return $post->load(['postType', 'user']);
    }
}
