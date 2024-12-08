<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cookie extends Model
{
    protected $fillable = [
        'host',
        'key',
        'value',
        'expiry'
    ];
}
