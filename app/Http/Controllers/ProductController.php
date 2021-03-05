<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(string $latin, int $id, Product $product)
    {
        $product = $product
            ->with('variants')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

//        dd($product);

//        $product = $this
//            ->repo
//            ->with('variants')
//            ->where('id', $id)
//            ->active()
//            ->first();
//
//        $comments = $product->comments;
//
//        $analogs = $this
//            ->repo
//            ->relatedMany($product->category)
//            ->where('is_active')
//            ->where('brand', $product->brand)
//            ->where('prices->'.Product::shopPrice(), $product->price * 0.9, '>')
//            ->where('prices->'.Product::shopPrice(), $product->price * 1.1, '<')
//            ->limit(6)
//            ->get();

        $comments = [];
        $analogs = [];

        $seo = (object)[
            'title' => $product->name . ' ' . $product->model,
            'description' => $product->name . ' ' . $product->firm . ' ' . $product->model,
            'keywords' => $product->name . ',' . $product->firm . ',' . $product->model,
        ];

        return view('product', compact(['seo', 'product', 'comments', 'analogs']));
    }

}
