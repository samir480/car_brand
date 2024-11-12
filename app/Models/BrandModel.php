<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandModel extends Model
{
    protected $fillable = [
        'name',
        'image',
        'year',
        'brand_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request->search)) {
            $value = "%" . $request->search . "%";
            $query->where('name', 'like', $value)
                ->orWhere('year', 'like', $value)
                ->orWhereHas('brand', function ($q) use ($value) {
                    $q->where('name', 'like', $value);
                });
        }
    }
}
