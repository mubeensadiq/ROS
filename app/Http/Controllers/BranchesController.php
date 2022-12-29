<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BranchesController extends Controller
{
    public function index(Request $request){
        try{
            $branches = Branch::with('area')->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'branches' => $branches
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'branches' => []
            ],500);
        }
    }

    public function saveBranch(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'landmark' => 'required',
                'area_id' => 'required',
            ]);
            $branch = Branch::create([
                'area_id' => $request->area_id,
                'name' => $request->name,
                'address' => $request->address,
                'landmark' => $request->landmark,
                'phone_number' => $request->phone_number,
            ]);
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
