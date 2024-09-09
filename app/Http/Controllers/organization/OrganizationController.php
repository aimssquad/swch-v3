<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Session;
use DB;


class OrganizationController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.organization';
        $this->_model       = new UserModel();
    }

    public function Dashboard(Request $request)
    {
        $email = Session::get("emp_email");

        if (!empty($email)) {
            $user_type = Session::get("user_type");
            if ($user_type == "employer") {
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first(); 
                    //dd($data);
            } else {
                $usemail = Session::get("user_email");
                $users_id = Session::get("users_id");
                $data["Roledata"] = DB::table("users")
                    ->where("id", "=", $users_id)
                    ->first();
                return view('employeer.employee-corner.dashboard', $data);
                
            }
            return view($this->_routePrefix . '.dashboard', $data);
        } else {
            return redirect("/");
        }
    }
    public function profile(Request $request){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            // dd($data);
            return view($this->_routePrefix . '.profile',$data);

        }else{
            return redirect('/');
        }
    }
    public function statistics(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        }
    }
    
    public function employeesRTI(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        }
    }
    public function authorizingOfficer(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        }  
    }

    public function keyContact(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        }  
    }
    public function level1User(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        } 
    }
    public function level2User(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);
        }else{
            return redirect('/');
        } 
    }
}
