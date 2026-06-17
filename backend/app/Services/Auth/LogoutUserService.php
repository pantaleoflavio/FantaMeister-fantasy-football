<?php

namespace App\Services\Auth;

use App\Models\User;

class LogoutUserService
{
    public function execute(?User $user): void
    {
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
    }
}
