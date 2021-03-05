<?php

namespace App\View\Share;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProductShare
{
    public static function share()
    {
        View::share('compareItems', self::compareItems());
    }

    public static function compareItems()
    {
        if (empty($_COOKIE['compare'])) {
            return null;
        }

        $idArr = json_decode(urldecode($_COOKIE['compare']));

        return Product
            ::select(DB::raw('category_id, count(category_id) as amount'))
            ->with('category')
            ->whereIn('id', $idArr)
            ->where('is_active', true)
            ->groupBy('category_id')
            ->get();
    }
}
