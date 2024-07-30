<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class ProjectMembers extends Model
{
    protected $fillable = [
        'id', 'user_id', 'project_id', 'createdBy', 'created_at', 'updated_at', 'role'
    ];
    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
