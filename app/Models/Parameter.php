<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use Traits\Relations\BelongsTo\Category;

    protected string $name = 'parameter';
    public $timestamps = false;
    protected $fillable = [
        'parent_id',
        'is_required',
        'is_filter',
        'title',
        'type',
        'hint',
        'units',
        'values',
    ];
    protected $casts = [
        'values' => 'array',
    ];
}
