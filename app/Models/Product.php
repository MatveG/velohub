<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Traits\Common;
    use Traits\Images;
    use Traits\Search;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Variants;
    use Traits\Relations\HasMany\Comments;

    protected string $name = 'product';
    protected string $imagesFolder = '/media/pt';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'category_id',
        'is_active',
        'is_stock',
        'is_sale',
        'warranty',
        'price',
        'price_old',
        'weight',
        'code',
        'barcode',
        'slug',
        'title',
        'brand',
        'model',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'sale_text',
        'summary',
        'description',
    ];
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'files' => 'array',
        'stocks' => JsonObject::class,
        'features' => JsonObject::class,
        'settings' => JsonObject::class
    ];
    protected $appends = [
        'link'
    ];

    public function analogs()
    {
        return $this
            ->hasMany(Product::class, 'category_id', 'category_id')
            ->where('brand', $this->brand)
            ->where('price', '>=', $this->price * 0.85)
            ->where('price', '<=', $this->price * 1.15)
            ->isActive();
    }

    public function getLinkAttribute(): string
    {
        return route('product', ['slug' => $this->slug, 'id' => $this->id]);
    }
}
