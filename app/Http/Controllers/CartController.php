<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function create(): JsonResponse
    {
        $cart = new Cart(['products' => []]);
        $cart->uuid = uniqid('', false);
        $cart->save();

        return response()->json($cart->only(['uuid', 'products']));
    }

    public function get(string $uuid): JsonResponse
    {
        // validation
        $cart = Cart::where('uuid', $uuid)->firstOrFail();

        return response()->json(['products' => $this->mapCartProducts($cart->products)]);
    }

    public function update(Request $request, string $uuid): JsonResponse
    {
        // validation

        $cart = Cart::where('uuid', $uuid)->firstOrFail();
        $cart->update($request->all());

        return response()->json(['products' => $this->mapCartProducts($cart->products)]);
    }

    private function mapCartProducts(array $products): array
    {
        return array_map(function ($el) {
            $product = Product::find($el['id']);

            if (empty($product)) {
                return null;
            }
            $product->variant_id = $el['variant_id'] ?? null;
            $product->amount = $el['amount'];

            return $product->only([
                'id',
                'variant_id',
                'amount',
                'title',
                'brand',
                'model',
                'price',
                'image',
                'link'
            ]);
        }, $products);
    }

//    public function add(Request $request, Cart $cart): JsonResponse
//    {
//        $this->checkAjaxRequiredFields($request, ['cart_id', 'sign', 'id']);
//
//        $where = [['id', $request->cart_id], ['sign', $request->sign]];
//        $cart = $cart->where($where)->first() ?: $cart->create(['sign' => uniqid('', false)]);
//
//        if (!$cart->variants()->find($request->get('id'))) {
//            $cart->variants()->attach($request->get('id'));
//        }
//
//        return response()->json(['ok' => 1]);
//    }

}
