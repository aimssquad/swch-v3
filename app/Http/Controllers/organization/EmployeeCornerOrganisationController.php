<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;
use PDF;
use App\Models\Registration;
use App\Models\UserModel;
use App\Models\Employee;
use App\Models\EmployeePayStructure;

use App\Models\Masters\Cast;
use App\Models\Masters\Sub_cast;
use App\Models\Masters\Department;
use App\Models\RotaEmployee;
use App\Models\EmployeeType;
use App\Models\LeaveType;
use App\Models\LeaveRule;
use App\Models\Holiday;
use App\Models\EmployeePersonalRecord;
use App\Models\ExperienceRecords;
use App\Models\ProfessionalRecords;
use App\Models\MiscDocuments;


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
            return view($this->_routePrefix . '.holiday-calendar',compact("holidays"));
            // return view(
            //     "employee-corner/holiday-calendar",
            //     compact("holidays")
            // );
        } else {
            return redirect("/");
        }
    }

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
                return view($this->_routePrefix . '.work-update',$data);
                //return view("employee-corner/work-update", $data);

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
                return view($this->_routePrefix . '.work-update',$data);
                //return view("employee-corner/work-update", $data);
               
           }
            
        } else {
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
            return view($this->_routePrefix . '.work-add',$data);
            //return view("employee-corner/work-add", $data);
        } else {
            return redirect("/");
        }
    }

    public function gettimemintuesnew($in_time, $out_time){
        $in_time = base64_decode($in_time);
        $out_time = base64_decode($out_time);
        $st_time = date('Y-m-d') . ' ' . $in_time . ':10';
    
        $end_time = date('Y-m-d') . ' ' . $out_time . ':10';
        $t1 = Carbon::parse($st_time);
        $t2 = Carbon::parse($end_time);
        $diff = $t1->diff($t2);
        // print_r($diff);
        //print_r(str_pad($diff->i,2,"0",STR_PAD_LEFT));
        $arr = array('hour' => $diff->h, 'min' => str_pad($diff->i,2,"0",STR_PAD_LEFT));
        echo json_encode($arr);
    }


    public function viewtasksave(Request $request)
    {
        try {
            //dd($request->all());
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

            return redirect("org-employee-corner/work-update");
            // return response()->json(['msg' => 'Task Information Successfully saved.', 'status' => 'true']);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
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
            return view($this->_routePrefix . '.work-edit',$data);
            //return view("employee-corner/work-edit", $data);
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
                Session::flash("message", " Work Update Successfully .");
               return redirect("org-employee-corner/work-update");
            }else{
              return redirect("/");  
        }
    }

    public function viewAttandancestatus()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("email", "=", $email)->first();
            $data["Roledata"] = Registration::where("email","=",$email)->first();
            return view($this->_routePrefix . '.daily-status',$data);
            //return view("employee-corner/daily-status", $data); 
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
            //dd($data);
            return view($this->_routePrefix . '.daily-status',$data);
            //return view("employee-corner/daily-status", $data);
        } else {
            return redirect("/");
        }
    }






} // End Class
