<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::where('is_readonly', false)->orderBy('id')->get();

        return response()->json($settings);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'value' => 'required|min:1',
        ]);

        $setting = Setting::findOrFail($id);
        $setting->update($request->all());
        $changed = array_keys($setting->getChanges());

        return response()->json($setting->only($changed));
    }
}
