<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;

class TrainingSheet extends BaseModel
{
    protected $table = 'training_sheets';

    protected $fillable = [
        'student_id',
        'created_by',
        'updated_by',
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Ficha de treino criada',
                'updated' => 'Ficha de treino editada',
                'deleted' => 'Ficha de treino excluída',
                default => $eventName,
            });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(TrainingSheetDivision::class)->orderBy('order');
    }

    public function workoutLogs(): HasMany
    {
        return $this->hasMany(WorkoutLog::class)->orderByDesc('started_at');
    }
}
