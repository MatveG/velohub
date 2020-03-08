<?php

namespace App\Widgets;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CompareWidget
{
    private $res = [];

    public function __construct(Product $products)
    {
        if(empty($_COOKIE['compare'])) {
            return;
        }

        $idArr = json_decode( urldecode($_COOKIE['compare']) );

        $this->res = ($products
            ->select(DB::raw('category_id, count(category_id) as amount'))
            ->with('category')
            ->whereIn('id', $idArr)
            ->where('is_active', true)
            ->groupBy('category_id')
            ->get()
        );
    }

    public function execute($data) {
        return view('Widgets::compare', ['res' => $this->res]);
    }

}
