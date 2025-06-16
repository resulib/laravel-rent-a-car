<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarModelController extends Controller
{
    public function index()
    {
        return CarModelResource::collection(CarModel::paginate(10));
    }

    public function show(CarModel $model)
    {
        return new CarModelResource($model);
    }

    public function store(StoreCarModelRequest $request)
    {
        try {
            CarModel::create($request->validated());
            return ApiResponse::success("Model created successfully", 201);
        } catch (\Exception $e) {
            return ApiResponse::error("Error creating model: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdateCarModelRequest $request, CarModel $model)
    {
        try {
            $model->update($request->validated());
            return ApiResponse::success("Model updated successfully", 200);
        }catch (\Exception $e) {
            return ApiResponse::error("Error updating model: " . $e->getMessage(), 422);
        }
    }

    public function destroy(CarModel $model)
    {
        try {
            $model->delete();
            return ApiResponse::success("Model deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting model: " . $e->getMessage(), 422);
        }
    }
}
