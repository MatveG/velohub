<?php

namespace App\Services;

/**
* Service Class
* Collect filters for Products
*/
class FilterService
{
    protected $settings = [];
    protected $filters;

    /**
     * Get Filters object
     * @return $this->filters;
     */
    public function get()
    {
        return $this->filters;
    }

    /**
    * Parse filter settings from url $path
     * @return $this
    */
    public function parsePath(string $path)
    {
        $this->filters = (object)[
            'base' => str_replace($path, '', url()->full()),
            'active' => (empty($path)) ? false : true,
        ];

        if(empty($path)) return $this;

        foreach(explode('/', $path) as $pathArray) {
            list($pathKey, $pathVal) = explode('-is-', $pathArray, 2);

            if(empty($pathKey) || empty($pathVal)) continue;

            if(strpos($pathVal, '-or-')) {
                $this->settings[$pathKey] = explode('-or-', $pathVal);
                continue;
            }
            $this->settings[$pathKey][] = $pathVal;
        }

        return $this;
    }

    /**
    * Fill values for price filter
    * @return $this
    */
    public function usePrice(object $query)
    {
        $this->filters->prices = (object)[
            'min' => (object)[ 'title' => 'Цена от', 'values' => [
                $query->selectRaw("min((prices->>'retail')::int)")->pluck('min')->first() => false]
            ],
            'max' => (object)[ 'title' => 'Цена до', 'values' => [
                $query->selectRaw("max((prices->>'retail')::int)")->pluck('max')->first() => false]
            ],
        ];

        foreach ($this->settings as $key => $setting) {
            if($setting && ($key === 'price-min' || $key === 'price-max')) {
                $short = ($key === 'price-min') ? 'min' : 'max';
                $this->filters->prices->{$short}->values = [$setting[0] => true];
            }
        }

        return $this;
    }

    /**
    * Fill values for brand filter
    * @return $this
    */
    public function useBrand(object $query)
    {
        $this->filters->brands = (object) ['brand' => (object)[ 'title' => 'Бренд', 'values' => [] ] ];

        $values = $this
            ->clearQuery($query)
            ->groupBy('brand')
            ->pluck('brand')
            ->toarray();

        natsort($values);

        foreach ($values as $value) {
            if(empty($value)) continue;

            $this->filters->brands->brand->values[$value] =
                isset($this->settings['brand']) && in_array($value, $this->settings['brand'], true);
        }

        return $this;
    }

    /**
    * Fill values for any Category filter
    * @return $this
    */
    public function useJson(object $category, string $jsonName, object $query)
    {
        $this->filters->{$jsonName} = (object) collect($category->{$jsonName})
            ->where('filter', '1')
            ->sortBy('order')
            ->all();

        foreach ($this->filters->{$jsonName} as $keyName => $filter) {
            if($filter->range) {
                $this->intervalValues($jsonName, $keyName, $query);
            } else {
                $this->regularValues($jsonName, $keyName, $query);
            }
        }

        return $this;
    }

    /**
     * Fill range values for Category filter
     * @return void
     */
    public function intervalValues(string $jsonName, string $keyName, object $query)
    {
        $fullName = $jsonName.'->'.$keyName;
        $values = $this
            ->clearQuery($query)
            ->groupBy($fullName)
            ->pluck($fullName.' AS '.$keyName)
            ->toarray();

        $max = max($values);
        $min = min($values);
        $total = round( 1 + 3.322 * log10( count($values) ) );
        $range = ($max - $min) / $total;

        for($i = 0; $i < $total; $i++) {
            $value = round( $min + $range * $i ) . "-" . round( $min + $range * ($i + 1) );

            $this->filters->{$jsonName}->{$keyName}->values[$value] = (
                isset($this->settings[$keyName])
                && in_array($value, $this->settings[$keyName])
            );
        }
    }

    /**
     * Fill regular values for Category filter
     * @return void
     */
    public function regularValues(string $jsonName, string $keyName, object $query)
    {
        $fullName = $jsonName.'->'.$keyName;
        $values = $this
            ->clearQuery($query)
            ->groupBy($fullName)
            ->pluck($fullName.' AS '.$keyName)
            ->toarray();

        natsort($values);

        foreach ($values as $value) {
            if(empty($value)) continue;

            $this->filters->{$jsonName}->{$keyName}->values[$value] =
                isset($this->settings[$keyName])
                && in_array($value, $this->settings[$keyName]);
        }
    }

    /**
     * Clear Query Builder
     * @return object $query
     */
    private function clearQuery(object $query)
    {
        $method = (method_exists($query, 'getBaseQuery')) ? 'getBaseQuery' : 'getQuery';

        $query->{$method}()->columns = null;
        $query->{$method}()->orders = null;
        $query->{$method}()->groups = null;

        return $query;
    }

}
