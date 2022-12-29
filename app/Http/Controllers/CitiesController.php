<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CitiesController extends Controller
{
    public function index(Request $request){
        try{
            $cities = City::orderBy('city','asc');
            if(isset($request->get) && $request->get === 'all')
                $cities = $cities->get();
            else
                $cities = $cities->paginate(20)->appends($request->all());
            return response()->json([
                'status' => 'success',
                'cities' => $cities
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'cities' => []
            ],500);
        }
    }

    public function getCitiesHasAreas(Request $request){
        try{
            $cities = City::has('areas')->orderBy('city','asc')->get();
            return response()->json([
                'status' => 'success',
                'cities' => $cities
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'cities' => []
            ],500);
        }
    }
}
