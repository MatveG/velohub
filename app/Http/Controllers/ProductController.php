<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\FilterService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repo;
    protected $filters;

    public function __construct(ProductRepository $repo, FilterService $filters)
    {
        $this->repo = $repo;
        $this->filters = $filters;
    }

    public function search(Request $request, string $path = '')
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
            //->join('skus')
            //->select('skus.*', 'products.*')
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

    public function show(string $latin, int $id)
    {
        $product = $this
            ->repo
            ->with('skus')
            ->where('id', $id)
            ->active()
            ->first();

        $comments = $product->comments;

        $analogs = $this
            ->repo
            ->relatedMany($product->category)
            ->where('is_active')
            ->where('brand', $product->brand)
            ->where('prices->'.Product::shopPrice(), $product->price * 0.9, '>')
            ->where('prices->'.Product::shopPrice(), $product->price * 1.1, '<')
            ->limit(6)
            ->get();

        $seo = (object)[
            'title' => $product->name . ' ' . $product->model,
            'description' => $product->name . ' ' . $product->firm . ' ' . $product->model,
            'keywords' => $product->name . ',' . $product->firm . ',' . $product->model,
        ];

        return view('product', compact(['seo', 'product', 'comments', 'analogs']));
    }

}
