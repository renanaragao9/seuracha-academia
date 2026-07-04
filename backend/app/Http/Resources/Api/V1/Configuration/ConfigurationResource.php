<?php

namespace App\Http\Resources\Api\V1\Configuration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'description' => $this->description,

            'contact' => [
                'email' => $this->email,
                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'emergency_phone' => $this->emergency_phone,
            ],

            'address' => [
                'zip_code' => $this->zip_code,
                'street' => $this->address,
                'number' => $this->number,
                'complement' => $this->complement,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'full' => $this->buildFullAddress(),
            ],

            'social' => [
                'website' => $this->website,
                'instagram' => $this->instagram,
                'facebook' => $this->facebook,
                'youtube' => $this->youtube,
            ],

            'branding' => [
                'logo' => $this->logo,
                'logo_url' => storage_url($this->logo),
                'favicon' => $this->favicon,
                'favicon_url' => storage_url($this->favicon),
            ],

            'schedule' => [
                'opening_hours' => $this->opening_hours,
                'opening_time' => $this->opening_time?->format('H:i'),
                'closing_time' => $this->closing_time?->format('H:i'),
            ],

            'notes' => $this->notes,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    private function buildFullAddress(): ?string
    {
        $parts = array_filter([
            $this->address,
            $this->number,
            $this->complement,
            $this->neighborhood,
            $this->city && $this->state ? "{$this->city} - {$this->state}" : ($this->city ?? $this->state),
            $this->zip_code ? "CEP {$this->zip_code}" : null,
        ]);

        return $parts ? implode(', ', $parts) : null;
    }
}
