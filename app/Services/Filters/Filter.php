<?php

namespace App\Services\Filters;

class Filter extends AFilter
{
    public function applyFilter(object $query): object
    {
        return $query->where(function ($query) {
            foreach ($this->getParams() as $param) {
                $query->orWhere($this->column, $param);
            }
        });
    }
}
