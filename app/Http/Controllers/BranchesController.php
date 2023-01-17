<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BranchesController extends Controller
{
    public function index(Request $request){
        try{
            $branches = Branch::with('area');
            if(isset($request->query) && $request->query != ''){
                $query = $request['query'];
                $branches = $branches->where('name' ,'like', "%$query%")
                    ->orWhere('address' ,'like', "%$query%")
                    ->orWhere('landmark' ,'like', "%$query%")
                    ->orWhere('phone_number' ,'like', "%$query%");
            }
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
            $branch = Branch::where('id' , $id)->first();
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
                'area_id' => 'required',
            ]);
            $branch = Branch::updateOrCreate(['id' => $request->id] , [
                'area_id' => $request->area_id,
                'name' => $request->name,
                'address' => $request->address,
                'landmark' => $request->landmark,
                'phone_number' => $request->phone_number,
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
