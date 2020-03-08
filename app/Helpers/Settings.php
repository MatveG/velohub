<?php

if (!function_exists('settings')) {
    function settings($group, $name)
    {
        static $settings;

        if(empty($settings)) {
            foreach (DB::table('settings')->get() as $row) {
                $settings[$row->section][$row->name] =
                    ($row->value[0] === '{') ? json_decode($row->value) : $row->value;
            }
        }

        return $settings[$group][$name] ?? null;
    }
}
