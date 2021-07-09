<?php

namespace App\Models\Traits\Relations\HasMany;

trait Parameters
{
    public function Parameters()
    {
        return $this->hasMany(\App\Models\Parameter::class)->where('parent_id', 0)->orderBy('ord');
    }
}
