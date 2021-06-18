<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

const ONLY_COLS = [
    'id',
    'variant_id',
    'amount',
    'title',
    'brand',
    'model',
    'price',
    'image',
    'link'
];

class CartProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $uuid = $request->cookie('_ucart');
        $cart = Cart::where('uuid', $uuid)->first();

        if (empty($uuid) || empty($cart)) {
            $cart = new Cart();
            $cart->uuid = uniqid('', false);
            $cart->products = [];
            $cart->save();

            return response()->json([])->cookie(
                cookie('_ucart', $cart->uuid, 60 * 24 * 90)
            );
        }

        return response()->json($this->mapCartProducts($cart->products));
    }

    public function attach(Request $request): JsonResponse
    {
        // validation
        // only unique id && variant_id

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();
        $product = Product::findOrFail($request->id);

        $product->variant_id = $request->variant_id ?? null;
        $product->amount = $request->amount;

        $cart->products = array_merge(
            $cart->products,
            [$product->only('id', 'variant_id', 'amount')]
        );
        $cart->save();

        return response()->json($product->only(ONLY_COLS));
    }

    public function detach(Request $request): JsonResponse
    {
        // validation

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();

        $cart->products = array_filter($cart->products, function ($el) use ($request) {
            return $request->variant_id ?
                $el['id'] !== $request->id && $el['variant_id'] !== $request->variant_id :
                $el['id'] !== $request->id;
        });
        $cart->save();

        return response()->json();
    }

    public function update(Request $request): JsonResponse
    {
        // validation

        $cart = Cart::where('uuid', $request->cookie('_ucart'))->firstOrFail();
        $product = Product::findOrFail($request->id);

        $product->variant_id = $request->variant_id ?? null;
        $product->amount = $request->amount;

        $cart->products = array_map(function ($el) use ($request, $product) {
            return $el['id'] === $request->id ? $product->only('id', 'variant_id', 'amount') : $el;
        }, $cart->products);
        $cart->save();

        return response()->json($product->only(ONLY_COLS));
    }

    private function mapCartProducts(array $products): array
    {
        $products = array_map(function ($el) {
            $product = Product::find($el['id']);
            $product->variant_id = $el['variant_id'] ?? null;
            $product->amount = $el['amount'];

            return $product ? $product->only(ONLY_COLS) : null;
        }, $products);

        return array_filter($products);
    }
}
