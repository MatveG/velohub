<?php

namespace App\Models\Traits\Relations\HasMany;

trait Products
{
    public function Products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
