<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAddon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function index(Request $request){
        try{
            $orders = Order::with('rider');
            if(isset($request->search) && $request->search != ''){
                $query = $request['search'];
                $orders = $orders->where('firs_name' ,'like', "%$query%")
                    ->orWhere('last_name' ,'like', "%$query%")
                    ->orWhere('order_number' ,'like', "%$query%");
            }
            $orders = $orders->orderBy('id' ,'desc');
            if(isset($request->get) && $request->get == 'all')
                $orders = $orders->get();
            else
                $orders = $orders->paginate(20)->appends($request->all());
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
            $order = Order::with(['products.addons'])->where('id' , $id)->first();
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
                'customer.first_name' => 'required',
                'customer.last_name' => 'required',
                'customer.phone_number' => 'required',
                'customer.delivery_address' => 'required',
                'customer.email' => 'email',
            ]);
            $customer = $request->customer;
            $cart = $request->cart;
            $order_number = '000001';
            $last_order = Order::latest()->first();
            if($last_order){
                $order_number = intval($last_order->order_number) + 1;
                $order_number = sprintf('%06d', $order_number);
            }
            $order = Order::create([
                'order_number' => $order_number,
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'phone_number' => $customer['phone_number'],
                'alternate_phone' => $customer['alternate_phone'],
                'delivery_address' => $customer['delivery_address'],
                'email' => $customer['email'],
                'instructions' => $customer['instructions'],
                'sub_total' => $cart['subTotal'],
                'tax' => $cart['tax_amount'],
                'total' => $cart['subTotal'] + $cart['tax_amount'],
                'payment_type' => 'cash',
                'status' => 'received'
            ]);
            foreach ($cart['items'] as $item){
                $product = OrderProduct::create([
                   'order_id' =>  $order->id,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ]);
                foreach ($item['addons'] as $addon){
                    if($addon == null) continue;
                    if(isset($addon[0])){
                        foreach ($addon as $add){
                            OrderProductAddon::create([
                                'order_product_id' => $product->id,
                                'name' => $add['name'],
                                'price' => $add['price'],
                                'quantity' => $add['quantity']
                            ]);
                        }
                    }
                    else{
                        OrderProductAddon::create([
                            'order_product_id' => $product->id,
                            'name' => $addon['name'],
                            'price' => $addon['price'],
                            'quantity' => $addon['quantity']
                        ]);
                    }


                }
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved',
                'order' => $order
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
