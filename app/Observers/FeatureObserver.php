<?php

namespace App\Observers;

use App\Models\Feature;

class FeatureObserver
{
    public function saving(Feature $feature)
    {
        if ($feature->isDirty('title')) {
            $feature->slug = latinize($feature->title);
        }
    }
}
