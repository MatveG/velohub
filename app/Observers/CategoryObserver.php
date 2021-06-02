<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category)
    {
        $category->ord = $this->nextOrdValue($category->parent_id);
    }

    public function updating(Category $category)
    {
        if ($category->isDirty('parent_id')) {
            $this->orderTheRest($category->getOriginal('parent_id'), $category->ord);
            $category->ord = $this->nextOrdValue($category->parent_id);
        }
    }

    public function saving(Category $category)
    {
        if ($category->isDirty('title')) {
            $category->slug = latinize($category->title);
        }
    }

    public function deleting(Category $category)
    {
        $this->orderTheRest($category->parent_id, $category->ord);
    }

    private function nextOrdValue(int $parentId): int
    {
        return Category::where('parent_id', $parentId)->max('ord') + 1;
    }

    private function orderTheRest(int $parentId, int $ordValue): void
    {
        Category::where('parent_id', $parentId)->where('ord', '>', $ordValue)->decrement('ord');
    }
}
