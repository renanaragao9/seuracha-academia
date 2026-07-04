<?php

namespace App\Http\Resources\Api\V1\Booking;

use App\Http\Resources\Api\V1\BookingType\BookingTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'description' => $this->description,
            'full_addresses' => $this->full_addresses,
            'start_date' => $this->start_date?->format('Y-m-d H:i:s'),
            'end_date' => $this->end_date?->format('Y-m-d H:i:s'),
            'vacancies' => $this->vacancies,
            'booked_count' => $this->whenCounted('bookingStudents'),
            'booking_type' => new BookingTypeResource($this->whenLoaded('bookingType')),
            'user' => $this->when($this->relationLoaded('user'), fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
            'booking_students' => $this->when($this->relationLoaded('bookingStudents'), fn () => $this->bookingStudents->map(fn ($bs) => [
                'id' => $bs->id,
                'student_id' => $bs->student_id,
                'status' => $bs->status,
                'student' => $bs->relationLoaded('student') ? [
                    'id' => $bs->student->id,
                    'name' => $bs->student->name,
                ] : null,
            ])
            ),
            'is_registered' => $this->when($request->user(), function () use ($request) {
                if ($this->is_registered !== null) {
                    return (bool) $this->is_registered;
                }

                if ($this->relationLoaded('bookingStudents')) {
                    return $this->bookingStudents->contains(
                        fn ($bs) => $bs->relationLoaded('student') && $bs->student->user_id === $request->user()->id
                    );
                }

                return false;
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
