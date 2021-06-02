<?php

namespace App\Observers;

use App\Models\Feature;

class FeatureObserver
{
    public function creating(Feature $feature)
    {
        $feature->ord = $this->nextOrdValue($feature->parent_id);
    }

    public function saving(Feature $feature)
    {
        if ($feature->isDirty('title')) {
            $feature->slug = latinize($feature->title);
        }
    }

    public function updating(Feature $feature)
    {
        if ($feature->isDirty('parent_id')) {
            $this->orderTheRest($feature->getOriginal('parent_id'), $feature->ord);
            $feature->ord = $this->nextOrdValue($feature->parent_id);
        }
    }

    public function deleting(Feature $feature)
    {
        $this->orderTheRest($feature->parent_id, $feature->ord);
    }


    private function nextOrdValue(int $parentId): int
    {
        return Feature::where('parent_id', $parentId)->max('ord') + 1;
    }

    private function orderTheRest(int $parentId, int $ordValue): void
    {
        Feature::where('parent_id', $parentId)->where('ord', '>', $ordValue)->decrement('ord');
    }
}
