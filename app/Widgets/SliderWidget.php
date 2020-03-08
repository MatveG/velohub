<?php
namespace App\Widgets;

use App\Widgets\ContractWidget;
use App\Models\Menu;

class SliderWidget
{
    public function execute($data) {
        return view('Widgets::menu', ['res' => $data]);
    }
}
