<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'latin',
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

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getLinkAttribute()
    {
        return route('category', ['slug' => $this->slug, 'id' => $this->id]);
    }

}
