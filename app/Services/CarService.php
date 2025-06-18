<?php

namespace App\Services;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarService
{

    public function getAll()
    {
        return Car::paginate(10);
    }

    public function getCar(Car $car)
    {
        return $car;
    }

    public function searchAndFilter(Request $request)
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

        return response()->json([
            'cars' => CarResource::collection($cars),
            'pagination' => [
                'total' => $cars->total(),
                'per_page' => $cars->perPage(),
                'current_page' => $cars->currentPage(),
                'last_page' => $cars->lastPage(),
            ]
        ]);
    }

    public function createCar(StoreCarRequest $request)
    {
        return Car::create($request->validated());
    }

    public function updateCar(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());
        return $car;
    }

    public function deleteCar(Car $car)
    {
        $car->delete();
    }
}
