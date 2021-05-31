<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class FeaturesCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes): array
    {
        return array_map(fn($each) => new Feature($each), json_decode($value, true));
    }

    public function set($model, $key, $value, $attributes)
    {
        // check instance of each
        return json_encode((array)$value, JSON_UNESCAPED_UNICODE);
    }
}
