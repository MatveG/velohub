<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\FiltersService;

class CategoryController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id, string $path = '')
    {
        $category = Category::whereId($id)->isActive()->firstOrFail();

        $query = $category->products()
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->isActive();

        $filters = FiltersService::init($query, $request->filter)
            ->withFilter(FiltersService::SLIDER, 'products.price', 'price', 'Price')
            ->withFilter(FiltersService::PLAIN, 'products.brand', 'brand', 'Brand')
            ->withFiltersArray($category->features, 'products.features')
            ->withFiltersArray($category->features, 'variants.parameters');

        dd($filters);

        $products = $query->select('variants.*', 'products.*')
            ->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->simplePaginate();

        $meta = (object)[
            'title' => $category->title,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('category', compact(['category', 'filters', 'products', 'meta']));
    }
}
