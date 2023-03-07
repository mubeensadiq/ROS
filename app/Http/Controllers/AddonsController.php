<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\AddonCategory;
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
            $addons = new Addon();
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $addons = $addons->where('name' ,'like', "%$query%")
                    ->orWhere('price' ,'like', "%$query%");
            }
            if(isset($request->get) && $request->get === 'all'){
                $addons = $addons->orderBy('name','asc')->get();
            }
            else{
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
                'name' => 'required',
                'price' => 'required',
            ]);
            Addon::updateOrCreate(['id' => $request->id],[
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

    /*** ADDON CATEGORY FUNCTIONS ***/

    public function addonCategories(Request $request){
        try{
            $categories = new AddonCategory();
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $categories = $categories->where('name' ,'like', "%$query%")
                    ->orWhere('title' ,'like', "%$query%");
            }
            if(isset($request->get) && $request->get === 'all'){
                $categories = $categories->orderBy('name','asc')->get();
            }
            else{
                $categories = $categories->orderBy('name','asc')->paginate(20)->appends($request->all());
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
                'categories' => [],
                'message'=>$ex->getMessage()
            ],500);
        }
    }
    public function getAddonCategoryDetails(Request $request , $id){
        try{
            $category = AddonCategory::where('id' , $id)->first();
            if($category){
                return response()->json([
                    'status' => 'success',
                    'category' => $category
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No Addon Category Found'
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
    public function saveAddonCategory(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'title' => 'required'
            ]);
            AddonCategory::updateOrCreate(['id' => $request->id],[
                'name' => $request->name,
                'title' => $request->title,
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
    public function deleteAddonCategory($id){
        try{
            AddonCategory::where('id' , $id)->delete();
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
