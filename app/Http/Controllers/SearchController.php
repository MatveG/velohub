<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request, string $path = '')
    {
        $this->validate($request, ['find' => 'required']);

        $query = $this
            ->repo
            ->search($request->find)
            ->active()
            ->builder();

        $filters = $this
            ->filters
            ->parsePath($path)
            ->usePrice($query)
            ->useBrand($query)
            ->get();

        $products = $this
            ->repo
            //->join('variants')
            //->select('variants.*', 'products.*')
            ->where('products.is_active')
            ->search($request->find)
            ->filter($filters)
            ->orderShop($request)
            ->orderByRelevance()
            ->paginate();

        $seo = (object)[
            'title' => 'Поиск: ' . $request->find,
            'description' => 'Поиск по каталогу товаров:' . $request->find,
            'keywords' => str_replace(' ', ',', $request->find),
        ];

        return view('shop', compact(['products', 'filters', 'seo']));
    }
}
