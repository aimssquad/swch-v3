<?php

namespace App\Models\HrSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HrSupportFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type_id',
        'title',
        'small_description',
        'description',
        'pdf',
        'doc',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo(HrSupportFileType::class, 'type_id');
    }
}
