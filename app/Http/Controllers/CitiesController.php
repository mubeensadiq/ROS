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
            else{
                if(isset($request->search) && $request->search != ''){
                    $query = $request['search'];
                    $cities = $cities->where('city' ,'like', "%$query%");
                }
                $cities = $cities->paginate(20)->appends($request->all());;
            }
            return response()->json([
                'status' => 'success',
                'cities' => $cities
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'cities' => [],
                'message' => $ex->getMessage()
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
                'cities' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function getCityDetails(Request $request , $id){
        try{
            $city = City::where('id' , $id)->first();
            if($city){
                return response()->json([
                    'status' => 'success',
                    'city' => $city
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No City Found'
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

    public function saveCity(Request $request){
        try{
            $validator = $request->validate([
                'city' => 'required',
            ]);
            $area = City::updateOrCreate(['id' => $request->id],[
                'city' => $request->city
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved'
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
    public function deleteCity($id){
        try{
            City::where('id' , $id)->delete();
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
