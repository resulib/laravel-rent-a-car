<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiModelNotFoundException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandController extends Controller
{
    public function index()
    {
        return BrandResource::collection(Brand::paginate(10));
    }

    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    public function store(StoreBrandRequest $request)
    {
        if (Brand::create($request->validated())) {
            return ApiResponse::success("Brand created successfully", 201);
        }
        return ApiResponse::error("Error creating brand", 422);
    }


    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        try {
            $brand->update($request->validated());
            return ApiResponse::success("Brand updated successfully", 200);

        } catch (ModelNotFoundException $e) {
            return ApiResponse::error("Brand not found with id: {$brand->id}", 404);

        } catch (\Exception $e) {
            return ApiResponse::error("Error updating brand: " . $e->getMessage(), 500);
        }
    }

    public function destroy(Brand $brand)
    {
        if ($brand->delete()) {
            return ApiResponse::success("Brand deleted successfully", 200);
        }
        return ApiResponse::error("Error deleting car", 422);
    }

    private function getBrand($id)
    {
        return findModelOrFail(Brand::class, $id,);
    }
}
