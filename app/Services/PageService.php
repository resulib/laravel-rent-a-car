<?php

namespace App\Services;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;

class PageService
{

    public function getAll()
    {
        return Page::paginate(10);
    }

    public function getPage(Page $page)
    {
        return $page;
    }

    public function createPage(StorePageRequest $request)
    {
        return Page::create($request->validated());
    }

    public function updatePage(UpdatePageRequest $request, Page $page)
    {
        return $page->update($request->validated());
    }

    public function deletePage(Page $page)
    {
        $page->delete();
    }
}
