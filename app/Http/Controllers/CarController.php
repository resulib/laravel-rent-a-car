<?php

namespace App\Http\Controllers;

use App\Constants\ImagePaths;
use App\Enums\FuelType;
use App\Enums\Status;
use App\Enums\Transmission;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class CarController extends Controller
{

    public function userIndex(Request $request)
    {
        $query = Car::query()->with(['model.brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('model', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->where('is_active', 1);
                })->orWhereHas('model.brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->where('is_active', 1);
                });
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('model.brand', function ($q) use ($request) {
                $q->where('id', $request->brand)
                    ->where('is_active', 1);
            });
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate(8);
        $brands = Brand::where('is_active', 1)->get();

        return view('user.cars.index', compact('cars', 'brands'));
    }


    public function adminIndex(Request $request)
    {
        $query = Car::query()->with(['model.brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('model', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->where('is_active', 1);
                })->orWhereHas('model.brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->where('is_active', 1);
                });
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('model.brand', function ($q) use ($request) {
                $q->where('id', $request->brand)
                    ->where('is_active', 1);
            });
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate(8);
        $brands = Brand::where('is_active', 1)->get();

        return view('admin.car.index', compact('cars', 'brands'));
    }


    public function show($slug)
    {
        $car = Car::where('slug', $slug)->first();

        if (!$car) {
            abort(404);
        }

        $relatedCars = Car::where('id', '!=', $car->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('user.cars.show', compact('car', 'relatedCars'));
    }


    public function create()
    {
        $brands = Brand::where('is_active', 1)->get();
        return view('admin.car.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_model_id' => 'numeric|required',
            'price_per_day' => 'numeric|required|min:1|max:100000',
            'description' => 'string|max:255',
            'year' => 'required|integer|min:2000|max:' . now()->year,
            'fuel_type' => ['required', Rule::enum(FuelType::class)],
            'transmission' => ['required', Rule::enum(Transmission::class)],
            'status' => ['required', Rule::enum(Status::class)],
            'image[]' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $car = new Car();
        $car->car_model_id = $request->car_model_id;
        $car->year = $request->year;
        $car->slug = time();
        $car->description = $request->description;
        $car->seats = $request->seats;
        $car->transmission = $request->transmission;
        $car->fuel_type = $request->fuel_type;
        $car->status = $request->status;
        $car->price_per_day = $request->price_per_day;
        $car->save();

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
        $brands = Brand::where('is_active', 1)->get();
        $models = CarModel::where('brand_id', $car->model->brand_id)->get();
        return view('admin.car.edit', compact('car', 'brands', 'models'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'seats' => 'required|integer|min:1|max:10',
            'fuel_type' => ['required', Rule::enum(FuelType::class)],
            'transmission' => ['required', Rule::enum(Transmission::class)],
            'status' => ['required', Rule::enum(Status::class)],
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'required|string|max:2000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $car->update([
            'car_model_id' => $validated['car_model_id'],
            'year' => $validated['year'],
            'seats' => $validated['seats'],
            'fuel_type' => $validated['fuel_type'],
            'transmission' => $validated['transmission'],
            'status' => $validated['status'],
            'price_per_day' => $validated['price_per_day'],
            'description' => $validated['description'],
        ]);

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
        $car->delete();
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
