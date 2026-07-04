<?php

namespace App\Http\Requests\Api\V1\Item;

use Illuminate\Foundation\Http\FormRequest;

class IndexItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_type_id' => ['sometimes', 'nullable', 'integer', 'exists:item_types,id'],
            'sort' => ['sometimes', 'nullable', 'string', 'in:price_asc,price_desc'],
            'promotion' => ['sometimes', 'boolean'],
        ];
    }
}
