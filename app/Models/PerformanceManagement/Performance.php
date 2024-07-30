<?php

namespace App\Models\PerformanceManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Performance extends Model
{
    protected $primarykey = 'id';
    protected $table = "performances";
    protected $fillable = [
        'id',
        'emid',
        'emp_code',
        'emp_reporting_auth',
        'apprisal_period_start',
        'apprisal_period_end',
        'performance_comments',
        'performance_feedback',
        'rating',
        'createdBy',
        'status',
        'created_at',
        'updated_at'
    ];

    // Define relationships
    // public function tasks()
    // {
    //     return $this->hasMany(Task::class);
    // }
    // public function members(): HasMany
    // {
    //     return $this->hasMany(ProjectMembers::class);
    // }
}
