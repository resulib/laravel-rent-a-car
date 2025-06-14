<?php

namespace App\Observers;

use App\Models\Car;
use Illuminate\Support\Str;

class   CarObserver
{
    /**
     * Handle the Car "created" event.
     */
    public function created(Car $car): void
    {
    }

    public function creating(Car $car): void
    {
        $car->slug = Str::slug($car->getFullName() . '-' . $car->id);
    }

    /**
     * Handle the Car "updated" event.
     */
    public function updated(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "deleted" event.
     */
    public function deleted(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "restored" event.
     */
    public function restored(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "force deleted" event.
     */
    public function forceDeleted(Car $car): void
    {
        //
    }
}
