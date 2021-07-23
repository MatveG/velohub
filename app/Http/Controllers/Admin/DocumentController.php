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
        $documents = Document::get([
            'id',
            'is_active',
            'slug',
            'title'
        ]);

        return response()->json($documents);
    }

    public function get($id): JsonResponse
    {
        $document = Document::findOrFail($id);

        return response()->json($document);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|min:2|max:255',
            'slug' => 'required|min:2|max:50'
        ]);

        $document = Document::create($request->all());

        return response()->json($document);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|min:2|max:255',
            'slug' => 'required|min:2|max:50'
        ]);

        $document = Document::findOrFail($id);
        $document->update($request->all());
        $changed = array_keys($document->getChanges());

        return response()->json($document->only($changed));
    }

    public function delete(int $id): JsonResponse
    {
        Document::findOrFail($id)->delete();

        return response()->json(compact('id'));
    }
}
