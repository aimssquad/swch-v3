<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportRota;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;
use view;
use App\Models\Employee;
use App\Models\Registration;
use App\Models\ShiftManagment;
use App\Models\Masters\Department;
use App\Models\DutyRoster;
use App\Models\Masters\Designation;
use App\Models\LatePolicy;
use App\Models\offdays;
use App\Models\GracePeriod;

class RotaController extends Controller
{
    public function viewdash()
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            return View("rota/dashboard", $data);
        } else {
            return redirect("/");
        }
    }
    public function viewvisitorlink()
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            return View("rota/visitor", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewvis($career_id)
    {
        // dd("hello");
        $data["role"] = DB::table("registration")
            ->where("status", "=", "active")
            ->where("reg", "=", base64_decode($career_id))
            ->first();

        return View("rota/application", $data);
    }

    public function savevis(Request $request)
    {
        $data = [
            "emid" => $request->reg,
            "name" => $request->name,

            "desig" => $request->desig,
            "phone_number" => $request->phone_number,
            "address" => $request->address,
            "purpose" => $request->purpose,

            "email" => $request->email,
            "time" => $request->time,
            "reff" => $request->reff,

            "date" => date("Y-m-d", strtotime($request->date)),
        ];

        DB::table("visiter_register")->insert($data);

        return redirect("visitor-register/thank-you");
    }
    public function appthankyouvis()
    {
        return View("rota/thank-you");
    }

    public function viewshift()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_type_rs"] = ShiftManagment::where("emid", "=", $Roledata->reg)
                ->get();

            return view("rota/shift-list", $data);
        } else {
            return redirect("/");
        }
    }
     public function shiftDeleted($id){
        if (!empty(Session::get("emp_email"))) {
            $data['visitor']=DB::table('shift_management')->where('id',$id)->delete();
            Session::flash(
                    "error",
                    "Shift Deleted Successfully ."
                );
            return redirect('rota/shift-management');
        }else{
            
        }
    }
    public function viewAddNewShift(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["departs"] = Department::where("emid", "=", $data["Roledata"]->reg)
                ->get();
              
            if ($request->id) {
                $duty_roaster = DutyRoster::where("emid", "=", $data["Roledata"]->reg)
                    ->where("shift_code", "=", $request->id)
                    ->get();
                // if (count($duty_roaster) > 0) {
                //     Session::flash(
                //         "error",
                //         "Shift Information in use and cannot be updated."
                //     );
                //     return redirect("rota/shift-management");
                // }

                $dt = ShiftManagment::where("id", "=", $request->id)
                    ->first();
                if (!empty($dt)) {
                    $data["shift_management"] =ShiftManagment::where("id", "=", $request->id)
                        ->first();
                    //   dd($data["shift_management"]);
                    $data["desig"] =Designation::where(
                            "id",
                            "=",
                            $data["shift_management"]->designation
                        )
                        ->get();
                    return view("rota/add-new-shift", $data);
                } else {
                    return redirect("rota/shift-management");
                }
            } else {
                return view("rota/add-new-shift", $data);
            }
        } else {
            return redirect("/");
        }
    }

    public function saveShiftData(Request $request)
    {
        //dd($request->all());
        if (!empty(Session::get("emp_email"))) {
            $department_name = strtoupper(trim($request->shift_code));
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            if ($request->id) {
                $data = [
                    "department" => $request->department,

                    "shift_des" => $request->shift_des,
                    "time_in" => $request->time_in,
                    "time_out" => $request->time_out,
                    "rec_time_in" => $request->rec_time_in,
                    "rec_time_out" => $request->rec_time_out,
                    "designation" => $request->designation,
                ];

                $dataInsert = DB::table("shift_management")
                    ->where("id", $request->id)
                    ->update($data);
                Session::flash(
                    "message",
                    "Shift Information Successfully Updated."
                );
                return redirect("rota/shift-management");
            } else {
                $ckeck_dept = DB::table("shift_management")
                    ->where("emid", $Roledata->reg)
                    ->orderBy("id", "DESC")
                    ->first();
                if (empty($ckeck_dept)) {
                    $pid = "SHIFT-001";
                } else {
                    $whatIWant = substr(
                        $ckeck_dept->shift_code,
                        strpos($ckeck_dept->shift_code, "-") + 1
                    );
                    $pid = "SHIFT-00" . ($whatIWant + 1);
                }

                $data = [
                    "department" => $request->department,
                    "shift_code" => $pid,
                    "shift_des" => $request->shift_des,
                    "time_in" => $request->time_in,
                    "time_out" => $request->time_out,
                    "rec_time_in" => $request->rec_time_in,
                    "rec_time_out" => $request->rec_time_out,
                    "designation" => $request->designation,
                    "employee_name" => $request->employee_name,
                    "emid" => $Roledata->reg,
                ];

                DB::table("shift_management")->insert($data);
                Session::flash(
                    "message",
                    "Shift Information Successfully Saved."
                );

                return redirect("rota/shift-management");
            }
        } else {
            return redirect("/");
        }
    }

    public function empdesignition($emp_department)
    {
    //  dd($emp_department);   
        $designation = Employee::where(
            "emp_designation",
            "=",
            $emp_department
        )->get();
       
        $result = "";

        $result_status1 = " <option value='' >Select</option> ";
        foreach ($designation as $val) {
            $result_status1 .=
                '<option value="' .
                $val->designation .
                '"> ' .
                $val->emp_fname.'-'. $val->emp_code.
                "</option>";
        }

        echo $result_status1;
    }

    public function viewlate()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

           $data["employee_type_rs"] = LatePolicy::join('shift_management', 'shift_management.id', '=', 'late_policy.shift_code')
               ->select('late_policy.*','shift_management.shift_code','shift_management.shift_des')
               ->where("shift_management.emid", "=", $Roledata->reg)
               ->get();
            //  dd($data["employee_type_rs"]);
            return view("rota/late-list", $data);
        } else {
            return redirect("/");
        }
    }
    public function viewvisitorregis()
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

            $data["employee_type_rs"] = DB::table("visiter_register")
                ->where("emid", "=", $Roledata->reg)
                ->orderBy("id", "DESC")
                ->get();

            return view("rota/visitor-list", $data);
        } else {
            return redirect("/");
        }
    }
    public function eitvisitorregisterlist($id){
        if (!empty(Session::get("emp_email"))) {
            $data['visitor']=DB::table('visiter_register')->where('id',$id)->first();
            // dd($data['visitor']);
            return view('rota/visitor-edit',$data);
        }else{
            
        }
    }
     public function eitvisitorregistersave(Request $request){
        if (!empty(Session::get("emp_email"))) {
           DB::table('visiter_register')->where('id',$request->visitor_id)->update([
               "name"=>$request->name,
               "desig"=>$request->desig,
               "phone_number"=>$request->phone_number,
               "email"=>$request->email,
               "address"=>$request->address,
               "purpose"=>$request->purpose,
               "date"=>$request->date,
               "time"=>$request->time,
               "reff"=>$request->reff,
               ]);
           return redirect('rota/visitor-regis');
        }else{
            
        }
    }
     public function visitorDeleted($id){
        if (!empty(Session::get("emp_email"))) {
            $data['visitor']=DB::table('visiter_register')->where('id',$id)->delete();
            return redirect('rota/visitor-regis');
        }else{
            
        }
    }
    

    public function viewAddNewlate(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["departs"] =Department::where("emid", "=", $data["Roledata"]->reg)
                ->get();
            if ($request->id) {
                $dt = LatePolicy::where("id", "=", $request->id)
                    ->first();
                if (!empty($dt)) {
                    $data["shift_management"] = LatePolicy::where("id", "=", $request->id)
                        ->first();
                    $data["desig"] = Designation::where(
                            "id",
                            "=",
                            $data["shift_management"]->designation
                        )
                        ->get();
                    $data["shiftc"] =ShiftManagment::where(
                            "id",
                            "=",
                            $data["shift_management"]->shift_code
                        )
                        ->get();
                    return view("rota/add-new-late", $data);
                } else {
                    return redirect("rota/late-policy");
                }
            } else {
                return view("rota/add-new-late", $data);
            }
        } else {
            return redirect("/");
        }
    }
    public function savelateData(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            if ($request->id) {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "max_grace" => $request->max_grace,
                    "no_allow" => $request->no_allow,
                    "no_day_red" => $request->no_day_red,

                    "designation" => $request->designation,
                ];

                $dataInsert = DB::table("late_policy")
                    ->where("id", $request->id)
                    ->update($data);
                Session::flash(
                    "message",
                    "Late Policy Information Successfully Updated."
                );
                return redirect("rota/late-policy");
            } else {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "max_grace" => $request->max_grace,
                    "no_allow" => $request->no_allow,
                    "no_day_red" => $request->no_day_red,

                    "designation" => $request->designation,
                    "emid" => $Roledata->reg,
                ];

                DB::table("late_policy")->insert($data);
                Session::flash(
                    "message",
                    "Late Policy Information Successfully Saved."
                );

                return redirect("rota/late-policy");
            }
        } else {
            return redirect("/");
        }
    }

    public function viewoffday()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_type_rs"] =offdays::where("emid", "=", $Roledata->reg)
                ->whereNotNull("shift_code")
                ->get();

            //    dd($data);

            return view("rota/offday-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddNewoffday(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["departs"] =Department::where("emid", "=", $data["Roledata"]->reg)
                ->get();
            if ($request->id) {
                $dt = offdays::where("id", "=", $request->id)
                    ->first();

                $duty_roaster = DutyRoster::where("emid", "=", $data["Roledata"]->reg)
                    ->where("shift_code", "=", $dt->shift_code)
                    ->get();
                //dd($duty_roaster);

                if (count($duty_roaster) > 0) {
                    Session::flash(
                        "error",
                        "Shift Information in use and cannot be updated."
                    );
                    return redirect("rota/offday");
                }

                if (!empty($dt)) {
                    $data["shift_management"] = offdays::where("id", "=", $request->id)
                        ->first();
                    $data["desig"] =Designation::where(
                            "id",
                            "=",
                            $data["shift_management"]->designation
                        )
                        ->get();
                    $data["shiftc"] = ShiftManagment::where(
                            "id",
                            "=",
                            $data["shift_management"]->shift_code
                        )
                        ->get();
                    return view("rota/add-new-offday", $data);
                } else {
                    return redirect("rota/offday");
                }
            } else {
                return view("rota/add-new-offday", $data);
            }
        } else {
            return redirect("/");
        }
    }

    public function saveoffdayData(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            if ($request->id) {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "sun" => $request->sun,
                    "mon" => $request->mon,
                    "tue" => $request->tue,
                    "wed" => $request->wed,

                    "thu" => $request->thu,
                    "fri" => $request->fri,
                    "sat" => $request->sat,

                    "designation" => $request->designation,
                ];

                $dataInsert = DB::table("offday")
                    ->where("id", $request->id)
                    ->update($data);
                Session::flash(
                    "message",
                    "Offday Information Successfully Updated."
                );
                return redirect("rota/offday");
            } else {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "sun" => $request->sun,
                    "mon" => $request->mon,
                    "tue" => $request->tue,
                    "wed" => $request->wed,

                    "thu" => $request->thu,
                    "fri" => $request->fri,
                    "sat" => $request->sat,

                    "designation" => $request->designation,
                    "emid" => $Roledata->reg,
                ];

                offdays::insert($data);
                Session::flash(
                    "message",
                    "Offday Information Successfully Saved."
                );

                return redirect("rota/offday");
            }
        } else {
            return redirect("/");
        }
    }

    public function viewgrace()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_type_rs"] =GracePeriod::where("emid", "=", $Roledata->reg)
                ->get();

            return view("rota/grace-period-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddNewgrace(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["departs"] = Department::where("emid", "=", $data["Roledata"]->reg)
                ->get();
            if ($request->id) {
                $dt = GracePeriod::where("id", "=", $request->id)
                    ->first();
                if (!empty($dt)) {
                    $data["shift_management"] = GracePeriod::where("id", "=", $request->id)
                        ->first();
                    $data["desig"] =Designation::where(
                            "id",
                            "=",
                            $data["shift_management"]->designation
                        )
                        ->get();
                    $data["shiftc"] = ShiftManagment::where(
                            "id",
                            "=",
                            $data["shift_management"]->shift_code
                        )
                        ->get();
                    return view("rota/add-new-grace-period", $data);
                } else {
                    return redirect("rota/grace-period");
                }
            } else {
                return view("rota/add-new-grace-period", $data);
            }
        } else {
            return redirect("/");
        }
    }
    public function savegraceData(Request $request)
    {
       
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            if ($request->id) {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "time_in" => $request->time_in,
                    "grace_time" => $request->grace_time,

                    "designation" => $request->designation,
                ];

                $dataInsert = DB::table("grace_period")
                    ->where("id", $request->id)
                    ->update($data);
                Session::flash(
                    "message",
                    "Grace Period Information Successfully Updated."
                );
                return redirect("rota/grace-period");
            } else {
                $data = [
                    "department" => $request->department,
                    "shift_code" => $request->shift_code,
                    "time_in" => $request->time_in,
                    "grace_time" => $request->grace_time,

                    "designation" => $request->designation,
                    "emid" => $Roledata->reg,
                ];

                GracePeriod::insert($data);
                Session::flash(
                    "message",
                    "Grace Period Information Successfully Saved."
                );

                return redirect("rota/grace-period");
            }
        } else {
            return redirect("/");
        }
    }

    public function viewroster()
    {
       
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["Roledata"] = Registration::where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
           
            $data["departs"] = Department::where("emid", "=", $data["Roledata"]->reg)
                ->get();
               
        $data["result"] = "";
                
          $leave_allocation_rs = DB::table("duty_roster")
                    ->join("employee", "duty_roster.employee_id", "=", "employee.emp_code")
                    ->join('shift_management','shift_management.id','duty_roster.shift_code')
                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->select("duty_roster.*","shift_management.shift_code","shift_management.shift_des","shift_management.time_in","shift_management.time_out","shift_management.rec_time_in","shift_management.rec_time_out")
                    ->get();
            //   dd($leave_allocation_rs) ;    
           
            $employee_desigrs = DB::table("designation")
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("emid", "=", $Roledata->reg)
                ->first();
            
         if ($leave_allocation_rs) {
            
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $employee_shift = DB::table("shift_management")
                        ->where("id", "=", $leave_allocation->shift_code)
                        ->first();
                    //   dd($employee_shift);
                    $employee_shift_emp = DB::table("employee")
                        ->where("emp_code", "=", $leave_allocation->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();
                        // dd($employee_shift_emp);
                    $data["result"] .=
                        '<tr>

				<td>' .
                        $employee_shift_emp->emp_department .
                        '</td>
				<td>' .
                        $employee_shift_emp->emp_designation .
                        '</td>
													<td>' .
                        $employee_shift_emp->emp_fname .
                        "  " .
                        $employee_shift_emp->emp_mname .
                        "  " .
                        $employee_shift_emp->emp_lname .
                        " (" .
                        $leave_allocation->employee_id .
                        ')</td>
														<td>' .
                        $leave_allocation->shift_code .
                        "  ( " .
                        $leave_allocation->shift_des .
                        ' )</td>


													<td>' .
                        date("h:i a", strtotime($leave_allocation->time_in)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($leave_allocation->time_out)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($leave_allocation->rec_time_in)) .
                        '</td>
													<td>' .
                        date(
                            "h:i a",
                            strtotime($leave_allocation->rec_time_out)
                        ) .
                        '</td>
														<td>' .
                        date(
                            "d/m/Y",
                            strtotime($leave_allocation->start_date)
                        ) .
                        '</td>
															<td>' .
                        date("d/m/Y", strtotime($leave_allocation->end_date)) .
                        '</td>



						</tr>';
                    $f++;
                }
            }
           
            

            return view("rota/roster-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function saverosterData(Request $request)
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

            $employee_code = $request->employee_code;
            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = DB::table("designation")
                ->where("id", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("id", "=", $department)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $date = date("Y-m-d", strtotime($request->date));
            //echo $Roledata->reg;
            $data["result"] = "";
            if ($employee_code != "") {
             
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join("employee", "duty_roster.employee_id", "=", "employee.emp_code")
                    ->join('shift_management','shift_management.id','duty_roster.shift_code')
                    ->where("duty_roster.employee_id", "=", $employee_code)
                    ->where("employee.emp_code", "=", $employee_code)
                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("employee.emp_designation", "=", $employee_desigrs->designation_name)
                    ->where("employee.emp_department", "=", $employee_depers->department_name)
                    ->whereDate('duty_roster.start_date', '<=', date("Y-m-d", strtotime($request->start_date)))
                    ->whereDate('duty_roster.end_date', '>=', date("Y-m-d", strtotime($request->end_date)))
                     ->select("duty_roster.*","shift_management.shift_code","shift_management.shift_des","shift_management.time_in","shift_management.time_out","shift_management.rec_time_in","shift_management.rec_time_out")
                    ->get();
                    // dd($leave_allocation_rs);
                    
            } else {
                //  ->join('shift_management','shift_management.id','duty_roster.shift_code')
                //     ->where("duty_roster.emid", "=", $Roledata->reg)
                //     ->where("employee.emid", "=", $Roledata->reg)
                //     ->select("duty_roster.*","shift_management.shift_code","shift_management.shift_des","shift_management.time_in","shift_management.time_out","shift_management.rec_time_in","shift_management.rec_time_out")
                    
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join(
                        "employee",
                        "duty_roster.employee_id",
                        "=",
                        "employee.emp_code"
                    )
                    ->join('shift_management','shift_management.id','duty_roster.shift_code')
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where(
                        "employee.emp_designation",
                        "=",
                        $employee_desigrs->designation_name
                    )
                    ->where(
                        "employee.emp_department",
                        "=",
                        $employee_depers->department_name
                    )
                    ->where(
                        "duty_roster.start_date",
                        ">=",
                        date("Y-m-d", strtotime($request->start_date))
                    )
                    ->where(
                        "duty_roster.end_date",
                        "<=",
                        date("Y-m-d", strtotime($request->end_date))
                    )
                    ->select("duty_roster.employee_id","shift_management.shift_des")
                    ->get();
            }
           
            
            if ($leave_allocation_rs) {
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $employee_shift = DB::table("shift_management")
                        ->where("id", "=", $leave_allocation->shift_code)

                        ->first();
                    $employee_shift_emp = DB::table("employee")
                        ->where("emp_code", "=", $leave_allocation->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();
                       
                    $data["result"] .=
                        '<tr>

				<td>' .
                        $employee_depers->department_name .
                        '</td>
				<td>' .
                        $employee_desigrs->designation_name .
                        '</td>
													<td>' .
                        $employee_shift_emp->emp_fname .
                        "  " .
                        $employee_shift_emp->emp_mname .
                        "  " .
                        $employee_shift_emp->emp_lname .
                        " (" .
                        $leave_allocation->employee_id .
                        ')</td>
														<td>' .
                        $leave_allocation->shift_code .
                        "  ( " .
                        $leave_allocation->shift_des .
                        ' )</td>


													<td>' .
                        date("h:i a", strtotime($leave_allocation->time_in)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($leave_allocation->time_out)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($leave_allocation->rec_time_in)) .
                        '</td>
													<td>' .
                        date(
                            "h:i a",
                            strtotime($leave_allocation->rec_time_out)
                        ) .
                        '</td>
														<td>' .
                        date(
                            "d/m/Y",
                            strtotime($leave_allocation->start_date)
                        ) .
                        '</td>
															<td>' .
                        date("d/m/Y", strtotime($leave_allocation->end_date)) .
                        '</td>



						</tr>';
                    $f++;
                }
            }
            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();
            $data["departs"] = DB::table("department")
                ->where("emid", "=", $data["Roledata"]->reg)
                ->get();

            $data["employee_code"] = $request->employee_code;
            $data["department"] = $request->department;
            $data["designation"] = $request->designation;
            $data["designation"] = $request->designation;
            $data["start_date"] = date(
                "Y-m-d",
                strtotime($request->start_date)
            );

            $data["end_date"] = date("Y-m-d", strtotime($request->end_date));
            return view("rota/roster-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddNewdepartmentduty()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["departs"] = DB::table("department")
                ->where("emid", "=", $data["Roledata"]->reg)
                ->get();

            return view("rota/add-new-department-roster", $data);
        } else {
            return redirect("/");
        }
    }

    public function savedepartmentdutyData(Request $request)
    {
        //dd($request->all());
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = DB::table("designation")
                ->where("id", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("id", "=", $department)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_duty_ros = DB::table("duty_roster")
                ->where("department", "=", $department)
                ->where("designation", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->where(
                    "end_date",
                    ">=",
                    date("Y-m-d", strtotime($request->start_date))
                )

                ->get();
                //dd($employee_duty_ros);
            $emp_dury = [];
            if ($employee_duty_ros) {
                foreach ($employee_duty_ros as $employee_duty) {
                    $emp_dury[] = $employee_duty->employee_id;
                }
            }


            $leave_allocation_rs = DB::table("employee")

                ->where("employee.emid", "=", $Roledata->reg)

                ->where(
                    "employee.emp_designation",
                    "=",
                    $employee_desigrs->designation_name
                )
                ->where(
                    "employee.emp_department",
                    "=",
                    $employee_depers->department_name
                )

                ->get();

            if ($leave_allocation_rs) {
                $newid = 1;
                $newnid = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    if (in_array($leave_allocation->emp_code, $emp_dury)) {
                        $newid++;
                    } else {
                        $ckeck_dept = DB::table("duty_roster")
                            ->where("department", $request->department)
                            ->where("designation", $request->designation)
                            ->where("employee_id", $leave_allocation->emp_code)
                            ->where(
                                "end_date",
                                ">=",
                                date("Y-m-d", strtotime($request->start_date))
                            )

                            ->where("emid", $Roledata->reg)
                            ->first();
                        if (!empty($ckeck_dept)) {
                        } else {
                            if (
                                isset($request->shift_code) &&
                                count($request->shift_code) != 0
                            ) {
                                $newnid++;

                                foreach ($request->shift_code as $valshift) {
                                    $data = [
                                        "department" => $request->department,
                                        "shift_code" => $valshift,
                                        "employee_id" =>
                                            $leave_allocation->emp_code,

                                        "start_date" => date(
                                            "Y-m-d",
                                            strtotime($request->start_date)
                                        ),
                                        "end_date" => date(
                                            "Y-m-d",
                                            strtotime($request->end_date)
                                        ),
                                        "designation" => $request->designation,
                                        "emid" => $Roledata->reg,
                                    ];

                                    DB::table("duty_roster")->insert($data);
                                  
                                }
                            } else {
                                Session::flash(
                                    "message",
                                    "Shift is not selected"
                                );
                                return redirect("rota/duty-roster");
                            }
                        }
                    }
                }
            } else {
                Session::flash("message", "No Employee Found.");
                return redirect("rota/duty-roster");
            }
            if ($newnid > 1) {
                Session::flash(
                    "message",
                    "Duty Roster Information Successfully Saved."
                );
                return redirect("rota/duty-roster");
            }
            if ($newid > 1) {
                Session::flash(
                    "message",
                    "Department  Already Exists.  For This time Period ."
                );
                return redirect("rota/duty-roster");
            }
        } else {
            return redirect("/");
        }
    }
    public function viewAddNewemployeeduty()
    {
        // dd("hello");
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["departs"] = DB::table("department")
                ->where("emid", "=", $data["Roledata"]->reg)
                ->get();

            return view("rota/add-new-employee-roster", $data);
        } else {
            return redirect("/");
        }
    }
    public function saveemployeedutyData(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = DB::table("designation")
                ->where("id", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("id", "=", $department)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_duty_ros = DB::table("duty_roster")
                ->where("department", "=", $department)
                ->where("designation", "=", $designation)
                ->where("employee_id", "=", $request->employee_id)
                ->where(
                    "end_date",
                    ">=",
                    date("Y-m-d", strtotime($request->start_date))
                )

                ->where("emid", "=", $Roledata->reg)
                ->first();

            if (!empty($employee_duty_ros)) {
                Session::flash(
                    "message",
                    "Employee Id  Already Exists For This time Period ."
                );
                return redirect("rota/duty-roster");
            } else {
                if (
                    isset($request->shift_code) &&
                    count($request->shift_code) != 0
                ) {
                    foreach ($request->shift_code as $valshift) {
                        $data = [
                            "department" => $request->department,
                            "shift_code" => $valshift,
                            "employee_id" => $request->employee_id,
                            "start_date" => date(
                                "Y-m-d",
                                strtotime($request->start_date)
                            ),
                            "end_date" => date(
                                "Y-m-d",
                                strtotime($request->end_date)
                            ),

                            "designation" => $request->designation,
                            "emid" => $Roledata->reg,
                        ];

                        DB::table("duty_roster")->insert($data);
                    }

                    Session::flash(
                        "message",
                        "Duty Roster Of Employee Information Successfully Saved."
                    );
                    return redirect("rota/duty-roster");
                } else {
                    Session::flash("message", "Shift is not selected");
                    return redirect("rota/duty-roster");
                }
            }
        } else {
            return redirect("/");
        }
    }
    public function savereportroData(Request $request)
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

            $employee_code = $request->employee_code;
            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = DB::table("designation")
                ->where("id", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("id", "=", $department)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $date = date("Y-m-d", strtotime($request->date));

            $data["result"] = "";
            if ($employee_code != "") {
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join(
                        "employee",
                        "duty_roster.employee_id",
                        "=",
                        "employee.emp_code"
                    )
                    ->where("duty_roster.employee_id", "=", $employee_code)
                    ->where("employee.emp_code", "=", $employee_code)
                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where(
                        "employee.emp_designation",
                        "=",
                        $employee_desigrs->designation_name
                    )
                    ->where(
                        "employee.emp_department",
                        "=",
                        $employee_depers->department_name
                    )
                    ->where(
                        "duty_roster.start_date",
                        ">=",
                        date("Y-m-d", strtotime($request->start_date))
                    )
                    ->where(
                        "duty_roster.end_date",
                        "<=",
                        date("Y-m-d", strtotime($request->end_date))
                    )
                    ->select("duty_roster.*")
                    ->get();
            } else {
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join(
                        "employee",
                        "duty_roster.employee_id",
                        "=",
                        "employee.emp_code"
                    )

                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where(
                        "employee.emp_designation",
                        "=",
                        $employee_desigrs->designation_name
                    )
                    ->where(
                        "employee.emp_department",
                        "=",
                        $employee_depers->department_name
                    )
                    ->where(
                        "duty_roster.start_date",
                        ">=",
                        date("Y-m-d", strtotime($request->start_date))
                    )
                    ->where(
                        "duty_roster.end_date",
                        "<=",
                        date("Y-m-d", strtotime($request->end_date))
                    )
                    ->select("duty_roster.*")
                    ->get();
            }

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
                "emid" => $Roledata->reg,
                "leave_allocation_rs" => $leave_allocation_rs,
                "designation_name" => $employee_desigrs->designation_name,
                "department_name" => $employee_depers->department_name,
            ];

            $pdf = PDF::loadView("mypdfrorareport", $datap);
            return $pdf->download("dutyrostereport.pdf");

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $employee_shift = DB::table("shift_management")
                        ->where("id", "=", $leave_allocation->shift_code)

                        ->first();
                    $employee_shift_emp = DB::table("employee")
                        ->where("emp_code", "=", $leave_allocation->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();
                    $data["result"] .=
                        '<tr>

				<td>' .
                        $employee_depers->department_name .
                        '</td>
				<td>' .
                        $employee_desigrs->designation_name .
                        '</td>
													<td>' .
                        $employee_shift_emp->emp_fname .
                        "  " .
                        $employee_shift_emp->emp_mname .
                        "  " .
                        $employee_shift_emp->emp_lname .
                        " (" .
                        $leave_allocation->employee_id .
                        ')</td>
														<td>' .
                        $employee_shift->shift_code .
                        '</td>


													<td>' .
                        date("h:i a", strtotime($employee_shift->time_in)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($employee_shift->time_out)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($employee_shift->rec_time_in)) .
                        '</td>
													<td>' .
                        date(
                            "h:i a",
                            strtotime($employee_shift->rec_time_out)
                        ) .
                        '</td>
														<td>' .
                        date(
                            "d/m/Y",
                            strtotime($leave_allocation->start_date)
                        ) .
                        '</td>
															<td>' .
                        date("d/m/Y", strtotime($leave_allocation->end_date)) .
                        '</td>



						</tr>';
                    $f++;
                }
            }
            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();
            $data["departs"] = DB::table("department")
                ->where("emid", "=", $data["Roledata"]->reg)
                ->get();

            $data["employee_code"] = $request->employee_code;
            $data["department"] = $request->department;
            $data["designation"] = $request->designation;
            $data["designation"] = $request->designation;
            $data["start_date"] = date(
                "Y-m-d",
                strtotime($request->start_date)
            );

            $data["end_date"] = date("Y-m-d", strtotime($request->end_date));
            return view("rota/roster-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function savereportroexcelData(Request $request)
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

            $employee_code = $request->employee_code;
            $department = $request->department;
            $designation = $request->designation;

            $employee_desigrs = DB::table("designation")
                ->where("id", "=", $designation)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $employee_depers = DB::table("department")
                ->where("id", "=", $department)
                ->where("emid", "=", $Roledata->reg)
                ->first();
            $date = date("Y-m-d", strtotime($request->date));

            $data["result"] = "";
            if ($employee_code != "") {
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join(
                        "employee",
                        "duty_roster.employee_id",
                        "=",
                        "employee.emp_code"
                    )
                    ->where("duty_roster.employee_id", "=", $employee_code)
                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where(
                        "employee.emp_designation",
                        "=",
                        $employee_desigrs->designation_name
                    )
                    ->where(
                        "employee.emp_department",
                        "=",
                        $employee_depers->department_name
                    )
                    ->where(
                        "duty_roster.start_date",
                        ">=",
                        date("Y-m-d", strtotime($request->start_date))
                    )
                    ->where(
                        "duty_roster.end_date",
                        "<=",
                        date("Y-m-d", strtotime($request->end_date))
                    )
                    ->select("duty_roster.*")
                    ->get();
            } else {
                $leave_allocation_rs = DB::table("duty_roster")
                    ->join(
                        "employee",
                        "duty_roster.employee_id",
                        "=",
                        "employee.emp_code"
                    )

                    ->where("duty_roster.emid", "=", $Roledata->reg)
                    ->where(
                        "employee.emp_designation",
                        "=",
                        $employee_desigrs->designation_name
                    )
                    ->where(
                        "employee.emp_department",
                        "=",
                        $employee_depers->department_name
                    )
                    ->where(
                        "duty_roster.start_date",
                        ">=",
                        date("Y-m-d", strtotime($request->start_date))
                    )
                    ->where(
                        "duty_roster.end_date",
                        "<=",
                        date("Y-m-d", strtotime($request->end_date))
                    )
                    ->select("duty_roster.*")
                    ->get();
            }
            $start_date = date("Y-m-d", strtotime($request->start_date));
            $end_date = date("Y-m-d", strtotime($request->end_date));
            if ($employee_code != "") {
                $new_emp = $employee_code;
            } else {
                $new_emp = "all";
            }
            return Excel::download(
                new ExcelFileExportRota(
                    $start_date,
                    $end_date,
                    $employee_depers->department_name,
                    $employee_desigrs->designation_name,
                    $new_emp,
                    $Roledata->reg
                ),
                "dutyroster.xlsx"
            );

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {
                $f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $employee_shift = DB::table("shift_management")
                        ->where("id", "=", $leave_allocation->shift_code)

                        ->first();
                    $employee_shift_emp = DB::table("employee")
                        ->where("emp_code", "=", $leave_allocation->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();
                    $data["result"] .=
                        '<tr>

				<td>' .
                        $employee_depers->department_name .
                        '</td>
				<td>' .
                        $employee_desigrs->designation_name .
                        '</td>
													<td>' .
                        $employee_shift_emp->emp_fname .
                        "  " .
                        $employee_shift_emp->emp_mname .
                        "  " .
                        $employee_shift_emp->emp_lname .
                        " (" .
                        $leave_allocation->employee_id .
                        ')</td>
														<td>' .
                        $employee_shift->shift_code .
                        '</td>


													<td>' .
                        date("h:i a", strtotime($employee_shift->time_in)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($employee_shift->time_out)) .
                        '</td>
													<td>' .
                        date("h:i a", strtotime($employee_shift->rec_time_in)) .
                        '</td>
													<td>' .
                        date(
                            "h:i a",
                            strtotime($employee_shift->rec_time_out)
                        ) .
                        '</td>
														<td>' .
                        date(
                            "d/m/Y",
                            strtotime($leave_allocation->start_date)
                        ) .
                        '</td>
															<td>' .
                        date("d/m/Y", strtotime($leave_allocation->end_date)) .
                        '</td>



						</tr>';
                    $f++;
                }
            }
            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();
            $data["departs"] = DB::table("department")
                ->where("emid", "=", $data["Roledata"]->reg)
                ->get();

            $data["employee_code"] = $request->employee_code;
            $data["department"] = $request->department;
            $data["designation"] = $request->designation;
            $data["designation"] = $request->designation;
            $data["start_date"] = date(
                "Y-m-d",
                strtotime($request->start_date)
            );

            $data["end_date"] = date("Y-m-d", strtotime($request->end_date));
            return view("rota/roster-list", $data);
        } else {
            return redirect("/");
        }
    }
}
