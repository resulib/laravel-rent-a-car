<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return ApiResponse::error('Invalid credentials', 401);
        }

        $user = Auth::user();

        if (!$user->is_admin) {
            Auth::logout();
            return ApiResponse::error('Unauthorized', 403);
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
        return ApiResponse::success('Logged out successfully');
    }
}
