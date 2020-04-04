<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductContoller extends Controller
{
    public function index()
    {
        $products = Product::with('category')->with('skus')->orderBy('id', 'desc')->paginate();
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'codes' => implode(PHP_EOL, $product->sku->codes),
                'brand' => $product->brand,
                'model' => $product->model,
                'category_name' => $product->category->name,
                'price' => number_format($product->price),
                'is_active' => $product->is_active,
                'is_stock' => $product->is_stock,
                'is_sale' => $product->is_sale,
                'thumb' => $product->thumb,
                'link' => $product->link,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json(['data' => $products]);
    }

//    public function store(Request $request, Product $product, $id)
//    {
//        $product = $product->findOrFail($id);
//        $product->update( $request->only($product->getFillable()) );
//
//        return response()->json();
//    }

    public function edit(Request $request, Product $product, $id)
    {
        $product = $product->with('category')->find($id)->toArray();

        return response()->json(['item' => $product]);
    }

    public function update(Request $request, Product $product, $id)
    {
        $product = $product->findOrFail($id);
        $category_id = $product->category_id;
        $product->update( $request->only($product->getFillable()) );

        if($product->category_id !== $category_id) {
            return response()->json(['category' => $product->category]);
        }

        return response()->json();
    }

//    public function destroy(Request $request)
//    {
//        $this->checkAjaxRequiredFields(['ids']);
//
//        Product::destroy($request->ids);
//
//        return response()->json();
//    }
}
