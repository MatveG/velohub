<?php

namespace App\Observers;

use App\Models\Feature;

class FeatureObserver
{
    public function creating(Feature $feature)
    {
        $feature->ord = $this->newItemOrd($feature->parent_id);
    }

    public function saving(Feature $feature)
    {
        $feature->slug = latinize($feature->title);
    }

    public function updating(Feature $feature)
    {
        if ($feature->isDirty('parent_id')) {
            $this->decrAboveOrd($feature->getOriginal('parent_id'), $feature->ord);
            $feature->ord = $this->newItemOrd($feature->parent_id);
        }
    }

    public function deleting(Feature $feature)
    {
        $this->decrAboveOrd($feature->parent_id, $feature->ord);
    }

    //
    private function newItemOrd($parentId) {
        return Feature::where('parent_id', $parentId)->max('ord') + 1;
    }

    private function decrAboveOrd(int $parentId, int $ordValue): void
    {
        Feature::where('parent_id', $parentId)->where('ord', '>', $ordValue)->decrement('ord');
    }
}
