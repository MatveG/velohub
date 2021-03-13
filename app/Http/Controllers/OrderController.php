<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function send(Request $request, CartService $service)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required|min:9',
            'address' => 'required|min:3',
            'payment' => 'required|numeric',
            'shipping' => 'required|numeric',
        ]);

        $order = new Order();
        $order->fill(request()->all());
        $order->items = $service->getItemsJson();
        $order->save();

        $service->clearCart();

        $meta = $seo = (object) [
            'title' => '',
            'description' => '',
            'keywords' => ''
        ];

        return view('order', compact(['common', 'seo', 'meta']));
    }
}
