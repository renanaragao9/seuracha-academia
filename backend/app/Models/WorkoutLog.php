<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class WorkoutLog extends Model
{
    use LogsActivity;

    protected $table = 'workout_logs';

    protected $fillable = [
        'student_id',
        'training_sheet_id',
        'training_sheet_division_id',
        'validated_by',
        'started_at',
        'finished_at',
        'duration_minutes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Treino iniciado',
                'updated' => 'Treino finalizado',
                default => $eventName,
            });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function trainingSheet(): BelongsTo
    {
        return $this->belongsTo(TrainingSheet::class);
    }

    public function sheetDivision(): BelongsTo
    {
        return $this->belongsTo(TrainingSheetDivision::class, 'training_sheet_division_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function logExercises(): HasMany
    {
        return $this->hasMany(WorkoutLogExercise::class);
    }
}
