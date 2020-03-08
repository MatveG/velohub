<?php

namespace App\Models\Traits\Relations\BelongsTo;

trait Product
{
    public function Product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
