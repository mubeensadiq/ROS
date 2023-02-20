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
                if(isset($request->get) && $request->get == 'all')
                    $products = $products->get();
                else
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
            $product = Product::with(['categories' , 'addon_category_product.addons' , 'branch_product','schedule'])->where('id' , $id)->first();
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
                'tax_applicable' => $request->tax_applicable,
                'discount' => $request->discount,
            ]);
            $product->categories()->sync($request->categories);
            $product->branch_product()->detach();
            foreach ($request->branch_product as $p_branch){
                foreach ($p_branch['branches']  as $branch){
                    if($branch !== '')
                        $product->branch_product()->attach($branch , ['price' => $p_branch['price']]);
                }
            }
            $product->addon_category_product()->delete();
            foreach ($request->addon_category_product as $product_addon){
                if(isset($product_addon['addonCategory'])){
                    $addon_cat_prod =  $product->addon_category_product()->create(['addon_category_id' => $product_addon['addonCategory'],'quantity' => $product_addon['quantity'] , 'required' => $product_addon['required']]);
                    $addon_cat_prod->addons()->sync($product_addon['addons']);
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
            $product = Product::where('id',$id)->first();
            if($product){
                $product->branch_product()->detach();
                $product->addon_category_product()->delete();
                $product->schedule()->delete();
                $product->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Deleted'
                ],200);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'No Product Found'
                ],500);
            }
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
