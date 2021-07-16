<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use Traits\Images;
    use Traits\Relations\BelongsTo\Category;
    use Traits\Relations\HasMany\Variants;
    use Traits\Relations\HasMany\Comments;

    protected string $modelName = 'product';
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
        'meta_title',
        'meta_description',
        'meta_keywords',
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
        'videos' => 'array',
        'files' => 'array',
        'stocks' => JsonObject::class,
        'features' => JsonObject::class,
        'settings' => JsonObject::class
    ];

    public function analogs(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id')->where([
            ['is_active', true],
            ['brand', $this->brand],
            ['price', '>=', $this->price * 0.85],
            ['price', '<=', $this->price * 1.15],
        ]);
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
