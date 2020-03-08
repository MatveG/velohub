<?php

namespace App\Models\Traits\Relations\HasMany;

trait Comments
{
    public function Comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }
}
