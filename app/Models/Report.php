<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportid', 'teamid', 'userid', 'active', 'private',
        'is_system', 'group1', 'group2', 'sortorder', 'descr', 'notes',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function columns()
    {
        return $this->hasMany(ReportColumns::class, 'reportid', 'reportid');
    }

    public function queries()
    {
        return $this->hasMany(ReportQueries::class, 'reportid', 'reportid');
    }

    public function groups()
    {
        return $this->hasMany(ReportGroups::class, 'reportid', 'reportid');
    }

    // Returns reports visible to the current user:
    // system reports + team reports + user's own private reports
    public function scopeAccessibleBy($query, $teamId, $userId, $isAdmin = false)
    {
        return $query->where('active', 'A')
            ->where(function ($q) use ($teamId, $userId, $isAdmin) {
                $q->where('is_system', true)
                  ->orWhere(function ($q2) use ($teamId, $userId, $isAdmin) {
                      $q2->where('teamid', $teamId)
                         ->where(function ($q3) use ($userId, $isAdmin) {
                             $q3->where('private', 'N')
                                ->orWhere('userid', $userId);
                             if ($isAdmin) {
                                 $q3->orWhereNotNull('userid'); // admins see all
                             }
                         });
                  });
            });
    }
}
