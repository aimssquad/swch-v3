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
use App\Exports\ExcelFileExportBalance;
use App\Exports\ExcelFileExportLeaveEmployee;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Models\Registration;
use App\Models\LeaveType;
use App\Models\LeaveRule;
use App\Models\EmployeeType;
use App\Models\Employee;
use App\Models\leaveAllocation;

class LeaveManagementController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.leave';
        //$this->_model       = new CompanyJobs();
    }


    public function getLeaveType()
    {   
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $data["leave_type_rs"] = LeaveType::where(
                    "emid",
                    "=",
                    $Roledata->reg
                )
                    ->orderBy("id", "desc")
                    ->get();

                    //dd($data);    
                //return view("leave/leave-type", $data);
                return view($this->_routePrefix . '.leave-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddLeaveType()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                //return view("leave/manage-leave-type", $data);
                return view($this->_routePrefix . '.new-leave-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveLeaveType(Request $request)
    {   //dd('okk');
        try {
            if (!empty(Session::get("emp_email"))) {
                //$data=$request->all();
                $email = Session::get("emp_email");
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $alias = trim(strtoupper($request->alies));
                if (!empty($request->id)) {
                    $leavedata = LeaveType::where("emid", "=", $Roledata->reg)
                        ->where("id", "!=", $request->id)
                        ->where("alies", "=", $alias)
                        ->first();
                } else {
                    $leavedata = LeaveType::where("emid", "=", $Roledata->reg)
                        ->where("alies", "=", $alias)
                        ->first();
                }

                $leave_type = trim(strtoupper($request->leave_type_name));

                $validate = Validator::make(
                    $request->all(),
                    [
                        "leave_type_name" => "required",

                        "alies" => "required",
                    ],
                    [
                        "leave_type_name.required" => "Leave Type required",

                        "alies.required" => "Alias is required",
                    ]
                );
                if ($validate->fails()) {
                    return redirect("leave/new-leave-type")
                        ->withErrors($validate)
                        ->withInput();
                }

                //$data = request()->except(['_token']);
                if (!empty($leavedata)) {
                    Session::flash("message", "It is already exits.");
                    return redirect("leave/new-leave-type");
                }

                $data = [
                    "leave_type_name" => trim(
                        strtoupper($request->leave_type_name)
                    ),
                    "alies" => trim(strtoupper($request->alies)),
                    "remarks" => $request->remarks,
                    "leave_type_status" => "active",
                    "emid" => $Roledata->reg,
                ];
                if (!empty($request->id)) {
                    // dd('hello');
                    db::table("leave_type")
                        ->where("id", $request->id)
                        ->update($data);
                    Session::flash(
                        "message",
                        "Leave Type Updated Successfully"
                    );
                    return redirect("leave/leave-type-listing");
                }
                if (!empty($data)) {
                    LeaveType::insert($data);

                    Session::flash("message", "Leave Type Added Successfully");
                    return redirect("leave/leave-type-listing");
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getLeaveTypeDtl($let_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $data["holidaydtl"] = LeaveType::where("id", $let_id)->first();

                // dd($data);

                //return view("leave/manage-leave-type", $data);
                return view($this->_routePrefix . '.new-leave-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
}
