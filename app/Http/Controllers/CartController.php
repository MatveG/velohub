<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
//    public function foo(Request $request): JsonResponse
//    {
//        DB::statement("UPDATE carts SET products = '[{\"id\":50,\"variant_id\":null,\"amount\":1},{\"id\":100,\"variant_id\":101,\"amount\":1}]' WHERE id = 153");
//
//        $cart = Cart::where('id', 153)->firstOrFail();
//
//        $cart->products = array_filter($cart->products, function ($el) {
//            return $el['id'] !== 50;
//        });
//        $cart->save();
//
//
//        dd($cart->products);
//
//        return response()->json($this->mapCartProducts($cart->products));
//    }

//    public function show(Request $request): JsonResponse
//    {
//        $uuid = $request->cookie('_ucart');
//        $cart = $uuid ? Cart::where('uuid', $request->cookie('_ucart'))->first() : null;
//
//        if (!$uuid || !$cart) {
//            $cart = new Cart();
//            $cart->uuid = uniqid('', false);
//            $cart->products = [];
//            $cart->save();
//
//            return response()->json([])->cookie(
//                cookie('_ucart', $cart->uuid, 60 * 24 * 90)
//            );
//        }
//
//        return response()->json($this->mapCartProducts($cart->products));
//    }

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
