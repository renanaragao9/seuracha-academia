<?php

namespace App\Http\Requests\Api\IA;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:2000'],
            'model' => ['nullable', 'string'],
            'system_prompt' => ['nullable', 'string'],
            'messages' => ['nullable', 'array'],
            'messages.*.role' => ['required', 'string', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'A mensagem é obrigatória.',
            'message.string' => 'A mensagem deve ser um texto.',
            'message.max' => 'A mensagem não pode ter mais de 2000 caracteres.',
            'model.string' => 'O modelo deve ser um texto válido.',
            'system_prompt.string' => 'O prompt do sistema deve ser um texto válido.',
            'messages.array' => 'O histórico deve ser uma lista válida.',
            'messages.*.role.in' => 'O papel da mensagem deve ser user ou assistant.',
        ];
    }
}
