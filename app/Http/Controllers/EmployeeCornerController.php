<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PDF;
use Session;
use view;
use App\Models\Masters\Cast;
use App\Models\Masters\Sub_cast;
use App\Models\Masters\Department;
use App\Models\UserModel;
use App\Models\Employee;
use App\Models\Registration;
use App\Models\RotaEmployee;
use App\Models\EmployeeType;
use App\Models\LeaveType;
use App\Models\LeaveRule;
use App\Models\Holiday;
use App\Models\EmployeePersonalRecord;
use App\Models\ExperienceRecords;
use App\Models\ProfessionalRecords;
use App\Models\MiscDocuments;
use App\Models\EmployeePayStructure;

class EmployeeCornerController extends Controller
{
    public function viewdash()
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $user_id = Session::get("users_id");
            $users = UserModel::where("id", "=", $user_id)->first();
            $data["employee"] = Employee::where(
                "emp_code",
                "=",
                $users->employee_id
            )
                ->where("emid", "=", $users->emid)
                ->first();
            $first_day_this_year = date("Y-01-01");
            //$first_day_this_year = date('2020-01-01');
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
                //->where('leave_allocation.month_yr','like', '%'.date('Y'))
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

            return View("employee-corner/dashboard", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewdetadash()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
            $data["employee"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            $data["employee_pay_structure"] = DB::table(
                "employee_pay_structure"
            )
                ->where("employee_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            $data["bank_name"] = DB::table("bank_masters")
                ->where("id", "=", $data["employee"]->emp_bank_name)
                ->first();

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
            return view("employee-corner/user-profile", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddEmployeeco()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $userId = Session::get("users_id_new");
            $Roledata = DB::table("registration")
                ->where("email", "=", $email)
                ->first();

            $data["Roledata"] = DB::table("registration")
                ->where("email", "=", $email)
                ->first();
            $userAccess = UserModel::where("id", $userId)->first();

            $employee_id = $userAccess->employee_id;

            $data["payment_wedes_rs"] = DB::table("payment_type_wedes")
                ->where("emid", "=", $Roledata->reg)
                ->get();

            if ($userAccess) {
                $data["employee_rs"] = Employee::where(
                    "emp_code",
                    $employee_id
                )->first();
                $current_emp_id = $data["employee_rs"]->id;
                $data["cast"] = Cast::where(
                    "cast_status",
                    "=",
                    "active"
                )->get();
                $data["sub_cast"] = Sub_cast::where(
                    "sub_cast_status",
                    "=",
                    "active"
                )->get();
                $data["religion"] = DB::table("religion_master")->get();
                $data["department"] = DB::table("department")->get();
                $data["designation"] = DB::table("designation")->get();
                $data["EmployeePersonalRecord"] = EmployeePersonalRecord::where(
                    "empid",
                    $current_emp_id
                )->get();
                $data["ExperienceRecords"] = ExperienceRecords::where(
                    "empid",
                    $current_emp_id
                )->get();
                $data["ProfessionalRecords"] = ProfessionalRecords::where(
                    "empid",
                    $current_emp_id
                )->get();
                $data["MiscDocuments"] = MiscDocuments::where(
                    "empid",
                    $current_emp_id
                )->get();
                $data["EmployeePayStructure"] = EmployeePayStructure::where(
                    "empid",
                    $current_emp_id
                )->first();
                $data["emp_pay_st"] = EmployeePayStructure::where(
                    "empid",
                    "=",
                    $current_emp_id
                )->first();
                $data["rate_master"] = DB::table("rate_masters")
                    ->where("head_type", "earning")
                    ->get();
                $data["rate_masterss"] = DB::table("rate_masters")
                    ->where("head_type", "deduction")
                    ->get();

                return view("employee-corner/edit-employee", $data);
            }

            //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
        } else {
            return redirect("/");
        }
    }

    public function viewdetaholiday()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
            $holidays = DB::table("holiday")

                ->where("emid", "=", $users->emid)
                ->get();

            return view(
                "employee-corner/holiday-calendar",
                compact("holidays")
            );
        } else {
            return redirect("/");
        }
    }
    public function viewcahngepass()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            return view("employee-corner/change-password", compact("users"));
        } else {
            return redirect("/");
        }
    }

    public function savecahngepass(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            if ($request->old != $users->password) {
                Session::flash("message", "Old Password Is Incorrect.");
                return redirect("employee-corner/change-password");
            } else {
                if ($request->new_p != $request->con) {
                    Session::flash(
                        "message",
                        "New Password and Cormfirm Password Are Not Same"
                    );
                    return redirect("employee-corner/change-password");
                } else {
                    $dataimgperpa = [
                        "password" => $request->new_p,
                    ];
                    DB::table("users")
                        ->where("id", "=", $user_id)
                        ->update($dataimgperpa);
                    Session::flash(
                        "message",
                        " Password Changed Successfully."
                    );
                    return redirect("employee-corner/change-password");
                }
            }
        } else {
            return redirect("/");
        }
    }
    public function savecahngeimage(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            if ($request->has("emp_image")) {
                $file = $request->file("emp_image");
                $extension = $request->emp_image->extension();
                $path = $request->emp_image->store("employee_logo", "public");
                $dataimg = [
                    "emp_image" => $path,
                ];
                DB::table("employee")
                    ->where("emp_code", $users->employee_id)
                    ->where("emid", "=", $users->emid)
                    ->update($dataimg);
            }

            return redirect("employee-corner/user-profile");
        } else {
            return redirect("/");
        }
    }

    public function viewapplyleaveapplication()
    {
      
        $user_email = Session::get("user_email");
        $user_type = Session::get("user_type");
        
        if($user_type=="employer"){
             if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            
            $users = UserModel::where("id", "=", $user_id)->first();
            // dd($users);
            $employee = Employee::where("emid", "=", $users->employee_id)
                ->orwhere("emid", "=", $users->emid)
                ->first();
            // dd($employee);
           
            $leave_type_rs = LeaveType::join(
                "leave_allocation",
                "leave_type.id",
                "=",
                "leave_allocation.leave_type_id"
            )

                ->select(
                    "leave_type.*",
                    "leave_allocation.id as lv_alloc_id",
                    "leave_allocation.month_yr"
                )
                ->where("leave_type.emid", "=", $users->employee_id)
                ->where(
                    "leave_allocation.emid",
                    "=",
                    $users->employee_id
                )
                ->where("leave_allocation.emid", "=", $users->employee_id)

                ->where("leave_allocation.leave_in_hand", "!=", 0)
                ->get();
                // dd($leave_type_rs);

            // dd($users->employee_id);

            $holiday_rs = Holiday::where("emid", "=", $users->employee_id)
                ->select("from_date", "to_date", "day", "holiday_type")
                ->get();
            // dd($holiday_rs);

            $holidays = [];
            $holiday_type = [];
            $holiday_array = [];
            foreach ($holiday_rs as $holiday) {
                if ($holiday->day > "1") {
                    $from_date = $holiday->from_date;
                    $to_date = $holiday->to_date;

                    $date1 = date("d-m-Y", strtotime($from_date));
                    $date2 = date("d-m-Y", strtotime($to_date));
                    // dd($date1);
                    // Declare an empty array
                    // $holiday_array = array();

                    // Use strtotime function
                    $variable1 = strtotime($date1);
                    $variable2 = strtotime($date2);

                    // Use for loop to store dates into array
                    // 86400 sec = 24 hrs = 60*60*24 = 1 day
                    for (
                        $currentDate = $variable1;
                        $currentDate <= $variable2;
                        $currentDate += 86400
                    ) {
                        $Store = date("Y-m-d", $currentDate);

                        $holidays[] = $Store;
                        $holiday_type[] = $holiday->holiday_type;
                    }

                    // Display the dates in array format
                } elseif ($holiday->day == "1") {
                    $Store = $holiday->from_date;
                    $holidays[] = $Store;
                    $holiday_type[] = $holiday->holiday_type;
                }

                $holiday_array = [
                    "holidays" => $holidays,
                    "holiday_type" => $holiday_type,
                ];
            }

            // dd($holiday_array);
            return view(
                "employee-corner/apply-leave",
                compact("leave_type_rs", "employee", "holiday_array")
            );
        } else {
            return redirect("/");
        }
        }else{
              if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            
            $users = UserModel::where("email", "=", $user_email)->first();
            
            $employee = Employee::where("emp_code", "=", $users->employee_id)
                // ->orwhere("emid", "=", $users->emid)
                ->first();
        //   dd($employee);
           
                $leave_type_rs = LeaveType::join(
                    "leave_allocation",
                    "leave_type.id",
                    "=",
                    "leave_allocation.leave_type_id"
                )
    
                    ->select(
                        "leave_type.*",
                        "leave_allocation.id as lv_alloc_id",
                        "leave_allocation.month_yr"
                    )
                    ->where("leave_type.emid", "=", $users->emid)
                    ->where(
                        "leave_allocation.emid",
                        "=",
                        $users->emid
                    )
                    ->where("leave_allocation.emid", "=", $users->emid)
    
                    ->where("leave_allocation.leave_in_hand", "!=", 0)
                    ->groupBy('leave_type.id')
                    ->get();
                    //  dd($leave_type_rs);

            // dd($users->employee_id);

            $holiday_rs = Holiday::where("emid", "=", $users->employee_id)
                ->select("from_date", "to_date", "day", "holiday_type")
                ->get();
            // dd($holiday_rs);

            $holidays = [];
            $holiday_type = [];
            $holiday_array = [];
            foreach ($holiday_rs as $holiday) {
                if ($holiday->day > "1") {
                    $from_date = $holiday->from_date;
                    $to_date = $holiday->to_date;

                    $date1 = date("d-m-Y", strtotime($from_date));
                    $date2 = date("d-m-Y", strtotime($to_date));
                    // dd($date1);
                    // Declare an empty array
                    // $holiday_array = array();

                    // Use strtotime function
                    $variable1 = strtotime($date1);
                    $variable2 = strtotime($date2);

                    // Use for loop to store dates into array
                    // 86400 sec = 24 hrs = 60*60*24 = 1 day
                    for (
                        $currentDate = $variable1;
                        $currentDate <= $variable2;
                        $currentDate += 86400
                    ) {
                        $Store = date("Y-m-d", $currentDate);

                        $holidays[] = $Store;
                        $holiday_type[] = $holiday->holiday_type;
                    }

                    // Display the dates in array format
                } elseif ($holiday->day == "1") {
                    $Store = $holiday->from_date;
                    $holidays[] = $Store;
                    $holiday_type[] = $holiday->holiday_type;
                }

                $holiday_array = [
                    "holidays" => $holidays,
                    "holiday_type" => $holiday_type,
                ];
            }

            // dd($holiday_array);
            return view(
                "employee-corner/apply-leave",
                compact("leave_type_rs", "employee", "holiday_array")
            );
        } else {
            return redirect("/");
        }
        }
    }

    public function saveApplyLeaveData(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            // dd($request);
            $user_id = Session::get("users_id");
            $users = UserModel::where("id", "=", $user_id)->first();

            $report_auth = Employee::where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();

            if (!empty($report_auth)) {
                $report_auth_name = $report_auth->reportingauthority;
            } else {
                $report_auth_name = "";
            }

            $diff = abs(
                strtotime($request->to_date) - strtotime($request->from_date)
            );
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(
                ($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24)
            );
            $days =
                floor(
                    ($diff -
                        $years * 365 * 60 * 60 * 24 -
                        $months * 30 * 60 * 60 * 24) /
                        (60 * 60 * 24)
                ) + 1;

            $leave_tyepenew = DB::table("leave_type")
                ->where("id", "=", $request->leave_type)
                ->first();

            //  $request->leave_inhand;
            if ($request->leave_inhand >= $request->days) {
                $data["employee_id"] = $request->employee_id;
                $data["employee_name"] = $request->employee_name;
                $data["emp_reporting_auth"] = $report_auth_name;
                $data["emp_lv_sanc_auth"] = "";
                $data["date_of_apply"] = date(
                    "Y-m-d",
                    strtotime($request->date_of_apply)
                );
                $data["leave_type"] = $request->leave_type;
                $data["half_cl"] = $request->half_cl;
                $data["from_date"] = $request->from_date;
                $data["to_date"] = $request->to_date;
                $data["no_of_leave"] = $request->days;
                $data["status"] = "NOT APPROVED";
                $data["emid"] = $users->emid;
                $leave_apply = DB::table("leave_apply")->insert($data);

                Session::flash("message", "Leave Apply Successfully..!.");
                return redirect("employeecornerdashboard");
            } else {
                Session::flash("Leave_msg", "Sorry, No Leave Available");
                return redirect("employee-corner/leave-apply");
            }
        } else {
            return redirect("/");
        }
    }

    public function holidayLeaveApplyAjax(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            // dd($request->all());
            $holidays = $request["holiday"]["holidays"];

            $endDate = strtotime($request["to_date"]);
            $startDate = strtotime($request["from_date"]);

            if ($request["leave_type"] == 1) {
                $days = ($endDate - $startDate) / 86400 + 1;
                $no_full_weeks = floor($days / 7);
                $no_remaining_days = fmod($days, 7);

                $the_first_day_of_week = date("N", $startDate);
                $the_last_day_of_week = date("N", $endDate);

                if ($the_first_day_of_week <= $the_last_day_of_week) {
                    if (
                        $the_first_day_of_week <= 6 &&
                        6 <= $the_last_day_of_week
                    ) {
                        $no_remaining_days--;
                    }

                    if (
                        $the_first_day_of_week <= 7 &&
                        7 <= $the_last_day_of_week
                    ) {
                        $no_remaining_days--;
                    }
                } else {
                    if ($the_first_day_of_week == 7) {
                        $no_remaining_days--;
                        if ($the_last_day_of_week == 6) {
                            $no_remaining_days--;
                        }
                    } else {
                        $no_remaining_days -= 2;
                    }
                }

                $workingDays = $no_full_weeks * 5;
                if ($no_remaining_days > 0) {
                    $workingDays += $no_remaining_days;
                }
                //We subtract the holidays
                foreach ($holidays as $key => $holiday) {
                    $time_stamp = strtotime($holiday);
                    $hol_type = $request["holiday"]["holiday_type"][$key];
                    //If the holiday doesn't fall in weekend
                    if (
                        $startDate <= $time_stamp &&
                        $time_stamp <= $endDate &&
                        date("N", $time_stamp) != 6 &&
                        date("N", $time_stamp) != 7 &&
                        $hol_type == "closed"
                    ) {
                        $workingDays--;
                    }
                }

                if ($request["cl_type"] == "half") {
                    $workingDays = $workingDays / 2;
                }
            } else {
                $diff = $endDate - $startDate;

                $workingDays = abs(round($diff / 86400)) + 1;

                foreach ($holidays as $key => $holiday) {
                    $time_stamp = strtotime($holiday);
                    $hol_type = $request["holiday"]["holiday_type"][$key];
                    //If the holiday doesn't fall in weekend
                    if (
                        $startDate <= $time_stamp &&
                        $time_stamp <= $endDate &&
                        date("N", $time_stamp) != 6 &&
                        date("N", $time_stamp) != 7 &&
                        $hol_type == "closed"
                    ) {
                        $workingDays--;
                    }
                }
            }
            echo json_encode($workingDays);
        } else {
            return redirect("/");
        }
    }

    public function viewAttandancestatus()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("email", "=", $email)->first();
            $data["Roledata"] = Registration::where(
                "email",
                "=",
                $email
            )->first();

            return view("employee-corner/daily-status", $data);
        } else {
            return redirect("/");
        }
    }

    public function saveAttandancestatus(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = UserModel::where("id", "=", $user_id)->first();

            $email = Session::get("emp_email");
            $Roledata = Registration::where("email", "=", $email)->first();
            $data["Roledata"] = Registration::where(
                "email",
                "=",
                $email
            )->first();

            $employee_code = $users->employee_id;

            $start_date = date("Y-m-d", strtotime($request->start_date));
            $end_date = date("Y-m-d", strtotime($request->end_date));
            $data["result"] = "";
            if ($employee_code != "") {
                $leave_allocation_rs = DB::table("attandence")
                    ->join(
                        "employee",
                        "attandence.employee_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where(
                        "attandence.employee_code",
                        "=",
                        $users->employee_id
                    )
                    ->where("attandence.emid", "=", $users->emid)

                    ->whereBetween("date", [$start_date, $end_date])
                    ->select("attandence.*")
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $data["result"] .=
                        '<tr>
				<td>' .
                        $f .
                        '</td>

													<td>' .
                        date("d/m/Y", strtotime($leave_allocation->date)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($leave_allocation->time_in)) .
                        '</td>
													<td>' .
                        $leave_allocation->time_in_location .
                        '</td>
														<td>' .
                        date("h:i a", strtotime($leave_allocation->time_out)) .
                        '</td>
													<td>' .
                        $leave_allocation->time_out_location .
                        '</td>
													<td>' .
                        $leave_allocation->duty_hours .
                        '</td>


						</tr>';
                    $f++;
                }
            }

            return view("employee-corner/daily-status", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewchangecircumstances()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
            $data["employee_rs"] = DB::table("change_circumstances")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->get();

            $data["employeet"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();

            return view("employee-corner/change-of-circumstances", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewchangecircumstancesedit()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
            $data["employee_rs"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();

            $data["nation_master"] = DB::table("nationality_master")
                ->where("emid", "=", $users->emid)
                ->get();
            $data["currency_user"] = DB::table("currencies")
                ->orderBy("country", "asc")
                ->get();

            $data["employee_otherd_doc_rs"] = DB::table("employee_other_doc")
                ->where("emid", "=", $users->emid)
                ->where("emp_code", "=", $users->employee_id)
                ->get();

            return view("employee-corner/edit-circumstances", $data);
        } else {
            return redirect("/");
        }
    }

    public function savechangecircumstancesedit(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $dataupdate = [
                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "issue_by" => $request->issue_by,
                "pas_iss_date" => date(
                    "Y-m-d",
                    strtotime($request->pas_iss_date)
                ),
                "pass_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->pass_exp_date)
                ),
                "pass_review_date" => date(
                    "Y-m-d",
                    strtotime($request->pass_review_date)
                ),
                "visa_doc_no" => $request->visa_doc_no,
                "visa_nat" => $request->visa_nat,
                "visa_issue" => $request->visa_issue,
                "visa_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_issue_date)
                ),
                "visa_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_exp_date)
                ),
                "visa_review_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_review_date)
                ),

                "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),

                "emp_pr_street_no" => $request->emp_pr_street_no,
                "emp_per_village" => $request->emp_per_village,
                "emp_pr_city" => $request->emp_pr_city,
                "emp_pr_country" => $request->emp_pr_country,
                "emp_pr_pincode" => $request->emp_pr_pincode,
                "emp_pr_state" => $request->emp_pr_state,

                "emp_ps_street_no" => $request->emp_ps_street_no,
                "emp_ps_village" => $request->emp_ps_village,
                "emp_ps_city" => $request->emp_ps_city,
                "emp_ps_country" => $request->emp_ps_country,
                "emp_ps_pincode" => $request->emp_ps_pincode,
                "emp_ps_state" => $request->emp_ps_state,
            ];

            if ($request->has("pr_add_proof")) {
                $file_peradd = $request->file("pr_add_proof");
                $extension_per_add = $request->pr_add_proof->extension();
                $path_peradd = $request->pr_add_proof->store(
                    "employee_per_add",
                    "public"
                );
                $dataimgper = [
                    "pr_add_proof" => $path_peradd,
                ];
                DB::table("employee")
                    ->where("emp_code", "=", $users->employee_id)
                    ->where("emid", "=", $users->emid)
                    ->update($dataimgper);
            }

            if ($request->has("pass_docu")) {
                $file_doc = $request->file("pass_docu");
                $extension_doc = $request->pass_docu->extension();
                $path_doc = $request->pass_docu->store(
                    "employee_doc",
                    "public"
                );

                $dataimgdoc = [
                    "pass_docu" => $path_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", "=", $users->employee_id)
                    ->where("emid", "=", $users->emid)
                    ->update($dataimgdoc);
            }
            if ($request->has("visa_upload_doc")) {
                $file_visa_doc = $request->file("visa_upload_doc");
                $extension_visa_doc = $request->visa_upload_doc->extension();
                $path_visa_doc = $request->visa_upload_doc->store(
                    "employee_vis_doc",
                    "public"
                );
                $dataimgvis = [
                    "visa_upload_doc" => $path_visa_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", "=", $users->employee_id)
                    ->where("emid", "=", $users->emid)
                    ->update($dataimgvis);
            }

            if ($request->has("ps_add_proof")) {
                $file_ps_add = $request->file("pr_add_proof");
                $extension_ps_add = $request->ps_add_proof->extension();
                $path_ps_ad = $request->ps_add_proof->store(
                    "employee_ps_add",
                    "public"
                );
                $dataimgps = [
                    "ps_add_proof" => $path_ps_ad,
                ];
                DB::table("employee")
                    ->where("emp_code", "=", $users->employee_id)
                    ->where("emid", "=", $users->emid)
                    ->update($dataimgps);
            }

            DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->update($dataupdate);

            if ($request->has("stat_up")) {
                $file_ps_doc = $request->file("stat_up");
                $extension_ps_doc = $request->stat_up->extension();
                $path_ps_doc = $request->stat_up->store(
                    "employee_ps_stat",
                    "public"
                );
            } else {
                $path_ps_doc = "";
            }

            if ($request->has("pap_up")) {
                $file_per_doc = $request->file("pap_up");
                $extension_per_doc = $request->pap_up->extension();
                $path_per_doc = $request->pap_up->store(
                    "employee_pap_up",
                    "public"
                );
            } else {
                $path_per_doc = "";
            }

            $data = [
                "pap_up" => $path_per_doc,
                "stat_up" => $path_ps_doc,

                "emp_designation" => $request->emp_designation,

                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "issue_by" => $request->issue_by,
                "pas_iss_date" => date(
                    "Y-m-d",
                    strtotime($request->pas_iss_date)
                ),
                "pass_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->pass_exp_date)
                ),
                "pass_review_date" => date(
                    "Y-m-d",
                    strtotime($request->pass_review_date)
                ),
                "remarks" => $request->remarks,
                "cur_pass" => $request->cur_pass,

                "visa_doc_no" => $request->visa_doc_no,
                "visa_nat" => $request->visa_nat,
                "visa_issue" => $request->visa_issue,
                "visa_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_issue_date)
                ),
                "visa_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_exp_date)
                ),
                "visa_review_date" => date(
                    "Y-m-d",
                    strtotime($request->visa_review_date)
                ),
                "country_residence" => $request->country_residence,
                "visa_remarks" => $request->visa_remarks,
                "visa_cur" => $request->visa_cur,

                "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
                "emp_pr_street_no" => $request->emp_pr_street_no,
                "emp_per_village" => $request->emp_per_village,
                "emp_pr_city" => $request->emp_pr_city,
                "emp_pr_country" => $request->emp_pr_country,
                "emp_pr_pincode" => $request->emp_pr_pincode,
                "emp_pr_state" => $request->emp_pr_state,

                "emp_ps_street_no" => $request->emp_ps_street_no,
                "emp_ps_village" => $request->emp_ps_village,
                "emp_ps_city" => $request->emp_ps_city,
                "emp_ps_country" => $request->emp_ps_country,
                "emp_ps_pincode" => $request->emp_ps_pincode,
                "emp_ps_state" => $request->emp_ps_state,

                "emp_code" => $users->employee_id,
                "emid" => $users->emid,

                "hr" => $request->hr,
                "home" => $request->home,
                "res_remark" => $request->res_remark,

                "date_change" => date(
                    "Y-m-d",
                    strtotime($request->date_change)
                ),
                "change_last" => $request->change_last,
                "stat_chage" => $request->stat_chage,

                "unique_law" => $request->unique_law,
                "repo_ab" => $request->repo_ab,
                "laeve_date" => $request->laeve_date,
            ];
            DB::table("change_circumstances")->insert($data);
            if (!empty($request->emqliotherdoc)) {
                $tot_item_edit_quli = count($request->emqliotherdoc);

                foreach ($request->emqliotherdoc as $value) {
                    if ($request->input("doc_name_" . $value) != "") {
                        if ($request->has("doc_upload_doc_" . $value)) {
                            $extension_doc_edit = $request
                                ->file("doc_upload_doc_" . $value)
                                ->extension();
                            $path_quli_doc_edit = $request
                                ->file("doc_upload_doc_" . $value)
                                ->store("emp_other_doc", "public");
                            $dataimgedit = [
                                "doc_upload_doc" => $path_quli_doc_edit,
                            ];
                            DB::table("employee_other_doc")
                                ->where("emid", "=", $users->emid)
                                ->where("id", $value)
                                ->update($dataimgedit);
                        }

                        $dataquli_edit = [
                            "emp_code" => $users->employee_id,
                            "doc_name" => $request->input("doc_name_" . $value),
                            "doc_ref_no" => $request->input(
                                "doc_ref_no_" . $value
                            ),
                            "doc_nation" => $request->input(
                                "doc_nation_" . $value
                            ),
                            "doc_issue_date" => date(
                                "Y-m-d",
                                strtotime(
                                    $request->input("doc_issue_date_" . $value)
                                )
                            ),
                            "doc_review_date" => date(
                                "Y-m-d",
                                strtotime(
                                    $request->input("doc_review_date_" . $value)
                                )
                            ),
                            "doc_exp_date" => date(
                                "Y-m-d",
                                strtotime(
                                    $request->input("doc_exp_date_" . $value)
                                )
                            ),
                            "doc_cur" => $request->input("doc_cur_" . $value),
                            "doc_remarks" => $request->input(
                                "doc_remarks_" . $value
                            ),
                        ];

                        DB::table("employee_other_doc")
                            ->where("id", $value)
                            ->where("emid", "=", $users->emid)
                            ->update($dataquli_edit);
                    }
                }
            }

            if (!empty($request->doc_name)) {
                $tot_item_nat = count($request->doc_name);

                for ($i = 0; $i < $tot_item_nat; $i++) {
                    if ($request->doc_name[$i] != "") {
                        if ($request->has("doc_upload_doc")) {
                            $extension_upload_doc = $request->doc_upload_doc[
                                $i
                            ]->extension();
                            $path_upload_otherdoc = $request->doc_upload_doc[
                                $i
                            ]->store("emp_other_doc", "public");
                        } else {
                            $path_upload_otherdoc = "";
                        }
                        $dataupload = [
                            "emp_code" => $users->employee_id,
                            "doc_name" => $request->doc_name[$i],
                            "emid" => $users->emid,
                            "doc_upload_doc" => $path_upload_otherdoc,

                            "doc_ref_no" => $request->doc_ref_no[$i],
                            "doc_nation" => $request->doc_nation[$i],
                            "doc_remarks" => $request->doc_remarks[$i],
                            "doc_issue_date" => date(
                                "Y-m-d",
                                strtotime($request->doc_issue_date[$i])
                            ),
                            "doc_exp_date" => date(
                                "Y-m-d",
                                strtotime($request->doc_exp_date[$i])
                            ),
                            "doc_review_date" => date(
                                "Y-m-d",
                                strtotime($request->doc_review_date[$i])
                            ),
                            "doc_cur" => $request->doc_cur[$i],
                        ];
                        DB::table("employee_other_doc")->insert($dataupload);
                    }
                }
            }

            $employeecircumsta = DB::table("change_circumstances")

                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->orderBy("id", "desc")
                ->first();

            $employee_otherd_doc_rs = DB::table("employee_other_doc")

                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->get();
            if (count($employee_otherd_doc_rs) != 0) {
                foreach ($employee_otherd_doc_rs as $valuother) {
                    $datachangecirdox = [
                        "emp_code" => $users->employee_id,
                        "doc_name" => $valuother->doc_name,
                        "emid" => $valuother->emid,
                        "doc_upload_doc" => $valuother->doc_upload_doc,

                        "doc_ref_no" => $valuother->doc_ref_no,
                        "doc_nation" => $valuother->doc_nation,
                        "doc_remarks" => $valuother->doc_remarks,
                        "doc_issue_date" => $valuother->doc_issue_date,
                        "doc_exp_date" => $valuother->doc_exp_date,
                        "doc_review_date" => $valuother->doc_review_date,
                        "doc_cur" => $valuother->doc_cur,
                        "cir_id" => $employeecircumsta->id,
                    ];

                    DB::table("circumemployee_other_doc")->insert(
                        $datachangecirdox
                    );
                }
            }

            Session::flash(
                "message",
                "Change Of Circumstances Updated Successfully."
            );
            return redirect("employee-corner/change-of-circumstances");
        } else {
            return redirect("/");
        }
    }

    public function viewemployeeagreement()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $data["employee_rs"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->get();
            return view("employee-corner/employee", $data);
        } else {
            return redirect("/");
        }
    }
    public function viewemployeeagreementdit()
    {
        if (!empty(Session::get("emp_email"))) {
            $first_day_this_year = date("Y-01-01");
            $last_day_this_year = date("Y-12-31");

            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $emjob = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")

                ->where("email", "=", $email)
                ->first();

            $currency_auth = DB::table("currencies")

                ->where("code", "=", $emjob->currency)
                ->orderBy("id", "DESC")
                ->first();

            if (!empty($emjob->emp_department)) {
                $employee_depers = DB::table("department")
                    ->where("department_name", "=", $emjob->emp_department)
                    ->where("emid", "=", $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table("designation")
                    ->where("designation_name", "=", $emjob->emp_designation)
                    ->where("department_code", "=", $employee_depers->id)
                    ->where("emid", "=", $Roledata->reg)
                    ->first();
                $duty_auth = DB::table("duty_roster")
                    ->where("department", "=", $employee_depers->id)
                    ->where("designation", "=", $employee_desigrs->id)
                    ->where("employee_id", "=", $users->employee_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->orderBy("id", "DESC")
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table("shift_management")
                        ->where("department", "=", $employee_depers->id)
                        ->where("id", "=", $duty_auth->shift_code)
                        ->where("designation", "=", $employee_desigrs->id)

                        ->where("emid", "=", $Roledata->reg)
                        ->orderBy("id", "DESC")
                        ->first();

                    $off_auth = DB::table("offday")
                        ->where("department", "=", $employee_depers->id)
                        ->where("shift_code", "=", $duty_auth->shift_code)
                        ->where("designation", "=", $employee_desigrs->id)

                        ->where("emid", "=", $Roledata->reg)
                        ->orderBy("id", "DESC")
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(
                        date("Y-m-d " . $shift_auth->time_out)
                    );
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = $difference % 60;
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->mon == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == "1") {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }
                }
            } else {
                $offarr = 0;
            }

            $pay_type_auth = DB::table("payment_type_master")

                ->where("id", "=", $emjob->emp_payment_type)
                ->orderBy("id", "DESC")
                ->first();

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
                ->whereBetween("leave_allocation.created_at", [
                    $first_day_this_year,
                    $last_day_this_year,
                ])
                //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                ->select(
                    "leave_allocation.*",
                    "leave_type.leave_type_name",
                    "leave_type.alies"
                )
                ->get();

            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));

            $datap = [
                "com_name" => $Roledata->com_name,
                "com_logo" => $Roledata->logo,
                "address" =>
                    $Roledata->address .
                    "," .
                    $Roledata->address2 .
                    "," .
                    $Roledata->road,
                "addresssub" =>
                    $Roledata->city .
                    "," .
                    $Roledata->zip .
                    "," .
                    $Roledata->country,
                "date" => $emjob->emp_doj,
                "date_con" => $emjob->start_date,
                "date_end" => $emjob->end_date,
                "job_loc" => $emjob->job_loc,
                "emid" => $emjob->emid,
                "emp_code" => $emjob->emp_code,
                "emp_pay_scale" => $emjob->emp_pay_scale,
                "em_name" =>
                    $emjob->emp_fname .
                    " " .
                    $emjob->emp_mname .
                    " " .
                    $emjob->emp_lname,
                "em_pos" => $emjob->emp_designation,
                "em_depart" => $emjob->emp_department,
                "address_emp" =>
                    $emjob->emp_pr_street_no .
                    "," .
                    $emjob->emp_per_village .
                    "," .
                    $emjob->emp_pr_state .
                    "," .
                    $emjob->emp_pr_city .
                    "," .
                    $emjob->emp_pr_pincode .
                    "," .
                    $emjob->emp_pr_country,
                "em_co" => $Roledata->country,
                "currency" => $emjob->currency,
                "symbol" => $currency_auth->symbol,
                "week_time" => $offarr,
                "year_time" => $years,
                "pay_type" => $pay_type_auth->pay_type,
                "LeaveAllocation" => $data["LeaveAllocation"],
                "birth" => $emjob->country_birth,
                "emp_de" => $emjob,
            ];

            $pdf = PDF::loadView("mypdfagree", $datap);
            return $pdf->download("contract.pdf");
            Session::flash(
                "message",
                "Contract Agreement Create Successfully."
            );
            return redirect("employee-corner/contract-agreement");
        } else {
            return redirect("/");
        }
    }

    public function saveEmployeeco(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("email", "=", $email)
                ->first();

            $data["Roledata"] = Registration::where("email", "=", $email)
                ->first();
                $employee_data=Employee::where('emid',$data["Roledata"]->reg)->first();
                $employee_id=$employee_data->id;
                $updateData = [];

                //employee update
                $updateData = [
                    // "emid" => $userObj->employee_id,
                    // "emp_code" => $employeeId,
                    "old_emp_code"=> $request->emp_old_code,
                    "salutation" => $request->salutation,
                    "emp_fname" => $request->emp_fname,
                    "emp_mname" => $request->emp_mname,
                    "emp_lname" => $request->emp_lname,
                    "emp_father_name" => $request->emp_father_name,
                    "spousename" => $request->spousename,
                    "emp_caste" => $request->emp_caste,
                    "emp_sub_caste" => $request->emp_sub_caste,
                    "emp_religion" => $request->emp_religion,
                    "maritalstatus" => $request->maritalstatus,
                    "mariddate" => $request->mariddate,
                    "department" => $request->department,
                    "designation" => $request->designation,
                    "dateofbirth" => $request->dateofbirth,
                    "dateofretirement" => $request->dateofretirement,
                    "dateofretirementbvc" => $request->dateofretirementbvc,
                    "dateofJoining" => $request->dateofJoining,
                    "confirmationdate" => $request->confirmationdate,
                    "nextincrementdate" => $request->nextincrementdate,
                    "eligibleforpromotion" => $request->eligibleforpromotion,
                    "employeetype" => $request->employeetype,
                    "renewdate" => $request->renewdate,
                    "profileimage" => $request->profileimage,
                    "reportingauthority" => $request->reportingauthority,
                    "leaveauthority" => $request->leaveauthority,
                    "grade" => $request->grade,
                    "registration_no" => $request->registration_no,
                    "registration_date" => $request->registration_date,
                    "registration_counci" => $request->registration_counci,
                    "date_of_up_gradation" => $request->date_of_up_gradation,
                    "emp_blood_grp" => $request->emp_blood_grp,
                    "emp_eye_sight_left" => $request->emp_eye_sight_left,
                    "emp_eye_sight_right" => $request->emp_eye_sight_right,
                    "emp_family_plan_status" => $request->emp_family_plan_status,
        
                    "emp_family_plan_date" => $request->emp_family_plan_date,
                    "emp_height" => $request->emp_height,
        
                    "emp_identification_mark_one" =>
                        $request->emp_identification_mark_one,
                    "emp_identification_mark_two" =>
                        $request->emp_identification_mark_two,
                    "emp_physical_status" => $request->emp_physical_status,
                    "emp_pr_street_no" => $request->emp_pr_street_no,
                    "emp_per_village" => $request->emp_per_village,
                    "emp_pr_city" => $request->emp_pr_city,
                    "emp_per_post_office" => $request->emp_per_post_office,
                    "emp_per_policestation" => $request->emp_per_policestation,
                    "emp_pr_pincode" => $request->emp_pr_pincode,
                    "emp_per_dist" => $request->emp_per_dist,
                    "emp_pr_state" => $request->emp_pr_state,
                    "emp_pr_country" => $request->emp_pr_country,
                    "emp_pr_mobile" => $request->emp_pr_mobile,
                    "em_name" => $request->em_name,
                    "em_relation" => $request->em_relation,
                    "relation_others" => $request->relation_others,
                    "em_email" => $request->em_email,
                    "em_phone" => $request->em_phone,
                    "hel_em_email" => $request->hel_em_email,
                    "hel_em_phone" => $request->hel_em_phone,
                    "em_address" => $request->em_address,
                    "pass_doc_no" => $request->pass_doc_no,
                    "pass_nat" => $request->pass_nat,
                    "place_birth" => $request->place_birth,
                    "issue_by" => $request->issue_by,
                    "pas_iss_date" => $request->pas_iss_date,
                    "pass_exp_date" => $request->pass_exp_date,
                    "pass_review_date" => $request->pass_review_date,
                    "pass_docu" => $request->pass_docu,
                    "cur_pass" => $request->cur_pass,
                    "cur_passss" => $request->cur_passss,
                    "remarks" => $request->remarks,
                    "emp_group" => $request->emp_group,
                    "emp_basic_pay" => $request->emp_basic_pay,
                    "emp_apf_percent" => $request->emp_apf_percent,
                    "emp_pf_type" => $request->emp_pf_type,
                    "emp_passport_no" => $request->emp_passport_no,
                    "emp_pf_no" => $request->emp_pf_no,
                    "emp_uan_no" => $request->emp_uan_no,
                    "emp_pan_no" => $request->emp_pan_no,
                    "emp_bank_name" => $request->emp_bank_name,
                    "bank_branch_id" => $request->bank_branch_id,
                    "emp_ifsc_code" => $request->emp_ifsc_code,
                    "emp_account_no" => $request->emp_account_no,
        
                    "emp_gradess" => $request->emp_gradess,
        
                    "emp_aadhar_no" => $request->emp_aadhar_no,
                    "emp_pension" => $request->emp_pension,
                    "emp_pf_inactuals" => $request->emp_pf_inactuals,
                    "emp_bonus" => $request->emp_bonus,
                ];
                DB::table('employee')->where('id',$employee_id)->update($updateData);
                //end employee update

        $documentNames = $request->input("document_name");
        $employeeId = $request->input("empid");
        $perId=$request->input("perid");
        if ($request->hasFile("document_upload")) {
            $documents = $request->file("document_upload");
            foreach ($documents as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new EmployeePersonalRecord();
                $documentModel->emp_code=$employeeId;
                $documentModel->document_name = $documentNames[$key];
                $documentModel->document_upload = $documentName;
               
                $documentModel->where('id',$perId[$key])->update([
                    "document_name"=>$documentNames[$key],
                    "document_upload"=>$documentName,
                ]);
            } 
        }
     
        $emp_document_names = $request->input("emp_document_name");
      
        $boardsss = $request->input("boardss");
        $yearofpassings = $request->input("yearofpassing");
        $emp_grades = $request->input("emp_grade");
        $erprec=$request->input("erprec");
        if ($request->hasFile("emp_document_upload")) {
            
            $documents = $request->file("emp_document_upload");
           
            foreach ($documents as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new ExperienceRecords();
                ExperienceRecords::where('id',$erprec[$key])->update([
                    'emp_document_name'=>$emp_document_names[$key],
                    'boardss'=>$boardsss[$key],
                    'yearofpassing'=>$yearofpassings[$key],
                    'emp_grade'=>$emp_grades[$key],
                    'emp_document_upload'=>$documentName
                ]);
            }
          
        }

        $Organization = $request->input("Organization");
        $Desigination = $request->input("Desigination");
        $formdate = $request->input("formdate");
        $todate = $request->input("todate");
        $proId=$request->input("proId");
        if ($request->hasFile("emp1_document_upload")) {
            $documentss = $request->file("emp1_document_upload");
            foreach ($documentss as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new ProfessionalRecords();
                $documentModel::where('id',$proId[$key])->update([
                    'Organization'=>$Organization[$key],
                    'Desigination'=>$Desigination[$key],
                    'formdate'=>$formdate[$key],
                    'todate'=>$todate[$key],
                    'emp1_document_upload'=>$documentName
                ]);
            }
        }

        $emp_tranings = $request->input("emp_traning");
        $traning1_document_upload=$request->input('traning1_document_upload');
        $miscId=$request->input('miscId');
        if ($request->hasFile("traning1_document_upload")) {
            $documentss = $request->file("traning1_document_upload");
            foreach ($documentss as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new MiscDocuments();
                $documentModel::where('id',$miscId)->update([
                    'emp_traning'=>$emp_tranings[$key],
                    'traning1_document_upload'=>$documentName
                ]); 
            }
        }

        Session::flash(
            "message",
            "Employee Information Successfully Saved."
        );

                return redirect("employee-corner/update-profile");
            }else{
            return redirect("/");
        }
    }

    // public function viewworkupdate()
    // {
    //     if (!empty(Session::get("emp_email"))) {
    //         $user_id = Session::get("users_id");
           
    //         $users = UserModel::where("id", "=", $user_id)->first();
    //         $data["user_type"]=$users->user_type;
    //       if($users->user_type=="employer"){
    //             $data["Roledata"] = Registration::where(
    //             "reg",
    //             "=",
    //             $users->emid
    //         )->first();

    //         $data["employee"] = Employee::where(
    //             "emp_code",
    //             "=",
    //             $users->employee_id
    //         )
    //             ->where("emid", "=", $users->emid)
    //             ->first();
    //              $data["employee_workupdate"] = RotaEmployee::where(
    //             "emid",
    //             "=",
    //             $users->employee_id
    //         )
    //             ->orderBy("date", "DESC")
    //             ->get();
    //               return view("employee-corner/work-update", $data);

    //       }else{
              
    //              $data["employee"] = Employee::where(
    //             "emp_code",
    //             "=",
    //             $users->employee_id
    //         )
    //             ->where("emid", "=", $users->emid)
    //             ->first();
    //             // dd($data["employee"]);
    //              $data["employee_workupdate"] = RotaEmployee::where(
    //             "employee_id",
    //             "=",
    //             $users->employee_id
    //         )
    //             ->orderBy("date", "DESC")
    //             ->get();
    //               return view("employee-corner/work-update", $data);
               
    //       }
            
    //     } else {
    //         return redirect("/");
    //     }
    // }
    
     public function viewworkupdate()
    {
        
        if (!empty(Session::get("emp_email"))) {
             
             $user_type = Session::get("user_type");   
           if($user_type=="employer"){
             $emp_email=Session::get("user_email_new");
            //  dd($emp_email);
            $users = UserModel::where("email", "=",  $emp_email)->first();
        //    dd($users);
            $data["user_type"]="employer";
            //     $data["Roledata"] = Registration::where(
            //     "reg",
            //     "=",
            //     $users->emid
            // )->first();

            $data["employee"] = Employee::where(
                "emp_code",
                "=",
                $users->employee_id
            )
                ->where("emid", "=", $users->emid)
                ->first();
                // dd($users->employee_id);
                 $data["employee_workupdate"] = RotaEmployee::where(
                "employee_id",
                "=",
                $users->employee_id
            )
                ->orderBy("date", "DESC")
                ->get();
                  return view("employee-corner/work-update", $data);

           }else{
              $user_email = Session::get("user_email");
              $users = UserModel::where("email", "=",  $user_email)->first();
                 $data["employee"] = Employee::where(
                "emp_code",
                "=",
                $users->employee_id
            )
                ->where("emid", "=", $users->emid)
                ->first();
                // dd($users->employee_id);
                 $data["employee_workupdate"] = RotaEmployee::where(
                "employee_id",
                "=",
                $users->employee_id
            )
                ->orderBy("date", "DESC")
                ->get();
                 $data["user_type"]="employee";
                  return view("employee-corner/work-update", $data);
               
           }
            
        } else {
            return redirect("/");
        }
    }
    
    public function viewaddworkupdateget($id){
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
                $data["employee_type"]=$users->user_type;
                $data['employee_type'];
            $data["Roledata"] = DB::table("registration")
                ->where("reg", "=", $users->employee_id)
                ->orwhere("reg", "=", $users->emid)
                ->first();
        $data['work_data']=RotaEmployee::where('id',$id)->first();
        //dd($data['work_data']);
         return view("employee-corner/work-edit", $data);
        }else{
          return redirect("/"); 
        }
    }
    
   public function viewtaskupdate(Request $request){
    //   dd($request->all());
         if (!empty(Session::get("emp_email"))) {
             $arrayData=array(
                 "in_time"=>$request->in_time,
                 "out_time"=>$request->out_time,
                 "w_hours"=>$request->w_hours,
                 "w_min"=>$request->w_min,
                 "remarks"=>$request->remarks,
                 "cmd"=>$request->cmd
                 );
                //  dd($arrayData);
            $data=RotaEmployee::where("id",$request->workId)->update($arrayData);
           return redirect("employee-corner/work-update");
        }else{
          return redirect("/");  
    }
   }
   

    public function viewaddworkupdate()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
        // dd($users);
            $data["Roledata"] = DB::table("registration")
                ->where("reg", "=", $users->employee_id)
                ->orwhere("reg", "=", $users->emid)
                ->first();
                // dd($data["Roledata"]);

            $data["employee"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->orwhere("emid", "=", $users->employee_id)
                ->first();
                // dd($data["employee"]);

            $data["employee_workupdate"] = DB::table("rota_employee")
                ->where("employee_id", "=", $users->employee_id)
                ->orderBy("date", "DESC")
                ->get();
                // dd($data["employee_workupdate"]);
            //dd($data);
            return view("employee-corner/work-add", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewtasksave(Request $request)
    {
        try {
            // dd($request->reg);
            $Employee1 = UserModel::where(
                "employee_id",
                "=",
                $request->reg
            )
                // ->where("employee_id", "=", $request->reg)
                ->where("status", "=", "active")
                ->first();
            //   dd($Employee1); 

            $data["Roledata"] = Registration::where(
                "reg",
                "=",
                $Employee1->employee_id
            )->first();
      
            $data["employee"] = Employee::where(
                "emp_code",
                "=",
                $request->employee_code
            )
                ->where("emid", "=", $request->reg)
                ->first();

            $tot = $request->w_min + $request->w_hours * 60;
            if ($request->has("file")) {
                $file_ps_doc = $request->file("file");
                $extension_ps_doc = $request->file->extension();
                $path_ps_doc = $request->file->store("tasks", "public");
            } else {
                $path_ps_doc = "";
            }

            $datagg = [
                "employee_id" => $request->employee_code,
                "emid" => $request->reg,
                "file" => $path_ps_doc,

                "w_hours" => $request->w_hours,
                "w_min" => $request->w_min,
                "in_time" => date("h:i A", strtotime($request->in_time)),
                "out_time" => date("h:i A", strtotime($request->out_time)),
                "min_tol" => $tot,
                "date" => date("Y-m-d", strtotime($request->date)),

                "remarks" => $request->remarks,
                "cr_date" => date("Y-m-d"),
            ];
            // dd($datagg);

            RotaEmployee::insert($datagg);

            Session::flash("message", " Tasks Added Successfully .");

            return redirect("employee-corner/work-update");
            // return response()->json(['msg' => 'Task Information Successfully saved.', 'status' => 'true']);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
}
