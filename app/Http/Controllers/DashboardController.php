<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\Brand;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function index()
    {

        $brands_count = Brand::count();
        $models_count = BrandModel::count();

        return Inertia::render(
            'Dashboard',
            [
                'brands_count' => $brands_count,
                'models_count' => $models_count,
            ]
        );
    }
}
