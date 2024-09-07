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
use Exception;
use App\Models\LeaveApply;
use App\Models\Registration;
use App\Models\leaveAllocation;
use App\Models\Employee;

class LeaveApproverController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.leave-approver';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
        return view($this->_routePrefix . '.dashboard');
    }

    public function viewLeaveApproved()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                if (Session::get("user_type") == "employee") {
                    
                    $user_id = Session::get("users_id");
                    $users = DB::table("users")
                        ->where("id", "=", $user_id)
                        ->first();
                        
                    $emp_code = $users->employee_id;
                    // dd($users);
                    $data["LeaveApply"] = LeaveApply::join(
                          "leave_type","leave_type.id","leave_apply.leave_type"
                        )
                        ->join('employee','employee.emp_code','leave_apply.employee_id')
                        ->select(
                            "leave_apply.*",
                            "leave_type.leave_type_name",
                            "leave_type.alies"
                            // "employee.employeetype"
                        )

                        ->where("leave_apply.emid", "=", $users->emid)
                        // ->where(function ($result) use ($emp_code) {
                        //     if ($emp_code) {
                        //         $result
                        //             ->where(
                        //                 "leave_apply.emp_reporting_auth",
                        //                 $emp_code
                        //             )
                        //             ->orWhere(
                        //                 "leave_apply.emp_lv_sanc_auth",
                        //                 $emp_code
                        //             );
                        //     }
                        // })

                        ->orderBy("date_of_apply", "DESC")
                        ->get();
                        // dd($data["LeaveApply"]);
                } else {
                   
                    $email = Session::get("emp_email");
                    $Roledata = Registration::where("status", "=", "active")
                        ->where("email", "=", $email)
                        ->first();
                    $data["LeaveApply"] = LeaveApply::join(
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
                        ->orderBy("date_of_apply", "DESC")
                        ->where("leave_apply.emid", "=", $Roledata->reg)
                        ->get();
                }

                // dd($data['LeaveApply']);
                //$data['LeaveApply']=DB::table('leave_apply')->get();
                return view($this->_routePrefix . '.leave-approver',$data);
                //return view("leave-approver/leave-approver", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
}
