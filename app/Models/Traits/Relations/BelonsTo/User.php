<?php

namespace App\Models\Traits\Relations\BelongsTo;

trait User
{
    public function User()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
