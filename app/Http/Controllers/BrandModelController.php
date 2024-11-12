<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandModelRequest;
use App\Http\Requests\UpdateBrandModelRequest;
use App\Models\Brand;
use App\Models\BrandModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BrandModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        return Inertia::render(
            'Model/Index',
            [
                "models" => BrandModel::with(['brand'])->search($request)->paginate($perPage)->through(fn($data) => [
                    'id' => $data->id,
                    'name' => $data->name,
                    'year' => $data->year,
                    'image' => asset('storage/' . $data->image),
                    'brand' => $data->brand->name
                ]),
                "search" => $request->input('search')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Model/Manage',
            [
                'brands' => Brand::all(['id', 'name'])
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandModelRequest $request)
    {
        DB::beginTransaction();
        try {
            // Store the logo file if it exists
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            }

            // Create a new Brand 
            BrandModel::create([
                'name' => $request->input('name'),
                'image' => $imagePath,
                'year' =>  $request->input('year'),
                'brand_id' => $request->input('brand_id')
            ]);

            DB::commit();

            return to_route('model.index')->with('success', 'Brand model created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('model.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BrandModel $brandModel)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrandModel $brandModel)
    {
        $brandModel->image = asset('storage/' . $brandModel->image);
        return Inertia::render('Model/Manage', [
            'model' => $brandModel->only(['id', 'name', 'year', 'brand_id', 'image']),
            'brands' => Brand::all(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandModelRequest $request, BrandModel $brandModel)
    {
        DB::beginTransaction();
        try {
            // Store the logo file if it exists
            $imagePath = null;
            if ($request->hasFile('image')) {

                //remove old image
                if (Storage::disk('public')->exists($brandModel->image)) {
                    Storage::disk('public')->delete($brandModel->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $brandModel->image = $imagePath;
            }

            $brandModel->name = $request->input('name');
            $brandModel->year = $request->input('year');
            $brandModel->brand_id = $request->input('brand_id');
            $brandModel->save(); // update

            DB::commit();

            return to_route('model.index')->with('success', 'Brand model updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('model.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandModel $brandModel)
    {
        DB::beginTransaction();
        try {
            if (Storage::disk('public')->exists($brandModel->image)) {
                Storage::disk('public')->delete($brandModel->image);
            }
            $brandModel->delete();
            DB::commit();
            return to_route('model.index')->with('success', 'Brand model deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('model.index')->with('error', 'Something went wrong');
        }
    }
}
