<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class AdminController extends Controller
{
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
