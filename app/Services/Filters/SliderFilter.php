<?php

namespace App\Services\Filters;

class SliderFilter extends AFilter
{
    protected string $type = 'slider';

    public function fetchValues(object $query): AFilter
    {
        parent::fetchValues($query);

        if (count($this->getValues())) {
            $this->setValues([
                min($this->getValues()),
                max($this->getValues())
            ]);
        }

        return $this;
    }

    public function fetchParams(array $request): AFilter
    {
        parent::fetchParams($request);

        if (count($this->getParams())) {
            $this->setParams([
                min($this->getParams()),
                max($this->getParams())
            ]);
        }

        return $this;
    }

    public function applyFilter(object $query): object
    {
        if ($this->getParams()) {
            $query->where($this->column, '>=', $this->getParams()[0]);
            $query->where($this->column, '<=', $this->getParams()[1]);
        }

        return $query;
    }
}
