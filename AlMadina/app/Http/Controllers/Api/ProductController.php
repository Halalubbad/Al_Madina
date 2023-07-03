<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update','destroy');
    }
    //
    public function index()
    {
        return Product::with('brand', 'nutritionalValues')->get();
    }

    // public function show($id){
    //     return Product::findOrFail($id);
    // }

    // model binding
    public function show(Product $product)
    {
        return $product->load('brand', 'nutritionalValues');
    }

    public function store(Request $request)
    {
        //
        $user = Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.create')){
            abort(403, 'You can not do this!');
        }

        Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'product_name' => 'required|string|min:3',
            'price' => 'required|integer',
            'product_ingredients' => 'required|string|min:5',
            'brand_id' => 'required|numeric|exists:brands,id'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_news_product.' . $file->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('images/products', $imageName);
            $imagePath = 'images/products/' . $imageName;
            $data['image'] = $imagePath;
        }

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        //

        $user = Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.update')){
            abort(403, 'You can not do this!');
        }

        Validator($request->all(), [
            'image' => 'sometimes|required|image|mimes:png,jpg,jpeg',
            'product_name' => 'sometimes|required|string|min:3',
            'price' => 'sometimes|required|integer',
            'product_ingredients' => 'sometimes|required|string|min:5',
            'brand_id' => 'sometimes|required|numeric|exists:brands,id'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_news_product.' . $file->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('images/products', $imageName);
            $imagePath = 'images/products/' . $imageName;
            $data['image'] = $imagePath;
        }

        $old_image = $product->image;
        $product->update($data);

        if ($old_image && isset($date['image'])) {
            Storage::delete($old_image);
        }

        // return response()->json($product , 201);
        return [
            'message' => 'Product updated successfully',
            'Product ' => $product
        ];
    }

    public function destroy($id)
    {
        //
        $user = Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.delete')){
            abort(403, 'You can not do this!');
        }
        Product::destroy($id);
        // if ($deleted) {
        //     Storage::delete($product->image);
        // }

        return response()->json([
            'message' => "Product $id deleted successfully", 
        ]);
        
    }
}
