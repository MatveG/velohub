<?php

namespace App\Services\Filters;

class PlainFilter extends AFilter
{
    protected string $type = 'plain';

    public function applyFilter(object $query): object
    {
        return $query->where(function ($query) {
            foreach ($this->getParams() as $param) {
                $query->orWhere($this->column, $param);
            }
        });
    }
}
