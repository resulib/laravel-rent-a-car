<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_admin) {
                Auth::logout(); // admin deyilsə, logout et
                return ApiResponse::error('You are not authorized to access admin panel.', 403);
            }

            // optional: token generasiya et (API üçün JWT / Sanctum istifadə edilirsə)
            return ApiResponse::success("Login successful", 200);
        }

        return ApiResponse::error('Invalid email or password', 422);
    }
}
