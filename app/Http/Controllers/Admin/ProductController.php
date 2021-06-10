<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ShopImagesUploader;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->with([
                'category' => fn ($query) => $query->select(['id', 'title'])
            ])
            ->get([
                'id',
                'is_active',
                'is_stock',
                'slug',
                'code',
                'title',
                'brand',
                'model',
                'price',
                'category_id',
                'images'
            ]);

        return response()->json($products);
    }

    public function get($id): JsonResponse
    {
        $product = Product::with('category.features', 'variants')->find($id);

        return response()->json($product);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|integer',
            'model' => 'required|min:2|max:255|string',
            'code' => 'max:255|nullable|unique:variants'
        ]);

        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'category_id' => 'integer',
            'model' => 'min:2|max:255|string',
            'code' => 'max:255|nullable|unique:products,code,' . $id,
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json($product->getChanges());
    }

    public function delete(int $id): JsonResponse
    {
        Product::findOrFail($id)->delete();

        return response()->json();
    }

    public function uploadImages(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::find($id);

        $newImages = ShopImagesUploader::uploadImages($request->images, $product->imagesFolder, $product->imagesName);
        $product->images = [
            ...array_diff($product->images, $newImages),
            ...$newImages
        ];
        $product->save();

        return response()->json($product->images);
    }

    public function updateImages(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'images' => 'array',
            'images.*' => 'string',
        ]);

        $product = Product::findOrFail($id);
        $product->images = $request->images;
        $product->save();
        File::delete(array_diff($product->getOriginal('images'), $product->images));

        return response()->json($product->images);
    }
}
