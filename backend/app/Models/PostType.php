<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;

class PostType extends BaseModel
{
    protected $table = 'post_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Tipo de postagem registrado',
                'updated' => 'Tipo de postagem atualizado',
                'deleted' => 'Tipo de postagem excluído',
                default => $eventName,
            });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
