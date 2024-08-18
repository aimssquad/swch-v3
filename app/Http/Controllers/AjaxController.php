<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Route;
use Session;
use App\InterviewCandidate;
use App\Http\Controllers\LandingController;

class AjaxController extends Controller
{
    //
    public function getEmpCode($empid){
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')
    
            ->where('email', '=', $email)
            ->first();
    
        $employee_desigrs = DB::table('designation')
            ->where('id', '=', $empid)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_depers = DB::table('department')
            ->where('id', '=', $employee_desigrs->department_code)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_rs = DB::table('employee')
    
            ->where('emp_designation', '=', $employee_desigrs->designation_name)
            ->where('emp_department', '=', $employee_depers->department_name)
            ->where('emid', '=', $Roledata->reg)
            ->get();
        $result = '';
        $result_status1 = "  <option value=''>Select</option>
    ";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
        }
    
        echo $result_status1;
    }
}
