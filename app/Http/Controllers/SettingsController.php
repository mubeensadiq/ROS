<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $settings = Setting::get();
            if($settings){
                $data = [];
                foreach($settings as $setting){
                    $data[$setting->key] = $setting->value;
                }
                return response()->json(['status' => 'success' , 'settings' => $data],200);
            }
        }
        catch(\Exception $ex){
            Log::info("SettingsController@index");
            Log::info($ex->getMessage());
        }
        return response()->json(['status' => 'success' , 'settings' => null],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveSettings(Request $request)
    {
        try{
            $request->validate([
                'company_name' => 'required',
                'company_description' => 'required',
                'company_contact' => 'required',
                'company_logo' => 'required',
            ]);
            $settings = $request->all();
            foreach($settings as $key => $setting){
                Setting::updateOrCreate(['key' => $key],['value' => $setting]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved'
            ],200);
        }catch(\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
