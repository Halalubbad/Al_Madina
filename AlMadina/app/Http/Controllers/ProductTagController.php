<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $productTags = ProductTag::all();
        // $products = Product::with('tags')->withCount('tags')->whereHas('tags')->get();
        // return Response()->view('admin.product_tag.index', ['products' => $products, 'productTags' => $productTags]);

        $productTags = ProductTag::with(['product', 'tag'])->get();
        return Response()->view('admin.product_tag.index', ['productTags' => $productTags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        // dd($request->input('id'));
        $tags = Tag::where('parent_id', '=', 0)->get();
        $product = Product::where('id', '=', $request->input('id'))->get();
        return response()->view('admin.product_tag.create', ['request' => $request, 'product' => $product, 'tags' => $tags]);
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
        $products = Product::where('name', '=', $request->input('product'))->with('tags')->get();
        $product_id = $products->first()->id;

        $parent_idR = $request->input('parent_idR');
        $products = Product::whereHas('tags', function ($query) use ($parent_idR) {
            $query->where('parent_id', $parent_idR);
        })->where('id', '=', $product_id)->get();
        

        // dd($products);
        // dd($products->isEmpty());
        if ($products->isEmpty()) {
            // dd('ok');
            $validator = Validator($request->all(), [
                'tag_id' => 'required|numeric|exists:tags,id',
                'product' => 'required|string|min:3',
                'parent_idR' => 'required|numeric|exists:tags,parent_id',
            ]);
            if (!$validator->fails()) {
                $product_tag = new ProductTag();
                $product_tag->tag_id = $request->input('tag_id');
                $product_tag->product_id = $product_id;
                $isSaved = $product_tag->save();

                return response()->json([
                    'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
                ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json(
                    ['message' => $validator->getMessageBag()->first()],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            // dd('nooooooooooooooo');
            return response()->json([
                'message' => 'Tag is already exists for this product!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_Tag  $product_Tag
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTag $product_Tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_Tag  $product_Tag
     * @return \Illuminate\Http\Response
     */
    public function edit(productTag $productTag)
    {
        //
        $tag_idR = $productTag->tag_id;
        $tag = Tag::where('id', '=', $tag_idR)->get();
        $parentID = $tag[0]->parent_id;
        $parent = Tag::where('id', '=', $parentID)->get();
        $allTags = Tag::where('parent_id', '=', $parentID)->get();
        return response()->view('admin.product_tag.edit', ['productTag' => $productTag, 'parent' => $parent, 'allTags' => $allTags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_Tag  $product_Tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTag $productTag)
    {
        //
        // dd($productTag);
        // dd($request->all());
        $products = Product::where('name', '=', $request->input('product_name'))->with('tags')->get();
        $product_id = $products->first()->id;
        // dd($product_id);
        $validator = Validator($request->all(), [
            'tag_id' => 'required|numeric|exists:tags,id',
            // 'product' => 'required|string|min:3',
            // 'parent_idR' => 'required|numeric|exists:tags,parent_id',
        ]);
        if (!$validator->fails()) {
            $productTag->tag_id = $request->input('tag_id');
            $productTag->product_id = $product_id;
            $isSaved = $productTag->save();

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
     * @param  \App\Models\Product_Tag  $product_Tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTag $productTag)
    {
        //
        $deleted = $productTag->delete();
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Product Tag deleted successfully' : 'Product Tag deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
