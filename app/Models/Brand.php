<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(BrandModel::class);
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request->search)) {
            $value = "%" . $request->search . "%";
            $query->where('name', 'like', $value);
        }
    }
}
