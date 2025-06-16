<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarController extends Controller
{

    public function index()
    {
        return CarResource::collection(Car::paginate());
    }


    public function show(string $id)
    {
        $car = $this->getCar($id);
        return new CarResource($car);
    }

    public function store(StoreCarRequest $request)
    {
        try {
            Car::create($request->validated());
            return ApiResponse::success('Car created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating car', 500);
        }
    }

    public function update(UpdateCarRequest $request, string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $updated = $car->update($request->validated());
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => "Car not found with id: $id"
            ], 404));
        }

        if ($updated) {
            return ApiResponse::success("Car updated successfully", 200);
        }
        return ApiResponse::error("Error updating car", 422);
    }

    public function destroy(string $id)
    {
        if ($this->getCar($id)) {
            return ApiResponse::success("Car deleted successfully", 200);
        }
        return ApiResponse::error("Error deleting car", 422);
    }

    private function getCar($id)
    {
        return findModelOrFail(Car::class, $id);
    }
}
