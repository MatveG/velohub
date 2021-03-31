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

    protected $name = 'Product';
    protected $imagesFolder = '/media/Product';
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
    protected $casts = [
        'prices' => 'object',
        'images' => 'array',
    ];
    protected $appends = ['link'];

    public function analogs()
    {
        return $this
            ->hasMany(Product::class, 'category_id', 'category_id')
            ->where('brand', $this->brand)
            ->where('price', '>=', $this->price * 0.85)
            ->where('price', '<=', $this->price * 1.15)
            ->isActive();
    }

    public function getFeaturesAttribute()
    {
        return json_decode($this->attributes['features'], true);
    }

    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = json_encode((object)($value));
    }

//    public function getFullNameAttribute()
//    {
//        return $this->title . ' ' . $this->brand . ' ' . $this->model;
//    }

    public function getLinkAttribute()
    {
        return route('Product.show', ['slug' => $this->slug, 'id' => $this->id]);
    }

    public function scopeSearchBy($query, $string)
    {
        $query->whereRaw("search @@ to_tsquery('" . $this->searchEscape($string) . "')");
    }

    public function scopeOrderByRelevance($query, $string)
    {
        $query->orderByRaw("ts_rank(search, to_tsquery('" . $this->searchEscape($string) . "')) DESC");
    }

    private function searchEscape(string $string): string
    {
        return str_replace(' ', '  |', trim(
            preg_replace('/[^+A-Za-z0-9- ]/', '', $string)
        ));
    }

}
