<?php

namespace App\Models\Traits\Relations\HasMany;

trait Features
{
    public function Features()
    {
        return $this->hasMany(\App\Models\Feature::class)->orderBy('ord');
    }
}
