<?php

namespace App\Http\Controllers\PerformanceManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PerformanceManagement\Performance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;

class PerformanceController extends Controller
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $currentUserType = Session::get('user_type');
            $data = [];
            $data['currentUserType'] = $currentUserType;
            // dd($currentUser);
            if ($currentUserType === 'employer') {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $query = $request->all();
                if (array_key_exists('status', $query)) {
                    $performanceList = Performance::select(
                        'performances.*',
                        'emp.emp_department as emp_department',
                        'emp.emp_fname as emp_fname',
                        'emp.emp_mname as emp_mname',
                        'emp.emp_lname as emp_lname',
                        'rep.emp_fname as rep_fname',
                        'rep.emp_mname as rep_mname',
                        'rep.emp_lname as rep_lname',
                    )
                        ->where('performances.emid', $Roledata->reg)
                        ->where('performances.status', $query['status'])
                        ->join('employee as emp', 'emp.emp_code', '=', 'performances.emp_code')
                        ->join('employee as rep', 'rep.emp_code', '=', 'performances.emp_reporting_auth')

                        ->get();
                    $data['performances'] = $performanceList;
                } else {
                    //dd($Roledata->reg);
                    $performanceList = Performance::select(
                        'performances.*',
                        'emp.emp_department as emp_department',
                        'emp.emp_fname as emp_fname',
                        'emp.emp_mname as emp_mname',
                        'emp.emp_lname as emp_lname',
                        'rep.emp_fname as rep_fname',
                        'rep.emp_mname as rep_mname',
                        'rep.emp_lname as rep_lname',
                    )
                        ->where('performances.emid', $Roledata->reg)
                        ->join('employee as emp', 'emp.emp_code', '=', 'performances.emp_code')
                        ->join('employee as rep', 'rep.emp_code', '=', 'performances.emp_reporting_auth')
                        ->get();
                    $data['performances'] = $performanceList;
                    
                }
            } else {
                $currentUserEmpDetails = User::select('users.*', 'e.id as emp_id', 'e.emp_code as emp_code')
                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                    ->where('users.id', $currentUser)
                    ->first();
                $query = $request->all();
                if (array_key_exists('status', $query)) {
                    $performanceList = Performance::select(
                        'performances.*',
                        'emp.emp_department as emp_department',
                        'emp.emp_fname as emp_fname',
                        'emp.emp_mname as emp_mname',
                        'emp.emp_lname as emp_lname',

                    )
                        ->where('performances.emp_reporting_auth', $currentUserEmpDetails->emp_code)
                        ->where('performances.status', $query['status'])
                        ->join('employee as emp', 'emp.emp_code', '=', 'performances.emp_code')
                        ->get();
                    $data['performances'] = $performanceList;
                } else {
                    //dd('po');
                    $performanceList = Performance::select(
                        'performances.*',
                        'emp.emp_department as emp_department',
                        'emp.emp_fname as emp_fname',
                        'emp.emp_mname as emp_mname',
                        'emp.emp_lname as emp_lname',

                    )
                        ->where('performances.emp_reporting_auth', $currentUserEmpDetails->emp_code)
                        ->join('employee as emp', 'emp.emp_code', '=', 'performances.emp_code')
                        ->get();
                    $data['performances'] = $performanceList;
                }
            }
            return View('performancemanagement/request/request', $data);
        } else {
            return redirect("/");
        }
    }
    public function request()
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data = [];

            $departments = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
            // print_r($Roledata);
            $data['departments'] = $departments;
            $data['mode'] = 'create';
            $data['userType'] = Session::get('user_type');
            $data['performance'] = (object)[];
            //dd($data['departments']);
            return View('performancemanagement/request/request-form', $data);
        } else {
            return redirect("/");
        }
    }
    public function requestEdit(Request $request, $id)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data = [];
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $departments = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
            // print_r($Roledata);
            $data['departments'] = $departments;
            $data['performance'] = Performance::select(
                'performances.*',
                'emp.emp_department as emp_department',
                'emp.emp_designation as emp_designation',
                'emp.emp_doj',
                'emp.emp_fname',
                'emp.emp_mname',
                'emp.emp_lname',
                'rep.emp_fname as rep_fname',
                'rep.emp_mname as rep_mname',
                'rep.emp_lname as rep_lname',
            )
                ->where('performances.id', decrypt($id))
                ->join('employee as emp', 'emp.emp_code', '=', 'performances.emp_code')
                ->join('employee as rep', 'rep.emp_code', '=', 'performances.emp_reporting_auth')
                ->first();
            $data['mode'] = 'edit';
            $data['userType'] = Session::get('user_type');
            //dd($data['performance']->status);
            return View('performancemanagement/request/request-form', $data);
        } else {
            return redirect("/");
        }
    }

    // public function submitRequest(Request $request)
    // {
       

    //     if (!empty(Session::get('user_type'))) {
    //         $currentUser = Session::get('users_id');
    //         $email = Session::get('emp_email');
    //         $Roledata = DB::table('registration')->where('status', '=', 'active')

    //             ->where('email', '=', $email)
    //             ->first();
    //         // $validatedData = $request->validate([
    //         //     'emp_code' => 'required',
    //         //     'rep_auth_id' => 'required',
    //         //     'apprisal_period_start' => 'required',
    //         //     'apprisal_period_end' => 'required',

    //         // ]);
    //         $data = $request->all();
    //         $isExit = Performance::where(['emp_code' => $data['emp_code'], 'emp_reporting_auth' => $data['rep_auth_id'], 'emid' => $Roledata->reg])
    //             ->whereIn('status', ['pending', 'submitted', 'recheck'])
    //             ->first();
    //         // die;
    //         if (empty($isExit)) {
    //             $insertData['emp_code'] = $data['emp_code'];
    //             $insertData['emp_reporting_auth'] = $data['rep_auth_id'];
    //             $insertData['apprisal_period_start'] = date('Y-m-d h:i:s', strtotime($data['apprisal_period_start']));
    //             $insertData['apprisal_period_end'] = date('Y-m-d h:i:s', strtotime($data['apprisal_period_end']));
    //             $insertData['created_at'] = date('Y-m-d h:i:s');
    //             $insertData['emid'] = $Roledata->reg;
    //             $insertData['createdBy'] = $currentUser;

    //             // return response()->json($project, 201);
    //             // print_r($project);
    //             // die;

    //             $apprisal_emp_details = DB::table('employee as emp')->select('emp.emp_fname', 'emp.emp_lname', 'emp.emp_mname', 'rep.emp_fname as rep_fname', 'rep.emp_mname as rep_mname', 'rep.emp_lname as rep_lname', 'ur.email as rep_email')
    //                 ->join('employee as rep', 'rep.emp_code', '=', 'emp.emp_reporting_auth')
    //                 ->join('users as ur', 'ur.employee_id', '=', 'rep.emp_code')
    //                 ->where('emp.emp_code', $data['emp_code'])->first();
    //             //dd($insertData);
    //             $details = [
    //                 'reporting_auth_name' => $apprisal_emp_details->emp_fname . ($apprisal_emp_details->emp_mname ? ' ' . $apprisal_emp_details->emp_mname : '') . ($apprisal_emp_details->emp_lname ? ' ' . $apprisal_emp_details->emp_lname : ""),
    //                 'emp_name' => $apprisal_emp_details->rep_fname . ($apprisal_emp_details->rep_mname ? ' ' . $apprisal_emp_details->rep_mname : '') . ($apprisal_emp_details->rep_lname ? ' ' . $apprisal_emp_details->rep_lname : ""),
    //                 'apprisal_period_end' => date('Y-m-d h:i:s', strtotime($data['apprisal_period_end']))
    //             ];
                 
    //             $project = Performance::create($insertData);
    //             Mail::to($apprisal_emp_details->rep_email)->send(new \App\Mail\PerformanceRequestMail("Performance feedback request", $details));
    //             Session::flash('message', 'Performance request has been sent successfully');
    //             return redirect('/performances/request');
    //         } else {
    //             $data = $request->all();
    //             if (array_key_exists('rating', $data)) {
    //                 $updatedData['rating'] = $data['rating'];
    //                 $updatedData['status'] = 'submitted';
    //             }
    //             if (array_key_exists('performance_comments', $data)) {
    //                 $updatedData['performance_comments'] = $data['performance_comments'];
    //             }
    //             if (array_key_exists('apprisal_period_start', $data)) {
    //                 $updatedData['apprisal_period_start'] = date('Y-m-d h:i:s', strtotime($data['apprisal_period_start']));
    //             }
    //             if (array_key_exists('apprisal_period_end', $data)) {
    //                 $updatedData['apprisal_period_end'] = date('Y-m-d h:i:s', strtotime($data['apprisal_period_end']));
    //             }
    //             $updatedData['updatedBy'] = $currentUser;

    //             $updatedData['updated_at'] = date('Y-m-d h:i:s');
    //             Performance::where('id', $isExit->id)->update($updatedData);
    //             Session::flash('message', 'Performance has been updated successfully');
    //             return redirect('/performances/request/' . encrypt($isExit->id));
    //         }
    //     } else {
    //         Session::flash('error', 'Unauthorized access');
    //         return redirect('/performances/request');
    //         // return response()->json(['message' => 'Unauthorized access'], 401);
    //     }
    // }

    public function submitRequest(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            
            if (!$Roledata) {
                Session::flash('error', 'No active registration found for the email.');
                return redirect('/performances/request');
            }

            $data = $request->all();
            
            $isExit = Performance::where(['emp_code' => $data['emp_code'], 'emp_reporting_auth' => $data['rep_auth_id'], 'emid' => $Roledata->reg])
                ->whereIn('status', ['pending', 'submitted', 'recheck'])
                ->first();
            
            if (empty($isExit)) {
                $insertData['emp_code'] = $data['emp_code'];
                $insertData['emp_reporting_auth'] = $data['rep_auth_id'];
                $insertData['apprisal_period_start'] = date('Y-m-d H:i:s', strtotime($data['apprisal_period_start']));
                $insertData['apprisal_period_end'] = date('Y-m-d H:i:s', strtotime($data['apprisal_period_end']));
                $insertData['created_at'] = date('Y-m-d H:i:s');
                $insertData['emid'] = $Roledata->reg;
                $insertData['createdBy'] = $currentUser;
                //dd($data['emp_code']);
                $apprisal_emp_details = DB::table('employee as emp')->select('emp.emp_fname', 'emp.emp_lname', 'emp.emp_mname', 'rep.emp_fname as rep_fname', 'rep.emp_mname as rep_mname', 'rep.emp_lname as rep_lname', 'ur.email as rep_email')
                    ->join('employee as rep', 'rep.emp_code', '=', 'emp.emp_reporting_auth')
                    ->join('users as ur', 'ur.employee_id', '=', 'rep.emp_code')
                    ->where('emp.emp_code', $data['emp_code'])->first();
                //dd($apprisal_emp_details);
                if (!$apprisal_emp_details) {
                    Session::flash('error', 'No employee details found for the given employee code.');
                    return redirect('/performances/request');
                }

                $details = [
                    'reporting_auth_name' => $apprisal_emp_details->emp_fname . ($apprisal_emp_details->emp_mname ? ' ' . $apprisal_emp_details->emp_mname : '') . ($apprisal_emp_details->emp_lname ? ' ' . $apprisal_emp_details->emp_lname : ""),
                    'emp_name' => $apprisal_emp_details->rep_fname . ($apprisal_emp_details->rep_mname ? ' ' . $apprisal_emp_details->rep_mname : '') . ($apprisal_emp_details->rep_lname ? ' ' . $apprisal_emp_details->rep_lname : ""),
                    'apprisal_period_end' => date('Y-m-d H:i:s', strtotime($data['apprisal_period_end']))
                ];
                
                $project = Performance::create($insertData);
                // Mail::to($apprisal_emp_details->rep_email)->send(new \App\Mail\PerformanceRequestMail("Performance feedback request", $details));
                Session::flash('message', 'Performance request has been sent successfully');
                return redirect('/performances/request');
            } else {
                if (array_key_exists('rating', $data)) {
                    $updatedData['rating'] = $data['rating'];
                    $updatedData['status'] = 'submitted';
                }
                if (array_key_exists('performance_comments', $data)) {
                    $updatedData['performance_comments'] = $data['performance_comments'];
                }
                if (array_key_exists('apprisal_period_start', $data)) {
                    $updatedData['apprisal_period_start'] = date('Y-m-d H:i:s', strtotime($data['apprisal_period_start']));
                }
                if (array_key_exists('apprisal_period_end', $data)) {
                    $updatedData['apprisal_period_end'] = date('Y-m-d H:i:s', strtotime($data['apprisal_period_end']));
                }
                $updatedData['updatedBy'] = $currentUser;
                $updatedData['updated_at'] = date('Y-m-d H:i:s');
                
                Performance::where('id', $isExit->id)->update($updatedData);
                Session::flash('message', 'Performance has been updated successfully');
                return redirect('/performances/request/' . encrypt($isExit->id));
            }
        } else {
            Session::flash('error', 'Unauthorized access');
            return redirect('/performances/request');
        }
    }



    public function destroy($id)
    {
        $performance = Performance::find(decrypt($id));
        if (!$performance) {
            Session::flash('error', 'Request  not found');
            return redirect('/performances');
        }
        $performance->delete();
        Session::flash('message', 'Performance request  has been deleted successfully');
        return redirect('/performances');
    }
    public function getEmployeesByDept(Request $request)
    {
        
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            // $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

            //     $query->whereNull('employee.emp_status')
            //         ->orWhere('employee.emp_status', '!=', 'LEFT');
            // })->get();
            //dd($Roledata->reg);
            $query = $request->all();
            //dd($query['dept']);
            $data = [];
            $employees =  DB::table('employee')->where('emid', '=', $Roledata->reg)
                ->where('emp_department', $query['dept'])
                ->get();
            $data['employees'] = $employees;
            return response()->json(['status' => true, 'message' => "Employee list has been fetched successfully", 'data' => $data]);
        } else {
            return response()->json(['status' => false, 'message' => "Access denied"]);
        }
    }
    public function getEmployeeDetails(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $query = $request->all();
            $data = [];
            $employee =  DB::table('employee as emp')->select('emp.*', 'e.id as rep_id', 'e.emp_code as rep_emp_code', 'e.emp_fname as rep_fname', 'e.emp_mname as rep_mname', 'e.emp_lname as rep_lname')
                ->leftJoin('employee as e', 'e.emp_code',  '=', 'emp.emp_reporting_auth')
                ->where('emp.emp_code', '=', $query['id'])
                ->first();
            $data['employee'] = $employee;
            return response()->json(['status' => true, 'message' => "Employee details has been fetched successfully", 'data' => $data]);
        } else {
            return response()->json(['status' => false, 'message' => "Access denied"]);
        }
    }
}
