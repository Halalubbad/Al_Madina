<?php

namespace App\Http\Controllers;

use App\Models\Theysaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class TheysaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $theysaids = Theysaid::all();
        return view('admin.theysaid.index', compact('theysaids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.theysaid.create');
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
            'name' => 'required|string|min:3',
            'category' => 'required|string|min:3',
            'details' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $theysaid = new Theysaid();
            $theysaid->name = $request->input('name');
            $theysaid->category = $request->input('category');
            $theysaid->details = $request->input('details');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_theysaid_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/theysaids', $imageName);
                $imagePath = 'images/theysaids/' . $imageName;
                $theysaid->image = $imagePath;
            }
            $isSaved = $theysaid->save();
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
     * @param  \App\Models\Theysaid  $theysaid
     * @return \Illuminate\Http\Response
     */
    public function show(Theysaid $theysaid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theysaid  $theysaid
     * @return \Illuminate\Http\Response
     */
    public function edit(Theysaid $theysaid)
    {
        //
        return view('admin.theysaid.edit', compact('theysaid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theysaid  $theysaid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theysaid $theysaid)
    {
        //
        $validator = Validator($request->all(), [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'name' => 'required|string|min:3',
            'category' => 'required|string|min:3',
            'details' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $theysaid->name = $request->input('name');
            $theysaid->category = $request->input('category');
            $theysaid->details = $request->input('details');
            if ($request->hasFile('image')) {
                Storage::delete($theysaid->image);
                $file = $request->file('image');
                $imageName = time() . '_theysaid_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/theysaids', $imageName);
                $imagePath = 'images/theysaids/' . $imageName;
                $theysaid->image = $imagePath;
            }
            $isSaved = $theysaid->save();
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
     * @param  \App\Models\Theysaid  $theysaid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theysaid $theysaid)
    {
        //
        $deleted = $theysaid->delete();
        if ($deleted) {
            Storage::delete($theysaid->image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Say deleted successfully' : 'Say deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
