<?php

namespace App\Services\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class IndexPostService
{
    public function run(array $data): Collection
    {
        $type = $data['type'] ?? null;
        $today = Date::now()->format('Y-m-d');

        return Post::query()
            ->with('postType')
            ->where('status', 'published')
            ->when($type, fn ($q) => $q->whereHas('postType', fn ($q) => $q->where('name', $type)))
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderByDesc('start_date')
            ->get();
    }
}
