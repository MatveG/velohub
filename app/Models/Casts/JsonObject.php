<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class JsonObject implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value);
    }

    public function set($model, $key, $value, $attributes)
    {
        if (gettype($value) === 'string') {
            $value = json_decode($value);
        }

        return json_encode((object)($value), JSON_UNESCAPED_UNICODE);
    }
}
