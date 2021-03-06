<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductFiltersService;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id, string $path = '')
    {
        $category = new Category();
        $mainQuery = $category->products()->active();
        $variantsQuery = $category->variants()->active();
        $filters = (new ProductFiltersService())
            ->parsePath($path)
            ->usePrice($mainQuery)
            ->useBrand($mainQuery)
            ->useJson($category, 'features', $mainQuery)
            ->useJson($category, 'options', $variantsQuery)
            ->get();

        dd($filters);

        $filters = ProductFiltersService::init($path, $query, [
            'price' => true,
            'brand' => true,

        ]);

        $category = Category::find($id)->active()->firstOrFail();

        $filters = new \StdClass(); //
        $filters->active = false;   //

        $products = Product::join('variants', 'products.id', '=', 'variants.product_id')
            ->select('variants.*', 'products.*')
            ->where('products.category_id', $id)
            ->isActive()
            ->orderBy('products.' . $request->sortCol, $request->sortOrd)
            ->simplePaginate();

        $meta = (object)[
            'title' => $category->name,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('category', compact(['category', 'products', 'filters', 'meta']));
    }

}
