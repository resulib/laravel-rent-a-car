<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CarNotFoundException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarController extends Controller
{

    public function index()
    {
        return CarResource::collection(Car::paginate());
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->validated());
        return new CarResource($car);
    }

    public function show(string $id)
    {
        $car = $this->getCar($id);
        if (!$car) {
            return new CarNotFoundException();
        }
        return new CarResource($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, string $id)
    {
        $car = Car::findOrFail($id);

        $updated = $car->update($request->validated());

        if ($updated) {
            return ApiResponse::success("Car updated successfully");
        }
        return ApiResponse::error("Failed to update car");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = $this->getCar($id);
        if ($car->delete()) {
            return ApiResponse::success("Car deleted successfully");
        }
        return ApiResponse::error("Car could not be deleted");
    }

    private function getCar($id)
    {
        try {
            return Car::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Car not found with id: $id",
            ], 404);
        }
    }
}
