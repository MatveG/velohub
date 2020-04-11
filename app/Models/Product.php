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
        'is_stock',
        'is_sale',
        'is_parent',
        'price',
        'price_sale',
        'stock',
        'weight',
        'code',
        'barcode',
        'name',
        'brand',
        'model',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'brief',
        'text',
        'images',
        'videos',
        'files',
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

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->brand . ' ' . $this->model;
    }

    public function getLinkAttribute()
    {
        return route('product.show', ['latin' => $this->latin, 'id' => $this->id]);
    }

}
