<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $abouts = About::all();
        return Response()->view('admin.about.index', ['abouts' => $abouts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('admin.about.create');
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
            'video' => 'required',
            'about_title' => 'required|string|min:5',
            'about_text' => 'required|string|min:5',
            'about_message' => 'required|string|min:5',
            'about_objectives' => 'required|string|min:5',
            'social_contribution' => 'required|string|min:5',
            'team_text' => 'required|string|min:5',
        ]);
        if (!$validator->fails()) {
            $about = new About();
            $about->title = $request->input('about_title');
            $about->about_text = $request->input('about_text');
            $about->message = $request->input('about_message');
            $about->objectives = $request->input('about_objectives');
            $about->social_contribution = $request->input('social_contribution');
            $about->team_text = $request->input('team_text');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_about_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/abouts', $imageName);
                $imagePath = 'images/abouts/' . $imageName;
                $about->image = $imagePath;
            }
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $videoName = time() . '_about_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/abouts', $videoName);
                $videoPath = 'videos/abouts/' . $videoName;
                $about->video = $videoPath;
            }
            $isSaved = $about->save();
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
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        //
        return response()->view('admin.about.edit',['about' => $about]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about)
    {
        //
        // dd($request->all());
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'video' => 'required',
            'about_title' => 'required|string|min:5',
            'about_text' => 'required|string|min:5',
            'about_message' => 'required|string|min:5',
            'about_objectives' => 'required|string|min:5',
            'social_contribution' => 'required|string|min:5',
            'team_text' => 'required|string|min:5',
        ]);
        if (!$validator->fails()) {
            $about->title = $request->input('about_title');
            $about->about_text = $request->input('about_text');
            $about->message = $request->input('about_message');
            $about->objectives = $request->input('about_objectives');
            $about->social_contribution = $request->input('social_contribution');
            $about->team_text = $request->input('team_text');
            if ($request->hasFile('image')) {
                Storage::delete($about->image);
                $file = $request->file('image');
                $imageName = time() . '_about_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/abouts', $imageName);
                $imagePath = 'images/abouts/' . $imageName;
                $about->image = $imagePath;
            }
            if ($request->hasFile('video')) {
                Storage::delete($about->video);
                $file = $request->file('video');
                $videoName = time() . '_about_video.' . $file->getClientOriginalExtension();
                $request->file('video')->storePubliclyAs('videos/abouts', $videoName);
                $videoPath = 'videos/abouts/' . $videoName;
                $about->video = $videoPath;
            }
            $isSaved = $about->save();
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
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
        $deleted = $about->delete();
        if ($deleted) {
            Storage::delete($about->image);
            Storage::delete($about->video);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'About deleted successfully' : 'About deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
