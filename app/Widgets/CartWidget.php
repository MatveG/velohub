<?php

namespace App\Widgets;

use App\Services\CartService;

class CartWidget
{
    private $res;

    public function __construct(CartService $service)
    {
        $this->res = $service->getItems();
    }

    public function execute($data) {
        return view('Widgets::cart', ['items' => $this->res]);
    }

}
