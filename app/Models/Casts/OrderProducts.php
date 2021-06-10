<?php

namespace App\Models\Casts;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class OrderProducts implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return array_map(function ($product) {
            if (isset($product->id)) {
                if (isset($product->variant_id)) {
                    $product->variant = Variant::find($product->variant_id);
                }
                $product->product = Product::with('variants')->find($product->id);
            }

            return $product;
        }, (array)json_decode($value));
    }

    public function set($model, $key, $value, $attributes)
    {
//        if (gettype($value) === 'string') {
//            $value = json_decode($value);
//        }
//
//        return json_encode((object)($value), JSON_UNESCAPED_UNICODE);
    }
}
