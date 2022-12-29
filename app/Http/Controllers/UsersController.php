<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(Request $request){
        try{
            $users = User::with('profile')->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'users' => $users
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'users' => []
            ],500);
        }
    }
    public function getRoles(Request $request){
        try{
            $roles = Role::get();
            return response()->json([
                'status' => 'success',
                'roles' => $roles
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'roles' => []
            ],500);
        }
    }
    public function saveUser(Request $request){
        try{
            $validator = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'original_password' => $request->password,
            ]);
            $user->profile()->create([
                'phone_number' => $request->profile['phone_number'],
                'address' => $request->profile['address'],
                'avatar' => $request->profile['avatar'] ?? null,
            ]);
            $user->rider()->create([
                'cnic' => $request->rider['cnic'],
                'license_no' => $request->rider['license_no'],
            ]);
            $user->areas()->attach($request->rider['areas']);

            return response()->json([
                'status' => 'success',
                'users' => $user
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }
}
