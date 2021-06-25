<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\ShopImages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('parent_id', 0)->with('children')->get();

        return response()->json($categories);
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

        return response()->json($category->only($category->getChanges()));
    }

    public function destroy($id)
    {
        Category::find($id)->destroy($id);

        return response()->json();
    }

    public function uploadImages(Request $request, $id)
    {
        request()->validate([
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $category = Category::find($id);
        $uploadedImages = ShopImages::uploadImages(
            $request->images,
            $category->imagesFolder,
            $category->imagesName
        );

        return response()->json($uploadedImages);
    }

}
