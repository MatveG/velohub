<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// todo: Add columnt to the table
// todo: Fill Title values
class Setting extends Model
{
    protected string $modelName = 'setting';
    public $timestamps = false;
    protected $fillable = [
        'value'
    ];

    public function getValueAttribute()
    {
        return in_array($this->attributes['type'], ['object', 'array']) ?
            json_decode($this->attributes['value']) :
            $this->attributes['value'];
    }

    public function setValueAttribute($value)
    {
        $type = $this->attributes['type'];
        $this->attributes['value'] = in_array($type, ['object', 'array'])
            ? json_encode(
                $type === 'object' ? (object)($value) : (array)($value),
                JSON_UNESCAPED_UNICODE
            )
            : $value;
    }
}
