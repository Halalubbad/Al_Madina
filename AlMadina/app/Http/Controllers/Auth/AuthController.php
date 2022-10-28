<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function showLoginView()
    {
        return response()->view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:1|max:20',
            'remember' => 'required|boolean',
        ]);

        if (!$validator->fails()) {
            $credntials = ['email' => $request->input('email'), 'password' => $request->input('password')];
            if (Auth::guard('admin')->attempt($credntials, $request->input('remember_me'))) {
                return response()->json([
                    'message' => 'logged in successfully'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'logge failed '
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editPassword(Request $request)
    {
        return response()->view('auth.edit-password');
    }

    public function updatePassword(Request $request)
    {
        // dd('aaaa');
        $guard = auth('admin')->check() ? 'admin' : 'user';
        $validator = Validator($request->all(), [
            'password' => 'required|current_password:' . $guard,
            'new_password' => [
                'required', 'confirmed',
                Password::min(8)
                    ->symbols()
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ]);

        if (!$validator->fails()) {
            $user = $request->user();
            $user->forceFill([
                'password' => Hash::make($request->input('new_password')),
            ]);
            $isSaved = $user->save();
            return response()->json(
                ['message' => $isSaved ? 'Password changed successfully' : 'Failed to change password!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('almadina.login');
    }


}
