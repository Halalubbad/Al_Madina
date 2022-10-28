<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $albums = Album::with('album_images')->get();
        return response()->view('admin.albums.index',['albums' => $albums]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('admin.albums.create');
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
            // 'image' => 'required|image|mimes:png,jpg,jpeg',
            'video' => 'required',
            'text' => 'required|string|min:3',            
            'title' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $album = new Album();
            $album->title = $request->input('title');
            $album->text = $request->input('text');
            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $imageName = time() . '_album_image.' . $file->getClientOriginalExtension();
            //     $request->file('image')->storePubliclyAs('images/albums', $imageName);
            //     $imagePath = 'images/albums/' . $imageName;
            //     $album->image = $imagePath;
            // }
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $videoName = time() . '_album_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/albums', $videoName);
                $videoPath = 'videos/albums/' . $videoName;
                $album->video = $videoPath;
            }
            $isSaved = $album->save();
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
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
        return response()->view('admin.albums.edit',['album' => $album]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        //
        $validator = Validator($request->all(), [
            'video' => 'required',
            'text' => 'required|string|min:3',            
            'title' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $album->title = $request->input('title');
            $album->text = $request->input('text');
            if ($request->hasFile('video')) {
                Storage::delete($album->video);
                $file = $request->file('video');
                $videoName = time() . '_album_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/albums', $videoName);
                $videoPath = 'videos/albums/' . $videoName;
                $album->video = $videoPath;
            }
            $isSaved = $album->save();
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
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $deleted = $album->delete();
        if ($deleted) {
            Storage::delete($album->video);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Album deleted successfully' : 'Album deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
