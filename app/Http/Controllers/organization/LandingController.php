<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use Exception;

class LandingController extends Controller
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
    // organization profile made by abbas
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

    public function allempcard(){
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $user_email=Session::get('user_email');
            // dd($user_email);
            $user_type=Session::get('user_type');
            $arrayEmail=[];
            if($user_type==="employer"){
                $email = Session::get('emp_email');
                array_push($arrayEmail, $email);
            }else{
                $user_email=Session::get('user_email');
                array_push($arrayEmail, $user_email);
            }
            $emp_email = implode(", ", $arrayEmail);
            // dd($emp_email);
            if($user_type==="employer"){
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $emp_email)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })->get();
            //dd($data);
            return view($this->_routePrefix . '.employees', $data);
            }else{
                $Roledata = DB::table('users')->where('status', '=', 'active')

                ->where('email', '=', $emp_email)
                ->first();
            //   dd($Roledata);
            $data['employee_rs'] = DB::table('employee')->where('emp_code', '=', $Roledata->employee_id)->where(function ($query) {
                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })->get();
            //dd($data);
            return view($this->_routePrefix . '.employees', $data);
            }

        } else {
            return redirect('/');
        }
        //return view($this->_routePrefix . '.employees'); 
    }

    public function allEmpList(){ //dd('ok');

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $user_email=Session::get('user_email');
            // dd($user_email);
            $user_type=Session::get('user_type');
            $arrayEmail=[];
            if($user_type==="employer"){
                $email = Session::get('emp_email');
                array_push($arrayEmail, $email);
            }else{
                $user_email=Session::get('user_email');
                array_push($arrayEmail, $user_email);
            }
            $emp_email = implode(", ", $arrayEmail);
            // dd($emp_email);
            if($user_type==="employer"){
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $emp_email)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })->get();
            //dd($data);
            return view($this->_routePrefix . '.employees-list', $data);
            }else{
                $Roledata = DB::table('users')->where('status', '=', 'active')

                ->where('email', '=', $emp_email)
                ->first();
            //   dd($Roledata);
            $data['employee_rs'] = DB::table('employee')->where('emp_code', '=', $Roledata->employee_id)->where(function ($query) {
                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })->get();
            //dd($data);
            return view($this->_routePrefix . '.employees-list', $data);
            }

        } else {
            return redirect('/');
        }
        //return view($this->_routePrefix . '.employees'); 
    }

    public function addEmployee(Request $request){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['payment_wedes_rs'] = DB::table('payment_type_wedes')->where('emid', '=', $Roledata->reg)->get();

            $id = $request->get('q');
            if ($id) {
                //dd($id);
                function my_simple_crypt($string, $action = 'encrypt')
                {
                    // you may change these values to your own
                    $secret_key = 'bopt_saltlake_kolkata_secret_key';
                    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

                    $output = false;
                    $encrypt_method = "AES-256-CBC";
                    $key = hash('sha256', $secret_key);
                    $iv = substr(hash('sha256', $secret_iv), 0, 16);

                    if ($action == 'encrypt') {
                        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
                    } else if ($action == 'decrypt') {
                        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                    }

                    return $output;
                }
                ///
                //$encrypted = my_simple_crypt( 'Hello World!', 'encrypt' );
                $decrypted_id = my_simple_crypt($id, 'decrypt');

                $data['employee_rs'] = DB::table('employee')
                    ->join('employee_pay_structure', 'employee.emp_code', '=', 'employee_pay_structure.employee_code')
                    ->where('employee.emp_code', '=', $decrypted_id)
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('employee_pay_structure.emid', '=', $Roledata->reg)
                    ->select('employee.*', 'employee_pay_structure.*')
                    ->get();

                $data['employee_job_rs'] = DB::table('employee_job')
                    ->where('emp_id', '=', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();

                $data['employee_quli_rs'] = DB::table('employee_qualification')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_id', '=', $decrypted_id)
                    ->get();

                $data['employee_otherd_doc_rs'] = DB::table('employee_other_doc')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_code', '=', $decrypted_id)
                    ->get();
                $data['employee_train_rs'] = DB::table('employee_training')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_id', '=', $decrypted_id)
                    ->get();

                $data['employee_upload_rs'] = DB::table('employee_upload')
                    ->where('emp_id', '=', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();

                $empdepartmen = DB::table('department')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('department_name', '=', $data['employee_rs'][0]->emp_department)
                    ->where('department_status', '=', 'active')
                    ->first();

                $data['department'] = DB::table('department')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('department_status', '=', 'active')->get();

                if (!empty($empdepartmen)) {
                    $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('department_code', '=', $empdepartmen->id)->where('designation_status', '=', 'active')->get();
                } else {
                    $data['designation'] = '';
                }

                $data['employee_type'] = DB::table('employ_type_master')->where('emid', '=', $Roledata->reg)->get();
                $emppaygr = DB::table('pay_scale_master')->where('emid', '=', $Roledata->reg)->where('payscale_code', '=', $data['employee_rs'][0]->emp_group_name)->first();
                $data['grade'] = DB::table('grade')->where('emid', '=', $Roledata->reg)->where('grade_status', '=', 'active')->get();
                if (!empty($emppaygr)) {
                    $data['annul'] = DB::table('pay_scale_basic_master')->where('pay_scale_master_id', '=', $emppaygr->id)->get();
                } else {
                    $data['annul'] = '';
                }

                $data['currency_user'] = DB::table('currencies')->orderBy('country', 'asc')->get();
                $data['bank'] = DB::table('bank_masters')->get();
                $data['payscale_master'] = DB::table('pay_scale_master')->where('emid', '=', $Roledata->reg)->get();
                $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->orderBy('name', 'asc')->get();
                $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['currency_master'] = DB::table('currency_code')->get();
                $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

                $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                if ($data['employee_rs'][0]->emp_pr_pincode != '') {

                    $data['employee_pin_rs'] = "<option value=''>&nbsp;</option>";
                } else {
                    $data['employee_pin_rs'] = "<option value=''>&nbsp;</option>";
                }
                // dd($data['nation_master']);
                return view('employee/edit-employee', $data);

            } else {
                $emp_cof = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $emp_totcof = DB::table('employee')

                    ->where('emid', '=', $emp_cof->reg)
                    ->orderBy('id', 'desc')
                    ->get();


                if (count($emp_totcof) != 0) {
                    $firstRecordEmpCode = $emp_totcof[0]->emp_code;
                } else {
                    $firstRecordEmpCode = '001';
                }

                $result = explode(" ", trim($emp_cof->com_name));


                $rsnew = strtoupper(substr($result['0'], 0, 3));

                $lastCodeNum = str_replace($rsnew, '', $firstRecordEmpCode);

                // dd($emp_totcof);

                $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('email', '!=', $email)
                    ->where('licence', '=', 'yes')
                    ->get();

                    // dd($countslug);

                if (count($emp_totcof) != 0) {
                    // if (count($countslug) != 0) {
                    //     $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 4)) . ($lastCodeNum + 1);
                    // } else {
                    //     $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) . ($lastCodeNum + 1);
                    // }

                    //fix made 11-06-22 for exponential issue
                    $emp_code =$rsnew. ($lastCodeNum + 1);

                    if ($emp_code == $firstRecordEmpCode) {
                        if (count($countslug) != 0) {
                            $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 4)) . ($lastCodeNum + 2);
                        } else {
                            $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) . ($lastCodeNum + 2);
                        }
                    }
                    //dd($emp_code);
                } else {
                    $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('email', '!=', $email)
                        ->where('licence', '=', 'yes')
                        ->get();

                    if (count($countslug) != 0) {
                        $ko = 1;
                        $new = 0;
                        $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')

                            ->where('licence', '=', 'yes')
                            ->get();
                        foreach ($countslug as $valnew) {
                            if ($valnew->id == $emp_cof->id) {
                                $new = $ko++;
                            } else {
                                $ko++;
                            }
                        }

                        $rest = $rsnew . $new;
                    } else {
                        $rest = $rsnew;
                    }

                    $emp_code = $rest . (count($emp_totcof) + 1);
                }
                // dd($Roledata->reg);
                $data['employee_code'] = $emp_code;
                $data['currency_user'] = DB::table('currencies')->orderBy('country', 'asc')->get();
                $data['department'] = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_status', '=', 'active')->get();
                $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('designation_status', '=', 'active')->get();

                $data['employee_type'] = DB::table('employ_type_master')
                ->where('emid', '=', $Roledata->reg)->get();
                // ->where('employee_type_status', '=', 'active')
                $data['grade'] = DB::table('grade')->where('emid', '=', $Roledata->reg)->where('grade_status', '=', 'active')->get();
                // dd($data['grade']);
                $data['bank'] = DB::table('bank_masters')->get();
                $data['payscale_master'] = DB::table('pay_scale_master')->where('emid', '=', $Roledata->reg)->get();
                $data['nation_master'] = DB::table('nationality_master')->orderBy('name', 'asc')->get();

                $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['currency_master'] = DB::table('currency_code')->get();
                $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

                $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                //echo "<pre>";print_r($data['states']);exit;
                return view($this->_routePrefix . '.add-employee', $data);
            }

        } else {
            return redirect('/');
        }
    }

    public function Doforgot(Request $request)
    {
        $Employee = DB::table("users")
            ->where("email", "=", $request->email)
            ->where("status", "=", "active")
            ->where("user_type", "!=", "admin")
            ->first();

        if (!empty($Employee)) {
            $Roledata = DB::table("users")

                ->where("employee_id", "=", $Employee->emid)
                ->where("status", "=", "active")
                ->first();
            $base_url = env('BASE_URL');

            $data = ["pass" => $Employee->password, "name" => $Employee->name,"web"=>$base_url ];
            $toemail = $request->email;
            Mail::send("mailforgot", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, env('MAIL_FROM_NAME'))
                    ->subject("Forgot  Password ");
                $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
            });

            Session::flash("message", "Mail sent successfully.");
            return redirect("forgot-password");
        } else {
            Session::flash("error", "Your email id was wrong!!");
            return redirect("forgot-password");
        }
    }

    public function indexfor()
    {
        return view("forgot-password");
    }


}
