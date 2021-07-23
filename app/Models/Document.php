<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected string $modelName = 'content';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'is_active',
        'slug',
        'title',
        'text',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_text'
    ];
}
