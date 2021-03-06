<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request, string $path = ''): View
    {
        $this->validate($request, ['find' => 'required']);

//        $filters = $this
//            ->filters
//            ->parsePath($path)
//            ->usePrice($query)
//            ->useBrand($query)
//            ->get();

        $filters = new \StdClass();
        $filters->active = false;

        $find = $request->find;
        $find = preg_replace('/[^+A-Za-z0-9- ]/', '', $find);
        $find = str_replace(' ', '|', trim($find));

        $products = Product::isActive()
//            ->filter($filters)
            ->whereRaw("search @@ to_tsquery('" . $find . "')")
            ->orderBy('products.' . $request->sortCol, $request->sortOrd)
            ->orderByRaw("ts_rank(search, to_tsquery('" . $find . "')) DESC")
            ->paginate();

        $meta = (object)[
            'title' => 'Поиск: ' . $request->find,
            'description' => 'Поиск по каталогу товаров:' . $request->find,
            'keywords' => str_replace(' ', ',', $request->find),
        ];

        return view('category', compact(['products', 'filters', 'meta']));
    }
}
