<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting(string $key, ?string $property = null)
    {
        static $settings;

        if (empty($settings)) {
//            $settings = Cache::rememeber('settings', 30, function () {
//                return Setting::all()->pluck('value', 'key')->toArray();
//            });
            $settings = Setting::all()->toArray();
            $settings = array_column($settings, 'value', 'key');
//            $settings = array_map(fn ($val) => $val['key'] => $val['value'], $settings);
        }

        dd($settings);

        return $property ? $settings[$key]->$property ?? null : $settings[$key] ?? null;
    }
}
