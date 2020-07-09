<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Traits\Common;
    use Traits\Relations\HasMany\Products;
    use Traits\Relations\HasMany\Variants;

    protected $name = 'category';
    protected $imagesFolder = '/media/cy';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'parent_id',
        'is_active',
        'is_parent',
        'sorting',
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

    public function getLinkAttribute() {
        return route('category.show', ['latin' => $this->latin, 'id' => $this->id]);
    }

//    public static function getTree($parentId = 0)
//    {
//        return self::where('parent_id', $parentId)
//            ->orderBy('sorting')
//            ->get()
//            ->map(function ($item) {
//                $item->child = self::getTree($item->id);
//                return $item;
//            });
//    }

    public function setLatinAttribute($value)
    {
        $this->attributes['latin'] = latinize($value);
    }

    public function setFeaturesAttribute($value)
    {
        $value = array_map(function ($element) {
            $element['latin'] = ($element['filter']) ? latinize($element['title']) : null;

            return $element;
        }, $value);

        $this->attributes['features'] = json_encode($value);
    }

    public function setParametersAttribute($value)
    {
        $value = array_map(function ($element) {
            $element['latin'] = ($element['is_filter']) ? latinize($element['title']) : null;

            return $element;
        }, $value);

        $this->attributes['parameters'] = json_encode($value);
    }

}
