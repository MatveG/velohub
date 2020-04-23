<?php

if (!function_exists('settings')) {
    function settings($group, $key)
    {
        static $settings;

        if(empty($settings)) {
            foreach (DB::table('settings')->get() as $row) {
                $settings[$row->group][$row->key] =
                    ($row->value[0] === '{') ? json_decode($row->value) : $row->value;
            }
        }

        return $settings[$group][$key] ?? null;
    }
}
