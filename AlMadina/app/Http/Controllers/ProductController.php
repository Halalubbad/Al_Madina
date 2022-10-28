<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->has('id')) {
            // dd($request->input('id'));
            $product = Product::where('id', '=', $request->input('id'))->with(['nutritionalValues', 'brand'])->get();
            return view('admin.products.product_details', compact('product'));
        } else {
            $products = Product::with(['nutritionalValues', 'brand'])->get();
            $tags = Tag::all();

            return view('admin.products.index', compact('products', 'tags'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->has('id')) {
            // $tags = Tag::where('parent_id', '=', 0)->get();
            // $product = Product::where('id', '=', $request->input('id'))->get();
            // return view('admin.product_tag.create', ['request' => $request, 'product' => $product, 'tags' => $tags]);
        } else {
            $tags = Tag::where('parent_id', '=', 0)->get();
            $brands = Brand::all();
            return view('admin.products.create', compact('tags', 'brands'));
        }
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
            'product_name' => 'required|string|min:3',
            'price' => 'required|integer',
            'product_ingredients' => 'required|string|min:5',
            'brand_id' => 'required|numeric|exists:brands,id'

        ]);
        if (!$validator->fails()) {
            $product = new Product();
            $product->name = $request->input('product_name');
            $product->price = $request->input('price');
            $product->brand_id = $request->input('brand_id');
            $product->product_ingredients = $request->input('product_ingredients');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_news_product.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/products', $imageName);
                $imagePath = 'images/products/' . $imageName;
                $product->image = $imagePath;
            }
            $isSaved = $product->save();

            // $product_tag = new ProductTag();
            // $product_tag->tag_id = $request->input('tag_id');
            // $product_tag->product_id = $product->id;
            // $product_tag->save();

            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request)
    {
        //
        if ($request->has('id')) {
            dd($product);
            $tags = Tag::where('parent_id', '=', 0)->get();
            $product = Product::where('id', '=', $request->input('id'))->get();
            return view('admin.product_tag.edit', ['product' => $product, 'tags' => $tags, 'request' => $request]);
        } else {
            // dd($product);
            $brands = Brand::all();
            return view('admin.products.edit', compact('product', 'brands'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'product_name' => 'required|string|min:3',
            'price' => 'required|integer',
            'product_ingredients' => 'required|string|min:5',
            'brand_id' => 'required|numeric|exists:brands,id'

        ]);
        if (!$validator->fails()) {
            $product->name = $request->input('product_name');
            $product->price = $request->input('price');
            $product->brand_id = $request->input('brand_id');
            $product->product_ingredients = $request->input('product_ingredients');
            if ($request->hasFile('image')) {
                Storage::delete($product->image);
                $file = $request->file('image');
                $imageName = time() . '_news_product.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/products', $imageName);
                $imagePath = 'images/products/' . $imageName;
                $product->image = $imagePath;
            }
            $isSaved = $product->save();
            return response()->json([
                'message' => $isSaved ? 'Updated successfully' : 'Update failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $deleted = $product->delete();
        if ($deleted) {
            Storage::delete($product->image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Product deleted successfully' : 'Product deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
