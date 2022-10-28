<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Album_Image;
use App\Models\AlbumImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AlbumImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->has('id')){
            $albumimages = AlbumImage::where('album_id','=',$request->input('id'))->get();
            $albums = Album::where('id','=',$request->input('id'))->get();
            return response()->view('admin.albumImages.index',['albumimages' => $albumimages , 'albums' => $albums]);
        }else{
            $albumimages = AlbumImage::with('album')->get();
            return response()->view('admin.albumImages.index',['albumimages' => $albumimages]);
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
        $albums = Album::all();
        return response()->view('admin.albumImages.create',['albums' => $albums]);
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
            'album_id' => 'required|numeric|exists:albums,id',
        ]);
        if (!$validator->fails()) {
            $albumimages = new AlbumImage();
            $albumimages->album_id = $request->input('album_id');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_albumimage_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/albumimages', $imageName);
                $imagePath = 'images/albumimages/' . $imageName;
                $albumimages->image = $imagePath;
            }
            $isSaved = $albumimages->save();
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
     * @param  \App\Models\Album_Image  $album_Image
     * @return \Illuminate\Http\Response
     */
    public function show(AlbumImage $album_Image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album_Image  $album_Image
     * @return \Illuminate\Http\Response
     */
    public function edit(AlbumImage $album_Image)
    {
        //
        $albums = Album::all();
        return response()->view('admin.albumImages.edit',['albums' => $albums ,'album_Image' => $album_Image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album_Image  $album_Image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlbumImage $album_Image)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'album_id' => 'required|numeric|exists:albums,id',
        ]);
        if (!$validator->fails()) {
            $album_Image->album_id = $request->input('album_id');
            if ($request->hasFile('image')) {
                Storage::delete($album_Image->image);
                $file = $request->file('image');
                $imageName = time() . '_albumimage_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/albumimages', $imageName);
                $imagePath = 'images/albumimages/' . $imageName;
                $album_Image->image = $imagePath;
            }
            $isSaved = $album_Image->save();
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album_Image  $album_Image
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlbumImage $album_Image)
    {
        //
        $deleted = $album_Image->delete();
        if ($deleted) {
            Storage::delete($album_Image->image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Image deleted successfully' : 'Image deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
