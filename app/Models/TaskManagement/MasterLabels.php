<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class MasterLabels extends Model
{
    protected $table = "tm_master_labels";
    protected $fillable = [
        'id',
        'title',
        'status',
        'project_id',
        'created_at',
        'updated_at'
    ];
}
