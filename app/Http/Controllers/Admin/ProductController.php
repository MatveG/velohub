<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ImageUploadHandler;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with('category:id,title')->get([
            'category_id',
            'title',
            'id',
            'code',
            'brand',
            'model',
            'is_active',
        ]);

        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'variants'])->find($id);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|integer',
            'code' => 'max:255|nullable|unique:variants'
        ]);

        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'max:255|nullable|unique:products,code,' . $id
        ]);

        $product = tap(Product::findOrFail($id))->update($request->all());
        $changes = array_keys($product->getChanges());

        if ($product->wasChanged('category_id')) {
            $product->load('category');
            $changes[] = 'category';
        }

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
        $uploadedImages = ImageUploadHandler::uploadArray($request->images, (object)[
            'folder' => $product->getImagesFolder(),
            'uid' => $product->id,
            'filename' => $product->latin
        ]);

        return response()->json($uploadedImages);
    }

}
