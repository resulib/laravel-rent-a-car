<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {
        return CarResource::collection(Car::paginate());
    }

    public function search(Request $request)
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
