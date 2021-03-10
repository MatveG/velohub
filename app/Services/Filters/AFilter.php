<?php

namespace App\Services\Filters;

abstract class AFilter
{
    protected $type = 'filter';
    protected $title;
    protected $column;
    protected $slug;
    protected $units;
    private $values = [];
    private $params = [];

    public function __construct(string $column, string $slug, string $title, string $units = null)
    {
        if (!str_contains($column, '.')) {
            throw new \InvalidArgumentException('Column property must contain table name');
        }

        $this->title = $title;
        $this->column = $column;
        $this->slug = $slug;
        $this->units = $units;
    }

    public function __get($property)
    {
        return property_exists($this, $property) ? $this->$property : null;
    }

    public static function init(...$arguments): self
    {
        return new static(...$arguments);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setValues(array $value): void
    {
        natsort($value);
        $this->values = $value;
    }

    public function setParams(array $value): void
    {
        $this->values = $value;
    }

    public function inParams($value): bool
    {
        return in_array($value, $this->params);
    }

    public function fetchValues(object $query): self
    {
        $this->setValues(
            (clone $query)
                ->whereNotNull($this->column)
                ->groupBy($this->column)
                ->pluck($this->pluckName())
                ->toarray()
        );

        return $this;
    }

    protected function pluckName(): string
    {
        if (str_contains($this->column, '->')) {
            return $this->column . ' AS ' . explode('->', $this->column)[1];
        }

        return $this->column;
    }

    public function fetchParams(array $request): AFilter
    {
        $this->params = $request[$this->slug] ?? [];

        return $this;
    }

    abstract public function applyFilter(object $query): object;
}
