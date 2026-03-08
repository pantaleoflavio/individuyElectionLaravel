<?php

namespace App\Http\Requests;

use App\Models\Federation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFederationRequest extends FormRequest
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
        /** @var Federation $federation */
        $federation = $this->route('id') ? Federation::findOrFail($this->route('id')) : new Federation();

        return [
            'name' => ['required', 'string', 'max:255', 'unique:federations,name,' . $federation->id],
        ];
    }
}
