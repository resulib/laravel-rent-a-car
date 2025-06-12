<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{

    protected $fillable = [
        'name',
        'brand_id',
        'is_active'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'car_model_id');
    }
}
