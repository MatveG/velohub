<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Repositories\ProductRepository;

class IndexController extends Controller
{
    public function index(Content $content, ProductRepository $repo)
    {
        $content = $content->where('latin', 'index')->firstOrFail();

        $shopSale = $repo
            ->where('is_active')
            ->where('is_stock')
            ->where('is_sale')
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $shopNew = $repo
            ->where('is_active')
            ->where('is_stock')
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $seo = (object)[
            'title' => $content->seo_title,
            'description' => $content->seo_description,
            'keywords' => $content->seo_keywords,
        ];

        return view('index', compact(['seo', 'content', 'shopSale', 'shopNew']));
    }

}
