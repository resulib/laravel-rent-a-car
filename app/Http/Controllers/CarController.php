<?php

namespace App\Http\Controllers;

use App\Constants\ImagePaths;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\CarModel;
use App\Services\BrandService;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{

    protected CarService $carService;
    protected BrandService $brandService;

    public function __construct(CarService $carService, BrandService $brandService)
    {
        $this->carService = $carService;
        $this->brandService = $brandService;
    }

    public function userIndex(Request $request)
    {
        $cars = $this->carService->searchAndFilter($request);
        $brands = $this->brandService->getActiveBrands();

        return view('user.cars.index', compact('cars', 'brands'));
    }


    public function adminIndex(Request $request)
    {
        $cars = $this->carService->searchAndFilter($request);
        $brands = $this->brandService->getActiveBrands();

        return view('admin.car.index', compact('cars', 'brands'));
    }


    public function show($slug)
    {
        $car = $this->carService->getCarBySlug($slug);
        $relatedCars = $this->carService->getRelatedCars($car);
        return view('user.cars.show', compact('car', 'relatedCars'));
    }


    public function create()
    {
        $brands = $this->brandService->getActiveBrands(1);
        return view('admin.car.create', compact('brands'));
    }

    public function store(StoreCarRequest $request)
    {
        $car = $this->carService->createCar($request);
        if ($request->hasFile('images')) {
            $folderPath = 'uploads/images/cars/' . $car->id;

            if (!File::exists(storage_path('app/public/' . $folderPath))) {
                File::makeDirectory(storage_path('app/public/' . $folderPath), 0777, true, true);
            }

            foreach ($request->file('images') as $image) {
                $fileName = uniqid() . ImagePaths::EXTENSION;
                $image->storeAs('public/' . $folderPath, $fileName);
                $image->storeAs($folderPath, $fileName, 'public');

            }
            return redirect(route('admin.car.index'))->with('success', 'Car added successfully');
        }
        return redirect(route('admin.car.create'))->with('error', 'Error adding car');
    }

    public function edit(Car $car)
    {
        $brands = $this->brandService->getActiveBrands();
        $models = CarModel::where('brand_id', $car->model->brand_id)->get();
        return view('admin.car.edit', compact('car', 'brands', 'models'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car = $this->carService->updateCar($request, $car);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $folderPath = 'uploads/images/cars/' . $car->id;
                $fileName = uniqid() . ImagePaths::EXTENSION;
                $image->storeAs('public/' . $folderPath, $fileName);
                $image->storeAs($folderPath, $fileName, 'public');
            }
        }
        return redirect()->route('admin.car.index')->with('success', 'Maşın uğurla yeniləndi.');
    }

    public function destroy(Car $car)
    {
        $this->carService->deleteCar($car);
        return redirect()->route('admin.car.index')->with('success', 'Car deleted successfully!');
    }

    public function deleteImage(Request $request)
    {
        $path = storage_path("app/public/uploads/images/cars/{$request->car_id}/{$request->image_name}");
        if (file_exists($path)) {
            unlink($path);
            return back()->with('success', 'Şəkil silindi.');
        }
        return back()->with('error', 'Şəkil tapılmadı.');
    }
}
