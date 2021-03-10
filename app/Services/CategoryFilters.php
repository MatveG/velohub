<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Filters\AFilter;
use App\Services\Filters\AndFilter;
use App\Services\Filters\Filter;

class CategoryFilters
{
    public $category;
    public $column;
    public $filters;

    public function __construct(Category $category, string $categoryColumn, string $targetTable)
    {
        $this->category = $category;
        $this->column = $categoryColumn;
        $this->table = $targetTable;
    }

    public static function init(...$arguments): self
    {
        return new static(...$arguments);
    }

    public function fetchFilters(object $query, array $request): self
    {
        $this->filters =  collect($this->category->{$this->column})
            ->where('filter', '1')
            ->sortBy('ord')
            ->map(function ($element) use ($query, $request) {
                return $this->initFilter($element, $query, $request);
            });

        return $this;
    }

    private function initFilter(array $filter, object $query, array $request): AFilter
    {
        return $this->filterType($filter)::init(
            $this->columnPath($filter['id']),
            $filter['latin'],
            $filter['title'],
            $filter['units'] ?? ''
        )->fetchValues($query)->fetchParams($request);
    }

    private function filterType(array $filter): string
    {
        return $filter ['type'] === 'multiple' ? AndFilter::class : Filter::class;
    }

    private function columnPath(string $id): string
    {
        return "$this->table.$this->column->{$id}";
    }

    public function applyFilter(object $query): object
    {
        return $this->filters->map(function ($filter) use ($query) {
            return $filter->applyFilter($query);
        });
    }

}
