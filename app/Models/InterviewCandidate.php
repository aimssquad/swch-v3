<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewCandidate extends Model
{
    use SoftDeletes;

    public function position(){
        return $this->belongsTo('App\InterviewPostion');
    }

}
