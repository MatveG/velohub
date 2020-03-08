<?php

namespace App\Repositories;

use \App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository extends Repository
{
    private static $orderMatch = [
        'a-z' => ['field' => 'products.model',          'order' => 'ASC'],
        'z-a' => ['field' => 'products.model',          'order' => 'DESC'],
        'l-h' => ['field' => 'products.prices->retail', 'order' => 'ASC'],
        'h-l' => ['field' => 'products.prices->retail', 'order' => 'DESC'],
        'o-n' => ['field' => 'products.id',             'order' => 'ASC'],
        'n-o' => ['field' => 'products.id',             'order' => 'DESC'],
    ];

    public function __construct(Product $model)
    {
        $this->model = $model;
        $this->query = $model->newQuery();
    }

    /**
     * Handle sorting by match values
     */
    public function orderShop(Request $request, string $defaultColumn = 'products.id', string $defaultOrder = 'DESC')
    {
        if($request->has('find') && !$request->has('sort')) return $this;

        $this->query->orderBy(
            self::$orderMatch[$request->sort]['field'] ?? $defaultColumn,
            self::$orderMatch[$request->sort]['order'] ?? $defaultOrder
        );

        return $this;
    }

    /**
     * Handle filtering by all conditions
     */
    public function filter(object $filters)
    {
        if(isset($filters->brands)) {
            $this->filterBrand($filters);
        }

        if(isset($filters->prices)) {
            $this->filterPrice($filters);
        }

        if(isset($filters->features)) {
            $this->filterJson($filters, 'products', 'features');
        }

        if(isset($filters->options)) {
            $this->filterJson($filters, 'skus', 'options');
        }

        return $this;
    }

    /**
     * Handle filtering by price
     */
    public function filterPrice(object $filters)
    {
        $min = array_key_first($filters->prices->min->values);
        $max = array_key_first($filters->prices->max->values);

        if($filters->prices->min->values[$min] === true) {
            $this->query->whereRaw("(products.prices->>'retail')::int >= " . $min);
        }

        if($filters->prices->max->values[$max] === true) {
            $this->query->whereRaw("(products.prices->>'retail')::int <= " . $max);
        }

        return $this;
    }

    /**
     * Handle filtering by brand
     */
    public function filterBrand(object $filters)
    {
        $this->query->where(function($query) use ($filters) {
            foreach ($filters->brands->brand->values as $key => $val) {
                if($val === true) {
                    $query->orWhere('brand', $key);
                }
            }
        });

        return $this;
    }

    /**
     * Handle filtering json fields
     */
    public function filterJson(object $filters, string $tableName, string $jsonName)
    {
        foreach ($filters->{$jsonName} as $filter => $records) {
            $method = 'filterJson' . ( ($records->range === 1) ? 'Range' : 'Regular' );

            $this->{$method}($tableName.'.'.$jsonName, $filter, $records->values);
        }

        return $this;
    }

    /**
     * Filtering by regular values
     */
    public function filterJsonRegular(string $field, string $filter, array &$values)
    {
        $field = $field.'->'.$filter;

        $this->query->where(function($query) use ($field, $values) {
            foreach ($values as $key => $val) {
                if($val !== true) continue;

                $query->orWhere($field, $key);
            }
        });
    }

    /**
     * Filtering by range values
     */
    public function filterJsonRange(string $field, string $filter, array &$values)
    {
        foreach ($values as $key => $val) {
            if($val !== true) continue;

            list($from, $to) = explode('-', $key);
            $min = (!isset($min) || $from < $min) ? $from : $min;
            $max = (!isset($max) || $to > $max) ? $to : $max;
            $flag = true;
        }

        if (isset($flag) && $flag === true) {
            $field = sprintf('(%s->\'%s\')::int', $field, $filter);

            $this->query->whereRaw($field.' > '.(int)$min);
            $this->query->whereRaw($field.' < '.(int)$max);
        }
    }

}
