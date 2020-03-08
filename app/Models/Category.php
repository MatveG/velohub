<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Traits\General;
    use Traits\Relations\HasMany\Products;
    use Traits\Relations\HasMany\Skus;

    protected $name = 'category';
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'settings' => 'object',
        'features' => 'object',
        'options' => 'object',
    ];

    public function getLinkAttribute() {
        return route('category.show', ['latin' => $this->latin, 'id' => $this->id]);
    }
}
