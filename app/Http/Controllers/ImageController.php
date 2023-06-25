<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $image_validation = "required|image|mimes:png,jpg,jpeg|max:512";
        if($request->has('resolution'))
            $image_validation .= $request->resolution;
        $validator = $request->validate([
            'image' => $image_validation,
            'path' => 'required',
        ]);
        try {
            $file = $request->file('image');
            $src = $request->path;
            $filename = $file->getClientOriginalName();
            $request->image->move(public_path($src), $filename);
            return response()->json(['status' => 'success', 'message' => 'Successfully uploaded', 'filename' => $filename]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
