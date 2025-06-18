<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Services\PageService;
use Mockery\Exception;

class PageController extends Controller
{

    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        return PageResource::collection($this->pageService->getAll());
    }

    public function show(Page $page)
    {
        return new PageResource($this->pageService->getPage($page));
    }

    public function store(StorePageRequest $request)
    {
        try {
            $this->pageService->createPage($request);
            return ApiResponse::success("Page created successfully", 201);
        } catch (Exception $e) {
            return ApiResponse::error("Error creating page: " . $e->getMessage(), 422);
        }
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $this->pageService->updatePage($request, $page);
            return ApiResponse::success("Page updated successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error updating page: " . $e->getMessage(), 422);
        }
    }

    public function destroy(Page $page)
    {
        try {
            $this->pageService->deletePage($page);
            return ApiResponse::success("Page deleted successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Error deleting page: " . $e->getMessage(), 422);
        }
    }
}
