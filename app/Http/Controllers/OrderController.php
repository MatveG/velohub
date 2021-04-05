<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __invoke(Request $request, CartService $service): JsonResponse
    {
        $this->validate($request, [
            'payment' => 'required|min:1',
            'delivery' => 'required|min:1',
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
            'address' => 'required|json',
            'products' => 'required|json',
        ]);

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        $order = new Order();
        $order->status = 1;
        $order->discount = 0;
        $order->shipping = 0;
        $order->total = 0;
        $order->address = $request->address;
        $order->products = $cart->products;
        $order->fill(request()->all())->save();

//        $cart->delete();

        return response()->json($order);
    }
}
