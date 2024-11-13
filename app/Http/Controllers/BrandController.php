<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        return Inertia::render(
            'Brand/Index',
            [
                "brands" => Brand::search($request)->paginate($perPage)->through(fn($data) => [
                    'id' => $data->id,
                    'name' => $data->name,
                    'logo' => asset('storage/' . $data->logo),
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
        return Inertia::render('Brand/Manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        DB::beginTransaction();
        try {
            // Store the logo file if it exists
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            // Create a new Brand 
            Brand::create([
                'name' => $request->input('name'),
                'logo' => $logoPath,
            ]);

            DB::commit();

            return to_route('brand.index')->with('success', 'Brand created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('brand.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        // Update the logo path to include the full URL
        $brand->logo = asset('storage/' . $brand->logo);
        return Inertia::render('Brand/Manage', [
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        DB::beginTransaction();
        try {
            // Store the logo file if it exists
            if ($request->hasFile('logo')) {

                //remove old image
                if (Storage::disk('public')->exists($brand->logo)) {
                    Storage::disk('public')->delete($brand->logo);
                }

                $logoPath = null;
                $logoPath = $request->file('logo')->store('logos', 'public');
                $brand->logo = $logoPath;
            }
            $brand->name = $request->input('name');
            $brand->save();

            DB::commit();

            return to_route('brand.index')->with('success', 'Brand updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('brand.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // check this brand has models
        if ($brand && $brand->models()->count() > 0) {
            return to_route('brand.index')
                ->with('error', 'This brand has associated brand models and cannot be deleted.');
        }

        DB::beginTransaction();
        try {
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }
            $brand->delete();
            DB::commit();
            return to_route('brand.index')->with('success', 'Brand deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return to_route('brand.index')->with('error', 'Something went wrong');
        }
    }

    function brand_list(Request $request)
    {
        $brands = Brand::search($request)->get()->map(fn($data) => [
            'id' => $data->id,
            'name' => $data->name,
            'logo' => asset('storage/' . $data->logo),
        ]);

        $brandCount = $brands->count();

        return Inertia::render(
            'Brand/List',
            [
                'brands' => $brands,
                'brandCount' => $brandCount,
                'search' => $request->search,
                'active_letter' => $request->active_letter,
            ]
        );
    }
}
