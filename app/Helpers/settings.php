<?php

if (!function_exists('settings')) {
    function settings($group = null, $key = null)
    {
        static $settings;

        if(empty($settings)) {
            foreach (DB::table('settings')->get() as $row) {
                $settings[$row->group][$row->key] =
                    ($row->value[0] === '{') ? json_decode($row->value) : $row->value;
            }
        }

        if(empty($group)) {
            return $settings;
        }

        return empty($key) ? $settings[$group] : $settings[$group][$key];
//        return $settings[$group][$key] ?? null;
    }
}
