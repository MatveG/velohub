<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Traits\Common;
    use Traits\Relations\BelongsTo\Product;

    protected string $name = 'comment';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'product_id',
        'rating',
        'pros',
        'cons',
        'comment',
        'author',
    ];
}
