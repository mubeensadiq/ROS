<?php

namespace App\Http\Controllers;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealsController extends Controller
{
    public function index(Request $request){
        try{
            if(isset($request->get) && $request->get === 'all'){
                $deals = Deal::orderBy('id','desc');
                if(isset($request->status))
                    $deals = $deals->where('status' , $request->status);
                $deals = $deals->get();
            }
            else{
                if(isset($request->search) && $request->search != ''){
                    $query = $request['search'];
                    $deals = Deal::where('name' ,'like', "%$query%")
                        ->orWhere('description' ,'like', "%$query%")
                        ->paginate(20)->appends($request->all());
                }
                else
                    $deals = Deal::orderBy('id','desc')->paginate(20)->appends($request->all());
            }

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
    public function getDealDetails(Request $request , $id){
        try{
            $deal = Deal::where('id' , $id)->first();
            if($deal){
                return response()->json([
                    'status' => 'success',
                    'deal' => $deal
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Deal Found'
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
    public function saveDeal(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            Deal::updateOrCreate(['id' => $request->id],[
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
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
    public function deleteDeal($id){
        try{
            Deal::where('id' , $id)->delete();
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

    public function products(){
        try{
            $products =  Deal::with('products')->whereHas('products', function ($q){
                $q->where('status',1);
                $q->orderBy('id','desc');
            })->where('status' , 1)->get();
            return response()->json([
                'status' => 'success',
                'products' => $products
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'products' => [],
                'message' => $ex->getMessage()
            ],500);
        }

    }
}
