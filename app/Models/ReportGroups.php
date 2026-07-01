<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportGroups extends Model
{
    protected $table = 'reportgroups';

    protected $fillable = [
        'reportid', 'columnorder', 'field', 'header',
        'sortable', 'sortorder', 'grouporder',
        'subtotal', 'total', 'count', 'hidden',
    ];
}
