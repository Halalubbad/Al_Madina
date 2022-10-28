<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $news = News::withCount('comments')->get();
        return Response()->view('admin.news.index',['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('admin.news.create');
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
            'text' => 'required|string|min:3',            
            'title' => 'required|string|min:3',
            'published_at' => 'required'

        ]);
        if (!$validator->fails()) {
            $news = new News();
            $news->title = $request->input('title');
            $news->text = $request->input('text');
            $news->published_at = $request->input('published_at');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_news_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/news', $imageName);
                $imagePath = 'images/news/' . $imageName;
                $news->image = $imagePath;
            }
            $isSaved = $news->save();
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
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
        return response()->view('admin.news.edit',['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'text' => 'required|string|min:3',            
            'title' => 'required|string|min:3',
            'published_at' => 'required'

        ]);
        if (!$validator->fails()) {
            $news->title = $request->input('title');
            $news->text = $request->input('text');
            $news->published_at = $request->input('published_at');
            if ($request->hasFile('image')) {
                Storage::delete($news->image);
                $file = $request->file('image');
                $imageName = time() . '_news_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/news', $imageName);
                $imagePath = 'images/news/' . $imageName;
                $news->image = $imagePath;
            }
            $isSaved = $news->save();
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
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
        $deleted = $news->delete();
        if ($deleted) {
            Storage::delete($news->image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'News deleted successfully' : 'News deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
