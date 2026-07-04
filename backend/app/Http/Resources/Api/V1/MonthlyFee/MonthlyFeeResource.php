<?php

namespace App\Http\Resources\Api\V1\MonthlyFee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyFeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => $this->status,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'date_payment' => $this->date_payment?->format('Y-m-d'),
            'full_payment' => $this->full_payment,
            'discount_payment' => $this->discount_payment,
            'amount_paid' => $this->amount_paid,
            'final_payment' => $this->final_payment,
            'plan_type' => [
                'id' => $this->planType?->id,
                'name' => $this->planType?->name ?? '-',
            ],
            'payment_type' => $this->whenLoaded('paymentType', fn () => [
                'id' => $this->paymentType?->id,
                'name' => $this->paymentType?->name ?? '-',
            ]),
        ];
    }
}
