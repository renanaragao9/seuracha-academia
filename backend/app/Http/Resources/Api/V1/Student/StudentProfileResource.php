<?php

namespace App\Http\Resources\Api\V1\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'image_url' => $this->user->image_path ? storage_url($this->user->image_path) : null,
            ],
            'student' => new StudentResource($this),
            'stats' => [
                'training_sheets_count' => $this->training_sheets_count,
                'assessments_count' => $this->assessments_count,
                'workout_logs_count' => $this->workout_logs_count,
                'meal_plans_count' => $this->meal_plans_count,
                'monthly_fees_count' => $this->monthly_fees_count,
                'purchases_count' => $this->sales_count,
                'bookings_count' => $this->booking_students_count,
            ],
        ];
    }
}
