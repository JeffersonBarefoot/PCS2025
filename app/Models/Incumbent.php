<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TeamScope;

class Incumbent extends Model
{
    //
    protected $fillable = [
        'company',
        'empno',
        'fname',
        'lname',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TeamScope);
    }
}
