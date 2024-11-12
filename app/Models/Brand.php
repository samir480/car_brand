<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
    ];

    public function scopeSearch($query, $request)
    {
        if (isset($request->search)) {
            $value = "%" . $request->search . "%";
            $query->where('name', 'like', $value);
        }
    }
}
