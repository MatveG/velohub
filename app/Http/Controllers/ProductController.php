<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\MetaService;

class ProductController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id)
    {
        $product = Product::with('variants')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $meta = MetaService::each(join(' ', $product->only(['name', 'brand', 'model'])));

        return view('product', compact(['product', 'meta']));
    }

}
