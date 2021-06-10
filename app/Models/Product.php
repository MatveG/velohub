<?php

namespace App\Models;

use App\Models\Casts\OrderProducts;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Traits\Common;
    use Traits\Images;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Variants;
    use Traits\Relations\HasMany\Comments;

    protected string $name = 'product';
    protected string $imagesFolder = '/images/product';
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
        'title',
        'brand',
        'model',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'sale_text',
        'summary',
        'description',
        'stocks',
        'features',
        'settings'
    ];
    protected $hidden = [
        'search'
    ];
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'files' => 'array',
        'stocks' => OrderProducts::class,
        'features' => OrderProducts::class,
        'settings' => OrderProducts::class
    ];
    protected $appends = [
        'link',
        'thumb'
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

    public function getRawStocksAttribute(): string
    {
        return $this->attributes['stocks'];
    }

    public function getRawFeaturesAttribute(): string
    {
        return $this->attributes['features'];
    }

    public function getRawSettingsAttribute(): string
    {
        return $this->attributes['settings'];
    }

    public function getLinkAttribute(): string
    {
        return route('product', ['slug' => $this->slug, 'id' => $this->id]);
    }

    public function scopeSearchBy($query, $keywords)
    {
        $query->whereRaw("search @@ to_tsquery('" . $keywords . "')");
    }

    public function scopeOrderByRelevance($query, $keywords)
    {
        $query->orderByRaw("ts_rank(search, to_tsquery('" . $keywords . "')) DESC");
    }
}
