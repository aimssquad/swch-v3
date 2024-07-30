<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $table = "tasks_comments";
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'task_id',
        'comment_details',
        'createdBy',
        'status',
        'created_at',
        'updated_at'
        // Add other fillable attributes
    ];

    // Define relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
