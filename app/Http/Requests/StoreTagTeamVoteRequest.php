<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagTeamVoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag_team_id' => ['required', 'exists:tag_teams,id'],
            'ranking_id' => ['required', 'exists:rankings,id'],
            'vote' => ['required', 'numeric', 'min:0', 'max:10'],
        ];
    }
}