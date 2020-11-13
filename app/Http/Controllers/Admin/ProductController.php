<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ShopImages;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::get()->makeHidden(['created_at', 'updated_at', 'search']);

        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|integer',
            'model' => 'required|min:2|max:255|string',
            'code' => 'max:255|nullable|unique:variants'
        ]);

        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required|integer',
            'model' => 'required|min:2|max:255|string',
            'code' => 'max:255|nullable|unique:products,code,' . $id
        ]);

        $product = tap(Product::findOrFail($id))->update($request->all());
        $changes = array_keys($product->getChanges());

        return response()->json($product->only($changes));
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json();
    }

    public function uploadImages(Request $request, $id)
    {
        request()->validate([
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::find($id);
        $uploadedImages = ShopImages::uploadImages(
            $request->images,
            $product->imagesFolder,
            $product->imagesName
        );

        return response()->json($uploadedImages);
    }

}
