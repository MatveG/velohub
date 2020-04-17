<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);

//        if (isset($product->features)) {
//            $features = (array)$product->features;
//
//            foreach ($features as $key => $feature) {
//                if(empty($product->category->features->{$key})) {
//                    unset($features->{$key});
//                }
//            }
//        }
//        $product->features = $features;
//        $product->save();

        return response()->json([
            'item' => $category->toArray(),
//            'variantsCount' => $product->variants->count(),
//            'currency' => settings('shop', 'currency'),
        ]);
    }

    public function update(Request $request, $id)
    {
        // if parent_id changed -> change sorting
        $category = Category::findOrFail($id);
        $category->fill($request->all());
        //$category->latin = $this->stringToLatin($product->fullName);
        $category->save();

        //return response()->json($category, 400);

//        $return = null;
//
//        if(isset($product->getChanges()['category_id'])) {
//            $return['category'] = $product->category;
//        }
//
//        if(isset($product->getChanges()['latin'])) {
//            $return['latin'] = $product->latin;
//        }

        return response()->json();
    }

    public function list(Request $request)
    {
        return response()->json([
            'items' => Category::where(($request->where) ?: [])->orderBy('sorting')->get(['id', 'parent_id', 'title'])
        ]);
    }

    public function index()
    {
        return response()->json(['items' => $this->getMenuTree()]);
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
}
