<?php

namespace App\Services\Filters;

class RangeFilter extends AFilter
{
    protected string $type = 'range';

    public function fetchValues(object $query): AFilter
    {
        parent::fetchValues($query);

        $result = [];
        $max = max($this->getValues());
        $min = min($this->getValues());
        $total = round(1 + 3.322 * log10(count($this->getValues())));
        $range = ($max - $min) / $total;

        for ($i = 0; $i < $total; $i++) {
            $result[] = round($min + $range * $i) . "-" . round($min + $range * ($i + 1));
        }
        $this->setValues($result);

        return $this;
    }

    public function applyFilter(object $query): object
    {
        $min = null;
        $max = null;

        foreach ($this->getParams() as $param) {
            list($from, $to) = explode('-', $param);
            $min = ($from < $min) ? $from : $min;
            $max = ($to > $max) ? $to : $max;
            $flag = true;
        }

        if (isset($flag) && $flag === true) {
            $field = sprintf('(%s->\'%s\')::int', $field, $filter);

            $query->whereRaw($field . ' > ' . (float)$min);
            $query->whereRaw($field . ' < ' . (float)$max);
        }

        return $query;
    }
}
