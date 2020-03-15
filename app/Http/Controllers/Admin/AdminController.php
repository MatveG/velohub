<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
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

    public function store(Request $request, Product $product, $id)
    {
//        $product = $product->findOrFail($id);
//        $product->update( $request->only($product->getFillable()) );

        return response()->json();
    }

    public function edit(Request $request, Product $product, $id)
    {
        $product = $product->with('category')->find($id)->toArray();

        return response()->json(['item' => $product]);
    }

    public function update(Request $request, Product $product, $id)
    {
        $product = $product->findOrFail($id);
        $product->update( $request->only($product->getFillable()) );

        return response()->json();
    }

    public function destroy(Request $request)
    {
        $this->checkAjaxRequiredFields(['ids']);

        Product::destroy($request->ids);

        return response()->json();
    }

//    public function get(Request $request)
//    {
//        $query = Product::with('category');
//        $this->applyFilters($query, $request, ['model', 'brand']);
//
//        $products = $query
//            ->orderBy(!empty($request->sort) ? $request->sort : 'id', !empty($request->order) ? $request->order : 'desc')
//            ->paginate(!empty($request->limit) ? $request->limit : 25);
//
//        return view('admin.products.rows', compact(['products']));
//    }

//    public function suggest(Request $request)
//    {
//        if (strlen($request->value) < 2) {
//            return;
//        }
//
//        $result = Product::where($request->column, 'ilike', '%'.$request->value.'%')
//            ->groupBy(empty($request->pluck) ? $request->column : $request->pluck)
//            ->pluck(empty($request->pluck) ? $request->column : $request->pluck);
//
//        return response()->json($result);
//    }

//    public function validateId(Request $request)
//    {
//        if (!$request->has('ids')) {
//            return response()->json(['ok' => 0]);
//        }
//    }

//    public function applyFilters($query, $request, $searchKeys = [])
//    {
//        $attributes = Product::first()->getAttributes();
//
//        foreach ($request->query as $key => $value) {
//            $value = ($value === 'on') ? true : trim($value);
//
//            if (empty($value) || !array_key_exists($key, $attributes)) {
//                continue;
//            }
//
//            if ($value === 'null') {
//                $query->whereNull($key);
//            } elseif (in_array($key, $searchKeys)) {
//                $query->where($key, 'ilike', '%'.$value.'%');
//            } else {
//                $query->where($key, $value);
//            }
//        }
//    }


    public function tree()
    {
        $categories = $this->getMenuTree(0);

        return response()->json(['categories' => $categories]);
    }

    public function getMenuTree($parentId = 0)
    {
        return Category::where('parent_id', $parentId)
            ->orderBy('sorting')
            ->get(['id', 'is_active', 'is_parent', 'name'])
            ->map(function ($item) {
                $item->child = $this->getMenuTree($item->id);
                return $item;
            });
    }
}
