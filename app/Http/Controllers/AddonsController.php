<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            if(isset($request->get) && $request->get === 'all')
                $addons = Addon::get();
            else{
                $addons = new Addon();
                if(isset($request->search) && $request->search != ''){
                    $query = $request['search'];
                    $addons = $addons->where('name' ,'like', "%$query%")
                        ->orWhere('title' ,'like', "%$query%")
                        ->orWhere('price' ,'like', "%$query%");
                }
                $addons = $addons->paginate(20)->appends($request->all());
            }


            return response()->json([
                'status' => 'success',
                'addons' => $addons
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'addons' => []
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddon(Request $request)
    {
        try{
            $validator = $request->validate([
                'title' => 'required',
                'name' => 'required',
                'price' => 'required',
            ]);
            Addon::updateOrCreate(['id' => $request->id],[
                'title' => $request->title,
                'name' => $request->name,
                'price' => $request->price,
                'required' => $request->required,
                'image' => $request->image,
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
    public function getAddonDetails(Request $request , $id){
        try{
            $addon = Addon::where('id' , $id)->first();
            if($addon){
                return response()->json([
                    'status' => 'success',
                    'addon' => $addon
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No addon Found'
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
    public function deleteAddon($id){
        try{
            Addon::where('id' , $id)->delete();
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
