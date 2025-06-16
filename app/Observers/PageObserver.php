<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{

    public function creating(Page $page): void
    {
        if (empty($page->slug)) {
            $baseSlug = Str::slug($page->title);
            $slug = $baseSlug;
            $i = 1;

            // Slug təkrarlanmasın deyə yoxlama
            while (Page::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $page->slug = $slug;
        }
    }

    public function updating(Page $page): void
    {
        if (empty($page->slug)) {
            $baseSlug = Str::slug($page->title);
            $slug = $baseSlug;
            $i = 1;

            while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $page->slug = $slug;
        }
    }
    /**
     * Handle the Page "created" event.
     */
    public function created(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        //
    }
}
