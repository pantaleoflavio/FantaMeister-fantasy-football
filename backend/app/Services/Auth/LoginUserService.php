<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserService
{
    /**
     * @return array{token:string,user:User}
     */
    public function execute(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['Invalid credentials.'],
            ]);
        }

        return [
            'token' => $user->createToken('auth-token')->plainTextToken,
            'user' => $user->load('roles'),
        ];
    }
}
