<?php

namespace App\Http\Controllers\api;

use App\Events\CreateOrderEvent;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\CreateOrderNotification;
use Illuminate\Support\Facades\Broadcast;

class OrderController extends Controller
{
    public function create(Request $request){
        try {
            $user =  $request->user();
            $order = Order::where('user_id', $user->id)
            ->cart()
            ->with('orderItems') 
            ->first();

            if(is_null($order)){
                return response()->json(['message' => 'Add some product in cart 😁'],200);
            }
            $order->update(['status' => 'order']);
    
            $admin = Admin::first();
            $admin->notify(new CreateOrderNotification($user,$order));
            // defer(fn() => $admin->notify(new CreateOrderNotification($user,$order)));

            return response()->json(['message' => 'Order created successfully ✅'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }
}
