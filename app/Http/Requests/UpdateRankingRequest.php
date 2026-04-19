<?php

namespace App\Http\Requests;

use App\Models\Ranking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRankingRequest extends FormRequest
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
        /** @var Ranking $ranking */
        $ranking = $this->route('id') ? Ranking::findOrFail($this->route('id')) : new Ranking();

        return [
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name,' . $ranking->id],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['required', 'exists:categories,id'],
            'federation_id' => ['nullable', 'exists:federations,id'],
            'federation_ids' => ['nullable', 'array'],
            'federation_ids.*' => ['required', 'exists:federations,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'countries_text' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
