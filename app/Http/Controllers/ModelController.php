<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        $models = CarModel::paginate(10);
        return view('admin.model.index', compact('models'));
    }

    public function modelsByBrand(Request $request)
    {
        $models = CarModel::where('brand_id', $request->brand_id)->get();
        return response()->json($models);
    }

    public function create()
    {
        $brands = Brand::where('is_active', '1')->get();
        return view('admin.model.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:255',
            'brand_id' => 'numeric|required',
            'is_active' => 'in:0,1'
        ]);

        $model = new CarModel();
        $model->name = $request->name;
        $model->brand_id = $request->brand_id;
        $model->is_active = $request->is_active;

        if ($model->save()) {
            return redirect(route('admin.model.index'))->with('success', 'Model created successfully');
        }
        return redirect(route('admin.model.create'))->with('error', 'Error creating model');
    }

    public function edit(CarModel $model)
    {
        $brands = Brand::where('is_active', '1')->get();
        return view('admin.model.edit', compact('model', 'brands'));
    }

    public function update(Request $request, CarModel $model)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        $model->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
        ]);
        return redirect()->route('admin.model.index', $model)->with('success', 'Brand updated successfully!');
    }

    public function destroy(CarModel $model)
    {
        $model->delete();
        return redirect()->route('admin.model.index')->with('success', 'Model deleted successfully!');
    }
}
