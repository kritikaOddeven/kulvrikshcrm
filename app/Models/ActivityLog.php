<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'role', 'module', 'action',
        'subject_type', 'subject_id', 'description', 'ip_address',
    ];

    protected static function booted()
    {
        static::addGlobalScope('ownLogs', function (Builder $builder) {
            if (Auth::check()) {
                // Allow all logs for super-admin only
                if (!Auth::user()->is_admin) {
                    $builder->where('user_id', Auth::id());
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
