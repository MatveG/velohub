<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id, string $path = '')
    {
        //        $mainQuery = $category->products()->active();
//        $variantsQuery = $category->variants()->active();
//        $filters = $this
//            ->filters
//            ->parsePath($path)
//            ->usePrice($mainQuery)
//            ->useBrand($mainQuery)
//            ->useJson($category, 'features', $mainQuery)
//            ->useJson($category, 'options', $variantsQuery)
//            ->get();
        $category = Category::find($id)->active()->firstOrFail();

        $filters = new \StdClass(); //
        $filters->active = false;   //

        $products = Product::join('variants', 'products.id', '=', 'variants.product_id')
            ->select('variants.*', 'products.*')
            ->where('products.category_id', $id)
            ->where('products.is_active', true)
            ->orderBy('products.' . $request->sortCol, $request->sortOrd)
            ->paginate();

        $seo = (object)[
            'title' => $category->name,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('shop', compact(['category', 'products', 'filters', 'seo']));
    }

}
