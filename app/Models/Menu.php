<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use Traits\Common;

    protected $name = 'menu';
    public $timestamps = false;

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
