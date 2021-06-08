<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ModelImages;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::with('category')->get();

        return response()->json(
            $products->map(fn($el) => $el->only([
                'id',
                'is_active',
                'is_stock',
                'code',
                'title',
                'brand',
                'model',
                'category',
                'thumb'
            ]))
        );
    }

    public function get($id): JsonResponse
    {
        $product = Product::with('category.features', 'variants')->find($id);

        return response()->json($product->only([
            'id',
            'category_id',
            'is_active',
            'is_stock',
            'is_sale',
            'warranty',
            'price',
            'price_old',
            'weight',
            'code',
            'barcode',
            'slug',
            'title',
            'brand',
            'model',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'sale_text',
            'summary',
            'description',
            'images',
            'stocks',
            'features',
            'category',
            'variants'
        ]));
    }

    public function post(Request $request): JsonResponse
    {
        $this->validate($request, [
            'category_id' => 'required|integer',
            'model' => 'required|min:2|max:255|string',
            'code' => 'max:255|nullable|unique:variants'
        ]);

        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'category_id' => 'integer',
            'model' => 'min:2|max:255|string',
            'code' => 'max:255|nullable|unique:products,code,' . $id
        ]);

        $product = tap(Product::findOrFail($id))->update($request->all());
        $changes = array_keys($product->getChanges());

        return response()->json($product->only($changes));
    }

    public function delete(int $id): JsonResponse
    {
        Product::findOrFail($id)->delete();

        return response()->json();
    }

    public function uploadImages(Request $request, int $id): JsonResponse
    {
        request()->validate([
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::find($id);
        $newImages = ModelImages::uploadImages(
            $request->images,
            $product->imagesFolder,
            $product->imagesName
        );

        return response()->json($newImages);
    }

}
