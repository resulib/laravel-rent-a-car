<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Mockery\Exception;

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
        try {
            Brand::create($request->validated());
            return ApiResponse::success("Brand created successfully", 201);
        } catch (Exception $e) {
            return ApiResponse::error("Error creating brand: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        try {
            $brand->update($request->validated());
            return ApiResponse::success("Brand updated successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error updating brand: " . $e->getMessage(), 500);
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return ApiResponse::success("Brand deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting brand: " . $e->getMessage(), 422);
        }
    }

    private function getBrand($id)
    {
        return findModelOrFail(Brand::class, $id,);
    }
}
