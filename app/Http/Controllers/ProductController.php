<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id)
    {
        $product = Product::with('variants')
            ->whereId($id)
            ->isActive()
            ->firstOrFail();

        $meta = $seo = (object)[
            'title' => $product->name . ' ' . $product->model,
            'description' => $product->name . ' ' . $product->firm . ' ' . $product->model,
            'keywords' => $product->name . ',' . $product->firm . ',' . $product->model,
        ];

        return view('Product', compact(['product', 'seo', 'meta']));
    }

}
