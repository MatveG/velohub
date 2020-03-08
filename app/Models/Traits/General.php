<?php

namespace App\Models\Traits;

trait General
{
    public function getName()
    {
        return $this->name;
    }

    public function getSearcheble()
    {
        return $this->searchable;
    }

    public function scopeActive($query)
    {
        $query->where($this->getTable() . '.is_active', 'true');
    }
}
