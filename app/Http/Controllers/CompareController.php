<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\MetaService;

class CompareController extends Controller
{
    public function __invoke(string $slug, int $id)
    {
        $category = Category::where('id', $id)->where('is_active', true)->firstOrFail();

        $meta = MetaService::title($category->meta_title ?? $category->title)
            ->description($category->meta_description)
            ->keywords($category->meta_keywords);

        $idArr = !empty($_COOKIE['compare']) ? json_decode(urldecode($_COOKIE['compare'])) : [];

        $products = $category->products()
            ->whereIn('id', $idArr)
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('is_active', true)
            ->select('variants.*', 'products.*')
            ->take(10);

        return view('compare', compact(['category', 'meta', 'products']));
    }
}
