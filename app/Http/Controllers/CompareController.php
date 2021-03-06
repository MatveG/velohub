<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function __invoke(string $latin)
    {
        $category = $this->category->where('latin', $latin)->firstOrFail();

        $idArr = !empty($_COOKIE['compare']) ? json_decode(urldecode($_COOKIE['compare'])) : [];

        $products = $this
            ->repo
            ->relatedMany($category)
            ->whereIn('id', $idArr)
            ->join('variants')
            ->select('variants.*', 'products.*')
            ->where('products.is_active')
            ->get();

        $seo = (object)[
            'title' => '',
            'description' => '',
            'keywords' => '',
        ];

        return view('compare', compact(['category', 'products', 'seo']));
    }
}
