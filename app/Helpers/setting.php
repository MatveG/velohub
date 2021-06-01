<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting(string $key, ?string $property = null)
    {
        static $settings;

        if (empty($settings)) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
        }

        return $property ? $settings[$key]->$property ?? null : $settings[$key] ?? null;
    }
}
