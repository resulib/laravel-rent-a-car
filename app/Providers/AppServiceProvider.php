<?php

namespace App\Providers;

use App\Exceptions\ApiModelNotFoundException;
use App\Models\Car;
use App\Models\Page;
use App\Observers\CarObserver;
use App\Observers\PageObserver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Car::observe(CarObserver::class);
        Page::observe(PageObserver::class);
    }
}
