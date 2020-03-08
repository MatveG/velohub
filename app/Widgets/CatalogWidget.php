<?php

namespace App\Widgets;

use App\Models\Category;

class CatalogWidget
{
    private $category;
    private $res;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->res = $this->getMenuTree();
    }

    public function execute($data) {
        return view('Widgets::catalog', ['res' => $this->res]);
    }

    public function getMenuTree($pId = 0, $result = [])
    {
        $menuItems = $this->category
          ->whereParent_id($pId)
          ->active()
          ->orderBy('sorting')
          ->get();

        foreach ($menuItems as $menu) {
            $curr = $menu->toarray();
            $curr['link'] = $menu->link;

            if(!empty($menu->settings->filters_in_menu)) {
                $curr['is_parent'] = true;
                $curr['with_filters'] = true;
                $curr['child'] = $this->getFilterLinks($menu, 'brand');
            }

            if($menu->is_parent) {
                $curr['child'] = $this->getMenuTree($menu->id);
            }

            $result[] = $curr;
        }

        return $result;
    }

    private function getFilterLinks($menu) {
        $filters = $menu->settings->filters_in_menu;

        foreach ($filters as $filter) {
            if($filter->column) {
                $groupBy = $filter->column . '->' . $filter->latin;
                $pluck = $filter->column . '->' . $filter->latin . ' AS ' . $filter->latin;
            } else {
                $groupBy = $pluck = $filter->latin;
            }

            $items = $menu->products()
                ->join('skus', 'skus.product_id', '=', 'products.id')
                ->active()
                ->groupBy($groupBy)
                ->pluck($pluck)
                ->toarray();

            foreach ($items as $item) {
                $current['name'] = $item;
                $current['is_parent'] = false;
                $current['link'] = "{$menu->link}/{$filter->latin}-is-{$item}/";
                $result[] = $current;
            }

            if ($filter !== end($filters)) {
                $result[] = ['name' => '', 'is_parent' => false, 'link' => '(divide)'];
            }
        }

        return $result ?? [];
    }
}
