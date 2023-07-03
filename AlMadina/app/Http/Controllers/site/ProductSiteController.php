<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductSiteController extends Controller
{
    //
    public function allProduct()
    {
        $products = Product::with(['tags', 'nutritionalValues', 'brand'])->paginate(10);

        $allBrands = Brand::all();
        $parents = Tag::where('parent_id', '=', 0)->get();

        $sizeTagType = Tag::where('name', 'size')->first();

        // dd($parents);
        $colorTag = Tag::where('name', '=', 'color')->with('childs')->orderBy('id', 'asc')->get();
        $sizeTag = Tag::where('name', '=', 'size')->with('childs')->orderBy('id', 'asc')->get();
        $tasteTag = Tag::where('name', '=', 'Taste')->with('childs')->orderBy('id', 'asc')->get();
        // dd($tasteTag);

        return view('al_madina.products.products', compact('products', 'allBrands', 'parents','sizeTagType' ,'colorTag', 'sizeTag', 'tasteTag'));
    }

    public function showProduct(Request $request)
    {
        $id = $request->id;
        $sizeTagType = Tag::where('name', 'size')->first();
        $show= Product::findOrFail($id);
        if ($show){
            $view = view('al_madina.products.product_details',compact('show','sizeTagType'))->render();
            return response()->json(['view'=>$view]);
        }
        return false;
    }

    public function filterProduct(Request $request)
    {
        // dd('filter_products');
        // dd($request->brand);
        // dd($request->color);
        // dd($request->brand);
        if ($request->ajax()) {
            $brand_id = $request->input('brand');
            $size_id = $request->input('size');
            $color_id = $request->input('color');
            $taste_id = $request->input('taste');

            $products = Product::query(); 
            if ($size_id != null) {
                $products =  $products->whereHas('tags', function ($query) use ($size_id) {
                    $query->where('tag_id', $size_id);
                });
            }
            if ($color_id != null) {
                $products = $products->whereHas('tags', function ($query) use ($color_id) {
                    $query->where('tag_id', $color_id);
                });
            }
            if ($taste_id != null) {
                // dd('taste');
                // dd($request->all());
                $products =  $products->whereHas('tags', function ($query) use ($taste_id) {
                    $query->where('tag_id', $taste_id);
                });
            }
            if($brand_id != null) {
                // dd('fff');
                $products = $products->whereIn('brand_id', $brand_id );
            }
            $products = $products->get();
            $sizeTagType = Tag::where('name', 'size')->first();
            // dd($products);
            $view = view('al_madina.products.product_filter',compact('products','sizeTagType'))->render();
        }
        return response()->json(['view' => $view]);
    }
}
