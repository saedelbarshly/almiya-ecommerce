<?php

namespace App\Http\Controllers\api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function getCart()
    {
        try {
            $order = Order::where('user_id', $this->user->id)->cart()->first();
            if (is_null($order)) {
                return response()->json(['message' => 'Empty Cart!'], 200);
            }
            return CartResource::collection($order?->orderItems)->response()->getData(true);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }

    public function add(CartRequest $request)
    {
        try {
            $order = Order::firstOrCreate(
                ['user_id' => $this->user->id, 'status' => 'cart'],
                ['status' => 'cart']
            );
            $orderItem = $order->orderItems()->where('product_id', $request->product_id)->first();

            if ($orderItem) {
                $orderItem->increment('quantity', 1);
            } else {
                $order->orderItems()->create([
                    'product_id' => $request->product_id,
                    'quantity' => 1,
                ]);
            }
            return response()->json(['message' => 'Product added to cart successfully ✅'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }

    public function remove(CartRequest $request)
    {
        try {
            $order = Order::where('user_id', $this->user->id)->cart()->first();
            $orderItem = $order->orderItems()->where('product_id', $request->product_id)->delete();
            return response()->json(['message' => 'Product deleted from cart successfully ✅'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }

    public function increment(CartRequest $request)
    {
        try {
            $order = Order::where('user_id', $this->user->id)->cart()->first();
            $orderItem = $order->orderItems()->where('product_id', $request->product_id)->first();
            $orderItem->increment('quantity', 1);
            return response()->json(['message' => 'Product quantity incremented successfully ✅'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }
    public function decrement(CartRequest $request)
    {
        try {
            $order = Order::where('user_id', $this->user->id)->cart()->first();
            $orderItem = $order->orderItems()->where('product_id', $request->product_id)->first();
            if ($orderItem->quantity > 1) {
                $orderItem->decrement('quantity', 1);
            } else {
                $orderItem->delete();
            }
            return response()->json(['message' => 'Product quantity decremented successfully ✅'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"], 400);
        }
    }
}
