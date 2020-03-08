<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->paginate();
        $categories = $this->getMenuTree(0);

        return view('admin.products', compact(['products', 'categories']));
    }

    public function get(Request $request)
    {
        $query = Product::with('category');
        $this->applyFilters($query, $request, ['model', 'brand']);

        $products = $query
            ->orderBy(!empty($request->sort) ? $request->sort : 'id', !empty($request->order) ? $request->order : 'desc')
            ->paginate(!empty($request->limit) ? $request->limit : 25);

        return view('admin.products.rows', compact(['products']));
    }

    public function suggest(Request $request)
    {
        if (strlen($request->value) < 2) {
            return;
        }

        $result = Product::where($request->column, 'ilike', '%'.$request->value.'%')
            ->groupBy(empty($request->pluck) ? $request->column : $request->pluck)
            ->pluck(empty($request->pluck) ? $request->column : $request->pluck);

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        if (!$request->has('ids')) {
            return response()->json(['ok' => 0]);
        }

        Product::destroy(json_decode($request->ids));

        return response()->json(['ok' => 1]);
    }

    public function edit(Request $request)
    {
        $this->validate($request, ['id' => 'required']);

        $product = Product::find($request->id);
        $categories = $this->getMenuTree(0);

        $product->skus = $product->skus->sortByDesc('is_default')->sortByDesc('is_active');

        return view('admin.products.edit', compact(['product', 'categories']));
    }

    public function validateId(Request $request)
    {
        if (!$request->has('ids')) {
            return response()->json(['ok' => 0]);
        }
    }


    public function getMenuTree($parentId = 0)
    {
        return Category::where('parent_id', $parentId)
            ->orderBy('sorting')
            ->get()
            ->map(function ($item) {
                $item->child = $this->getMenuTree($item->id);
                return $item;
            });
    }

    public function applyFilters($query, $request, $searchKeys = [])
    {
        $attributes = Product::first()->getAttributes();

        foreach ($request->query as $key => $value) {
            $value = ($value === 'on') ? true : trim($value);

            if (empty($value) || !array_key_exists($key, $attributes)) {
                continue;
            }

            if ($value === 'null') {
                $query->whereNull($key);
            } elseif (in_array($key, $searchKeys)) {
                $query->where($key, 'ilike', '%'.$value.'%');
            } else {
                $query->where($key, $value);
            }
        }
    }
}
