<?php

namespace App\Services\Filters;

class AndFilter extends AFilter
{
    protected string $type = 'and';

    public function setValues(array $value): void
    {
        $result = array_unique(
            array_reduce($value, function ($carry, $el) {
                array_push($carry, ...json_decode($el));

                return $carry;
            }, [])
        );

        parent::setValues($result);
    }

    public function applyFilter(object $query): object
    {
        return $query->where(function ($query) {
            foreach ($this->getParams() as $param) {
                $query->Where($this->column, $param);
            }
        });
    }
}
