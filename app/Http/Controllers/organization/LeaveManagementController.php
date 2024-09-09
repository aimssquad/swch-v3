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

    public function viewdash()
    {
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $data["leave_type_tot"] = DB::Table("leave_rule")

                    ->join(
                        "leave_type",
                        "leave_rule.leave_type_id",
                        "=",
                        "leave_type.id"
                    )

                    ->select(
                        "leave_rule.*",
                        "leave_type.leave_type_name",
                        "leave_type.alies"
                    )

                    ->where("leave_rule.emid", "=", $data["Roledata"]->reg)
                    ->get();
                $data["leave_rule_tot"] = DB::Table("leave_rule")

                    ->join(
                        "leave_type",
                        "leave_rule.leave_type_id",
                        "=",
                        "leave_type.id"
                    )

                    ->select(
                        "leave_rule.*",
                        "leave_type.leave_type_name",
                        "leave_type.alies"
                    )
                    ->where("leave_rule_status", "=", "active")
                    ->where("leave_rule.emid", "=", $data["Roledata"]->reg)
                    ->get();
                return view($this->_routePrefix . '.dashboard',$data);
                //return View("leave/dashboard", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
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


    public function getLeaveRules()
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
                   
                // $data["leave_rule_rs"] = LeaveRule::join(
                //     "leave_type",
                //     "leave_rule.leave_type_id",
                //     "=",
                //     "leave_type.id"
                // )
                // ->join('employ_type_master','leave_rule.employee_type','employ_type_master.id')
                //     ->select("leave_rule.*", "leave_type.leave_type_name",'employ_type_master.employ_type_name')
                //     ->where("leave_rule_status", "=", "active")
                //     ->where("leave_rule.emid", "=", $Roledata->reg)
                //     ->orderBy("leave_rule.id", "desc")
                //     ->get();
                // dd($data['leave_rule_rs']);
                $data["leave_rule_rs"] = LeaveRule::join(
                    "leave_type",
                    "leave_rule.leave_type_id",
                    "=",
                    "leave_type.id"
                )
                ->join('employ_type_master','leave_rule.employee_type','employ_type_master.employ_type_id')
                ->select("leave_rule.*", "leave_type.leave_type_name",'employ_type_master.employ_type_name')
                ->where("leave_rule_status", "=", "active")
                ->where("leave_rule.emid", "=", $Roledata->reg)
                ->orderBy("leave_rule.id", "desc")
                ->get();
                //dd($Roledata->reg);
                // dd($data['leave_rule_rs']);

                //return view("leave/leave-rule", $data);
                return view($this->_routePrefix . '.leave-rule',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function leaveRules()
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
                    ->where("leave_type_status", "=", "active")
                    ->select("id", "leave_type_name")
                    ->get();
                   
                $data["employee_type_rs"] = EmployeeType::where('emid',$Roledata->reg)->get();
                //dd($data["employee_type_rs"]);
                return view($this->_routePrefix . '.add-new-rule',$data);
                //return view("leave/add-new-rule", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddLeaveRule(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                //dd($request->all());
                $email = Session::get("emp_email");
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $validator = Validator::make(
                    $request->all(),
                    [
                        "leave_type_id" => "required|max:255",

                        "max_no" => "required|max:10",
                        //'employee_type'=>'required',

                        "effective_from" => "required",
                        "effective_to" => "required",
                    ],
                    [
                        "leave_type_id.required" => "Leave Type Name Required",
                        "max_no.required" => "Maximum No. Required",
                        //'employee_type.required'=>'Employee Type Required',

                        "effective_from.required" => "Effective From Required",
                        "effective_to.required" => "Effective To Required",
                    ]
                );

                if ($validator->fails()) {
                    return redirect("leave/save-leave-rule")
                        ->withErrors($validator)
                        ->withInput();
                        //dd('check');
                }
                //dd('not check');
                $data = $request->all();

                if (!empty($request->id)) {
                    DB::table("leave_rule")
                        ->where("id", $request->id)
                        ->update([
                            "leave_type_id" => $request->leave_type_id,
                            "max_no" => $request->max_no,
                            "employee_type" => $request->employee_type,
                            "effective_from" => $request->effective_from,
                            "updated_at" => date("Y-m-d h:i:s"),
                            "created_at" => date("Y-m-d h:i:s"),
                            "leave_rule_status" => "active",
                            "effective_to" => $request->effective_to,
                        ]);
                    Session::flash(
                        "message",
                        "Leave Rule Information Successfully Updated."
                    );
                } else {
                    // dd($request->all());
                    $data = [
                        "leave_type_id" => $request->leave_type_id,
                        "max_no" => $request->max_no,

                        "employee_type" => $request->employee_type,

                        "effective_from" => $request->effective_from,
                        "effective_to" => $request->effective_to,
                        "updated_at" => date("Y-m-d h:i:s"),
                        "created_at" => date("Y-m-d h:i:s"),
                        "leave_rule_status" => "active",
                        "emid" => $Roledata->reg,
                    ];

                    $check_entry = LeaveRule::where("emid", "=", $Roledata->reg)
                        ->where("employee_type", "=", $request->employee_type)
                        ->where("leave_type_id", "=", $request->leave_type_id)
                        ->where("effective_from", "=", $request->effective_from)
                        ->where("effective_to", "=", $request->effective_to)
                        ->first();
                    if (empty($check_entry)) {
                        LeaveRule::insert($data);
                        Session::flash(
                            "message",
                            "Leave Rule Information Successfully Saved."
                        );
                    } else {
                        Session::flash(
                            "message",
                            "Leave Rule Information alredy Exists."
                        );
                        return redirect("leave/leave-rule-listing");
                    }
                }

                return redirect("leave/leave-rule-listing");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getLeaveRulesById($leave_rule_id)
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

                $data["leave_rule_data"] = LeaveRule::where(
                    "id",
                    $leave_rule_id
                )->first();
            //   dd($data["leave_rule_data"]);
                $data["leave_type_rs"] = LeaveType::where(
                    "emid",
                    "=",
                    $Roledata->reg
                )
                    ->where("leave_type_status", "=", "active")
                    ->select("id", "leave_type_name")
                    ->get();
                $data["employee_type_rs"] = DB::Table("employ_type_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                // dd($data["employee_type_rs"]);
                //return view("leave/add-new-rule", $data);
                return view($this->_routePrefix . '.add-new-rule',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getLeaveAllocation()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $data["leave_allocation"] = DB::table("leave_allocation")
                    ->join(
                        "leave_type",
                        "leave_allocation.leave_type_id",
                        "=",
                        "leave_type.id"
                    )
                    ->select("leave_allocation.*", "leave_type.leave_type_name")
                    ->whereYear("leave_allocation.created_at", "=", date("Y"))
                    ->where("leave_allocation.emid", "=", $Roledata->reg)
                    ->where("leave_type.emid", "=", $Roledata->reg)
                    ->orderBy("leave_allocation.id", "desc")
                    ->get();
                    // dd($data["leave_allocation"]);
                return view($this->_routePrefix . '.leave-allocation',$data);
                //return view("leave/leave-allocation", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddLeaveAllocation()
	{   try{
	      if(!empty(Session::get('emp_email')))
      {
         

		$email = Session::get('emp_email'); 
		   $data['Roledata'] = Registration::where('status','=','active')      
                 
                  ->where('email','=',$email) 
                  ->first();
				   $email = Session::get('emp_email'); 
		   $Roledata = Registration::where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
		
		$data['result']	='';
        $data['employees']=Employee::where('emid','=',$Roledata->reg)->get();
		$data['employee_type_rs']=EmployeeType::where('emid',$Roledata->reg)->get();
        //dd($data['employee_type_rs']);
		
		//return view('leave/add-new-allocation', $data);
        return view($this->_routePrefix . '.add-new-allocation',$data);
      }
       else
       {
              return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
	}

    public function getAddLeaveAllocation(Request $request)
	{   
        dd('working');
        try{ 
        if(!empty(Session::get('emp_email')))
        {
            $email = Session::get('emp_email'); 
            $data['Roledata'] = Registration::where('status','=','active')      
                    ->where('email','=',$email) 
                    ->first();
                    $email = Session::get('emp_email'); 
            $Roledata = Registration::where('status','=','active')       
                    
                    ->where('email','=',$email) 
                    ->first();

            $current_year=date('Y');
            $previous_year=$current_year-1;
        
            $desig_rs=EmployeeType::where('employ_type_name', '=',$request->employee_type)
            ->where('emid',$Roledata->reg)
            ->first();
                //     $desig_rs=DB::table('employ_type_master')
                // 	  ->where('emid',$Roledata->reg)
                // 	  ->where('employ_type_name',$request->employee_type)
                // 	  ->first();
                    // dd($desig_rs);
            if($request->employee_code!=''){
                $employeesy=Employee::where('emp_code','=',$request->employee_code) ->where('emid', '=',  $Roledata->reg)->get();
            }else{
                $employeesy=Employee::where('emid', '=',  $Roledata->reg)->get();
            }
    
            $leave_allocations=LeaveRule::leftJoin('leave_type','leave_rule.leave_type_id','=','leave_type.id')
            ->where('leave_type.emid','=',$Roledata->reg) 
            ->whereYear('effective_from','<=',$request->year_value.'-01-01')
            ->whereYear('effective_to','>=',$request->year_value.'-12-31')
            ->where('leave_rule.employee_type', '=',  $desig_rs->employ_type_id)
            ->select('leave_rule.*','leave_type.leave_type_name')->get();
            // 		dd($leave_allocations);
            // dd($employeesy);
        
            $result='';
            $i=1;	
            foreach ($employeesy as $employeesyg){
                
                    foreach($leave_allocations as $leave_allocationkey=>$leave_allocation){
                    
                    //->where('month_yr','=',date('m').'/'.date('Y')) 

                    $leave_allocationew=DB::Table('leave_allocation')
                    ->where('emid','=',$Roledata->reg) 
                    ->where('month_yr','like','%'.$request->year_value.'%')
                    ->where('leave_rule_id','=',$leave_allocation->id) 
                    ->where('employee_code', '=', $employeesyg->emp_code)
                    ->first();
                    // dd($leave_allocationew);
                    if(empty($leave_allocationew)){
            
                        $leave_in_hand=$leave_allocation->max_no;

                        $result .='<tr>
                            <input type="hidden" value="'.$leave_allocation->leave_type_id.'" class="form-control" name="leave_type_id'.$i.'"  id="leave_type_id'.$i.'" readonly>


                            <input type="hidden" value="'.$desig_rs->id.'" class="form-check-input" name="employee_type'.$i.'" id="employee_type'.$i.'"  readonly>
                            <input type="hidden" value="'.$employeesyg->emp_code.'" class="form-check-input" name="employee_code'.$i.'" id="employee_code'.$i.'"  readonly>
                            <td><div class="form-check"><label class="form-check-label"><input type="checkbox" name="leave_rule_id[]" value="'.$leave_allocation->id.'"  id="leave_rule_id'.$i.'" ><span class="form-check-sign"> </span></label></div></td>
                            <td>'.$desig_rs->employ_type_name.'</td>
                            
                            <td>'.$employeesyg->emp_code.'</td>
                            <td>'.$employeesyg->emp_fname.' '.$employeesyg->emp_mname.' '.$employeesyg->emp_lname.'</td>
                            <td>'.$leave_allocation->leave_type_name.'</td>
                            <td><input type="text" value="'.$leave_allocation->max_no.'" name="max_no'.$i.'" class="form-control" id="max_no'.$i.'"  readonly style="height: 35px !important"></td>
                            
                            
                            <td><input type="text" id="leave_in_hand'.$i.'" value="'.$leave_in_hand.'" name="leave_in_hand'.$i.'" class="form-control" style="height: 35px !important" required></td>
                            <td><input type="month" id="month_yr'.$i.'"  name="month_yr'.$i.'" class="form-control"  style="height: 35px !important"  required>
                            </td>

                        </tr>';
                        $i++;
                    }
                }
                    
            }
            $employees=Employee::where('emid','=',$Roledata->reg)
                // ->where('status','=','active')
                // ->where('emp_status','!=','TEMPORARY')
                // ->where('emp_status','!=','EX-EMPLOYEE')
                ->orderBy('emp_fname', 'asc')
                // ->where('emp_status', '=',  $desig_rs->employee_type_name)
                ->get();
                // dd($employees);
            
            $employee_type_rs=EmployeeType::where('emid','=',$Roledata->reg)->get();
            $remp=$request->employee_code;
            $rempty=$request->employee_type;
            return view($this->_routePrefix . '.add-new-allocation',compact('result','Roledata','employees','employee_type_rs','remp','rempty'));
            //return view('leave/add-new-allocation',compact('result','Roledata','employees','employee_type_rs','remp','rempty'));
        } else {
                return redirect('/');
        }
	    }catch(Exception $e){
	         return redirect('leave/save-leave-allocation');
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

	}


    public function saveAddLeaveAllocation(Request $request)
    {
        //dd('Working On this route');
        try {
           
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $allocation_list = $request->all();
                if (
                    isset($allocation_list["leave_rule_id"]) &&
                    count($allocation_list["leave_rule_id"]) != 0
                ) {
                    $g = 1;
                    foreach (
                        $allocation_list["leave_rule_id"]
                        as $allocationkey => $allocation_value
                    ) {
                        $data = [
                            "leave_type_id" =>
                                $allocation_list["leave_type_id" . $g],
                            "leave_rule_id" => $allocation_value,
                            "max_no" => $allocation_list["max_no" . $g],
                            "employee_type" =>
                                $allocation_list["employee_type" . $g],
                            "leave_in_hand" =>
                                $allocation_list["leave_in_hand" . $g],
                            "month_yr" => date(
                                "m/Y",
                                strtotime(
                                    $allocation_list["month_yr" . $g] . "-01"
                                )
                            ),
                            "employee_code" =>
                                $allocation_list["employee_code" . $g],
                            "updated_at" => date("Y-m-d h:i:s"),
                            "created_at" => date("Y-m-d h:i:s"),
                            "leave_allocation_status" => "active",
                            "emid" => $Roledata->reg,
                        ];

                        $leave_month = $this->getLeaveAllocationByYear(
                            $allocation_value,
                            $allocation_list["employee_code" . $g],
                            $allocation_list["month_yr" . $g]
                        );

                        if (empty($leave_month)) {
                            DB::table("leave_allocation")->insert($data);
                        } else {
                            Session::flash(
                                "message",
                                "Leave Allocation Information Already Exits."
                            );
                            return redirect(
                                "leave/leave-allocation-listing"
                            );
                        }

                        $g++;
                    }

                    Session::flash(
                        "message",
                        "Leave Allocation Information Successfully Saved."
                    );
                    return redirect(
                        "leave/leave-allocation-listing"
                    );
                } else {
                    Session::flash("message", "Leave Allocation Not Selected.");
                    return redirect(
                        "leave/leave-allocation-listing"
                    );
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }


    public function getLeaveBalance()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $data["leave_balance_rs"] =leaveAllocation::join(
                        "leave_type",
                        "leave_allocation.leave_type_id",
                        "=",
                        "leave_type.id"
                    )
                    ->join(
                        "employee",
                        "leave_allocation.employee_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("leave_allocation.emid", "=", $Roledata->reg)
                    ->where("leave_type.emid", "=", $Roledata->reg)
                    ->select(
                        "leave_allocation.*",
                        "leave_type.leave_type_name",
                        "employee.*"
                    )
                    ->get();
                return view($this->_routePrefix . '.leave-balance',$data);
                //return view("leave/leave-balance", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function spoLeaveBalance(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $employee_rs =Employee::where("emid", "=", $Roledata->reg)

                    ->get();
                $leave_balance_rs =leaveAllocation::join(
                        "leave_type",
                        "leave_allocation.leave_type_id",
                        "=",
                        "leave_type.id"
                    )
                    ->join(
                        "employee",
                        "leave_allocation.employee_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("leave_allocation.emid", "=", $Roledata->reg)
                    ->where("leave_type.emid", "=", $Roledata->reg)
                    ->select(
                        "leave_allocation.*",
                        "leave_type.leave_type_name",
                        "employee.*"
                    )
                    ->get();
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
                    "employee_rs" => $employee_rs,
                    "leave_balance_rs" => $leave_balance_rs,
                ];

                $pdf = PDF::loadView("mypdfleavebalance", $datap);
                return $pdf->download("leavebalancereport.pdf");
                //return view($this->_routePrefix . '.leave-balance',$data);
                return redirect("leave/leave-balance");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function spoLeaveBalanceexcel(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();

                $employee_rs = Employee::where("emid", "=", $Roledata->reg)

                    ->get();
                $leave_balance_rs = leaveAllocation::join(
                        "leave_type",
                        "leave_allocation.leave_type_id",
                        "=",
                        "leave_type.id"
                    )
                    ->join(
                        "employee",
                        "leave_allocation.employee_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("leave_allocation.emid", "=", $Roledata->reg)
                    ->where("leave_type.emid", "=", $Roledata->reg)
                    ->select(
                        "leave_allocation.*",
                        "leave_type.leave_type_name",
                        "employee.*"
                    )
                    ->get();
                return Excel::download(
                    new ExcelFileExportBalance($Roledata->reg),
                    "leavebalance.xlsx"
                );

                return redirect("leave/leave-balance");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function leaveBalanceView()
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

                //return view("leave/leave-report", $data);
                return view($this->_routePrefix . '.leave-report',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function leaveBalanceReport(Request $request)
    {   
        //dd($request->all());
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $email = Session::get("emp_email");
                $Roledata =Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                    //dd($Roledata->reg);
                $employeelist = DB::table('employee')->join("leave_apply","leave_apply.employee_id",'employee.emp_code')
                    ->join("leave_type","leave_type.id","leave_apply.leave_type")
                    ->select(
                        "employee.emp_code",
                        "employee.emp_fname",
                        "employee.emp_mname",
                        "employee.emp_lname",
                        "employee.emp_designation",
                        "employee.emid",
                        "leave_apply.no_of_leave",
                        "leave_apply.status",
                        "leave_type.leave_type_name",
                         DB::raw('SUM(leave_apply.no_of_leave) as total_leave')
                        )
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->groupBy("employee.emp_code", "leave_type.leave_type_name")
                    ->get();
                
            //   $employeelist = DB::table('employee')
            //     ->join("leave_apply", "leave_apply.employee_id", 'employee.emp_code')
            //     ->join("leave_type", "leave_type.id", "leave_apply.leave_type")
            //     ->select(
            //         "employee.emp_code",
            //         "employee.emp_fname",
            //         "employee.emp_mname",
            //         "employee.emp_lname",
            //         "employee.emp_designation",
            //         "employee.emid",
            //         "leave_apply.status",
            //         "leave_type.leave_type_name"
            //         // DB::raw('SUM(leave_apply.no_of_leave) as total_leave')
            //     )
            //     ->where("employee.emid", "=", $Roledata->reg)
            //     ->where("leave_apply.status", "=", "approved")
            //     ->groupBy("employee.emp_code", "leave_type.leave_type_name")
            //     ->get();

              //dd($employeelist);
               $leave_rs = leaveAllocation::leftJoin(
                        "leave_type",
                        "leave_allocation.leave_type_id",
                        "=",
                        "leave_type.id"
                    )
                    ->leftJoin(
                        "employee",
                        "leave_allocation.employee_code",
                        "=",
                        "employee.emp_code"
                    )

                    ->whereYear(
                        "leave_allocation.created_at",
                        "=",
                        $request->year_value
                    )
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("leave_type.emid", "=", $Roledata->reg)
                    ->where("leave_allocation.emid", "=", $Roledata->reg)
                    ->select(
                        "leave_allocation.*",
                        "employee.emp_fname",
                        "employee.emp_mname",
                        "employee.emp_designation",
                        "employee.emp_lname",
                        "leave_type.leave_type_name",
                        "leave_type.id as leavetypeid"
                    )
                    ->orderBy("leave_allocation.leave_type_id", "ASC")
                    ->get();
                 //dd($leave_rs);
                $leave_type = LeaveType::orderBy("id", "ASC")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                   
                $year_value = $request->year_value;
                
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
                    "year_value" => $year_value,
                    "leave_rs" => $leave_rs,
                    "leave_type" => $leave_type,
                    "employeelist" => $employeelist,
                    "emid" => $Roledata->reg,
                ];
                // dd($datap);

                $pdf = PDF::loadView("mypdfleave", $datap);
                $pdf->setPaper("A4", "landscape");
                
                return $pdf->download("leavereport.pdf");
                return redirect("leave/leave-report");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            //dd('lll');
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewleaveemplyee()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $data["Roledata"] = Registration::where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $Roledata = Registration::where("email", "=", $email)
                    ->first();

                $data["employee_rs"] =Employee::where("emid", "=", $Roledata->reg)
                    ->get();

                //return view("leave/leave-emplyee", $data);
                return view($this->_routePrefix . '.leave-emplyee',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getleaveemplyee(Request $request)
	{  
        try{
            if(!empty(Session::get('emp_email')))
            {
                
                $first_day_this_year =$request->year_value.'-01-01' ; 
                $last_day_this_year  =$request->year_value.'-12-31';
                $email = Session::get('emp_email'); 
                $data['Roledata'] =Registration::where('status','=','active')            
                        ->where('email','=',$email) 
                        ->first();
                        $Roledata= Registration::where('email','=',$email) 
                        ->first();
                $data['result'] ='';
                    $data['leaveApply']=DB::table('leave_apply')
                    ->join('leave_type','leave_apply.leave_type','=','leave_type.id') 
                    ->select('leave_apply.*','leave_type.leave_type_name','leave_type.alies')
                    ->where('leave_apply.employee_id','=',$request->employee_code)
                    ->where('leave_apply.emid','=',$data['Roledata']->reg)
                        ->where('leave_apply.status','=','APPROVED')
                    ->whereDate('leave_apply.from_date','>=',$first_day_this_year)
                    ->whereDate('leave_apply.to_date','<=',$last_day_this_year)
                    ->get(); 
                
                    if($data['leaveApply'])
                {$f=1;
                    foreach($data['leaveApply'] as $lvapply){
                        $job_details=DB::table('employee')->where('emp_code', '=', $request->employee_code)->where('emid', '=',$data['Roledata']->reg )->orderBy('id', 'DESC')->first();
        
                        $data['result'] .='<tr>
                            <td>'.$f.'</td>
                            <td>'.$lvapply->employee_id.'</td>
                            <td>'.$job_details->emp_fname.'  '.$job_details->emp_mname.'  '.$job_details->emp_lname.'</td>
                            <td>'.$lvapply->leave_type_name.'</td>
                            <td>'.date("d/m/Y",strtotime($lvapply->date_of_apply)).'</td>
                            <td>'.date('d/m/Y',strtotime($lvapply->from_date)).' To  '.date('d/m/Y',strtotime($lvapply->to_date)).'</td>
                            <td>'.$lvapply->no_of_leave.'</td>
                        </tr>';
                        $f++;
                    }
                }
                $data['employee_rs']=DB::table('employee')->where('emid', '=', $data['Roledata']->reg )->get();
                        $data['employee_code']=$request->employee_code;
                $data['year_value']=$request->year_value;
                return view($this->_routePrefix . '.leave-emplyee',$data);
                //return view('leave/leave-emplyee',$data);
            }
            else
            {
                    return redirect('/');
            }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
	}

    public function postleaveemplyee(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $first_day_this_year = $request->year_value . "-01-01";
                $last_day_this_year = $request->year_value . "-12-31";

                //$data=$request->all();
                $email = Session::get("emp_email");
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $data["result"] = "";
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
                    ->where(
                        "leave_apply.employee_id",
                        "=",
                        $request->employee_code
                    )
                    ->where("leave_apply.emid", "=", $data["Roledata"]->reg)
                    ->where("leave_apply.status", "=", "APPROVED")
                    ->whereDate(
                        "leave_apply.from_date",
                        ">=",
                        $first_day_this_year
                    )
                    ->whereDate(
                        "leave_apply.to_date",
                        "<=",
                        $last_day_this_year
                    )
                    ->get();

                if ($data["leaveApply"]) {
                    $f = 1;
                    foreach ($data["leaveApply"] as $lvapply) {
                        $data["result"] .=
                            '<tr>
				<td>' .
                            $f .
                            '</td>
												<td>' .
                            $lvapply->employee_id .
                            '</td>
														<td>' .
                            $lvapply->employee_name .
                            '</td>
													<td>' .
                            $lvapply->leave_type_name .
                            '</td>
													<td>' .
                            date("d/m/Y", strtotime($lvapply->date_of_apply)) .
                            '</td>
													
													<td>' .
                            date("d/m/Y", strtotime($lvapply->from_date)) .
                            " To  " .
                            date("d/m/Y", strtotime($lvapply->to_date)) .
                            '</td>
													<td>' .
                            $lvapply->no_of_leave .
                            '</td>
													
							
						</tr>';
                        $f++;
                    }
                }

                $data["employee_rs"] = DB::table("employee")
                    ->where("emid", "=", $data["Roledata"]->reg)
                    ->get();
                $data["employee_code"] = $request->employee_code;
                $data["year_value"] = $request->year_value;

                $leave_type = DB::table("leave_type")
                    ->orderBy("id", "ASC")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $year_value = $request->year_value;

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
                    "year_value" => $data["year_value"],
                    "leaveApply" => $data["leaveApply"],
                    "emid" => $Roledata->reg,
                ];

                $pdf = PDF::loadView("mypdfleaveemplyee", $datap);

                return $pdf->download("leavereportemplyeewise.pdf");
                return view($this->_routePrefix . '.leave-emplyee',$data);
                //return view("leave/leave-emplyee", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function postleaveemplyeeexcel(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $first_day_this_year = $request->year_value . "-01-01";
                $last_day_this_year = $request->year_value . "-12-31";

                //$data=$request->all();
                $email = Session::get("emp_email");
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")

                    ->where("email", "=", $email)
                    ->first();
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["result"] = "";
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
                    ->where(
                        "leave_apply.employee_id",
                        "=",
                        $request->employee_code
                    )
                    ->where("leave_apply.emid", "=", $data["Roledata"]->reg)
                    ->where("leave_apply.status", "=", "APPROVED")
                    ->whereDate(
                        "leave_apply.from_date",
                        ">=",
                        $first_day_this_year
                    )
                    ->whereDate(
                        "leave_apply.to_date",
                        "<=",
                        $last_day_this_year
                    )
                    ->get();

                if ($data["leaveApply"]) {
                    $f = 1;
                    foreach ($data["leaveApply"] as $lvapply) {
                        $data["result"] .=
                            '<tr>
				<td>' .
                            $f .
                            '</td>
												<td>' .
                            $lvapply->employee_id .
                            '</td>
														<td>' .
                            $lvapply->employee_name .
                            '</td>
													<td>' .
                            $lvapply->leave_type_name .
                            '</td>
													<td>' .
                            date("d/m/Y", strtotime($lvapply->date_of_apply)) .
                            '</td>
													
													<td>' .
                            date("d/m/Y", strtotime($lvapply->from_date)) .
                            " To  " .
                            date("d/m/Y", strtotime($lvapply->to_date)) .
                            '</td>
													<td>' .
                            $lvapply->no_of_leave .
                            '</td>
													
							
						</tr>';
                        $f++;
                    }
                }

                $data["employee_rs"] = DB::table("employee")
                    ->where("emid", "=", $data["Roledata"]->reg)
                    ->get();
                $data["employee_code"] = $request->employee_code;
                $data["year_value"] = $request->year_value;

                $leave_type = DB::table("leave_type")
                    ->orderBy("id", "ASC")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $year_value = $request->year_value;
                return Excel::download(
                    new ExcelFileExportLeaveEmployee(
                        $year_value,
                        $request->employee_code,
                        $Roledata->reg
                    ),
                    "leaveemployeewise.xlsx"
                );
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }





}
