<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $admins = Admin::all();
        // $editadmin = Admin::where('id','=',1)->get();
        return view('admin.admins.index', ['admins' => $admins, 'request' => $request]);
        // dd();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.admins.create');
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
        // $admin = Admin::create($request->all());
        // $isSaved = $admin->save();
        // return response()->json(
        //     ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
        //     $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        // );
        $validator = Validator($request->all(), [
            'adminname' => 'required|string|min:3',
            'adminemail' => 'required|email|unique:admins,email',
            'adminpassword' => 'required|string|min:3'
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('adminname');
            $admin->email = $request->input('adminemail');
            $admin->password = Hash::make($request->input('adminpassword'));

            $isSaved = $admin->save();

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */

    public function editAdmin(Request $request)
    {

        dd($request->all());
        $admine = Admin::where('id', '=', $request->input('id'))->get();
        return view('admin.admins.index', ['admine' => $admine]);
    }

    public function edit(Admin $admin)
    {
        //
        return view('admin.admins.edit', ['admin' => $admin]);
    }

    // public function updateAdmin(Request $request, Admin $admin){
    //     dd($request->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        // dd($request->all());
        // $admin->update($request->all());
        // $isSaved = $admin->save();
        // return response()->json(
        //     ['message' => $isSaved ? 'Updated successfully' : 'Updated failed!'],
        //     $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        // );

        // dd($admin->id);

        // dd($request->all());
        $request->validate([
            'edit_name' => 'required|string|min:3',
            'edit_email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);

        $admin->name = $request->input('edit_name');
        $admin->email = $request->input('edit_email');
        $admin->password = Hash::make($admin->password);
        $isSaved = $admin->save();

        if ($isSaved) {
            return redirect()->route('admins.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $deleted = $admin->delete();
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Admin deleted successfully' : 'Admin deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
