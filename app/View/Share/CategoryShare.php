<?php

namespace App\View\Share;

use App\Models\Category;
use Illuminate\Support\Facades\View;

class CategoryShare
{
    public static function share()
    {
        View::share('categoryTree', self::categoryTree());
    }

    protected static function categoryTree()
    {
        return Category
            ::where('parent_id', 0)
            ->where('is_active', true)
            ->orderBy('ord')
            ->get();
    }
}
