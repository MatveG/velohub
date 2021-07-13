<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use Traits\Relations\BelongsTo\Category;

    protected string $modelName = 'parameter';
    public $timestamps = false;
    protected $fillable = [
        'parent_id',
        'category_id',
        'is_required',
        'is_filter',
        'title',
        'type',
        'units',
        'values',
    ];
    protected $casts = [
        'values' => 'array',
    ];
}
