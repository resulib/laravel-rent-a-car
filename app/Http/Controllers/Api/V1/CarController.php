<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class CarController extends Controller
{

    protected CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index()
    {
        return CarResource::collection($this->carService->getAll());
    }

    public function searchAndFilter(Request $request): JsonResponse
    {
        return $this->carService->searchAndFilterApi($request);
    }


    public function show(Car $car)
    {
        return $this->carService->getCar($car);
    }

    public function store(StoreCarRequest $request)
    {
        try {
            $this->carService->createCar($request);
            return ApiResponse::success('Car created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating car', 500);
        }
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        try {
            $this->carService->updateCar($request, $car);
            return ApiResponse::success("Car updated successfully", 200);
        } catch (Exception $e) {
            return ApiResponse::error("Error updating car", 422);
        }
    }

    public function destroy(Car $car)
    {
        try {
            $this->carService->deleteCar($car);
            return ApiResponse::success("Car deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting car: " . $e->getMessage(), 422);
        }
    }

}
