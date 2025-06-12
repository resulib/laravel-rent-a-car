<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages',
            'content' => 'required'
        ]);

        $page = new Page();
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->content = $request->content;
        $page->is_active = $request->is_active;

        if ($page->save()) {
            return redirect()->route('admin.pages.index')->with('success', 'Səhifə yaradıldı.');
        }
        return redirect()->route('admin.pages.create')->with('error', 'Xeta bas verdi.');

    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,' . $page->id,
            'content' => 'required'
        ]);

        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->content = $request->content;
        $page->is_active = $request->is_active;

        if ($page->save()) {
            return redirect()->route('admin.pages.index')->with('success', 'Səhifə ugurla yeniləndi.');
        }
        return redirect()->route('admin.pages.edit')->with('success', 'Səhifə yenilenmedi xeta bas verdi.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Səhifə silindi.');
    }

    public function show(Page $page)
    {
        if (!$page->is_active) {
            abort(404);
        }
        return view('user.pages.show', compact('page'));
    }
}
