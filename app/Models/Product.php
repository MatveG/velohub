<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Traits\Common;
    use Traits\Shop;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Variants;
    use Traits\Relations\HasMany\Comments;

    protected $name = 'product';
    protected $imagesFolder = '/media/pt';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'category_id',
        'is_active',
        'is_stock',
        'is_sale',
        'price',
        'price_sale',
        'stock',
        'weight',
        'sale_text',
        'code',
        'barcode',
        'title',
        'brand',
        'model',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'summary',
        'description',
        'images',
        'videos',
        'files',
        'features',
    ];
//    protected $appends = [
//        'link'
//    ];
    protected $casts = [
        'features' => 'object',
        'prices' => 'object',
        'images' => 'array',
    ];

    public function getFullNameAttribute()
    {
        return $this->title . ' ' . $this->brand . ' ' . $this->model;
    }

    public function getLinkAttribute()
    {
        return route('product.show', ['latin' => $this->latin, 'id' => $this->id]);
    }
}
