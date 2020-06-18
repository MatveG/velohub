<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ModelImages;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $response = Product::with('category:id,title')->get([
            'category_id',
            'title',
            'id',
            'code',
            'brand',
            'model',
            'is_active',
        ]);

        return response()->json($response);
    }

    public function edit($id)
    {
        return response()->json(Product::with('category')->find($id));
    }

    public function store(Request $request)
    {
        //$this->validate($request, []);

        $product = Product::create($request->all());

        return response()->json($product->getChanges());
    }

    public function update(Request $request, $id)
    {
        //$this->validate($request, []);

        $product = tap(Product::findOrFail($id))->update($request->all());

        return response()->json($product->getChanges());
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->destroy();

        return response()->json();
    }

    public function uploadImages(Request $request, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::find($id);
        $image = ModelImages::upload($product, $request->file('image'));
        $product->update(array_merge($product->images, [$image]));

        return response()->json($image);
    }

    public function updateImages(Request $request, $id)
    {
        $product = Product::find($id);

        if(ModelImages::delete(array_diff($request->images, $product->images))) {
            $product->update($request->images);
        }

        return response()->json();
    }

}
