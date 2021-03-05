<?php

namespace App\Models\Traits\Relations\BelongsTo;

trait Category
{
    public function Category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
