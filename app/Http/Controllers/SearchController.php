<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\MetaService;
use App\Services\FiltersService;

class SearchController extends Controller
{
    public function __construct() {
        $this->middleware(['escape.search', 'parse.path', 'parse.sort']);
    }

    public function __invoke(Request $request, string $path = '')
    {
        $request->validate(['find' => 'required']);

        $query = Product::where('is_active', true)->searchBy($request->searchWords);

        $meta = MetaService::title('Поиск: ' . $request->find)
            ->description('Поиск по каталогу товаров:' . $request->find)
            ->keywords(str_replace(' ', ',', $request->find));


        $filters = FiltersService::init($query, $request->filter)
            ->addSliderFilter('products.price', 'price', 'Price')
            ->addPlainFilter('products.brand', 'brand', 'Brand')
            ->applyFilters()
            ->getFilters();

        $products = $query->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->orderByRelevance($request->searchWords)
            ->paginate();

        $route = route('search') . '?' . request()->getQueryString();

        return view('category', compact(['products', 'meta', 'filters', 'route']));
    }
}
