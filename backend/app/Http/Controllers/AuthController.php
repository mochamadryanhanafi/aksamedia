<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(\App\Http\Requests\LoginRequest $request)
    {
        $credentials = $request->validated();

        $data = $this->authService->login($credentials);

        if (!$data) {
             return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login Berhasil',
            'data' => $data,
        ]);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout',
        ]);
    }
}
