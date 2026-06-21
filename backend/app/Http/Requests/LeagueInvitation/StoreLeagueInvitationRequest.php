<?php

namespace App\Http\Requests\LeagueInvitation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeagueInvitationRequest extends FormRequest
{
       public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'max_uses' => ['nullable', 'integer', 'min:1', 'max:100'],
            'expires_at' => ['nullable', 'date', 'after:now'],
            'code' => ['prohibited'],
            'status' => ['prohibited'],
            'used_count' => ['prohibited'],
            'created_by_user_id' => ['prohibited'],
            'league_id' => ['prohibited'],
            'league_role_id' => ['prohibited'],
            'role' => ['prohibited'],
            'target_role' => ['prohibited'],
        ];
    }
}
