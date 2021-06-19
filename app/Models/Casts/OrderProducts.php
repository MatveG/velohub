<?php

namespace App\Models\Casts;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class OrderProducts implements CastsAttributes
{
    const PRODUCT_COLS = [
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

    public function get($model, $key, $value, $attributes)
    {
        return array_filter(
            array_map([$this, 'mapModels'], (array)json_decode($value))
        );
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode(
            (object)(gettype($value) === 'string' ? json_decode($value) : $value),
            JSON_UNESCAPED_UNICODE
        );
    }

    private function mapModels($item)
    {
        if ($item->product_id) {
            $item->product = Product::with('variants')->find($item->product_id)->only(self::PRODUCT_COLS);
        }
        if ($item->variant_id) {
            $item->variant = Variant::find($item->variant_id);
        }

        return $item->product ? $item : null;
    }
}
