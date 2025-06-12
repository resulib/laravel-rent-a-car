<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $popularCars = Car::inRandomOrder()->take(8)->get();
        return view('user.home', compact('popularCars'));
    }
}
