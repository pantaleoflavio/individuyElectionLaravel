<?php

namespace App\Http\Requests;

use App\Models\Ranking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRankingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Ranking $ranking */
        $ranking = $this->route('id') ? Ranking::findOrFail($this->route('id')) : new Ranking();

        return [
            'name' => ['required', 'string', 'max:255', 'unique:rankings,name,' . $ranking->id],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'federation_id' => ['nullable', 'exists:federations,id'],
            'country' => ['nullable', 'string', 'max:255'],
            'includes_inactive' => ['nullable', 'boolean'],
        ];
    }
}
