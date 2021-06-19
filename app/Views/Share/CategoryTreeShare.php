<?php

namespace App\Views\Share;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CategoryTreeShare
{
    public static function share()
    {
        View::share('_categoryTree', self::categoryTree());
    }

    protected static function categoryTree()
    {
        return Cache::remember('App\Views\Share\CategoryShare::categoryTree', 60 * 60, function () {
            return Category::where('parent_id', 0)
                ->where('is_active', true)
                ->with('children')
                ->orderBy('ord')
                ->get();
        });
    }
}
