<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class TrainingExercise extends Model
{
    use LogsActivity;

    protected $table = 'training_exercises';

    protected $fillable = [
        'training_sheet_division_id',
        'exercise_id',
        'series',
        'repetitions',
        'rest_seconds',
        'load',
        'observation',
        'order',
    ];

    protected $casts = [
        'series' => 'integer',
        'rest_seconds' => 'integer',
        'load' => 'decimal:2',
        'order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Exercício adicionado à ficha',
                'updated' => 'Exercício da ficha atualizado',
                'deleted' => 'Exercício removido da ficha',
                default => $eventName,
            });
    }

    public function sheetDivision(): BelongsTo
    {
        return $this->belongsTo(TrainingSheetDivision::class, 'training_sheet_division_id');
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
