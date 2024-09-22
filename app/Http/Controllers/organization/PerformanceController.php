<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformanceManagement\Performance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;

class PerformanceController extends Controller
{
    protected $_routePrefix;
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.performances';
        //$this->_model       = new CompanyJobs();
    }
    //return view($this->_routePrefix . '.company_bank',$data);

    public function dashboard(Request $request){
        if(!empty(Session::get('emp_email'))){
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')->where('email', '=', $email)->first();
            $data['performence_list'] = Performance::where('emid', $Roledata->reg)->count();
            //dd($data);
            return view($this->_routePrefix . '.dashboard',$data);
        } else {
            return redirect('/');
        }
       
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
            return view($this->_routePrefix . '.request',$data);
            //return View('performancemanagement/request/request', $data);
        } else {
            return redirect("/");
        }
    }

    public function performanceRequest()
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
            return view($this->_routePrefix . '.request-form',$data);
            //return View('performancemanagement/request/request-form', $data);
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
            return view($this->_routePrefix . '.request-form',$data);
            //return View('performancemanagement/request/request-form', $data);
        } else {
            return redirect("/");
        }
    }



}// End Class
