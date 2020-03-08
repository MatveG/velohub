<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\ProductRepository;
use App\Services\FilterService;

class CategoryController extends Controller
{
    protected $category;
    protected $repo;
    protected $filters;

    public function __construct(Category $category, ProductRepository $repo, FilterService $filters)
    {
        $this->category = $category;
        $this->repo = $repo;
        $this->filters = $filters;
    }

    public function show(Request $request, string $latin, int $id, string $path = '')
    {
        $category = $this->category->findOrFail($id);
        $mainQuery = $category->products()->active();
        $skusQuery = $category->skus()->active();

        $filters = $this
            ->filters
            ->parsePath($path)
            ->usePrice($mainQuery)
            ->useBrand($mainQuery)
            ->useJson($category, 'features', $mainQuery)
            ->useJson($category, 'options', $skusQuery)
            ->get();

        $products = $this
            ->repo
            ->relatedMany($category)
            ->join('skus')
            ->select('skus.*', 'products.*')
            ->where('products.is_active')
            ->filter($filters)
            ->orderShop($request)
            ->paginate();

        $seo = (object)[
            'title' => $category->name,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('shop', compact(['category', 'products', 'filters', 'seo']));
    }

    public function compare(string $latin)
    {
        $category = $this->category->where('latin', $latin)->firstOrFail();
        $idArr = (!empty($_COOKIE['compare'])) ? json_decode(urldecode($_COOKIE['compare'])) : [];

        $products = $this
            ->repo
            ->relatedMany($category)
            ->whereIn('id', $idArr)
            ->join('skus')
            ->select('skus.*', 'products.*')
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
