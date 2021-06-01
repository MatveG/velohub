<?php

namespace App\Models\Traits;

trait Search
{
    public function scopeSearchBy($query, $string)
    {
        $query->whereRaw("search @@ to_tsquery('" . $this->escapeSearchString($string) . "')");
    }

    public function scopeOrderByRelevance($query, $string)
    {
        $query->orderByRaw("ts_rank(search, to_tsquery('" . $this->escapeSearchString($string) . "')) DESC");
    }

    private function escapeSearchString(string $string): string
    {
        return str_replace(' ', '  |', trim(
            preg_replace('/[^+A-Za-z0-9- ]/', '', $string)
        ));
    }
}
