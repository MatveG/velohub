<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use Traits\Common;
    use Traits\Images;
    use Traits\Relations\BelongsTo\Product;
    use Traits\Relations\BelongsTo\Category;

    protected string $name = 'variant';
    protected string $imagesFolder = '/media/variant';
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'category_id',
        'is_active',
        'is_sale',
        'price',
        'surcharge',
        'stock',
        'weight',
        'code',
        'barcode',
        'parameters',
        'images'

    ];
    protected $casts = [
        'images' => 'array',
        'parameters' => JsonObject::class,
        'stocks' => JsonObject::class
    ];

    public function getImagesNameAttribute(): string
    {
        $format = '%s-%s.%d.%s';

        return sprintf(
            $format,
            $this->product->latin,
            latinize(implode('-', array_values((array)$this->parameters))),
            $this->id,
            config('category.images_format')
        );
    }

}
