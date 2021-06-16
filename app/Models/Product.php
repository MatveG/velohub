<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use Traits\Common;
    use Traits\ProductImages;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Variants;
    use Traits\Relations\HasMany\Comments;

    protected string $modelName = 'product';
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
        'stocks' => JsonObject::class,
        'features' => JsonObject::class,
        'settings' => JsonObject::class
    ];
    protected $appends = [
        'name',
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

    public function getNameAttribute(): string
    {
        return $this->attributes['title'] . ' ' . $this->attributes['brand'] . ' ' . $this->attributes['model'];
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
