<?php

namespace App\Models\Traits\Relations\HasMany;

trait Variants
{
    public function Variants()
    {
        return $this->hasMany(\App\Models\Variant::class);
    }
}
