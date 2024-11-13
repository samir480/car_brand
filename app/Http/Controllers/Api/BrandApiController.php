<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands)->response()
            ->setStatusCode(200);  // Customize the status code here;
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brand->load('models');

        return BrandResource::make($brand)->response()
            ->setStatusCode(200);  // Customize the status code here;
    }

}
