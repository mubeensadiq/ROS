<?php

namespace App\Http\Controllers;
;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealsController extends Controller
{
    public function index(Request $request){
        try{
            $deals = Deal::with('city')->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'deals' => $deals
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'deals' => []
            ],500);
        }
    }
}
