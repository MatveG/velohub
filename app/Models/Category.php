<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Traits\Relations\HasMany\Features;
    use Traits\Relations\HasMany\Parameters;
    use Traits\Relations\HasMany\Products;
    use Traits\Relations\HasMany\Variants;

    protected string $modelName = 'category';
    protected string $imagesFolder = '/images/category';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'parent_id',
        'is_active',
        'is_parent',
        'ord',
        'slug',
        'title',
        'title_short',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'description',
        'images',
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getLinkAttribute(): string
    {
        return route('category', ['slug' => $this->slug, 'id' => $this->id]);
    }


    public function scopeCache($query)
    {
        dd($query);
        return $query;
    }


//    public function getRawImagesAttribute(): string
//    {
//        return $this->attributes['images'];
//    }
//
//    public function getRawSettingsAttribute(): string
//    {
//        return $this->attributes['settings'];
//    }
}
