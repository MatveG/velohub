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
            'payment' => 'required',
            'delivery' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
        ]);

        $result = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 7) === 'address') {
                preg_match("/\[(.*?)\]/", $key, $matches);
                $result[$matches[1]] = $value;
            }
        }

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        $order = new Order();
        $order->fill(request()->all());
        $order->status = 1;
        $order->discount = 0;
        $order->shipping = 0;
        $order->total = 0;
        $order->products = $cart->products;
        $order->address = $result;

        $order->save();
        $cart->delete();

        return response()->json($order);
    }
}
