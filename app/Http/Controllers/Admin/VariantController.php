<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Services\Admin\ShopImages;

class VariantController extends Controller
{
    public function index($product_id)
    {
        $variant = Variant::where('product_id', $product_id)->get();

        return response()->json($variant);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:variants|max:255'
        ]);

        $variant = Variant::create($request->all());

        return response()->json($variant);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|max:255|unique:variants,code,' . $id
        ]);

        $variant = tap(Variant::findOrFail($id))->update($request->all());

        return response()->json($variant);
    }

    public function destroy($id)
    {
        Variant::findOrFail($id)->delete();

        return response()->json();
    }

    public function uploadImages(Request $request, $id)
    {
        request()->validate([
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $variant = Variant::with('Product')->find($id);
        $uploadedImages = ShopImages::uploadImages(
            $request->images,
            $variant->imagesFolder,
            $variant->imagesName
        );

        return response()->json($uploadedImages);
    }

}
