<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Traits\General;
    use Traits\Shop;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Skus;
    use Traits\Relations\HasMany\Comments;

    protected $name = 'product';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'category_id',
        'is_active',
        'is_sale',
        'name',
        'brand',
        'model',
        'preview',
        'text',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'features',
    ];
    protected $casts = [
        'features' => 'object',
        'prices' => 'object',
        'images' => 'array',
    ];

    public function getSkuAttribute()
    {
        return $this->skus()->where('is_default', true)->firstOrFail();
    }

    public function getLinkAttribute()
    {
        return route('product.show', ['latin' => $this->latin, 'id' => $this->id]);
    }

}
