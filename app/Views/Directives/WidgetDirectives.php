<?php

namespace App\Views\Directives;

use App\Models\Widget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;

class WidgetDirectives
{
    private static Collection $widgets;

    public static function directives()
    {
        self::$widgets = Widget::all();

        Blade::directive('widget', function ($key) {
            return self::render($key);
        });
    }

    protected static function render($key)
    {
        return self::$widgets->firstWhere('slug', $key)->text ?? null;
    }
}
