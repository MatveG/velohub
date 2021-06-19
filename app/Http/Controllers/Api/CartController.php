<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $uuid = $request->cookie('_ucart');
        $cart = Cart::where('uuid', $uuid)->first();

        if (empty($cart)) {
            $cart = new Cart();
            $cart->uuid = uniqid('', false);
            $cart->products = [];
            $cart->save();
            $cookie = cookie('_ucart', $cart->uuid, 60 * 24 * 90, '/');

            return response()->json([])->cookie($cookie);
        }

        return response()->json($cart->products);
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'integer|nullable',
        ]);

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        CartService::addProduct($cart, $request->only(['product_id', 'variant_id', 'amount']));

        return response()->json($cart->products);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'integer|nullable',
        ]);

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        CartService::updateProduct($cart, $request->only(['product_id', 'variant_id', 'amount']));

        return response()->json($cart->products);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'integer|nullable',
        ]);

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        CartService::removeProduct($cart, $request->only(['product_id', 'variant_id']));

        return response()->json($cart->products);
    }
}

