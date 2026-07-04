<?php

namespace App\Http\Resources\Api\V1\Landing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'configuration' => $this->resource['configuration'],
            'stats' => $this->resource['stats'],
            'plans' => $this->resource['plans'],
        ];
    }
}
