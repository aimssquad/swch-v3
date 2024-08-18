<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class UploadAttendenceController extends Controller
{
    public function viewdashboard(Request $request){
        dd('okk');
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            //dd($data);
            $data['ClassName'] = 'dashboard';

            return View('attendance/dashboard', $data);
        } else {
            return redirect('/');
        }
        
    }
}
