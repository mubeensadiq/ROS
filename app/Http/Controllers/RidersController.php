<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RidersController extends Controller
{
    public function index(Request $request){
        try{
            $riders = Rider::with('branch')->orderBy('name','asc');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $riders = $riders->where('name' ,'like', "%$query%")
                    ->orWhere('phone_number_1' ,'like', "%$query%");
            }
            $riders = $riders->paginate(20)->appends($request->all());

            return response()->json([
                'status' => 'success',
                'riders' => $riders
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'riders' => []
            ],500);
        }
    }
    public function getRiderDetails(Request $request , $id){
        try{
            $rider = Rider::with('branch.areas')->where('id' , $id)->first();
            if($rider){
                return response()->json([
                    'status' => 'success',
                    'rider' => $rider
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Rider Found'
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
    public function saveRider(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'branch_id' => 'required',
                'phone_number_1' => 'required',
                'nic_image' => 'required',
            ]);
            Rider::updateOrCreate(['id' => $request->id],[
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'phone_number_1' => $request->phone_number_1,
                'phone_number_2' => $request->phone_number_2,
                'nic_image' => $request->nic_image,
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
    public function deleteRider($id){
        try{
            Rider::where('id' , $id)->delete();
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
