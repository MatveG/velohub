<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [];

        foreach (DB::table('settings')->get() as $row) {
            $settings[$row->group][$row->key] =
                ($row->value[0] === '{') ? json_decode($row->value) : $row->value;
        }

        return response()->json($settings);
    }
}
