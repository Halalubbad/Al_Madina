<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = Tag::all();
        // $parents = Tag::where('parent_id', '=', '0')->get();
        // dd($parents[0]->name);
        return view('admin.tags.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parents = Tag::where('parent_id', '=', '0')->get();
        // $tags = Tag::all();
        return response()->view('admin.tags.create', ['parents' => $parents]);
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
        $validator = validator($request->all(), [
            'name' => 'required|string|min:3',
            'parent_id' => 'nullable',
        ]);
        if (!$validator->fails()) {
            $tag = new Tag();
            $tag->name = $request->input('name');
            $tag->parent_id = $request->input('parent_id');

            $isSaved = $tag->save();
            return response()->json([
                'message' => $isSaved ? 'Saved Successfully' : 'Save Failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
        $tags = $tag->where('parent_id' ,'=' ,$tag->id)->get();
        return response()->json(['message'=>'success' , 'data' => $tags]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
        $parents = Tag::where('parent_id', '=', '0')->get();
        return response()->view('admin.tags.edit', ['tag' => $tag, 'parents' => $parents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
        $validator = validator($request->all(), [
            'name' => 'required|string|min:3',
            'parent_id' => 'nullable',

        ]);
        if (!$validator->fails()) {
            $tag->name = $request->input('name');
            $tag->parent_id = $request->input('parent_id');

            $isSaved = $tag->save();
            return response()->json([
                'message' => $isSaved ? 'Updated Successfully' : 'Update Failed!'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
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
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        // dd('delete');
        $pp = $tag->parent_id;
        if ($pp == 0) {
            // dd('parent');
            Tag::where('parent_id' , '=' , $tag->id)->delete();
            $deleted = $tag->delete();
        }else{
            $deleted = $tag->delete();
        }
        
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Tag deleted successfully' : 'Tag deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
