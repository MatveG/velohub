<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Document::orderBy('ord')->get([
            'id',
            'is_active',
            'slug',
            'title'
        ]);

        return response()->json($categories);
    }

    public function get($id): JsonResponse
    {
        $category = Document::findOrFail($id)->append(['imagesPath']);

        return response()->json($category);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'title_short' => 'required|min:2|max:255',
        ]);

        $category = Document::create($request->all());

        return response()->json($category);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'title_short' => 'required|min:2|max:255',
        ]);

        $category = Document::findOrFail($id);
        $category->update($request->all());
        $changed = array_keys($category->getChanges());

        return response()->json($category->only($changed));
    }

    public function delete(int $id): JsonResponse
    {
        Document::findOrFail($id)->delete();

        return response()->json(compact('id'));
    }
}
