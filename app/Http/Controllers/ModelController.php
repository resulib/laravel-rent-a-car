<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Models\CarModel;
use App\Services\BrandService;
use App\Services\CarModelService;
use Illuminate\Http\Request;

class ModelController extends Controller
{

    protected CarModelService $carModelService;
    protected BrandService $brandService;

    public function __construct(CarModelService $carModelService, BrandService $brandService)
    {
        $this->carModelService = $carModelService;
        $this->brandService = $brandService;
    }

    public function index()
    {
        $models = $this->carModelService->getAll();
        return view('admin.model.index', compact('models'));
    }

    public function modelsByBrand(Request $request)
    {
        $models = $this->carModelService->getCarModelByBrandId($request->brand_id);
        return response()->json($models);
    }

    public function create()
    {
        $brands = $this->brandService->getActiveBrands();
        return view('admin.model.create', compact('brands'));
    }

    public function store(StoreCarModelRequest $request)
    {

        $model = $this->carModelService->createCarModel($request);
        if ($model->save()) {
            return redirect(route('admin.model.index'))->with('success', 'Model created successfully');
        }
        return redirect(route('admin.model.create'))->with('error', 'Error creating model');
    }

    public function edit(CarModel $model)
    {
        $brands = $this->brandService->getActiveBrands();
        return view('admin.model.edit', compact('model', 'brands'));
    }

    public function update(UpdateCarModelRequest $request, CarModel $model)
    {
        $this->carModelService->updateCarModel($request, $model);
        return redirect()->route('admin.model.index', $model)->with('success', 'Brand updated successfully!');
    }

    public function destroy(CarModel $model)
    {
        $this->carModelService->deleteCarModel($model);
        return redirect()->route('admin.model.index')->with('success', 'Model deleted successfully!');
    }
}
