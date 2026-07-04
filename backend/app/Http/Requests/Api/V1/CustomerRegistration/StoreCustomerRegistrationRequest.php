<?php

namespace App\Http\Requests\Api\V1\CustomerRegistration;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255'],
            'message' => ['sometimes', 'nullable', 'string'],
            'plan_type_id' => ['sometimes', 'required', 'integer', 'exists:plan_types,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.max' => 'O campo telefone deve ter no máximo 20 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.string' => 'O campo email deve ser uma string.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres.',
            'message.string' => 'O campo mensagem deve ser uma string.',
            'plan_type_id.required' => 'O campo plano é obrigatório.',
            'plan_type_id.integer' => 'O campo plano deve ser um número inteiro.',
            'plan_type_id.exists' => 'O plano selecionado é inválido.',
        ];
    }
}
