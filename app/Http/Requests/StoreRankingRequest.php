<?php

namespace App\Http\Requests;

use App\Enums\RankingType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRankingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:' . implode(',', RankingType::values())],
            'status' => ['required', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'federation_id' => ['nullable', 'exists:federations,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'includes_inactive' => ['nullable', 'boolean'],
        ];
    }
}
