<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends BaseModel
{
    use HasFileUploads;

    protected $table = 'exercises';

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'gif_path',
        'video_path',
        'is_active',
        'equipment_type_id',
        'muscle_group_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function fileUploadFields(): array
    {
        return ['image_path', 'gif_path'];
    }

    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function muscleGroup(): BelongsTo
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
