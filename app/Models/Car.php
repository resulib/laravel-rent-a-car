<?php

namespace App\Models;

use App\Enums\FuelType;
use App\Enums\Status;
use App\Enums\Transmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Car extends Model
{

    protected $fillable = [
        'car_model_id',
        'slug',
        'year',
        'description',
        'seats',
        'transmission',
        'fuel_type',
        'price_per_day',
        'status',
    ];

    protected $casts = [
        'fuel_type' => FuelType::class,
        'transmission' => Transmission::class,
        'status' => Status::class,
    ];

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function getBrandAttribute()
    {
        return $this->model?->brand;
    }

    public function getFullName(): string
    {
        $brand = $this->model?->brand?->name ?? '';
        $model = $this->model?->name ?? '';
        return trim("$brand $model $this->year");
    }

//    protected static function boot(): void
//    {
//        parent::boot();
//
//        static::created(function ($car) {
//            $car->slug = Str::slug($car->getFullName() . '-' . $car->id);
//            $car->save();
//        });
//    }
}
