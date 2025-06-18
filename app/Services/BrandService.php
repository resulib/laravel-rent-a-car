<?php

namespace App\Services;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;

class BrandService
{

    public function getAll()
    {
        return Brand::paginate(10);
    }

    public function getBrand(Brand $brand): Brand
    {
        return $brand;
    }

    public function createBrand(StoreBrandRequest $request): Brand
    {
        return Brand::create($request->validated());
    }

    public function updateBrand(UpdateBrandRequest $request, Brand $brand): Brand
    {
        $brand->update($request->validated());
        return $brand;
    }

    public function deleteBrand(Brand $brand): void
    {
        $brand->delete();
    }


}
