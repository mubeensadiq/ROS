<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken(config('app.name'))->plainTextToken;
            $permissions = [];
            if(isset($user->roles[0]) && $user->roles[0]->name === 'Super Admin'){
                foreach (Permission::all() as $permission) {
                    $permissions[] = $permission->name;
                }
            }
            else{
                $permissions = $user->getPermissionsViaRoles()->pluck('name');
            }
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'role' => $user->roles[0]->name ?? '',
                'profile' => Auth::user()->profile(),
                'token' => $token,
                'permissions' => $permissions ?? []
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials do not match our records.'
            ],400);
        }
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        Auth::logout();
        Session::flush();
        return response()->json([
            'status' => 'success',
            'user' => null
        ]);
    }
}
