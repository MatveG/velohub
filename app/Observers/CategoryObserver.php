<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saving(Category $category)
    {
        if ($category->isDirty('title')) {
            $category->slug = latinize($category->title);
        }
    }
}
