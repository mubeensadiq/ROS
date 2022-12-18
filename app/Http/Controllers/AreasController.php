<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreasController extends Controller
{
    public function index(Request $request){
        try{
            $areas = Area::with('city')->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'areas' => $areas
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'areas' => []
            ],500);
        }
    }
}
