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
        $settings = Setting::orderBy('id')->get();

        return response()->json($settings);
    }

    public function get($id): JsonResponse
    {
        $setting = Setting::findOrFail($id);

        return response()->json($setting);
    }

    public function post(Request $request): JsonResponse
    {
//        $request->validate([
//            'name' => 'required|min:2|max:50',
//        ]);

        $setting = Setting::create($request->all());

        return response()->json($setting);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
//        $request->validate([
//            'name' => 'required|min:2|max:50',
//        ]);

//        $request->merge([
//            'value' => (object)$request->value,
//        ]);

        $setting = Setting::findOrFail($id);
        $setting->update($request->all());
        $changed = array_keys($setting->getChanges());

        return response()->json($setting->only($changed));
    }

    public function delete(int $id): JsonResponse
    {
        Setting::findOrFail($id)->delete();

        return response()->json(compact('id'));
    }
}
