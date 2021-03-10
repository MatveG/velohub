<?php

namespace App\Services;

class FiltersService
{
    private $query;
    private $input;
    private $filters = [];

    public function __construct(object $query, array $input)
    {
        $this->query = $query;
        $this->input = $input;
    }

    public function __get($property)
    {
        return property_exists($this, $property) ? $this->$property : null;
    }

    public static function init(...$args): self
    {
        return new self(...$args);
    }

    public function withFilters(array $filters): self
    {
        foreach ($filters as $filter) {
            $filter->loadValues($this->query);
            $filter->loadChecked($this->input);
        }
        $this->filters = $filters;

        return $this;
    }







    public function usePrice(object $query)
    {
        $this->filters->prices = (object)[
            'min' => (object)[ 'title' => 'Цена от', 'values' => [
                $query->selectRaw("min(price)")->pluck('min')->first() => false]
            ],
            'max' => (object)[ 'title' => 'Цена до', 'values' => [
                $query->selectRaw("max(price)")->pluck('max')->first() => false]
            ],
        ];

        foreach ($this->settings as $key => $setting) {
            if ($setting && ($key === 'price-min' || $key === 'price-max')) {
                $short = ($key === 'price-min') ? 'min' : 'max';
                $this->filters->prices->{$short}->values = [$setting[0] => true];
            }
        }

        return $this;
    }

    public function useJson(object $category, string $jsonName, object $query)
    {
        $this->filters->{$jsonName} = (object) collect($category->{$jsonName})
            ->where('filter', '1')
            ->sortBy('order')
            ->all();

        foreach ($this->filters->{$jsonName} as $keyName => $filter) {
            if ($filter->range) {
                $this->intervalValues($jsonName, $keyName, $query);
            } else {
                $this->regularValues($jsonName, $keyName, $query);
            }
        }

        return $this;
    }

    public function intervalValues(string $jsonName, string $keyName, object $query)
    {
        $fullName = $jsonName . '->' . $keyName;
        $values = $this
            ->clearQuery($query)
            ->groupBy($fullName)
            ->pluck($fullName . ' AS ' . $keyName)
            ->toarray();

        $max = max($values);
        $min = min($values);
        $total = round(1 + 3.322 * log10(count($values)));
        $range = ($max - $min) / $total;

        for ($i = 0; $i < $total; $i++) {
            $value = round($min + $range * $i) . "-" . round($min + $range * ($i + 1));

            $this->filters->{$jsonName}->{$keyName}->values[$value] = (
                isset($this->settings[$keyName])
                && in_array($value, $this->settings[$keyName])
            );
        }
    }

    public function regularValues(string $jsonName, string $keyName, object $query)
    {
        $fullName = $jsonName . '->' . $keyName;
        $values = $this
            ->clearQuery($query)
            ->groupBy($fullName)
            ->pluck($fullName . ' AS ' . $keyName)
            ->toarray();

        natsort($values);

        foreach ($values as $value) {
            if (empty($value)) {
                continue;
            }

            $this->filters->{$jsonName}->{$keyName}->values[$value] =
                isset($this->settings[$keyName])
                && in_array($value, $this->settings[$keyName]);
        }
    }

    private function clearQuery(object $query)
    {
        $method = (method_exists($query, 'getBaseQuery')) ? 'getBaseQuery' : 'getQuery';

        $query->{$method}()->columns = null;
        $query->{$method}()->orders = null;
        $query->{$method}()->groups = null;

        return $query;
    }
}
