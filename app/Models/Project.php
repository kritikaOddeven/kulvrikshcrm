<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function scopeParent($query)
    {
        return $query->whereNull('project_id');
    }

    public function scopeSubproject($query)
    {
        return $query->whereNotNull('project_id');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function subprojects()
    {
        return $this->hasMany(Project::class, 'project_id')->where('status', 'active');
    }

}
