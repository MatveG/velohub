<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saving(Category $category)
    {
        if ($category->isDirty('title')) {
            $category->latin = latinize($category->title);
        }

        if (empty($category->sorting) || $category->isDirty('parent_id')) {
            $category->sorting = $this->calculateSorting($category->parent_id);
        }

        if ($category->isDirty('parent_id')) {
            self::redoSorting($category->getOriginal('parent_id'), $category->sorting);
        }
    }

    public function deleting(Category $category)
    {
        self::redoSorting($category->parent_id, $category->sorting);
    }

    private static function calculateSorting($parentId) {
        return Category::where('parent_id', $parentId)->max('sorting') + 1;
    }

    private static function redoSorting($parentId, $initialValue) {
        return Category::where('parent_id', $parentId)->where('sorting', '>', $initialValue)->decrement('sorting');
    }
}
