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

        return view('cart', compact(['items', 'seo']));
    }

}
