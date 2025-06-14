<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success(string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code);
    }

    public static function error(string $message = 'Something went wrong', int $code = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
