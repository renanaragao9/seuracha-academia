<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSheetDivision extends Model
{
    protected $table = 'training_sheet_divisions';

    protected $fillable = [
        'training_sheet_id',
        'training_division_id',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function trainingSheet(): BelongsTo
    {
        return $this->belongsTo(TrainingSheet::class);
    }

    public function trainingDivision(): BelongsTo
    {
        return $this->belongsTo(TrainingDivision::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(TrainingExercise::class)->orderBy('order');
    }

    public function workoutLogs(): HasMany
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
