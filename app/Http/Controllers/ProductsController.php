<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function index(Request $request){
        try{
            $products = Product::with('category');
            if(isset($request->query) && $request->query != ''){
                $query = $request['query'];
                $products = $products->where('name' ,'like', "%$query%")
                    ->orWhere('price' ,'like', "%$query%")
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    });
            }
            $products = $products->paginate(20)->appends($request->all());
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
            $product = Product::with('addons')->where('id' , $id)->first();
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
                'stock' => 'required',
                'min_quantity' => 'required',
            ]);
            $product = Product::updateOrCreate(['id' => $request->id] , [
                'category_id' => 2,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'min_quantity' => $request->min_quantity,
                'max_quantity' => $request->max_quantity,
                'status' => $request->status,
                'image' => $request->image,
                'prep_time' => $request->prep_time,
            ]);
            $product->addons()->sync($request->addons);
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
