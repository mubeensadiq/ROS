<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function index(Request $request){
        try{
            $orders = Order::with('category');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $orders = $orders->where('name' ,'like', "%$query%")
                    ->orWhere('price' ,'like', "%$query%")
                    ->orWhereHas('categories', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    });
            }
            if(isset($request->type) && $request->type != ''){
                $orders = $orders->where('type' , $request->type)->get();
            }
            else{
                if(isset($request->get) && $request->get == 'all')
                    $orders = $orders->get();
                else
                    $orders = $orders->paginate(20)->appends($request->all());
            }
            return response()->json([
                'status' => 'success',
                'orders' => $orders
            ],200);
        }
        catch (\Exception $ex){
            Log::info($ex);
            return response()->json([
                'status' => 'error',
                'orders' => [],
                'message' => $ex->getMessage()
            ],500);
        }
    }
    public function getOrderDetails(Request $request , $id){
        try{
            $order = Order::with(['categories' , 'addon_category_order.addons' , 'branch_order','schedule'])->where('id' , $id)->first();
            if($order){
                return response()->json([
                    'status' => 'success',
                    'order' => $order
                ],200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'No order Found'
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

    public function saveOrder(Request $request){
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'image' => 'required',
                'price' => 'required',
            ]);
            $order = Order::updateOrCreate(['id' => $request->id] , [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
                'image' => $request->image,
                'type' => $request->type,
                'tax_applicable' => $request->tax_applicable,
                'discount' => $request->discount,
            ]);
            $order->categories()->sync($request->categories);
            $order->branch_order()->detach();
            foreach ($request->branch_order as $p_branch){
                foreach ($p_branch['branches']  as $branch){
                    if($branch !== '')
                        $order->branch_order()->attach($branch , ['price' => $p_branch['price']]);
                }
            }
            $order->addon_category_order()->delete();
            foreach ($request->addon_category_order as $order_addon){
                if(isset($order_addon['addons']) && count($order_addon['addons']) > 0){
                    $addon_cat_prod =  $order->addon_category_order()->create(['addon_category_id' => $order_addon['addonCategory'],'quantity' => $order_addon['quantity'] , 'required' => $order_addon['required']]);
                    $addon_cat_prod->addons()->sync($order_addon['addons']);
                }
            }
            OrderSchedule::updateOrCreate(['order_id' => $order->id],[
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
    public function deleteOrder($id){
        try{
            $order = Order::where('id',$id)->first();
            if($order){
                $order->branch_order()->detach();
                $order->addon_category_order()->delete();
                $order->schedule()->delete();
                $order->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Deleted'
                ],200);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'No Order Found'
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
