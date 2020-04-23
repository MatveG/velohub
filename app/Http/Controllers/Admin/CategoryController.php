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

    public function list(Request $request)
    {
        return response()->json(Category::where($request->input('where', []))
                ->orderBy('sorting')
                ->get(['id', 'parent_id', 'title'])
                ->toArray()
        );
    }

    public function edit(Request $request, $id)
    {
        return response()->json(Category::find($id)->toArray());
    }

    public function store(Request $request, $id = 0)
    {
        $category = Category::create($request->all());
        $category->sorting = Category::where('parent_id', $request->input('parent_id'))->max('sorting') + 1;
        $category->save();

        return response()->json( $category->only( ['id'] + array_keys($category->getChanges()) ) );
    }

    public function update(Request $request, $id = 0)
    {
        $category = Category::findOrFail($id);
        $category->fill($request->all());

        if ($category->isDirty('parent_id')) {
            $category->sorting = Category::where('parent_id', $request['parent_id'])->max('sorting') + 1;
        }
        $category->save();

        return response()->json( $category->only( ['id'] + array_keys($category->getChanges()) ) );
    }

    public function destroy(Request $request, $id)
    {
        Category::destroy($id);

        // resort

        return response()->json();
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
