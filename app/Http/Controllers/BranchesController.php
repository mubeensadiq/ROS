<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BranchesController extends Controller
{
    public function index(Request $request){
        try{
            $branches = Branch::with('areas');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $branches = $branches->where('name' ,'like', "%$query%")
                    ->orWhere('address' ,'like', "%$query%")
                    ->orWhere('landmark' ,'like', "%$query%")
                    ->orWhere('phone_number' ,'like', "%$query%");
            }
            if($request->city_id){
                $city_id = $request->city_id;
                $branches = $branches->whereHas('areas' , function ($q) use($city_id){
                   $q->where('city_id' , $city_id);
                })->get();
            }
            else
                if(isset($request->get) && $request->get === 'all')
                    $branches = $branches->get();
                else
                    $branches = $branches->paginate(20)->appends($request->all());

            return response()->json([
                'status' => 'success',
                'branches' => $branches
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'branches' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function getBranchDetails(Request $request , $id){
        try{
            $branch = Branch::with('areas')->where('id' , $id)->first();
            if($branch){
                return response()->json([
                    'status' => 'success',
                    'branch' => $branch
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Branch Found'
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

    public function saveBranch(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'landmark' => 'required',
                'areas.0' => 'required',
            ]);
            $branch = Branch::updateOrCreate(['id' => $request->id] , [
                'name' => $request->name,
                'address' => $request->address,
                'landmark' => $request->landmark,
                'phone_number' => $request->phone_number,
            ]);
            $branch->areas()->sync($request->areas);
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
    public function deleteBranch($id){
        try{
            Branch::where('id' , $id)->delete();
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
