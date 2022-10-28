<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
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
            $offer = Offer::with('conditions')->withCount('conditions')->where('id','=',$request->input('id'))->get();
            return view('admin.offers.offer_details',compact('offer'));
        } else {
            $offers = Offer::with('conditions')->withCount('conditions')->get();
            return Response()->view('admin.offers.index', ['offers' => $offers]);
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
        return response()->view('admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //mimes:mp4,ogx,oga,ogv,ogg,webm,wmv
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'video' => 'required',
            'text' => 'required|string|min:3',
            'title' => 'required|string|min:3',
            'expired_at' => 'required',
            'Joining_mechanism' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $offer = new Offer();
            $offer->title = $request->input('title');
            $offer->text = $request->input('text');
            $offer->Joining_mechanism = $request->input('Joining_mechanism');
            $offer->expired_at = $request->input('expired_at');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_offer_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/offers', $imageName);
                $imagePath = 'images/offers/' . $imageName;
                $offer->image = $imagePath;
            }
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $videoName = time() . '_offer_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/offers', $videoName);
                $videoPath = 'videos/offers/' . $videoName;
                $offer->video = $videoPath;
            }
            $isSaved = $offer->save();
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
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
        return response()->view('admin.offers.edit', ['offer' => $offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'video' => 'required',
            'text' => 'required|string|min:3',
            'title' => 'required|string|min:3',
            'expired_at' => 'required',
            'Joining_mechanism' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $offer->title = $request->input('title');
            $offer->text = $request->input('text');
            $offer->Joining_mechanism = $request->input('Joining_mechanism');
            $offer->expired_at = $request->input('expired_at');
            if ($request->hasFile('image')) {
                Storage::delete($offer->image);
                $file = $request->file('image');
                $imageName = time() . '_offer_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/offers', $imageName);
                $imagePath = 'images/offers/' . $imageName;
                $offer->image = $imagePath;
            }
            if ($request->hasFile('video')) {
                Storage::delete($offer->video);
                $file = $request->file('video');
                $videoName = time() . '_offer_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/offers', $videoName);
                $videoPath = 'videos/offers/' . $videoName;
                $offer->video = $videoPath;
            }
            $isSaved = $offer->save();
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
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
        $deleted = $offer->delete();
        if ($deleted) {
            Storage::delete($offer->image);
            Storage::delete($offer->video);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Offer deleted successfully' : 'Offer deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
