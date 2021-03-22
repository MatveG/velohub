<?php

// [{"id":"6qcnLu","ord":null,"title":"stringOne","latin":"stringone","type":"string","hint":null,"required":true,"filter":true,"units":null,"values":[],"sub":[]},{"id":"C4t5_8","ord":null,"title":"numberTwo","latin":"numbertwo","type":"number","hint":null,"required":false,"filter":true,"units":"sm","values":[],"sub":[]}]
// [{"id":"wbDv9_","ord":null,"title":"paramThree","latin":"paramthree","type":"string","filter":true,"units":null,"values":[]}]

namespace App\Services;

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

    private function addFilter(
        string $type,
        string $column,
        string $slug,
        string $title,
        string $units = null
    ): self {
        $className = "App\Services\Filters\\$type";
        $filter = $className::init($column, $slug, $title, $units)
            ->fetchValues($this->query)
            ->fetchParams($this->params);
        !$filter->isEmpty() && $this->filters[] = $filter;

        return $this;
    }

    public function addFiltersSet(array $fieldsSet, string $column): self
    {
        $filters = array_filter($fieldsSet, fn ($el) => $el['filter'] === true);
        usort($filters, fn ($a, $b) => $a['ord'] <=> $b['ord']);

        array_walk($filters, fn ($filter) => $this->addFilter(
            self::filterType($filter),
            "$column->{$filter['id']}",
            $filter['latin'],
            $filter['title'],
            $filter['units']
        ));

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

    private static function filterType(array $filter): string
    {
        return $filter['type'] === 'multiple' ? 'AndFilter' : 'PlainFilter';
    }
}
