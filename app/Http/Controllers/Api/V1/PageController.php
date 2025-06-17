<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Mockery\Exception;

class PageController extends Controller
{
    public function index()
    {
        return PageResource::collection(Page::paginate(10));
    }

    public function show(Page $page)
    {
        return new PageResource($page);
    }

    public function store(StorePageRequest $request)
    {
        try {
            Page::create($request->validated());
            return ApiResponse::success("Page created successfully", 201);
        } catch (Exception $e) {
            return ApiResponse::error("Error creating page: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $validated = $request->validated();

            $page->update($validated);
            return ApiResponse::success("Page updated successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error updating page: " . $e->getMessage(), 422);
        }
    }

    public function destroy(Page $page)
    {
        try {
            $page->delete();
            return ApiResponse::success("Page deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting page: " . $e->getMessage(), 422);
        }
    }
}
