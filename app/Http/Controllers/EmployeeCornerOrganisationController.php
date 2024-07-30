<?php

namespace App\Http\Controllers;

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
               

            return view("employeeorganisation-list", $data);
        } else {
            return redirect("/");
        }
        }else{
             return redirect()->intended(
                        "employeecornerorganisationdashboard"
                    );
        }
       
    }
    public function DoLoginorganisationemployee(Request $request)
    {
        $email = Session::get("emp_email");
        // dd($request->all());
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
                        "employeecornerorganisationdashboard"
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

            return View("employee-corner-organisation/dashboard", $data);
        } else {
            return redirect("/");
        }
    }
    public function viewdetadash()
    {
         if (!empty(Session::get("emp_email"))) {
            // $user_id = Session::get("users_id_new");
           $users_ids=Session::get("users_id");
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
            return view("employee-corner-organisation/user-profile", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddEmployeeco()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();
            $data["payment_wedes_rs"] = DB::table("payment_type_wedes")
                ->where("emid", "=", $Roledata->reg)
                ->get();
            $id = Input::get("q");
            if ($id) {
                function my_simple_crypt($string, $action = "encrypt")
                {
                    // you may change these values to your own
                    $secret_key = "bopt_saltlake_kolkata_secret_key";
                    $secret_iv = "bopt_saltlake_kolkata_secret_iv";

                    $output = false;
                    $encrypt_method = "AES-256-CBC";
                    $key = hash("sha256", $secret_key);
                    $iv = substr(hash("sha256", $secret_iv), 0, 16);

                    if ($action == "encrypt") {
                        $output = base64_encode(
                            openssl_encrypt(
                                $string,
                                $encrypt_method,
                                $key,
                                0,
                                $iv
                            )
                        );
                    } elseif ($action == "decrypt") {
                        $output = openssl_decrypt(
                            base64_decode($string),
                            $encrypt_method,
                            $key,
                            0,
                            $iv
                        );
                    }

                    return $output;
                }
                ///
                //$encrypted = my_simple_crypt( 'Hello World!', 'encrypt' );
                $decrypted_id = my_simple_crypt($id, "decrypt");

                $data["employee_rs"] = DB::table("employee")
                    ->join(
                        "employee_pay_structure",
                        "employee.emp_code",
                        "=",
                        "employee_pay_structure.employee_code"
                    )
                    ->where("employee.emp_code", "=", $decrypted_id)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("employee_pay_structure.emid", "=", $Roledata->reg)
                    ->select("employee.*", "employee_pay_structure.*")
                    ->get();

                $data["employee_job_rs"] = DB::table("employee_job")
                    ->where("emp_id", "=", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                $data["employee_quli_rs"] = DB::table("employee_qualification")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_id", "=", $decrypted_id)
                    ->get();
                $data["employee_train_rs"] = DB::table("employee_training")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_id", "=", $decrypted_id)
                    ->get();

                $data["employee_upload_rs"] = DB::table("employee_upload")
                    ->where("emp_id", "=", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["currency_user"] = DB::table("currencies")
                    ->orderBy("country", "asc")
                    ->get();
                $empdepartmen = DB::table("department")
                    ->where("emid", "=", $Roledata->reg)
                    ->where(
                        "department_name",
                        "=",
                        $data["employee_rs"][0]->emp_department
                    )
                    ->where("department_status", "=", "active")
                    ->first();
                $data["department"] = DB::table("department")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("department_status", "=", "active")
                    ->get();
                if (!empty($empdepartmen)) {
                    $data["designation"] = DB::table("designation")
                        ->where("emid", "=", $Roledata->reg)
                        ->where("department_code", "=", $empdepartmen->id)
                        ->where("designation_status", "=", "active")
                        ->get();
                } else {
                    $data["designation"] = "";
                }

                $data["employee_type"] = DB::table("employee_type")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("employee_type_status", "=", "active")
                    ->get();
                $emppaygr = DB::table("pay_scale_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->where(
                        "payscale_code",
                        "=",
                        $data["employee_rs"][0]->emp_group_name
                    )
                    ->first();
                $data["grade"] = DB::table("grade")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("grade_status", "=", "active")
                    ->get();
                if (!empty($emppaygr)) {
                    $data["annul"] = DB::table("pay_scale_basic_master")
                        ->where("pay_scale_master_id", "=", $emppaygr->id)
                        ->get();
                } else {
                    $data["annul"] = "";
                }

                $data["bank"] = DB::table("bank_masters")->get();
                $data["payscale_master"] = DB::table("pay_scale_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["nation_master"] = DB::table("nationality_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["payment_type_master"] = DB::table("payment_type_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["currency_master"] = DB::table("currency_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["tax_master"] = DB::table("tax_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                $data["employeelists"] = DB::table("employee")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_code", "!=", $decrypted_id)
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
            $user_id = Session::get("users_id_new");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();
            $holidays = DB::table("holiday")

                ->where("emid", "=", $users->emid)
                ->get();

            return view(
                "employee-corner-organisation/holiday-calendar",
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
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $employee = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            $leave_type_rs = DB::table("leave_type")
                ->join(
                    "leave_allocation",
                    "leave_type.id",
                    "=",
                    "leave_allocation.leave_type_id"
                )

                ->select("leave_type.*")
                ->where("leave_type.emid", "=", $users->emid)
                ->where(
                    "leave_allocation.employee_code",
                    "=",
                    $users->employee_id
                )
                ->where("leave_allocation.emid", "=", $users->emid)
                ->get();

            $holiday_rs = DB::Table("holiday")
                ->where("emid", "=", $users->emid)
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

    public function saveApplyLeaveData(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            // dd($request);
            $user_id = Session::get("users_id");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $report_auth = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->first();
            if (!empty($report_auth)) {
                $report_auth_name = $report_auth->emp_reporting_auth;
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

            //  $request->leave_inhand;
            if ($request->leave_inhand >= $days) {
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
                $data["no_of_leave"] = $days;
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
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            return view("employee-corner-organisation/daily-status", $data);
        } else {
            return redirect("/");
        }
    }

    public function saveAttandancestatus(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id_new");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

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
                        "<br>(" .
                        date("l", strtotime($leave_allocation->date)) .
                        ')</td>
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

            return view("employee-corner-organisation/daily-status", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewchangecircumstances()
    {
        if (!empty(Session::get("emp_email"))) {
            $user_id = Session::get("users_id_new");
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

            return view(
                "employee-corner-organisation/change-of-circumstances",
                $data
            );
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
            $user_id = Session::get("users_id_new");
            $users = DB::table("users")
                ->where("id", "=", $user_id)
                ->first();

            $data["employee_rs"] = DB::table("employee")
                ->where("emp_code", "=", $users->employee_id)
                ->where("emid", "=", $users->emid)
                ->get();
            return view("employee-corner-organisation/employee", $data);
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
                ->where("status", "=", "active")
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
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            function my_simple_crypt($string, $action = "encrypt")
            {
                // you may change these values to your own
                $secret_key = "bopt_saltlake_kolkata_secret_key";
                $secret_iv = "bopt_saltlake_kolkata_secret_iv";

                $output = false;
                $encrypt_method = "AES-256-CBC";
                $key = hash("sha256", $secret_key);
                $iv = substr(hash("sha256", $secret_iv), 0, 16);

                if ($action == "encrypt") {
                    $output = base64_encode(
                        openssl_encrypt($string, $encrypt_method, $key, 0, $iv)
                    );
                } elseif ($action == "decrypt") {
                    $output = openssl_decrypt(
                        base64_decode($string),
                        $encrypt_method,
                        $key,
                        0,
                        $iv
                    );
                }

                return $output;
            }

            //print_r($request->hasFile('emp_image')); print_r($request->edit_emp_image); exit;
            if (
                !empty($request->edit_emp_image) &&
                $request->hasFile("emp_image") == 1
            ) {
                $files = $request->file("emp_image");
                $filename = $files->store("emp_pic");
            } elseif (
                empty($request->edit_emp_image) &&
                $request->hasFile("emp_image") == 1
            ) {
                $files = $request->file("emp_image");
                $filename = $files->store("emp_pic");
            } elseif (
                !empty($request->edit_emp_image) &&
                $request->hasFile("emp_image") != 1
            ) {
                $filename = $request->edit_emp_image;
            } else {
                $filename = "";
            }

            $id = Input::get("q");
            if ($id) {
                $decrypted_id = my_simple_crypt($id, "decrypt");

                $ckeck_dept = DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emp_code", "!=", $decrypted_id)
                    ->where("emid", $Roledata->reg)
                    ->first();
                if (!empty($ckeck_dept)) {
                    Session::flash(
                        "message",
                        "Employee Code Code  Already Exists."
                    );
                    return redirect("employee-corner/update-profile?q=" . $id);
                }

                $ckeck_email = DB::table("users")
                    ->where("email", "=", $request->emp_ps_email)
                    ->where("employee_id", "!=", $decrypted_id)
                    ->where("status", "=", "active")
                    ->where("emid", $Roledata->reg)
                    ->first();
                if (!empty($ckeck_email)) {
                    Session::flash("message", "E-mail id  Already Exists.");
                    return redirect("employee-corner/update-profile?q=" . $id);
                }

                if (!empty($request->emqliup)) {
                    $tot_item_edit_quli = count($request->emqliup);

                    foreach ($request->emqliup as $value) {
                        if ($request->input("quli_" . $value) != "") {
                            if ($request->has("doc_" . $value)) {
                                $extension_doc_edit = $request
                                    ->file("doc_" . $value)
                                    ->extension();
                                $path_quli_doc_edit = $request
                                    ->file("doc_" . $value)
                                    ->store("employee_quli_doc", "public");
                                $dataimgedit = [
                                    "doc" => $path_quli_doc_edit,
                                ];
                                DB::table("employee_qualification")
                                    ->where("emid", "=", $Roledata->reg)
                                    ->where("id", $value)
                                    ->update($dataimgedit);
                            }
                            if ($request->has("doc2_" . $value)) {
                                $extension_doc_edit2 = $request
                                    ->file("doc2_" . $value)
                                    ->extension();
                                $path_quli_doc_edit2 = $request
                                    ->file("doc2_" . $value)
                                    ->store("employee_quli_doc2", "public");
                                $dataimgedit = [
                                    "doc2" => $path_quli_doc_edit2,
                                ];
                                DB::table("employee_qualification")
                                    ->where("id", $value)
                                    ->where("emid", "=", $Roledata->reg)
                                    ->update($dataimgedit);
                            }
                            $dataquli_edit = [
                                "emp_id" => $decrypted_id,
                                "quli" => $request->input("quli_" . $value),
                                "dis" => $request->input("dis_" . $value),
                                "ins_nmae" => $request->input(
                                    "ins_nmae_" . $value
                                ),
                                "board" => $request->input("board_" . $value),
                                "year_passing" => $request->input(
                                    "year_passing_" . $value
                                ),
                                "perce" => $request->input("perce_" . $value),
                                "grade" => $request->input("grade_" . $value),
                            ];

                            DB::table("employee_qualification")
                                ->where("id", $value)
                                ->where("emid", "=", $Roledata->reg)
                                ->update($dataquli_edit);
                        }
                    }
                }

                if ($request->has("emp_image")) {
                    $file = $request->file("emp_image");
                    $extension = $request->emp_image->extension();
                    $path = $request->emp_image->store(
                        "employee_logo",
                        "public"
                    );
                    $dataimg = [
                        "emp_image" => $path,
                    ];
                    DB::table("employee")
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimg);
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
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
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
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimgvis);
                }

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
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimgper);
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
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimgps);
                }

                $dataupdate = [
                    "emp_fname" => strtoupper($request->emp_fname),
                    "emp_mname" => strtoupper($request->emp_mid_name),
                    "emp_lname" => strtoupper($request->emp_lname),

                    "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
                    "emp_ps_phone" => $request->emp_ps_phone,
                    "em_contact" => $request->em_contact,
                    "emp_gender" => $request->emp_gender,
                    "emp_father_name" => $request->emp_father_name,

                    "marital_status" => $request->marital_status,
                    "marital_date" => date(
                        "Y-m-d",
                        strtotime($request->marital_date)
                    ),
                    "spouse_name" => $request->spouse_name,
                    "nationality" => $request->nationality,

                    "dis_remarks" => $request->dis_remarks,
                    "cri_remarks" => $request->cri_remarks,
                    "criminal" => $request->criminal,

                    "ni_no" => $request->ni_no,
                    "emp_blood_grp" => $request->emp_blood_grp,
                    "emp_eye_sight_left" => $request->emp_eye_sight_left,
                    "emp_eye_sight_right" => $request->emp_eye_sight_right,
                    "emp_weight" => $request->emp_weight,
                    "emp_height" => $request->emp_height,
                    "emp_identification_mark_one" =>
                        $request->emp_identification_mark_one,
                    "emp_identification_mark_two" =>
                        $request->emp_identification_mark_two,
                    "emp_physical_status" => $request->emp_physical_status,

                    "em_name" => $request->em_name,
                    "em_relation" => $request->em_relation,
                    "em_email" => $request->em_email,
                    "em_phone" => $request->em_phone,
                    "em_address" => $request->em_address,

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

                    "nat_id" => $request->nat_id,
                    "place_iss" => $request->place_iss,
                    "iss_date" => $request->iss_date,
                    "exp_date" => date("Y-m-d", strtotime($request->exp_date)),
                    "pass_nation" => $request->pass_nation,
                    "country_residence" => $request->country_residence,
                    "country_birth" => $request->country_birth,
                    "place_birth" => $request->place_birth,

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
                    "eli_status" => $request->eli_status,

                    "cur_pass" => $request->cur_pass,
                    "remarks" => $request->remarks,

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
                    "visa_eli_status" => $request->visa_eli_status,

                    "visa_cur" => $request->visa_cur,
                    "visa_remarks" => $request->visa_remarks,

                    "drive_doc" => $request->drive_doc,
                    "licen_num" => $request->licen_num,
                    "lin_exp_date" => $request->lin_exp_date,

                    "emid" => $Roledata->reg,
                    "titleof_license" => $request->titleof_license,
                    "cf_license_number" => $request->cf_license_number,
                    "cf_start_date" => date(
                        "Y-m-d",
                        strtotime($request->cf_start_date)
                    ),
                    "cf_end_date" => date(
                        "Y-m-d",
                        strtotime($request->cf_end_date)
                    ),
                ];

                DB::table("employee")
                    ->where("emp_code", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataupdate);

                $tot_job_item = count($request->job_name);
                DB::table("employee_job")
                    ->where("emp_id", "=", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->delete();
                for ($i = 0; $i < $tot_job_item; $i++) {
                    if ($request->job_name[$i] != "") {
                        $datajob = [
                            "emp_id" => $decrypted_id,
                            "job_name" => $request->job_name[$i],
                            "job_start_date" => date(
                                "Y-m-d",
                                strtotime($request->job_start_date[$i])
                            ),
                            "job_end_date" => date(
                                "Y-m-d",
                                strtotime($request->job_end_date[$i])
                            ),
                            "des" => $request->des[$i],
                            "emid" => $Roledata->reg,
                            "exp" => $request->exp[$i],
                        ];
                        DB::table("employee_job")->insert($datajob);
                    }
                }

                $tot_train_item = count($request->tarin_name);
                DB::table("employee_training")
                    ->where("emp_id", "=", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->delete();

                for ($i = 0; $i < $tot_train_item; $i++) {
                    if ($request->tarin_name[$i] != "") {
                        $datatrain = [
                            "emp_id" => $decrypted_id,
                            "train_des" => $request->train_des[$i],
                            "tarin_start_date" => date(
                                "Y-m-d",
                                strtotime($request->tarin_start_date[$i])
                            ),
                            "tarin_end_date" => date(
                                "Y-m-d",
                                strtotime($request->tarin_end_date[$i])
                            ),
                            "tarin_name" => $request->tarin_name[$i],

                            "emid" => $Roledata->reg,
                        ];
                        DB::table("employee_training")->insert($datatrain);
                    }
                }

                if (!empty($request->quli)) {
                    $tot_item_quli = count($request->quli);

                    for ($i = 0; $i < $tot_item_quli; $i++) {
                        if ($request->quli[$i] != "") {
                            if ($request->has("doc")) {
                                $extension_quli_doc = $request->doc[
                                    $i
                                ]->extension();
                                $path_quli_doc = $request->doc[$i]->store(
                                    "employee_quli_doc",
                                    "public"
                                );
                            }
                            if ($request->has("doc2")) {
                                $extension_quli_doc2 = $request->doc2[
                                    $i
                                ]->extension();
                                $path_quli_doc2 = $request->doc2[$i]->store(
                                    "employee_quli_doc2",
                                    "public"
                                );
                            }
                            $dataquli = [
                                "emp_id" => $request->emp_code,
                                "quli" => $request->quli[$i],
                                "dis" => $request->dis[$i],
                                "ins_nmae" => $request->ins_nmae[$i],
                                "board" => $request->board[$i],
                                "year_passing" => $request->year_passing[$i],
                                "perce" => $request->perce[$i],
                                "grade" => $request->grade[$i],
                                "doc" => $path_quli_doc,
                                "doc2" => $path_quli_doc2,
                                "emid" => $Roledata->reg,
                            ];
                            DB::table("employee_qualification")->insert(
                                $dataquli
                            );
                        }
                    }
                }

                if (!empty($request->id_up_doc)) {
                    $tot_item_nat_edit = count($request->id_up_doc);

                    foreach ($request->id_up_doc as $valuee) {
                        if ($request->input("type_doc_" . $valuee) != "") {
                            if ($request->has("docu_nat_" . $valuee)) {
                                $extension_doc_edit_up = $request
                                    ->file("docu_nat_" . $valuee)
                                    ->extension();

                                $path_quli_doc_edit_up = $request
                                    ->file("docu_nat_" . $valuee)
                                    ->store("employee_upload_doc", "public");
                                $dataimgeditup = [
                                    "docu_nat" => $path_quli_doc_edit_up,
                                ];

                                DB::table("employee_upload")
                                    ->where("id", $valuee)
                                    ->where("emid", "=", $Roledata->reg)
                                    ->update($dataimgeditup);
                            }

                            $datauploadedit = [
                                "emp_id" => $decrypted_id,
                                "type_doc" => $request->input(
                                    "type_doc_" . $valuee
                                ),
                            ];
                            DB::table("employee_upload")
                                ->where("id", $valuee)
                                ->where("emid", "=", $Roledata->reg)
                                ->update($datauploadedit);
                        }
                    }
                }

                if (!empty($request->type_doc)) {
                    $tot_item_nat = count($request->type_doc);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->type_doc[$i] != "") {
                            if ($request->has("docu_nat")) {
                                $extension_upload_doc = $request->docu_nat[
                                    $i
                                ]->extension();
                                $path_upload_doc = $request->docu_nat[
                                    $i
                                ]->store("employee_upload_doc", "public");
                            }
                            $dataupload = [
                                "emp_id" => $decrypted_id,
                                "type_doc" => $request->type_doc[$i],
                                "emid" => $Roledata->reg,
                                "docu_nat" => $path_upload_doc,
                            ];
                            DB::table("employee_upload")->insert($dataupload);
                        }
                    }
                }

                Session::flash(
                    "message",
                    "Employee data has been successfully updated"
                );
                return redirect("employee-corner/update-profile?q=" . $id);
            }
        } else {
            return redirect("/");
        }
    }
}
