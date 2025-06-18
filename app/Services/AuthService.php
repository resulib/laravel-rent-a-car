<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function login(array $credentials):JsonResponse
    {

        if (!Auth::attempt($credentials)) {
            return ApiResponse::error("Invalid credentials.", 401);
        }

        $user = Auth::user();

        if (!$user->is_admin) {
            Auth::logout();
            return ApiResponse::error("Unauthorized.", 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
