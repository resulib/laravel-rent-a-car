<?php

namespace App\Providers;

use App\Exceptions\ApiModelNotFoundException;
use App\Models\Car;
use App\Observers\CarObserver;
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
    }
}
