<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9-]+$/|unique:pages,slug',
            'content' => 'nullable|string',
            'is_active' => 'nullable|in:0,1',
        ]);

        $page = new Page();
        $page->title = $validated['title'];
        $page->slug = $validated['slug'] ?? null;
        $page->content = $validated['content'] ?? null;
        $page->is_active = $validated['is_active'] ?? 0;

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

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'content' => 'nullable|string',
        ]);


        $page->update($validated);

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
