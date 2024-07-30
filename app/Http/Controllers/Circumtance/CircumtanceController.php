<?php

namespace App\Http\Controllers\Circumtance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CircumtanceController extends Controller
{
    public function dashboard(){
        return view('circumtance.dashboard');
    }
}
