<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                'status' => 'success',
                'users' => []
            ],500);
        }
    }
}
