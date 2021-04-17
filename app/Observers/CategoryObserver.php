<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category)
    {
        $category->ord = self::computeOrd($category->parent_id);
    }

    public function updating(Category $category)
    {
        if ($category->isDirty('parent_id')) {
            self::decrementOrd($category->getOriginal('parent_id'), $category->ord);
            $category->ord = self::computeOrd($category->parent_id);
        }
    }

    public function saving(Category $category)
    {
        if ($category->isDirty('title')) {
            $category->slug = latinize($category->title);
        }

        if ($category->isDirty('features')) {
            $category->features = self::mapSlugProperty($category->features);
        }

        if ($category->isDirty('parameters')) {
            $category->parameters = self::mapSlugProperty($category->parameters);
        }
    }

    public function deleting(Category $category)
    {
        self::decrementOrd($category->parent_id, $category->ord);
    }

    private static function computeOrd($parentId) {
        return Category::where('parent_id', $parentId)->max('ord') + 1;
    }

    private static function decrementOrd($parentId, $initialValue) {
        return Category::where('parent_id', $parentId)->where('ord', '>', $initialValue)->decrement('ord');
    }

    private static function mapSlugProperty(array $array, ?string $prefix = null)
    {
        return array_map(static function ($element) use ($prefix) {
            if ($element['filter']) {
                $element['latin'] = latinize(($prefix ? "$prefix-" : '') . $element['title']);
            } else {
                $element['latin'] = null;
            }

            if (!empty($element['sub'])) {
                $element['sub'] = self::mapSlugProperty($element['sub'], $element['title']);
            }

            return $element;
        }, $array);
    }
}
