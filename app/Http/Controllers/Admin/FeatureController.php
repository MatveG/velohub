<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FeatureController extends Controller
{
    public function index(int $categoryId): JsonResponse
    {
        $features = Feature::where('category_id', $categoryId)
//            ->where('parent_id', 0)
//            ->with('children')
            ->orderBy('ord')
            ->get();

        return response()->json($features);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'type' => 'required|min:2|max:255',
        ]);

        $feature = Feature::create($request->all());
        $feature = $feature->fresh();

        return response()->json($feature);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'type' => 'required|min:2|max:255',
        ]);

        $feature = Feature::findOrFail($id);
        $feature->update($request->all());

        return response()->json($feature);
    }

    public function delete(int $id): JsonResponse
    {
        Feature::findOrFail($id)->delete();

        return response()->json($id);
    }
}
