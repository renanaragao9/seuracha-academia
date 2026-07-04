<?php

namespace App\Http\Requests\Api\V1\MealPlan;

use Illuminate\Foundation\Http\FormRequest;

class IndexMealPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.string' => 'O campo código deve ser uma string.',
            'code.max' => 'O campo código deve ter no máximo 255 caracteres.',
        ];
    }
}
