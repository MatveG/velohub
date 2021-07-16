<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index(int $categoryId): JsonResponse
    {
        $parameters = Parameter::where('category_id', $categoryId)->get();

        return response()->json($parameters);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'type' => 'required|min:2|max:255',
        ]);

        $parameter = Parameter::create($request->all());
        $parameter = $parameter->fresh();

        return response()->json($parameter);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'type' => 'required|min:2|max:255',
        ]);

        $parameter = Parameter::findOrFail($id);
        $parameter->update($request->all());
        $parameter = $parameter->fresh()->first(array_keys($parameter->getChanges()));

        return response()->json($parameter);
    }

    public function delete(int $id): JsonResponse
    {
        Parameter::findOrFail($id)->delete();

        return response()->json($id);
    }
}
