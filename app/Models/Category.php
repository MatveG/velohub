<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Casts\Feature;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Traits\Common;
    use Traits\Relations\HasMany\Products;
    use Traits\Relations\HasMany\Variants;

    protected $name = 'category';
    protected $imagesFolder = '/media/category';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'parent_id',
        'is_active',
        'is_parent',
        'ord',
        'slug',
        'title',
        'title_short',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'description',
        'images',
        'features',
        'parameters',
    ];
    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'parameters' => 'array',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getFeaturesAttribute()
    {
        return json_decode($this->attributes['features'], true);
    }

    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = json_encode((array)($value), JSON_UNESCAPED_UNICODE);
    }

//    public function getFeaturesAttribute($value)
//    {
//        $features = json_decode($this->attributes['features'], true);
//        $features = array_map(function ($feature) {
//            return Feature::init($feature);
//        }, $features);
//
//        return $features;
//    }

    public function getLinkAttribute(): string
    {
        return route('category', ['slug' => $this->slug, 'id' => $this->id]);
    }

}
