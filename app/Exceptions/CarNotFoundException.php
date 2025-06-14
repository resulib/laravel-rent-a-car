<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CarNotFoundException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => "Car not found with id",
            'errors' => ['id' => 'Car not found with id']
        ], 404);
    }
}
