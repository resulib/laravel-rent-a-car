<?php

namespace App\Http\Controllers;

use App\Constants\ImagePaths;
use App\Helpers\ImageHelper;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('models')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'in:0,1',

        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->is_active = $request->is_active;
        $brand->save();

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

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:png|max:2048',
        ]);

        $brand->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

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
        $brand->delete();
        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully!');
    }
}
