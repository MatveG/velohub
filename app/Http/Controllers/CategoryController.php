<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\MetaService;
use App\Services\FiltersService;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['parse.path', 'parse.sort']);
    }

    public function __invoke(Request $request, string $slug, int $id, string $path = '')
    {
        $route = route('category', compact(['slug', 'id']));

        $category = Category::where('id', $id)->where('is_active', true)->firstOrFail();

        $meta = MetaService::title($category->meta_title ?? $category->title)
            ->description($category->meta_description)
            ->keywords($category->meta_keywords);

        $query = $category->products()
            ->leftJoin('variants', 'products.id', '=', 'variants.product_id')
            ->where('products.is_active', true);

        $filters = FiltersService::init($query, $request->filter)
            ->addSliderFilter('products.price', 'price', 'Price')
            ->addPlainFilter('products.brand', 'brand', 'Brand')
            ->addFiltersSet($category->features, 'products.features')
            ->addFiltersSet($category->parameters, 'variants.parameters')
            ->applyFilters()
            ->getFilters();

        $products = $query->select('variants.*', 'products.*')
            ->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->paginate(40);

        return view('category', compact(['route', 'category', 'filters', 'products', 'meta']));
    }
}
