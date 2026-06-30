<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
use HasFactory;

protected $fillable = [
'name',
'description',
'is_deleted',
'team_id', // Adjust based on your actual database schema
];

/**
* Define a relationship to permissions (if permissions table exists).
*/
public function permissions()
{
// Assuming there's a Permission model and 'permissions' table
return $this->hasMany(Permission::class, 'report_id'); // Adjust foreign key if necessary
}

/**
* Scope to filter reports that are accessible to a specific user.
*
* @param \Illuminate\Database\Eloquent\Builder $query
* @param int $userId
* @return \Illuminate\Database\Eloquent\Builder
*/
public function scopeAccessibleBy($query, $userId)
{
return $query->where('is_deleted', false) // Example: Exclude deleted reports
->whereHas('permissions', function ($permissionQuery) use ($userId) {
// Check user permissions in the `permissions` table
$permissionQuery->where('user_id', $userId);
});
}
}
