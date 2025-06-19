<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageService;

class PageController extends Controller
{
    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        $pages = $this->pageService->getAll();
        return view('admin.pages.index', compact('pages'));
    }

    public function show(Page $page)
    {
        $page = $this->pageService->getPage($page);
        return view('user.pages.show', compact('page'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $page = $this->pageService->createPage($request);
        if ($page->save()) {
            return redirect()->route('admin.pages.index')
                ->with('success', 'Səhifə yaradıldı.');
        }

        return redirect()->route('admin.pages.create')
            ->with('error', 'Xəta baş verdi.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page = $this->pageService->updatePage($request, $page);

        if ($page) {
            return redirect()->route('admin.pages.index')->with('success', 'Səhifə ugurla yeniləndi.');
        }
        return redirect()->route('admin.pages.edit')->with('success', 'Səhifə yenilenmedi xeta bas verdi.');
    }

    public function destroy(Page $page)
    {
        $this->pageService->deletePage($page);
        return back()->with('success', 'Səhifə silindi.');
    }

}
