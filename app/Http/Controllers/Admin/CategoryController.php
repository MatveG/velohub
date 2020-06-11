<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\ModelImages;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::getTree());
    }

    public function edit($id)
    {
        return response()->json(Category::find($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parent_id' => 'required|integer',
            'title' => 'required|min:3|max:255',
            'title_short' => 'required|min:3|max:255',
        ]);

        $category = Category::create($request->all());
        $category->title = $request->title;
        $category->sorting = $this->calculateSorting($category->parent_id);
        $category->save();

        return response()->json(['id' => $category->id] + $category->getChanges());
    }

    public function update(Request $request, $id = 0)
    {
        $this->validate($request, [
            'parent_id' => 'required|integer',
            'title' => 'required|min:3|max:255',
            'title_short' => 'required|min:3|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->fill($request->all());
        $category->title = $request->title;

        if ($category->isDirty('parent_id')) {
            $this->decreaseSorting($category->parent_id, $category->sorting);
            $category->sorting = $this->calculateSorting($category->parent_id);
        }
        $category->save();

        return response()->json(['id' => $category->id] + $category->getChanges());
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        $this->decreaseSorting($category->parent_id, $category->sorting);

        return response()->json();
    }

    private function calculateSorting($parentId) {
        return Category::where('parent_id', $parentId)->max('sorting') + 1;
    }

    private function decreaseSorting($parentId, $initialValue) {
        return Category::where('parent_id', $parentId)->where('sorting', '>', $initialValue)->decrement('sorting');
    }

    public function imagesUpload(Request $request, $id)
    {
        // check if already exists
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $category = Category::findOrFail($id);
        $newImage = ModelImages::upload($category, $request->file('image'));

        if ($newImage) {
            $category->images = array_merge($category->images, [$newImage]);
            $category->save();
        }

        return response()->json($newImage);
    }

    public function imagesUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->images = $request->images;

        foreach (array_diff($category->images, $category->getDirty('images')) as $image) {
            ModelImages::delete($image);
        }
        $category->save();

        return response()->json();
    }

}
