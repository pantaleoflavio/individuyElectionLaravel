<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFederationVoteRequest extends FormRequest
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
            'federation_id' => ['required', 'exists:federations,id'],
            'ranking_id' => ['required', 'exists:rankings,id'],
            'vote' => ['required', 'numeric', 'min:0', 'max:10'],
        ];
    }
}
