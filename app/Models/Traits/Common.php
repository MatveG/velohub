<?php

namespace App\Models\Traits;

trait Common
{
    public function getName(): string
    {
        return $this->name;
    }

    public function scopeIsActive($query): void
    {
        $query->where($this->getTable() . '.is_active', 'true');
    }
}
