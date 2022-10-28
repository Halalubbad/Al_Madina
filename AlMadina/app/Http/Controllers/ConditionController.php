<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\Offer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // dd($request->input('id'));
        if($request->has('id')){
            $conditions = Condition::where('offer_id','=',$request->input('id'))->get();
            $offer = Offer::where('id','=',$request->input('id'))->get();
                return response()->view('admin.conditions.index',['conditions' => $conditions , 'offer' => $offer ,'request' => $request]);
        }else{
            $conditions = Condition::all();
            return Response()->view('admin.conditions.index',['conditions' => $conditions]);
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
        $offers = Offer::all();
        return response()->view('admin.conditions.create',['offers' => $offers]);
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
            'offer_id' => 'required|numeric|exists:offers,id',            
            'condition' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $condition = new Condition();
            $condition->offer_id = $request->input('offer_id');
            $condition->name = $request->input('condition');
            $isSaved = $condition->save();
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
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function edit(Condition $condition)
    {
        //
        $offers = Offer::all();
        return response()->view('admin.conditions.edit',['condition' => $condition, 'offers' => $offers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        //
        $validator = Validator($request->all(), [
            'offer_id' => 'required|numeric|exists:offers,id',            
            'condition' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $condition->offer_id = $request->input('offer_id');
            $condition->name = $request->input('condition');
            $isSaved = $condition->save();
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
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)
    {
        //
        $deleted = $condition->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Delete failed!'],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
