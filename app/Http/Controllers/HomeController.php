<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarModel;
use App\Services\CarService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }
    public function home()
    {
        $popularCars = $this->carService->getRandomCars();
        return view('user.home', compact('popularCars'));
    }
}
