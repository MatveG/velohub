<?php

namespace App\Views\Directives;

use App\Models\Widget;
use Illuminate\Support\Facades\Blade;

class WidgetDirectives
{
    private static $widgets;

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
