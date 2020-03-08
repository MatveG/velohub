<?php

namespace App\Widgets;

use App\Widgets\ContractWidget;
use App\Models\Menu;

class MenuWidget
{
    private $menu;
    private $res;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
        $this->res = $this->getMenuTree();
    }

    public function execute($data) {
        return view('Widgets::menu', ['res' => $this->res]);
    }

    public function getMenuTree($pId = 0, $result = [])
    {
        $menuItems = $this->menu
          ->where('parent_id', $pId)
          ->active()
          ->orderBy('sorting')
          ->get();

        foreach ($menuItems as $menu) {
            $curr = $menu->toarray();

            if($menu->is_parent) $curr['child'] = $this->getMenuTree($menu->id);
            $result[] = $curr;
        }

        return $result;
    }
}
