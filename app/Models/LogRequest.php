<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    protected $table = 'log_request';
    protected $fillable = [
        'url',
        'method',
        'body',
        'result',
        'status'
    ];
}
