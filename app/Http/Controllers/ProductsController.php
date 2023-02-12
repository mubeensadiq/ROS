<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function index(Request $request){
        try{
            $products = Product::with('category');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $products = $products->where('name' ,'like', "%$query%")
                    ->orWhere('price' ,'like', "%$query%")
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    });
            }
            if(isset($request->type) && $request->type != ''){
                $products = $products->where('type' , $request->type)->get();
            }
            else{

                $products = $products->paginate(20)->appends($request->all());
            }
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
    public function getProductDetails(Request $request , $id){
        try{
            $product = Product::with(['categories' , 'addons' , 'dealProducts','schedule'])->where('id' , $id)->first();
            if($product){
                return response()->json([
                    'status' => 'success',
                    'product' => $product
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No product Found'
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

    public function saveProduct(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'image' => 'required',
                'price' => 'required',
            ]);
            $product = Product::updateOrCreate(['id' => $request->id] , [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
                'image' => $request->image,
                'type' => $request->type,
                'city_id' => $request->city_id !== '' ? $request->city_id : null,
                'branch_id' => $request->branch_id !== '' ? $request->branch_id : null,
            ]);
            if($request->type === 'Single')
            $product->addons()->sync($request->addons);
            $product->categories()->sync($request->categories);

            if($request->type === 'Multiple'){
                $product->dealProducts()->detach();
                foreach ($request->deal_products as $dealProduct){
                        foreach ($dealProduct['products']  as $deal){
                        $product->dealProducts()->attach($deal , ['quantity' => $dealProduct['quantity']]);
                    }

                }
            }
            ProductSchedule::updateOrCreate(['product_id' => $product->id],[
                'start_date' => $request->schedule['start_date'],
                'end_date' => $request->schedule['end_date'],
                'start_time' => $request->schedule['start_time'],
                'end_time' => $request->schedule['end_time'],
                'specific_date' => $request->schedule['specific_date'],
                'specific_day' => json_encode($request->schedule['specific_day'])
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
    public function deleteProduct($id){
        try{
            Product::where('id' , $id)->delete();
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
