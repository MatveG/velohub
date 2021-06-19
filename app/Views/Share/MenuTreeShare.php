<?php

namespace App\Views\Share;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class MenuTreeShare
{
    public static function share()
    {
        View::share('_menuTree', self::menuTree());
    }

    public static function menuTree()
    {
        return Cache::remember('App\Views\Share\MenuShare::menuTree', 60 * 60, function () {
            return Menu::where('parent_id', 0)
                ->where('is_active', true)
                ->with('children')
                ->orderBy('ord')
                ->get();
        });
    }
}
