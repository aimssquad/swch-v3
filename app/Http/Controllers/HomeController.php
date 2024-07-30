<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    public function Dashboard(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            return View('payroll/home-dashboard');
        } else {
            return redirect('/');
        }
    }
}
