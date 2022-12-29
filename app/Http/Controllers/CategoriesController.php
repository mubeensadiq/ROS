<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function index(Request $request){
        try{
            $categories = Category::orderBy('id','desc')->paginate(20)->appends($request->all());
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
    public function saveCategory(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => 'success'
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
