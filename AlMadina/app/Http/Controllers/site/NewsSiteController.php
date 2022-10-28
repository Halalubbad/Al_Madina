<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsSiteController extends Controller
{
    //
    public function news()
    {
        $allnews = News::with('comments')->get();
        return view('al_madina.news.news', compact('allnews'));
    }

    public function news_details(Request $request)
    {
        // dd($request->input('id'));
        $newsD = News::where('id', '=', $request->input('id'))->with('comments')->withCount('comments')->get();
        // dd($newsD);
        $allnews = News::all();
        $comments = Comment::where('news_id', '=', $request->input('id'))->get();
        // dd($comments);
        return view('al_madina.news.news-details', compact('newsD', 'comments', 'allnews'));
    }

    public function add_comment(Request $request)
    {
        // dd('commets');
        // dd($request->all());
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'comment' => 'required|string|min:3',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        $comment = new Comment();
        $comment->client_name = $request->input('name');
        $comment->text = $request->input('comment');
        $comment->news_id = $request->input('news_id');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_comment_image.' . $file->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('images/comments', $imageName);
            $imagePath = 'images/comments/' . $imageName;
            $comment->image = $imagePath;
        }
        $isSaved = $comment->save();
        return response()->json([
            'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }
}
