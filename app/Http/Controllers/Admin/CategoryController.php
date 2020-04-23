<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([$this->getCategoriesTree(0)]);
    }

    public function list(Request $request)
    {
        return response()->json(
            Category::where(($request->where) ?: [])
                ->orderBy('sorting')
                ->get(['id', 'parent_id', 'title'])
                ->toArray()
        );
    }

    public function edit(Request $request, $id)
    {
        return response()->json(Category::find($id)->toArray());
    }

    public function save(Request $request, $id = 0)
    {
        $category = Category::firstOrCreate(['id' => $id]);
        $category->fill($request->all());
        $category->latin = latinize($category->title);

        if (Category::where('id', '!=', $id)->where('title', $request->title)->exists()) {
            $category->latin .= '-' . $category->id;
        }
        if ($category->sorting === 0 || $category->isDirty('parent_id')) {
            $category->sorting = Category::where('parent_id', $request['parent_id'])->max('sorting') + 1;
        }

        $category->features = array_map($this->mapLatinProperty, $request->features);
        $category->parameters = array_map($this->mapLatinProperty, $request->parameters);
        $category->save();

        return response()->json( $category->only( ['id'] + array_keys($category->getChanges()) ) );
    }

    public function destroy(Request $request, $id)
    {
        Category::firstOrFail($id)->destroy();
    }

    private function getCategoriesTree($parentId = 0)
    {
        return Category::where('parent_id', $parentId)
            ->orderBy('sorting')
            ->get()
            ->map(function ($item) {
                $item->child = $this->getCategoriesTree($item->id);
                return $item;
            });
    }

    private function mapLatinProperty($element)
    {
        return array_replace($element, [
            'latin' => ($element['is_filter']) ? latinize($element['title']) : null
        ]);
    }
}
