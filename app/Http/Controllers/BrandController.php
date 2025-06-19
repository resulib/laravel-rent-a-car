<?php

namespace App\Http\Controllers;

use App\Constants\ImagePaths;
use App\Helpers\ImageHelper;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;

class BrandController extends Controller
{

    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brands = Brand::withCount('models')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandService->createBrand($request);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs(ImagePaths::BRAND_LOGO_DIR, ImageHelper::generateBrandLogoName($brand), 'public');
        }
        return redirect(route('admin.brand.create'))->with('success', 'Brand added successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand = $this->brandService->updateBrand($request, $brand);

        if ($request->hasFile('image')) {
            $filename = strtolower($brand->id . ImagePaths::EXTENSION);

            if ($brand->image && file_exists(storage_path(ImagePaths::BRAND_LOGO_DIR . $brand->image))) {
                unlink(storage_path(ImagePaths::BRAND_LOGO_DIR . $brand->image));
            }
            $request->file('image')->storeAs(ImagePaths::BRAND_LOGO_DIR, $filename, 'public');
        }
        return redirect()->route('admin.brand.index', $brand)->with('success', 'Brand updated successfully!');
    }


    public function destroy(Brand $brand)
    {
        $this->brandService->deleteBrand($brand);
        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully!');
    }
}
