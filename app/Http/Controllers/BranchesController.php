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
}
