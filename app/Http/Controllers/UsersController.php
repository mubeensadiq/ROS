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
                'username' => 'sometimes|required|unique:users',
                'email' => 'sometimes|required|email|unique:users',
                'password' => 'sometimes|required',
                'profile.phone_number' => 'required'
            ]);
            $user = User::updateOrCreate(['id' => $request->id],[
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'original_password' => $request->password,
            ]);
            $user->assignRole($request->role);
            $user->profile()->updateOrCreate(['user_id' => $request->id],[
                'phone_number' => $request->profile['phone_number'],
                'address' => $request->profile['address'],
                'avatar' => $request->profile['avatar'] ?? null,
            ]);
            $rider = $user->rider()->updateOrCreate(['user_id' => $request->id],[
                'cnic' => $request->rider['cnic'],
                'license_no' => $request->rider['license_no'],
            ]);
            $rider->areas()->delete();
            foreach ($request->rider['areas'] as $area){
                $rider->areas()->create(['area_id'=>$area]);
            }


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
    public function getUserDetails(Request $request , $id){
        try{
            $user = User::with(['profile','rider.areas.area','roles'])->where('id' , $id)->first();
            if($user){
                return response()->json([
                    'status' => 'success',
                    'user' => $user
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No user Found'
            ],200);

        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ],500);
        }
    }
    public function deleteUser($id){
        try{
            User::where('id' , $id)->delete();
            return response()->json([
                'status' => 'success'
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
