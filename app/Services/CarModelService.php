<?php

namespace App\Services;

use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Models\CarModel;

class CarModelService
{

    public function getAll()
    {
        return CarModel::paginate(10);
    }

    public function getCarModel(CarModel $model): CarModel
    {
        return $model;
    }

    public function getCarModelByBrandId($brandId)
    {
        return CarModel::where('brand_id', $brandId)->get();
    }

    public function createCarModel(StoreCarModelRequest $request): CarModel
    {
        return CarModel::create($request->validated());
    }

    public function updateCarModel(UpdateCarModelRequest $request, CarModel $model): CarModel
    {
        $model->update($request->validated());
        return $model;
    }

    public function deleteCarModel(CarModel $model): void
    {
        $model->delete();
    }
}
