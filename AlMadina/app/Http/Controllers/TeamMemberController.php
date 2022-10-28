<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teamMembers = TeamMember::all();
        return Response()->view('admin.team_member.index',['teamMembers' => $teamMembers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('admin.team_member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('store');
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'speciality' => 'required|string|min:3',            
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!$validator->fails()) {
            $teamMember = new TeamMember();
            $teamMember->employee_name = $request->input('name');
            $teamMember->speciality = $request->input('speciality');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_teamMember_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/teamMembers', $imageName);
                $imagePath = 'images/teamMembers/' . $imageName;
                $teamMember->image = $imagePath;
            }
            $isSaved = $teamMember->save();
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
     * @param  \App\Models\TeamMemmber  $teamMemmber
     * @return \Illuminate\Http\Response
     */
    public function show(TeamMember $teamMemmber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamMemmber  $teamMemmber
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamMember $teamMember)
    {
        //
        return response()->view('admin.team_member.edit',['teamMember' => $teamMember]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeamMemmber  $teamMemmber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'speciality' => 'required|string|min:3',            
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!$validator->fails()) {
            $teamMember->employee_name = $request->input('name');
            $teamMember->speciality = $request->input('speciality');
            if ($request->hasFile('image')) {
                Storage::delete($teamMember->image);
                $file = $request->file('image');
                $imageName = time() . '_teamMember_image.' . $file->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('images/teamMembers', $imageName);
                $imagePath = 'images/teamMembers/' . $imageName;
                $teamMember->image = $imagePath;
            }
            $isSaved = $teamMember->save();
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
     * @param  \App\Models\TeamMemmber  $teamMemmber
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamMember $teamMember)
    {
        //
        $deleted = $teamMember->delete();
        if ($deleted) {
            Storage::delete($teamMember->image);
        }
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'teamMember deleted successfully' : 'teamMember deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
