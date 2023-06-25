<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannersController extends Controller
{
    public function index(Request $request){
        try{
            $banners = Banner::get();
            return response()->json([
                'status' => 'success',
                'banners' => $banners
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'banners' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }

    public function saveBanner(Request $request){
        try{
            $request->validate([
                'image' => 'required',
            ]);
            $banner = Banner::create(['image' => $request->image]);
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved',
                'banner' => $banner
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
    public function deleteBanner($id){
        try{
            if(count(Banner::get()) == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'There should be atleast 1 banner'
                ],500);
            }
            $banner = Banner::where('id',$id)->first();
            if($banner){
                $banner->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Deleted'
                ],200);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'No Banner Found'
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
