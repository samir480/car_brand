<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'image',
        'year',
    ];
}
