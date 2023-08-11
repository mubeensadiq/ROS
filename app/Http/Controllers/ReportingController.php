<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
            if(!isset($request->type)){
                return $this->widgetStats($request);
            }
            else{
                $function = $request->type.'Stats';
                return $this->$function($request);
            }
        }
        catch(\Exception $ex){
            Log::info("dashboardStats");
            Log::info($ex->getMessage());
        }
        
    }
    public function widgetStats($request){
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

    public function datesStats($request){
        try{
            $stats = Order::select(DB::raw('count(*) as orders, day(created_at) as order_date'))
                            ->whereBetween('created_at',[$request->start_date , $request->end_date])
                            ->groupBy('order_date')
                            ->get()->pluck('orders', 'order_date');

            for($i = 1 ; $i <= 31; $i++){
                if(!isset($stats[$i]))
                    $stats[$i] = 0;
            }
            $stats = $stats->toArray();
            ksort($stats);
            $newArray = array();
            foreach ($stats as $key => $value) {
                $newKey = $this->numberSuffix($key);
                $newArray[$newKey] = $value;
            }
           
        }
        catch(\Exception $ex){
            Log::info("datesStats");
            Log::info($ex);
        }
        return response()->json(['stats' => $newArray]);
    }

    public function numberSuffix($num) {
        if ($num >= 11 && $num <= 13) {
            return $num . 'th';
        }
    
        switch ($num % 10) {
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
            default:
                return $num . 'th';
        }
    }
    
    public function dayStats($request){
        try{
            $stats = Order::select(DB::raw('count(*) as orders, DAYNAME(created_at) as order_day'))
                            ->whereBetween('created_at',[$request->start_date , $request->end_date])
                            ->groupBy('order_day')
                            ->orderBy(DB::raw("FIELD(DAYNAME(created_at), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')"))
                            ->get()->pluck('orders', 'order_day');

            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday', 'Saturday', 'Sunday'];
            $stats = $stats->toArray();
            foreach($days as $day){
                if(!isset($stats[$day]))
                    $stats[$day] = 0;
                
            }
            ksort($stats);
            
        }
        catch(\Exception $ex){
            Log::info("datesStats");
            Log::info($ex);
        }
        return response()->json(['stats' => $stats]);
    }

    public function hourStats($request){
        try{
            $stats = Order::select(DB::raw('count(*) as orders, HOUR(created_at) as order_hour'))
                            ->whereBetween('created_at',[$request->start_date , $request->end_date])
                            ->groupBy('order_hour')
                            ->orderBy('order_hour' , 'ASC')
                            ->get()->pluck('orders', 'order_hour');

            for($i =0 ; $i <= 23; $i++){
                if(!isset($stats[$i]))
                    $stats[$i] = 0;
            }
            $stats = $stats->toArray();
            ksort($stats);
            $newArray = array();
            foreach ($stats as $key => $value) {
                $newKey = $key.'h';
                $newArray[$newKey] = $value;
            }
        }
        catch(\Exception $ex){
            Log::info("datesStats");
            Log::info($ex);
        }
        return response()->json(['stats' => $newArray]);
    }

    public function salesStats($request){
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

    public function ordersStats($request){
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

    public function branchesStats($request){
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

    public function dealsStats($request){
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

    public function categoryStats($request){
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


    public function productStats($request){
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

    public function costStats($request){
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

    public function orderStatusStats($request){
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
