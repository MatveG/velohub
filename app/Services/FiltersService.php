<?php

namespace App\Services;

use Illuminate\Support\Collection;

class FiltersService
{
    protected object $query;
    protected array $params;
    protected array $filters = [];

    public function __construct(object $query, array $params)
    {
        $this->query = $query;
        $this->params = $params;
    }

    public function __get(string $property)
    {
        return property_exists($this, $property) ? $this->$property : null;
    }

    public static function init(...$arguments): self
    {
        return new static(...$arguments);
    }

    public function addAndFilter(...$arguments): self
    {
        return $this->addFilter('AndFilter', ...$arguments);
    }

    public function addPlainFilter(...$arguments): self
    {
        return $this->addFilter('PlainFilter', ...$arguments);
    }

    public function addRangeFilter(...$arguments): self
    {
        return $this->addFilter('RangeFilter', ...$arguments);
    }

    public function addSliderFilter(...$arguments): self
    {
        return $this->addFilter('SliderFilter', ...$arguments);
    }

    private function addFilter(string $type, string $column, string $slug, string $title, string $units = null): self
    {
        $className = "App\Services\Filters\\$type";
        $filter = $className::init($column, $slug, $title, $units)
            ->fetchValues($this->query)
            ->fetchParams($this->params);

        if (!$filter->isEmpty()) {
            $this->filters[] = $filter;
        }

        return $this;
    }

    public function addFiltersSet(Collection $fields, string $tableColumn): self
    {
        $filters = $fields->where('is_filter', true)->sortBy('ord');

        $filters->each(function ($filter) use ($tableColumn) {
            $this->addFilter(
                self::filterType($filter),
                "$tableColumn->$filter->key",
                $filter->slug,
                $filter->title,
                $filter->units
            );
        });

        return $this;
    }

    public function applyFilters(): self
    {
        array_walk($this->filters, fn ($filter) => $filter->applyFilter($this->query));

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    private static function filterType(object $filter): string
    {
        return $filter->type === 'multiple' ? 'AndFilter' : 'PlainFilter';
    }
}
