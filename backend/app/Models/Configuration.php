<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFileUploads;

    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'phone',
        'whatsapp',
        'emergency_phone',
        'zip_code',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'website',
        'instagram',
        'facebook',
        'youtube',
        'logo',
        'favicon',
        'description',
        'notes',
        'opening_hours',
        'opening_time',
        'closing_time',
    ];

    protected $casts = [
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    public $timestamps = true;

    protected function fileUploadFields(): array
    {
        return ['logo', 'favicon'];
    }
}
