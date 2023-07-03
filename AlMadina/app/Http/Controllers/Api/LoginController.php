<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // $admin = Admin::where('email' , '=' , $request->post('email'))->first();
        $user = User::where('email' , '=' , $request->post('email'))->first();
        if($user && Hash::check($request->password ,$user->password)){
            
            $token = $user->createToken($request->userAgent(),['products.create','products.update']);

            return response()->json([
                'message' => 'Authenticated',
                'access_token' => $token->plainTextToken,
            ]);
        }

        return Response::json([
            'message' => 'Invalid email and password!'
        ], 401);
    }

    public function tokens(){
        $user = Auth::guard('sanctum')->user();
        return $user->tokens;
    }

    public function logout(Request $request){
        $user = Auth::guard('sanctum')->user();
        // return $user->currentAccessToken();

        // Log out from current device
        // $user->currentAccessToken()->delete();

        // Log out from all devices
        $user->tokens()->delete();


        return Response::json([
            'message' => 'Logged Out!'
        ]);
    }
}
