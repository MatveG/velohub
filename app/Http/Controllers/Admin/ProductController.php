<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

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
                'category_id',
                'code',
                'title',
                'brand',
                'model',
                'price',
                'images'
            ])
            ->append([
                'thumb'
            ]);

        return response()->json($products);
    }

    public function get($id): JsonResponse
    {
        $product = Product::with('category.features')
            ->findOrFail($id)
            ->append([
                'imagesStorage'
            ]);

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

        $product = $product->fresh()
            ->with($product->wasChanged('category_id') ? ['category.features'] : [])
            ->first(array_keys($product->getChanges()));

        return response()->json($product);
    }

    public function delete(int $id): JsonResponse
    {
        Product::findOrFail($id)->delete();

        return response()->json($id);
    }
}
