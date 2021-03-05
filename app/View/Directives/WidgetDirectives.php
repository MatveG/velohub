<?php

namespace App\View\Directives;

use App\Models\Widget;
use Illuminate\Support\Facades\Blade;

class WidgetDirectives
{
    public static function directives()
    {
        $widgets = Widget::all();

        Blade::directive('widget', function ($key) use ($widgets) {
            return self::render($key, $widgets);
        });
    }

    protected static function render($key, $widgets)
    {
        return $widgets->firstWhere('slug', $key)->text;
    }
}
