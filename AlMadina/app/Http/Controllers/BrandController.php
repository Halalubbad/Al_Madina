<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'brand_name' => 'required|string|min:3',
        ]);
        $brand = new Brand();
        $brand->name = $request->input('brand_name');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_brand_image.' . $file->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('images/brands', $imageName);
            $imagePath = 'images/brands/' . $imageName;
            $brand->brand_image = $imagePath;
        }
        $isSaved = $brand->save();
        return response()->json([
            'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'brand_name' => 'required|string|min:3',
        ]);
        $brand->name = $request->input('brand_name');
        if ($request->hasFile('image')) {
            Storage::delete($brand->brand_image);
            $file = $request->file('image');
            $imageName = time() . '_brand_image.' . $file->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('images/brands', $imageName);
            $imagePath = 'images/brands/' . $imageName;
            $brand->brand_image = $imagePath;
        }
        $isSaved = $brand->save();
        return response()->json([
            'message' => $isSaved ? 'Updated successfully' : 'Update failed!'
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
        $deleted = $brand->delete();
        if ($deleted) {
            Storage::delete($brand->brand_image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Brand deleted successfully' : 'Brand deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
