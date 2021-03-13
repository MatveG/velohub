<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Product;
use App\Services\Filters\Filter;
use App\Services\Filters\SliderFilter;

class SearchController extends Controller
{
    public function __invoke(Request $request, string $path = '')
    {
        $this->validate($request, ['find' => 'required']);

        $query = Product::isActive()->searchBy($request->find);

        $filters = $this->initFilters($query, $request);

        $products = $query->orderBy('products.' . $request->orderBy, $request->orderWay)
            ->orderByRelevance($request->find)
            ->paginate();

        $meta = (object)[
            'title' => 'Поиск: ' . $request->find,
            'description' => 'Поиск по каталогу товаров:' . $request->find,
            'keywords' => str_replace(' ', ',', $request->find),
        ];

        return view('category', compact(['products', 'filters', 'meta']));
    }

    private function initFilters(object $query, object $request): Collection
    {
        return collect([
            'price' => SliderFilter::init('products.price', 'price', 'Price')
                ->fetchValues($query)
                ->fetchParams($request->filter),
            'brand' => Filter::init('products.brand', 'brand', 'Brand')
                ->fetchValues($query)
                ->fetchParams($request->filter),
        ])->each(function ($element) use ($query) {
            $element->applyFilter($query);
        });
    }
}
