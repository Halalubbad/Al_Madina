<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\subscribe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfferSiteController extends Controller
{
    //
    public function offers()
    {
        // dd('offers');
        $offers = Offer::with('conditions')->get();
        return view('al_madina.offers.offers', compact('offers'));
    }

    public function offer_details(Request $request)
    {
        // dd('details');
        $offers = Offer::where('id', '=', $request->input('id'))->with('conditions')->get();
        // dd($offers[0]->conditions);
        return view('al_madina.offers.offers-details', compact('offers'));
    }

    public function offerSubscribe(Request $request)
    {
        // dd($request->all());
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'code' => 'required',
            'mobile' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $subscribe = new subscribe();
            $subscribe->name = $request->input('name');
            $subscribe->email = $request->input('email');
            $subscribe->code = $request->input('code');
            $subscribe->mobile = $request->input('mobile');

            $isSaved = $subscribe->save();

            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }
}
