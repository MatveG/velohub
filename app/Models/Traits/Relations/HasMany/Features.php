<?php

namespace App\Models\Traits\Relations\HasMany;

trait Features
{
    public function Features()
    {
        return $this->hasMany(\App\Models\Feature::class)->where('parent_id', 0)->orderBy('ord');
    }
}
