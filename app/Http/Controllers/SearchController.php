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

        $keywords = $this->escapeSearchString($request->find);

        $query = Product::where('is_active', true)->searchBy($keywords);

        $filters = FiltersService::init($query, $request->filter)
            ->addSliderFilter('products.price', 'price', 'Price')
            ->addPlainFilter('products.brand', 'brand', 'Brand')
            ->applyFilters()
            ->getFilters();

        $products = $query->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->orderByRelevance($keywords)
            ->paginate();

        $route = route('search') . '?' . request()->getQueryString();

        $meta = (object)[
            'title' => 'Поиск: ' . $request->find,
            'description' => 'Поиск по каталогу товаров:' . $request->find,
            'keywords' => str_replace(' ', ',', $request->find),
        ];

        return view('category', compact(['products', 'filters', 'route', 'meta']));
    }

    private function escapeSearchString(string $string): string
    {
        return str_replace(' ', '  |', trim(preg_replace('/[^+A-Za-z0-9- ]/', '', $string)));
    }
}
