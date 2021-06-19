<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('settings')) {
    function settings(string $group, string $key = null)
    {
        static $settings;

        if (empty($settings)) {
            $settings = Cache::remember('App\Helpers\settings', 5 * 60, function () {
                return array_map(
                    fn ($group) => array_column($group, 'value', 'key'),
                    Setting::all()->groupBy('group')->toArray()
                );
            });
        }

        return $key ? $settings[$group][$key] ?? null : $settings[$group] ?? null;
    }
}
