<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CompareController extends Controller
{
    public function __invoke(string $slug, int $id)
    {
        $category = Category::where('id', $id)->where('is_active', true)->firstOrFail();

        $idArr = !empty($_COOKIE['compare']) ? json_decode(urldecode($_COOKIE['compare'])) : [];

        $products = $category->products()
            ->whereIn('id', $idArr)
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('is_active', true)
            ->select('variants.*', 'products.*')
            ->take(10);

        $seo = (object)[
            'title' => '',
            'description' => '',
            'keywords' => '',
        ];

        return view('compare', compact(['category', 'products', 'seo']));
    }
}
