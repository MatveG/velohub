<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use Traits\Images;

    protected string $modelName = 'content';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'is_active',
        'name',
        'email',
        'password',
        'rights'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $casts = [
        'rights' => JsonObject::class,
        'email_verified_at' => 'datetime',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
}
