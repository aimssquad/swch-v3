<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class MasterRoles extends Model
{
    protected $table = "tm_master_roles";
    protected $fillable = [
        'id',
        'title',
        'status',
        'project_id',
        'created_at',
        'updated_at'
    ];
}
