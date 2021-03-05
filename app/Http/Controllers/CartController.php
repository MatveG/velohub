<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;

/**
 * Shopping Cart Controller
 */
class CartController extends Controller
{
    public function new(Request $request, Cart $cart)
    {
        $this->checkAjaxRequiredFields($request, ['id']);

        $cart = $cart->create(['sign' => uniqid('', false)]);
        $cart->variants()->attach($request->id);

        return response()->json([
            'ok' => 1,
            'id' => $cart->id,
            'sign' => $cart->sign,
        ]);
    }

    public function add(Request $request, Cart $cart)
    {
        $this->checkAjaxRequiredFields($request, ['cart_id', 'sign', 'id']);

        $where = [['id', $request->cart_id], ['sign', $request->sign]];
        $cart = $cart->where($where)->first() ?: $cart->create(['sign' => uniqid('', false)]);

        if (!$cart->variants()->find($request->get('id'))) {
            $cart->variants()->attach($request->get('id'));
        }

        return response()->json(['ok' => 1]);
    }

    public function form(CartService $service)
    {
        $items = $service->getCartItems();
        $seo = (object) ['title' => '','description' => '','keywords' => ''];

        return view('cart-form', compact(['items', 'seo']));
    }

    public function send(Request $request, Order $order, CartService $service)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required|min:9',
            'address' => 'required|min:3',
            'payment' => 'required|numeric',
            'shipping' => 'required|numeric',
        ]);

        $order->fill(request()->all());
        $order->items = $service->getItemsJson();
        $order->save();
        $service->clearCart();

        $seo = (object) ['title' => '','description' => '','keywords' => ''];

        return view('cart-send', compact(['common', 'seo']));
    }
}
