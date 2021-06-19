<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;

class CartService
{
    public static function findProduct(Cart $cart, array $props): ?object
    {
        $searched = array_filter($cart->products, function ($product) use ($props) {
            return $product->product_id === $props['product_id'] ||
                $props['variant_id'] && $product->variant_id === $props['variant_id'];
        });

        return array_shift($searched);
    }

    public static function addProduct(Cart $cart, array $props): void
    {
        if (($existing = self::findProduct($cart, $props))) {
            self::updateProduct($cart, array_merge($props, ['amount' => $existing->amount + 1]));
            return;
        }

        $product = Product::findOrFail($props['product_id']);

        if ($props['variant_id']) {
            $variant = Variant::findOrFail($props['variant_id']);
        }

        $cart->products = [...$cart->products, [
            'product_id' => $product->id,
            'variant_id' => $variant->id ?? null,
            'amount' => $props['amount'] ?? 1,
        ]];
        $cart->save();
    }

    public static function updateProduct(Cart $cart, array $props): void
    {
        $product = Product::findOrFail($props['product_id']);

        if ($props['variant_id']) {
            $variant = Variant::findOrFail($props['variant_id']);
        }

        $cart->products = array_map(function ($item) use ($props) {
            if ($item->product_id === $props['product_id']) {
                $item->amount = $props['amount'];
            }

            return $item;
        }, $cart->products);
        $cart->save();
    }

    public static function removeProduct(Cart $cart, array $props): void
    {
        $cart->products = array_filter($cart->products, function ($item) use ($props) {
            return $props['variant_id'] ?
                $item->product_id !== $props['product_id'] && $item->variant_id !== $props['variant_id'] :
                $item->product_id !== $props['product_id'];
        });
        $cart->save();
    }
}
