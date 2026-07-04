<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class WorkoutLogExercise extends Model
{
    use LogsActivity;

    protected $table = 'workout_log_exercises';

    protected $fillable = [
        'workout_log_id',
        'exercise_id',
        'performed_series',
        'performed_repetitions',
        'performed_load',
        'completed',
        'observation',
    ];

    protected $casts = [
        'performed_series' => 'integer',
        'performed_load' => 'decimal:2',
        'completed' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['performed_load', 'performed_series', 'performed_repetitions', 'completed'])
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Exercício executado no treino',
                'updated' => 'Execução de exercício atualizada',
                default => $eventName,
            });
    }

    public function workoutLog(): BelongsTo
    {
        return $this->belongsTo(WorkoutLog::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
