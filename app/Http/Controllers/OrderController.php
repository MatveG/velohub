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
//        $this->validate($request, [
//            'name' => 'required|min:3',
//            'phone' => 'required|min:9',
//            'address' => 'required|min:3',
//            'payment' => 'required|numeric',
//            'shipping' => 'required|numeric',
//        ]);
        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        $order = new Order();
//        $order->fill(request()->all());
        $order->delivery = $request['delivery'];
        $order->requisites = $request->requisites;
        $order->products = $cart->products;
        $order->text = $request['text'];
        $order->save();

//        $cart->delete();

        $meta = (object) [
            'title' => '',
            'description' => '',
            'keywords' => ''
        ];

        return response()->json($order);
    }
}
