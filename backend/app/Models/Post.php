<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Support\LogOptions;

class Post extends BaseModel
{
    protected $table = 'posts';

    public const STATUSES = [
        'draft' => 'Rascunho',
        'published' => 'Publicado',
        'archived' => 'Arquivado',
    ];

    protected $fillable = [
        'post_type_id',
        'user_id',
        'title',
        'description',
        'image_path',
        'link_video',
        'link_site',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Postagem registrada',
                'updated' => 'Postagem atualizada',
                'deleted' => 'Postagem excluída',
                default => $eventName,
            });
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
