<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWrestlerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'country' => ['required', 'string', 'max:255'],
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['required', 'exists:categories,id'],
            'federation_ids' => ['required', 'array', 'min:1'],
            'federation_ids.*' => ['required', 'exists:federations,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}