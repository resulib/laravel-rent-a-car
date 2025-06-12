<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
