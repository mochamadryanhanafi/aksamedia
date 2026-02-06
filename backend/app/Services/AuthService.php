<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials)
    {
        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'admin' => $user,
        ];
    }

    public function logout()
    {
        // Auth::user() context handled in Controller
        // But actual token revocation:
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
             return true;
        }
        return false;
    }
}
