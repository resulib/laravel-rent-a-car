<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'is_active'
    ];
    public function models()
    {
        return $this->hasMany(CarModel::class, 'brand_id');
    }
}
