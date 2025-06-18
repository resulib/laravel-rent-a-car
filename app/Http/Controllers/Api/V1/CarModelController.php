<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use App\Services\CarModelService;

class CarModelController extends Controller
{

    protected CarModelService $carModelService;

    public function __construct(CarModelService $carModelService)
    {
        $this->carModelService = $carModelService;
    }

    public function index()
    {
        return CarModelResource::collection($this->carModelService->getAll());
    }

    public function show(CarModel $model)
    {
        return new CarModelResource($this->carModelService->getCarModel($model));
    }

    public function store(StoreCarModelRequest $request)
    {
        try {
            $this->carModelService->createCarModel($request);
            return ApiResponse::success("Model created successfully", 201);
        } catch (\Exception $e) {
            return ApiResponse::error("Error creating model: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdateCarModelRequest $request, CarModel $model)
    {
        try {
            $this->carModelService->updateCarModel($request, $model);
            return ApiResponse::success("Model updated successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error updating model: " . $e->getMessage(), 422);
        }
    }

    public function destroy(CarModel $model)
    {
        try {
            $this->carModelService->deleteCarModel($model);
            return ApiResponse::success("Model deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting model: " . $e->getMessage(), 422);
        }
    }
}
