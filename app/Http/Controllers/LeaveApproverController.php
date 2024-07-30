<?php

namespace App\Http\Controllers;

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
    public function viewdash()
    {
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                return View("leave-approver/dashboard");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
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

                return view("leave-approver/leave-approver", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function ViewLeavePermission($id)
    {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                // $id = base64_decode(Input::get("id"));
                // dd($id);
                $id=$id;
                
                $data["LeaveApply"] = DB::table("leave_apply")
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
                    ->where("leave_apply.id", "=", $id)
                    ->where("leave_apply.emid", "=", $Roledata->reg)
                    ->get();

               

                $lv_aply = DB::table("leave_apply")
                    ->where("id", "=", $id)
                    ->pluck("employee_id");
                $lv_type = DB::table("leave_apply")
                    ->where("id", "=", $id) // dd($lv_aply);
                    ->first();
                   
                $data["Prev_leave"] = DB::table("leave_apply")
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
                    ->where("leave_apply.leave_type", "=", $lv_type->leave_type)
                    ->where("leave_apply.employee_id", "=", $lv_aply)
                    ->where("leave_apply.emid", "=", $Roledata->reg)
                    ->where("leave_apply.status", "=", "APPROVED")
                    ->orderBy("created_at", "desc")
                    ->take(4)
                    ->get();
                    
                $from = date("Y-01-01");
                $to = date("Y-12-31");
                
                $data["totleave"] = DB::table("leave_apply")

                    // ->join('leave_allocation','leave_apply.leave_type','=','leave_type.id')
                    // ->where("status", "=", "APPROVED")
                    ->select(DB::raw("SUM(no_of_leave) AS no_of_leave"))

                    ->where("leave_type", "=", $lv_type->leave_type)
                    ->where("employee_id", "=", $lv_type->employee_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->whereBetween("from_date", [$from, $to])
                    ->whereBetween("to_date", [$from, $to])
                    ->orderBy("date_of_apply", "desc")
                    ->first();
                // dd($data['totleave']);

                return view("leave-approver/leave-approved-right", $data);
            } else {
                return redirect("/");
            }
        } 
    // }

    public function SaveLeavePermission(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
              
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                   
  
                $Allocation = leaveAllocation::where("employee_code", "=", $request->employee_id)
                    ->where("leave_type_id", "=", $request->leave_type)
                    ->where("emid", "=", $Roledata->reg)

                    ->where(
                        "month_yr",
                        "like",
                        "%" . $request["month_yr"] . "%"
                    )
                    ->get();
               
                $inhand = $Allocation[0]->leave_in_hand;
               
                $lv_sanc_auth = Employee::where("emp_code", "=", $request->employee_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->first();

                if (!empty($lv_sanc_auth)) {
                  
                    $lv_sanc_auth_name = $lv_sanc_auth->leaveauthority;
                    // dd($lv_sanc_auth_name);
                } else {
                    $lv_sanc_auth_name = "";
                }

                if ($request->leave_check == "APPROVED") {
                    $lv_inhand = $inhand - $request->no_of_leave;

                    if ($lv_inhand < 0) {
                        Session::flash(
                            "message",
                            "Insufficient Leave Balance!"
                        );
                        return redirect("leave-approver/leave-request");
                    } else {
                      LeaveApply::where("id", $request->apply_id)
                            ->where("employee_id", $request->employee_id)
                            ->update([
                                "status" => $request->leave_check,
                                "status_remarks" => $request->status_remarks,
                            ]);

                            leaveAllocation::where("leave_type_id", "=", $request->leave_type)
                            ->where("employee_code", "=", $request->employee_id)
                            ->where(
                                "month_yr",
                                "like",
                                "%" . $request["month_yr"] . "%"
                            )
                            ->update(["leave_in_hand" => $lv_inhand]);
                        Session::flash(
                            "message",
                            "Leave Status updated successfully. "
                        );

                        return redirect("leave-approver/leave-request");
                    }
                } elseif ($request->leave_check == "REJECTED") {
                  LeaveApply::where("id", $request->apply_id)
                        ->where("employee_id", $request->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update([
                            "status" => $request->leave_check,
                            "status_remarks" => $request->status_remarks,
                        ]);
                    Session::flash("message", "Leave Rejected Successfully!");
                    return redirect("leave-approver/leave-request");
                } elseif ($request->leave_check == "RECOMMENDED") {
                    $lv_inhand = $inhand - $request->no_of_leave;
                    // dd($lv_inhand);
                    if ($lv_inhand < 0) {
                        Session::flash(
                            "message",
                            "Insufficient Leave Balance!"
                        );
                        return redirect("leave-approver/leave-request");
                    } else {
                        $user_id = Session::get("users_id");
                        $users = DB::table("users")
                            ->where("id", "=", $user_id)
                            ->first();

                        $emp_code = $users->employee_id;

                        $sanc_auth = DB::table("employee")
                            ->where("emp_code", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->first();

                        $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                        DB::table("leave_apply")
                            ->where("id", $request->apply_id)
                            ->where("employee_id", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->update([
                                "status" => $request->leave_check,
                                "status_remarks" => $request->status_remarks,
                                "emp_lv_sanc_auth" => $lv_sanc_auth_name,
                            ]);
                        Session::flash(
                            "message",
                            "Leave Recommended Successfully!"
                        );
                        return redirect("leave-approver/leave-request");
                    }
                } else {
                    $current_status = DB::table("leave_apply")
                        ->where("id", $request->apply_id)
                        ->first();
                    if (
                        $current_status->status == "APPROVED" &&
                        $request->leave_check == "CANCEL"
                    ) {
                        $lv_inhand = $inhand + $request->no_of_leave;
                        DB::table("leave_apply")
                            ->where("id", $request->apply_id)
                            ->where("employee_id", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->update([
                                "status" => $request->leave_check,
                                "status_remarks" => $request->status_remarks,
                            ]);

                        DB::table("leave_allocation")
                            ->where("leave_type_id", $request->leave_type)
                            ->where("emid", "=", $Roledata->reg)
                            ->where("employee_code", $request->employee_id)
                            ->update(["leave_in_hand" => $lv_inhand]);
                    } else {
                        DB::table("leave_apply")
                            ->where("id", $request->apply_id)
                            ->where("employee_id", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->update([
                                "status" => $request->leave_check,
                                "status_remarks" => $request->status_remarks,
                            ]);
                    }

                    Session::flash("message", "Leave Cancel Successfully!");
                    return redirect("leave-approver/leave-request");
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
}
