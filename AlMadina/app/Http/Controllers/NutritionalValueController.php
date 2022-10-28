<?php

namespace App\Http\Controllers;

use App\Models\NutritionalValue;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NutritionalValueController extends Controller
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
            $nutritionalValues = NutritionalValue::where('product_id','=',$request->input('id'))->get();
            return response()->view('admin.nutritionalValue.index', ['request' => $request,'nutritionalValues' => $nutritionalValues]);
        } else {
            $nutritionalValues = NutritionalValue::with('product')->get();
            return response()->view('admin.nutritionalValue.index', ['request' => $request,'nutritionalValues' => $nutritionalValues]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        return response()->view('admin.nutritionalValue.create', ['products' => $products]);
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
            'product_id' => 'required|numeric|exists:products,id',
            'energy' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'fatty' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'proteins' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'carbohydrates' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'vitaminC' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ]);
        if (!$validator->fails()) {
            $nutritionalValue = new nutritionalValue();
            $nutritionalValue->product_id = $request->input('product_id');
            $nutritionalValue->energy = $request->input('energy');
            $nutritionalValue->fatty = $request->input('fatty');
            $nutritionalValue->proteins = $request->input('proteins');
            $nutritionalValue->carbohydrates = $request->input('carbohydrates');
            $nutritionalValue->vitaminC = $request->input('vitaminC');
            $isSaved = $nutritionalValue->save();
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
     * @param  \App\Models\NutritionalValue  $nutritionalValue
     * @return \Illuminate\Http\Response
     */
    public function show(NutritionalValue $nutritionalValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NutritionalValue  $nutritionalValue
     * @return \Illuminate\Http\Response
     */
    public function edit(NutritionalValue $nutritionalValue)
    {
        //
        $products = Product::all();
        return response()->view('admin.nutritionalValue.edit', ['products' => $products, 'nutritionalValue' => $nutritionalValue]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NutritionalValue  $nutritionalValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NutritionalValue $nutritionalValue)
    {
        //
        $validator = Validator($request->all(), [
            'product_id' => 'required|numeric|exists:products,id',
            'energy' => 'required|string|min:3',
            'fatty' => 'required|string|min:3',
            'proteins' => 'required|string|min:3',
            'carbohydrates' => 'required|string|min:3',
            'vitaminC' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $nutritionalValue->product_id = $request->input('product_id');
            $nutritionalValue->energy = $request->input('energy');
            $nutritionalValue->fatty = $request->input('fatty');
            $nutritionalValue->proteins = $request->input('proteins');
            $nutritionalValue->carbohydrates = $request->input('carbohydrates');
            $nutritionalValue->vitaminC = $request->input('vitaminC');
            $isSaved = $nutritionalValue->save();
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
     * @param  \App\Models\NutritionalValue  $nutritionalValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(NutritionalValue $nutritionalValue)
    {
        //
        $deleted = $nutritionalValue->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Delete failed!'],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
