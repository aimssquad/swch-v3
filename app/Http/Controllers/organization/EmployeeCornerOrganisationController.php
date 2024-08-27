<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use PDF;
use App\Models\Registration;
use App\Models\UserModel;
use App\Models\Employee;
use App\Models\EmployeePayStructure;

class EmployeeCornerOrganisationController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.employee-corner';
        //$this->_model       = new CompanyJobs();
    }

    public function indexserorganisationemployee()
    {
        // dd("hello");
        $email = Session::get("emp_email");
        $user_email = Session::get("user_email");
        $user_type = Session::get("user_type");
        if($user_type=="employer"){
            if (!empty($email)) {
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
            
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["users"] = UserModel::join(
                    "employee",
                    "employee.emp_code",
                    "users.employee_id"
                )
                    ->where("users.emid", "=", $Roledata->reg)
                    ->where("users.user_type", "=", "employee")
                    ->where("users.status", "=", "active")
                    ->select(
                        "users.*",
                        "employee.emp_fname",
                        "employee.emp_mname",
                        "employee.emp_lname"
                    )
                    ->get();
                return view($this->_routePrefix . '.employeeorganisation-list',$data);
                //return view("employeeorganisation-list", $data);
            } else {
                return redirect("/");
            }
        }else{
             return redirect()->intended(
                        "employeecornerorganisationdashboard"
                    );
        }
       
    }





} // End Class
