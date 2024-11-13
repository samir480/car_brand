<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandModelRequest;
use App\Http\Resources\BrandModelResource;
use App\Models\BrandModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandModelApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandModelRequest $request)
    {
        DB::beginTransaction();
        try {

            // Create a new Brand 
            $brandModel = BrandModel::create([
                'name' => $request->input('name'),
                'year' =>  $request->input('year'),
                'brand_id' => $request->input('brand_id')
            ]);

            DB::commit();

            return response()->json([
                'data' => BrandModelResource::make($brandModel),
                'message' => 'Brand model created successfully',
            ], 201); // 201 for resource creation
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
