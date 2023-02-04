<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(Request $request){
        try{
            $users = User::with('profile');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $users = $users->where('first_name' ,'like', "%$query%")
                    ->orWhere('last_name' ,'like', "%$query%")
                    ->orWhere('email' ,'like', "%$query%")
                    ->orWhere('username' ,'like', "%$query%");
            }
            $users = $users->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'users' => $users
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'users' => [],
                'message' => $ex->getMessage()
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
    public function getPermissions(Request $request){
        try{
            $permissions = Permission::get();
            return response()->json([
                'status' => 'success',
                'permissions' => $permissions
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'permissions' => []
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
                'profile.phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ]);
            if($request->id){
              $user = User::updateOrCreate(['id' => $request->id],[
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                ]);
            }
            else{
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'original_password' => $request->password,
                    'api_token' => hash('sha256', Str::random(60))


                ]);
            }
            $user->profile()->updateOrCreate(['user_id' => $request->id],[
                'phone_number' => $request->profile['phone_number'],
                'address' => $request->profile['address'],
                'avatar' => $request->profile['avatar'] ?? null,
            ]);

            $user->assignRole($request->role);
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
            $user = User::with(['profile','rider.areas.area','roles'])->select(['first_name','last_name','id'])->where('id' , $id)->first();
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
                'status' => 'success',
                'message' => 'Successfully Deleted'
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

    public function saveRole(Request $request){
        try{
            $validator = $request->validate([
                'name' => 'required'
            ]);
            $role = Role::updateOrCreate(['id' => $request->id],[
                'name' => $request->name
            ]);

            $role->syncPermissions($request->permissions);


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
    public function getRoleDetails(Request $request , $id){
        try{
            $role = Role::with('permissions' )->where('id' , $id)->first();
            if($role){
                return response()->json([
                    'status' => 'success',
                    'role' => $role
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No role Found'
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
    public function deleteRole($id){
        try{
            User::where('id' , $id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Deleted'
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
