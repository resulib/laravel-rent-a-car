<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Mockery\Exception;

class BrandController extends Controller
{

    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        return BrandResource::collection($this->brandService->getAll());
    }

    public function show(Brand $brand)
    {
        $brand = $this->brandService->getBrand($brand);
        return new BrandResource($brand);
    }

    public function store(StoreBrandRequest $request)
    {
        try {
            $this->brandService->createBrand($request);
            return ApiResponse::success("Brand created successfully", 201);
        } catch (Exception $e) {
            return ApiResponse::error("Error creating brand: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        try {
            $this->brandService->updateBrand($request, $brand);
            return ApiResponse::success("Brand updated successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error updating brand: " . $e->getMessage(), 422);
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $this->brandService->deleteBrand($brand);
            return ApiResponse::success("Brand deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting brand: " . $e->getMessage(), 422);
        }
    }
}
