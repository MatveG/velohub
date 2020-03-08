<?php

namespace App\Models\Traits\Relations\HasMany;

trait Skus
{
    public function Skus()
    {
        return $this->hasMany(\App\Models\Sku::class);
    }
}
