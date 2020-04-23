<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait Common
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

    public function getImagesFolder()
    {
        return $this->imagesFolder;
    }

//    public function getCreatedAtAttribute($date)
//    {
//        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d.m.Y');
//    }
//
//    public function getUpdatedAtAttribute($date)
//    {
//        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d.m.Y');
//    }
}
