<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'id',
        'project_id',
        'task_name',
        'task_desc',
        'tags',
        'assignedTo',
        'start_date',
        'expected_end_date',
        'updatedBy',
        'createdBy',
        'priority',
        'status',
        'created_at',
        'updated_at'
    ];

    // Define relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
