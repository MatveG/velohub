<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\ImageUploadHandler;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
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

        return response()->json($category);
    }

    public function update(Request $request, $id = 0)
    {
        $this->validate($request, [
            'parent_id' => 'required|integer',
            'title' => 'required|min:3|max:255',
            'title_short' => 'required|min:3|max:255',
        ]);

        $category = tap(Category::find($id))->update($request->all());

        return response()->json($category->getChanges());
    }

    public function destroy($id)
    {
        Category::find($id)->destroy($id);

        return response()->json();
    }

    public function uploadImages(Request $request, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $category = Category::find($id);
        $image = ImageUploadHandler::upload($category, $request->file('image'));
        $category->update(array_merge($category->images, [$image]));

        return response()->json($image);
    }

    public function updateImages(Request $request, $id)
    {
        $category = Category::find($id);

        if(ImageUploadHandler::delete(array_diff($request->images, $category->images))) {
            $category->update($request->images);
        }

        return response()->json();
    }

}
