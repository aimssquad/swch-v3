<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $primarykey = 'id';
    protected $fillable = [
        'id',
        'emid',
        'title',
        'description',
        'keywords',
        'createdBy',
        'identifier',
        'status',
        'created_at',
        'updated_at'
    ];

    // Define relationships
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function members(): HasMany
    {
        return $this->hasMany(ProjectMembers::class);
    }
}
