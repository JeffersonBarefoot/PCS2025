<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScope;

class Position extends Model
{
    protected $fillable = [
        'company',
        'descr',
        'posno',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TeamScope);
    }
}
