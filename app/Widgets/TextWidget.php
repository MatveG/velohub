<?php

namespace App\Widgets;

use App\Widgets\ContractWidget;
use App\Models\Widget;

class TextWidget
{
    protected $data;
    protected $items;

    public function __construct() {
        $this->items = Widget::all();
    }

    public function execute($data) {
        $res = $this->items->where('latin', $data)->first();

        return view('Widgets::text', compact(['res']));
    }
}
