<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProudctQuantityForCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = Product::find($request->product_id);
        if ($product->quantity < 1) {
            return response()->json(['message' => 'Insufficient stock 😱'],400);
        }
        return $next($request);
    }
}
