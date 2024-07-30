<?php

namespace App\Models\HrSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrSupportFileType extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'description', 'status'];

    public function supportFiles()
    {
        return $this->hasMany(HrSupportFile::class, 'type_id');
    }
}
