<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $discounts = Discount::with(['products','categories','cities','branches']);
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $discounts = $discounts->where('name' ,'like', "%$query%")
                    ->orWhere('price' ,'like', "%$query%")
                    ->orWhere('status' ,'like', "%$query%");
            }
            if(isset($request->get) && $request->get === 'all'){
                $discounts = $discounts->orderBy('name','asc')->get();
            }
            else{
                $discounts = $discounts->paginate(20)->appends($request->all());
            }



            return response()->json([
                'status' => 'success',
                'discounts' => $discounts
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'discounts' => []
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDiscount(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'value' => 'required|numeric',
                'type' => 'required',
            ]);
            $discount = Discount::updateOrCreate(['id' => $request->id],[
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
                'status' => $request->status,
                'discount_on' => $request->discount_on,
            ]);
            if($request->discount_on !== 'OverAll'){
                $rel = strtolower($request->discount_on);
                $discount->$rel()->sync($request->discountable);
            }
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
    public function getDiscountDetails(Request $request , $id){
        try{
            $discount = Discount::with(['products','categories','cities','branches'])->where('id' , $id)->first();
            if($discount){
                return response()->json([
                    'status' => 'success',
                    'discount' => $discount
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No discount Found'
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
    public function deleteDiscount($id){
        try{
            Discount::where('id' , $id)->delete();
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
