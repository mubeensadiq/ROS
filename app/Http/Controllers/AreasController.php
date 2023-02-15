<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreasController extends Controller
{
    public function index(Request $request){
        try{
            $areas = Area::with('city');
            if(isset($request->get) && $request->get === 'all')
                $areas = $areas->get();
            else{
                if(isset($request->search) && $request->search != ''){
                    $query = $request['search'];
                    $areas = $areas->where('area' ,'like', "%$query%")
                        ->orWhereHas('city', function ($q) use ($query) {
                            $q->where('city', 'like', "%$query%");
                        });
                }
                $areas = $areas->paginate(20)->appends($request->all());
            }

            return response()->json([
                'status' => 'success',
                'areas' => $areas
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'areas' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function getAreasByCity(Request $request){
        try{
            $areas = Area::with('city')->where('city_id', $request->city_id)->get();
            return response()->json([
                'status' => 'success',
                'areas' => $areas
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'areas' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function getAreaDetails(Request $request , $id){
        try{
            $area = Area::where('id' , $id)->first();
            if($area){
                return response()->json([
                    'status' => 'success',
                    'area' => $area
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Area Found'
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

    public function saveArea(Request $request){
        try{
            $validator = $request->validate([
                'area' => 'required',
                'city_id' => 'required',
                'postal_code' => 'required',
            ]);
            $area = Area::updateOrCreate(['id' => $request->id],[
                'area' => $request->area,
                'city_id' => $request->city_id,
                'postal_code' => $request->postal_code,
                'delivery_time' => $request->delivery_time,
                'delivery_charges' => $request->delivery_charges
            ]);
            return response()->json([
                'status' => 'success',
                'area' => $area,
                'message' => 'Successfully Saved'
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'area' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function deleteArea($id){
        try{
            Area::where('id' , $id)->delete();
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
