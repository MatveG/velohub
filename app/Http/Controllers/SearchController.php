<?php

namespace App\Http\Controllers;

use App\Services\FiltersService;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function __invoke(Request $request, string $path = '')
    {
        $this->validate($request, ['find' => 'required']);

        $query = Product::isActive()->searchBy($request->find);

        $filters = FiltersService::init($query, $request->filter)
            ->addSliderFilter('products.price', 'price', 'Price')
            ->addPlainFilter('products.brand', 'brand', 'Brand')
            ->getFilters();

        $products = $query->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->orderByRelevance($request->find)
            ->simplePaginate();

        $meta = (object)[
            'title' => 'Поиск: ' . $request->find,
            'description' => 'Поиск по каталогу товаров:' . $request->find,
            'keywords' => str_replace(' ', ',', $request->find),
        ];

        return view('category', compact(['products', 'filters', 'meta']));
    }
}
