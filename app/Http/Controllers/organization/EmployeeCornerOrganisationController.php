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
        //dd("hello");
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
                        "org-employeecornerorganisationdashboard"
                    );
        }
       
    }


    public function DoLoginorganisationemployee(Request $request)
    {
        $email = Session::get("emp_email");
        //dd($email);
        if (!empty($email)) {
            $employer = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $Employee = UserModel::where("employee_id", "=", $request->com)
                ->where("status", "=", "active")
                ->where("user_type", "=", "employee")
                ->where("emid", "=", $employer->reg)
                ->first();

            if (!empty($Employee)) {
                $Roledata = UserModel::where("employee_id", "=", $request->com)
                    ->where("status", "=", "active")
                    ->where("user_type", "=", "employee")
                    ->where("emid", "=", $employer->reg)
                    ->first();
                if (!empty($Roledata)) {
                    $Roledatadd = Registration::where("status", "=", "active")
                        ->where("reg", "=", $Roledata->emid)
                        ->first();
                    Session::put("emp_email", $Roledatadd->email);
                    Session::put("user_email_new", $Employee->email);
                    Session::put("user_type_new", $Employee->user_type);
                    Session::put("users_id_new", $Employee->id);
                    Session::put("emp_pass_new", $request->psw);

                    return redirect()->intended(
                        "org-employeecornerorganisationdashboard"
                    );
                } else {
                    Session::flash("message", "Employee Is not active!!");
                    return redirect("/");
                }
            } else {
                Session::flash("message", "Employee Is not active!!");
                return redirect("/");
            }
        } else {
            return redirect("/");
        }
    }

    public function viewdash()
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $user_id = Session::get("users_id_new");
           
            $users = DB::table("users")
                ->where("email", "=", $email)
                ->first();
            
            $data["employee"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            // $first_day_this_year = date('Y-01-01');
            $first_day_this_year = date("2020-01-01");
            $last_day_this_year = date("Y-12-31");

            $data["LeaveAllocation"] = DB::table("leave_allocation")
                ->join(
                    "leave_type",
                    "leave_allocation.leave_type_id",
                    "=",
                    "leave_type.id"
                )
                ->where(
                    "leave_allocation.employee_code",
                    "=",
                    $users->employee_id
                )
                ->where("leave_allocation.emid", "=", $users->emid)
                // ->where('leave_allocation.month_yr','like', '%'.date('Y'))
                // ->where('leave_allocation.month_yr','like', '%2020')
                ->whereDate(
                    "leave_allocation.created_at",
                    ">=",
                    $first_day_this_year
                )
                ->select(
                    "leave_allocation.*",
                    "leave_type.leave_type_name",
                    "leave_type.alies"
                )
                ->get();

            $data["leaveApply"] = DB::table("leave_apply")
                ->join(
                    "leave_type",
                    "leave_apply.leave_type",
                    "=",
                    "leave_type.id"
                )
                ->select(
                    "leave_apply.*",
                    "leave_type.leave_type_name",
                    "leave_type.alies"
                )
                ->where("leave_apply.employee_id", "=", $users->employee_id)
                ->where("leave_apply.emid", "=", $users->emid)
                ->whereDate("leave_apply.from_date", ">=", $first_day_this_year)
                ->whereDate("leave_apply.to_date", "<=", $last_day_this_year)
                ->get();
            return view($this->_routePrefix . '.dashboard',$data);
            //return View("employee-corner-organisation/dashboard", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewdetadash()
    {
         if (!empty(Session::get("emp_email"))) {
            // $user_id = Session::get("users_id_new");
           $users_ids=Session::get("users_id");
           //dd($users_ids);
           $arryValue=array();
           if(Session::get("users_id_new")){
              $arryValue[]=Session::get("users_id_new");
           }else{
               $arryValue[]=Session::get("users_id");
           }
           $user_id=implode(",",$arryValue);
            $users =UserModel::where("id", "=", $user_id)
                ->first();
               
            //  dd($users->employee_id); 
            $data["employee"] = Employee::where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
               
            $data["employee_pay_structure"] = EmployeePayStructure::where("employee_code", "=", $users->employee_id)
                // ->where("emid", "=", $users->emid)
                ->first();
               
            // $data["bank_name"] = DB::table("bank_masters")
            //     ->where("id", "=", $data["employee"]->emp_bank_name)
            //     ->first();
            if (!empty($data["employee"]->emp_bank_name)) {
                $data["bank_name"] = DB::table("bank_masters")
                    ->where("id", "=", $data["employee"]->emp_bank_name)
                    ->first();
            } else {
                // Handle the case when emp_bank_name is empty
                $data["bank_name"] = null; // or you can set it to some default value
            }
             
            $roledata = DB::table("role_authorization")
                ->join(
                    "module",
                    "role_authorization.module_name",
                    "=",
                    "module.id"
                )

                ->select("role_authorization.*", "module.module_name")
                ->where("member_id", "=", $users->email)
                ->where("emid", "=", $users->emid)
                ->get();
                
            $module_name = [];

            if (!empty($roledata)) {
                foreach ($roledata as $rdata) {
                    if (!in_array($rdata->module_name, $module_name)) {
                        $module_name[] = $rdata->module_name;
                    }
                }
                $result = "" . implode(", ", $module_name) . "";
            } else {
                $result = "";
            }
            $data["module_name"] = $result;
            //dd($data["employee"]);
            return view($this->_routePrefix . '.user-profile',$data);
            //return view("employee-corner-organisation/user-profile", $data);
        } else {
            return redirect("/");
        }
    }





} // End Class
