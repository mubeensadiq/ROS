<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function index(Request $request){
        try{
            if(isset($request->get) && $request->get === 'all'){
                $categories = Category::orderBy('id','desc');
                if(isset($request->status))
                    $categories = $categories->where('status' , $request->status);

                $categories = $categories->get();
            }
            else{
                if(isset($request->search) && $request->search != ''){
                    $query = $request['search'];
                    $categories = Category::where('name' ,'like', "%$query%")
                        ->orWhere('description' ,'like', "%$query%")
                        ->paginate(20)->appends($request->all());
                }
                else
                    $categories = Category::orderBy('id','desc')->paginate(20)->appends($request->all());
            }

            return response()->json([
                'status' => 'success',
                'categories' => $categories
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'categories' => []
            ],500);
        }
    }
    public function getCategoryDetails(Request $request , $id){
        try{
            $category = Category::where('id' , $id)->first();
            if($category){
                return response()->json([
                    'status' => 'success',
                    'category' => $category
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Category Found'
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
    public function saveCategory(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            Category::updateOrCreate(['id' => $request->id],[
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
    public function deleteCategory($id){
        try{
            Category::where('id' , $id)->delete();
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

    public function products(Request $request){
        try{
           $categories =  Category::with(['products.dealProducts','products.addons'])->whereHas('products', function ($q) use($request) {
                $q->where('status',1);
                $q->orderBy('products.id','desc');
            })->where('status' , 1)->get();
           foreach ($categories as $cat_index => $category){
               foreach ($category->products as $index => $product){
                   if(!$product->city_id)
                       continue;
                   else{
                       if($product->city_id != $request->city_id){
                           unset($categories[$cat_index]['products'][$index]);
                       }
                   }
                   if($request->branch_id !== ''){
                       if($product->branch_id != $request->branch_id){
                           unset($categories[$cat_index]['products'][$index]);
                       }
                   }
               }
           }

            return response()->json([
                'status' => 'success',
                'products' => $categories
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
