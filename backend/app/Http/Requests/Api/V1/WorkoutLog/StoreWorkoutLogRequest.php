<?php

namespace App\Http\Requests\Api\V1\WorkoutLog;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_sheet_id' => ['required', 'integer', 'exists:training_sheets,id'],
            'training_sheet_division_id' => ['required', 'integer', 'exists:training_sheet_divisions,id'],
            'started_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.exercise_id' => ['required', 'integer', 'exists:exercises,id'],
            'exercises.*.performed_series' => ['nullable', 'integer', 'min:1'],
            'exercises.*.performed_repetitions' => ['nullable', 'string', 'max:255'],
            'exercises.*.performed_load' => ['nullable', 'numeric', 'min:0'],
            'exercises.*.completed' => ['required', 'boolean'],
            'exercises.*.observation' => ['nullable', 'string'],
        ];
    }
}
