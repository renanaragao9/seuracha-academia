<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentItem extends Model
{
    use SoftDeletes;

    protected $table = 'assessment_items';

    protected $fillable = [
        'assessment_id',
        'measurement_type_id',
        'value',
        'unit',
        'notes',
        'order',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'unit' => 'string',
        'order' => 'integer',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function measurementType(): BelongsTo
    {
        return $this->belongsTo(MeasurementType::class);
    }

}
