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
            ->addSliderFilter('products.price', 'price', 'Price')
            ->addPlainFilter('products.brand', 'brand', 'Brand')
            ->addFiltersSet($category->features, 'products.features')
            ->addFiltersSet($category->features, 'variants.parameters')
            ->applyFilters()
            ->getFilters();

        $products = $query->select('variants.*', 'products.*')
            ->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->paginate();

        $meta = (object)[
            'title' => $category->title,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('category', compact(['category', 'filters', 'products', 'meta']));
    }
}
