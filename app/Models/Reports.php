namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
use HasFactory;

protected $fillable = [
'name', 'description', 'is_deleted', 'team_id', // Adjust fields per your schema
];

/**
* Scope to filter accessible reports for a user or team.
*
* @param \Illuminate\Database\Eloquent\Builder $query
* @param int $userId
* @return \Illuminate\Database\Eloquent\Builder
*/
public function scopeAccessibleBy($query, $userId)
{
return $query->where('is_deleted', false)
->whereHas('permissions', function ($query) use ($userId) {
$query->where('user_id', $userId);
});
}
}

