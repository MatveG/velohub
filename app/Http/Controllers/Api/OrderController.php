<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'payment' => 'required|min:1',
            'delivery' => 'required|min:1',
            'address' => 'required|array',
            'email' => 'required|email',
            'phone' => 'required|string',
            'name' => 'required|string',
        ]);

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        $order = new Order();
        $order->fill(request()->all());
        $order->status = 1;
        $order->discount = 0;
        $order->shipping = 0;
        $order->total = 0;
        $order->products = $cart->products;

        $order->save();
        $cart->delete();

        return response()->json($order);
    }
}
