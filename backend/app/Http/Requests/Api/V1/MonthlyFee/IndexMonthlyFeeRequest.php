<?php

namespace App\Http\Requests\Api\V1\MonthlyFee;

use Illuminate\Foundation\Http\FormRequest;

class IndexMonthlyFeeRequest extends FormRequest
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
            'code.required' => 'O campo codigo e obrigatorio.',
            'code.string' => 'O campo codigo deve ser uma string.',
            'code.max' => 'O campo codigo deve ter no maximo 255 caracteres.',
        ];
    }
}
