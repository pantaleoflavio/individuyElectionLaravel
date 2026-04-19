<?php

namespace App\Http\Requests;

use App\Enums\RankingType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRankingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:' . implode(',', RankingType::values())],
            'status' => ['required', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['required', 'exists:categories,id'],
            'federation_id' => ['nullable', 'exists:federations,id'],
            'federation_ids' => ['nullable', 'array'],
            'federation_ids.*' => ['required', 'exists:federations,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'countries_text' => ['nullable', 'string', 'max:1000'],
            'includes_inactive' => ['nullable', 'boolean'],
        ];
    }
}
