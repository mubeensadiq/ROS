<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardStats(Request $request)
    {
        try{
            $stats = [
                'total_sale' => 0 , 'total_orders' => 0
            ];
            $orders = Order::whereBetween('created_at',[$request->start_date , $request->end_date])->get();
            $stats['total_sale'] = $orders->sum('total');
            $stats['total_orders'] = $orders->count('id');
        }
        catch(\Exception $ex){
            Log::info("dashboardStats");
            Log::info($ex->getMessage());
        }
        return response()->json(['stats' => $stats]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request)
    {
        try{
            $filter = $request->filter;
            $orders = Order::whereBetween('created_at',[$filter['start_date'] , $filter['end_date']]);
            if(isset($filter['order_status'])){
                $orders->where('status', $filter['order_status']);
            }
            if(isset($filter['order_type'])){
                $orders->where('order_type', $filter['order_type']);
            }
            if(isset($filter['product'])){
                $orders->whereHas('products' , function($q) use ($filter){
                    $q->where('product_id', $filter['product']);
                });
            }

            $orders = $orders->paginate(20);
        }
        catch(\Exception $ex){
            Log::info("dashboardStats");
            Log::info($ex->getMessage());
        }
        return response()->json(['records' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
