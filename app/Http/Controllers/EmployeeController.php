<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportCircumstances;
use App\Exports\ExcelFileExportemployeeInformation;
use App\Exports\EmployeeExcelReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeBulkDataTableExport;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mail;
use PDF;
use Session;
use view;
use App\Models\EmployeePersonalRecord;
use App\Models\ExperienceRecords;
use App\Models\ProfessionalRecords;
use App\Models\MiscDocuments;
use App\Models\PayStructure;
use App\Models\Deduction;
use App\Models\Masters\Cast;
use App\Models\Masters\Sub_cast;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Employee;
use App\Models\Masters\Bank;
use App\Models\RateDetail;
use App\Models\Rate_master;
use App\Models\EmployeePayStructure;
use App\Models\EmployeeType;
use App\Models\UserModel;

class EmployeeController extends Controller
{
    public function getamployeedas()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_active"] = DB::table("users")
                ->join(
                    "employee",
                    "users.employee_id",
                    "=",
                    "employee.emp_code"
                )
                ->where("employee.emid", "=", $Roledata->reg)
                ->where("users.emid", "=", $Roledata->reg)
                ->where("users.status", "=", "active")
                ->where("users.user_type", "=", "employee")
                ->where(function ($query) {
                    $query
                        ->whereNull("employee.emp_status")
                        ->orWhere("employee.emp_status", "!=", "LEFT");
                })
                //->where('employee.emp_status', '!=', 'LEFT')
                ->select("users.*")
                ->get();

            $data["employee_inactive"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->get();

            $data["employee_migarnt"] = DB::table("users")
                ->join(
                    "employee",
                    "users.employee_id",
                    "=",
                    "employee.emp_code"
                )
                ->where("employee.emid", "=", $Roledata->reg)
                ->where("users.emid", "=", $Roledata->reg)
                ->where("users.status", "=", "active")
                ->where("users.user_type", "=", "employee")
                ->where(function ($query) {
                    $query
                        ->whereNull("employee.emp_status")
                        ->orWhere("employee.emp_status", "!=", "LEFT");
                })
                //->where('employee.emp_status', '!=', 'LEFT')
                ->where(function ($query) {
                    $query
                        ->orWhereNotNull("employee.visa_doc_no")
                        // ->orWhereNotNull('employee.visa_exp_date')
                        // ->orWhereNotNull('employee.euss_exp_date')

                        ->orWhereNotNull("employee.euss_ref_no");
                })
                ->select("employee.*")
                ->get();

            $data["employee_suspened"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "SUSPEND")
                ->get();
            $data["employee_complete"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->get();
            $data["employee_incomplete"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "not approved")
                ->get();

            $data["employee_constuct"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "CONTRACTUAL")
                ->get();
            $data["employee_fulltime"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "FULL TIME")
                ->get();
            $data["employee_regular"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "REGULAR")
                ->get();
            $data["employee_parttime"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "PART TIME")
                ->get();
            $data["employee_ex_empoyee"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                ->where("verify_status", "=", "approved")
                ->where("emp_status", "=", "LEFT")
                ->get();

            $data["employee_ex_empoyee_c"] = DB::table("employee")

                ->where("emid", "=", $Roledata->reg)
                // ->where('verify_status', '=', 'approved')
                ->where("emp_status", "=", "LEFT")
                ->get();

            $data["employee_data_count"] = DB::table("employee_bulk_data")
                ->where("status", "=", "active")
                ->count();
            return view("employee/dashboard", $data);
        } else {
            return redirect("/");
        }
    }

    //swch employee
    public function getEmployees()
    {

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
            return view('employee/employee', $data);
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
            return view('employee/employee', $data);
            }

        } else {
            return redirect('/');
        }
    }
    public function empexcelreport(){
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
                $reg=$Roledata->reg;
           return Excel::download(
              new EmployeeExcelReport($reg),
              "employeeexcel.xlsx"
          );
        }else{
           return redirect('/');
        }
      }

     public function emppdfreport(){
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
                $reg=$Roledata->reg;

                $datap['role'] =$Roledata;


                // $datap['datap'] = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo,
                //     'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country,
                //     'emid' => $Roledata->reg];
                $datap['employee'] = DB::table('employee')
                ->where('emid','=',$reg)
                ->get();
                  //dd($datap);


                $pdf = PDF::loadView('myallpdfemployee', $datap);
                return $pdf->download('EmployeeReport.pdf');
        }else{
           return redirect('/');
        }
      }

    public function viewAddEmployee(Request $request)
    {
         //dd($request->all());

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
                return view('employee/add-employee', $data);
            }

        } else {
            return redirect('/');
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }



    public function saveEmployee(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            // echo $id = Input::get('q');
            // dd($request->all());
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

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

            //print_r($request->hasFile('emp_image')); print_r($request->edit_emp_image); exit;
            if (!empty($request->edit_emp_image) && $request->hasFile('emp_image') == 1) {
                $files = $request->file('emp_image');
                $filename = $files->store('emp_pic');
            } else if (empty($request->edit_emp_image) && $request->hasFile('emp_image') == 1) {
                $files = $request->file('emp_image');
                $filename = $files->store('emp_pic');

            } else if (!empty($request->edit_emp_image) && $request->hasFile('emp_image') != 1) {

                $filename = $request->edit_emp_image;
            } else {

                $filename = "";
            }

            $id = $request->get('q');

            if ($id) {
                //edit mode
                $decrypted_id = my_simple_crypt($id, 'decrypt');

                $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emp_code', '!=', $decrypted_id)->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Employee Code Code  Already Exists.');
                    return redirect('employees');
                }

                $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->where('employee_id', '!=', $decrypted_id)->where('status', '=', 'active')->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('employees');
                }

                $ckeck_right = DB::table('right_works')->where('employee_id', '=', $decrypted_id)->where('emid', $Roledata->reg)->first();

                if (!empty($ckeck_right)) {
                    $datarigh_edit = array(
                        'start_date' => date('Y-m-d', strtotime($request->emp_doj)),

                    );

                    DB::table('right_works')
                        ->where('employee_id', '=', $decrypted_id)
                        ->where('emid', $Roledata->reg)
                        ->update($datarigh_edit);
                }

                if (!empty($request->emqliup)) {

                    $tot_item_edit_quli = count($request->emqliup);

                    foreach ($request->emqliup as $value) {

                        if ($request->input('quli_' . $value) != '') {
                            if ($request->has('doc_' . $value)) {

                                $extension_doc_edit = $request->file('doc_' . $value)->extension();
                                $path_quli_doc_edit = $request->file('doc_' . $value)->store('employee_quli_doc', 'public');
                                $dataimgedit = array(
                                    'doc' => $path_quli_doc_edit,
                                );
                                DB::table('employee_qualification')
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('id', $value)
                                    ->update($dataimgedit);

                            }
                            if ($request->has('doc2_' . $value)) {

                                $extension_doc_edit2 = $request->file('doc2_' . $value)->extension();
                                $path_quli_doc_edit2 = $request->file('doc2_' . $value)->store('employee_quli_doc2', 'public');
                                $dataimgedit = array(
                                    'doc2' => $path_quli_doc_edit2,
                                );
                                DB::table('employee_qualification')
                                    ->where('id', $value)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->update($dataimgedit);

                            }
                            $dataquli_edit = array(
                                'emp_id' => $decrypted_id,
                                'quli' => $request->input('quli_' . $value),
                                'dis' => $request->input('dis_' . $value),
                                'ins_nmae' => $request->input('ins_nmae_' . $value),
                                'board' => $request->input('board_' . $value),
                                'year_passing' => $request->input('year_passing_' . $value),
                                'perce' => $request->input('perce_' . $value),
                                'grade' => $request->input('grade_' . $value),

                            );

                            DB::table('employee_qualification')
                                ->where('id', $value)
                                ->where('emid', '=', $Roledata->reg)
                                ->update($dataquli_edit);
                        }
                    }

                }

                if (!empty($request->emqliotherdoc)) {

                    $tot_item_edit_quli = count($request->emqliotherdoc);

                    foreach ($request->emqliotherdoc as $value) {

                        if ($request->input('doc_name_' . $value) != '') {
                            if ($request->has('doc_upload_doc_' . $value)) {

                                $extension_doc_edit = $request->file('doc_upload_doc_' . $value)->extension();
                                $path_quli_doc_edit = $request->file('doc_upload_doc_' . $value)->store('emp_other_doc', 'public');
                                $dataimgedit = array(
                                    'doc_upload_doc' => $path_quli_doc_edit,
                                );
                                DB::table('employee_other_doc')
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('id', $value)
                                    ->update($dataimgedit);

                            }

                            $dataquli_edit = array(
                                'emp_code' => $decrypted_id,
                                'doc_name' => $request->input('doc_name_' . $value),
                                'doc_ref_no' => $request->input('doc_ref_no_' . $value),
                                'doc_nation' => $request->input('doc_nation_' . $value),
                                'doc_issue_date' => date('Y-m-d', strtotime($request->input('doc_issue_date_' . $value))),
                                'doc_review_date' => date('Y-m-d', strtotime($request->input('doc_review_date_' . $value))),
                                'doc_exp_date' => date('Y-m-d', strtotime($request->input('doc_exp_date_' . $value))),
                                'doc_cur' => $request->input('doc_cur_' . $value),
                                'doc_remarks' => $request->input('doc_remarks_' . $value),

                            );

                            DB::table('employee_other_doc')
                                ->where('id', $value)
                                ->where('emid', '=', $Roledata->reg)
                                ->update($dataquli_edit);
                        }
                    }

                }

                $sm_cch_pass_docu = '';
                $sm_cch_visa_upload_doc = '';
                $sm_cch_visaback_doc = '';
                $sm_cch_pr_add_proof = '';

                if ($request->has('emp_image')) {

                    $file = $request->file('emp_image');
                    $extension = $request->emp_image->extension();
                    $path = $request->emp_image->store('employee_logo', 'public');
                    $dataimg = array(
                        'emp_image' => $path,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimg);

                }
                if ($request->has('pass_docu')) {

                    $file_doc = $request->file('pass_docu');
                    $extension_doc = $request->pass_docu->extension();
                    $path_doc = $request->pass_docu->store('employee_doc', 'public');

                    $dataimgdoc = array(
                        'pass_docu' => $path_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgdoc);

                    $sm_cch_pass_docu = $path_doc;

                }
                if ($request->has('visa_upload_doc')) {

                    $file_visa_doc = $request->file('visa_upload_doc');
                    $extension_visa_doc = $request->visa_upload_doc->extension();
                    $path_visa_doc = $request->visa_upload_doc->store('employee_vis_doc', 'public');
                    $dataimgvis = array(
                        'visa_upload_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                    $sm_cch_visa_upload_doc = $path_visa_doc;

                }

                if ($request->has('visaback_doc')) {

                    $file_visa_doc = $request->file('visaback_doc');
                    $extension_visa_doc = $request->visaback_doc->extension();
                    $path_visa_doc = $request->visaback_doc->store('employee_vis_doc', 'public');
                    $dataimgvis = array(
                        'visaback_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                    $sm_cch_visaback_doc = $path_visa_doc;

                }

                if ($request->has('pr_add_proof')) {

                    $file_peradd = $request->file('pr_add_proof');
                    $extension_per_add = $request->pr_add_proof->extension();
                    $path_peradd = $request->pr_add_proof->store('employee_per_add', 'public');
                    $dataimgper = array(
                        'pr_add_proof' => $path_peradd,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgper);

                    $sm_cch_pr_add_proof = $path_peradd;

                }
                if ($request->has('ps_add_proof')) {

                    $file_ps_add = $request->file('pr_add_proof');
                    $extension_ps_add = $request->ps_add_proof->extension();
                    $path_ps_ad = $request->ps_add_proof->store('employee_ps_add', 'public');
                    $dataimgps = array(
                        'ps_add_proof' => $path_ps_ad,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgps);

                }

                if ($request->has('euss_upload_doc')) {

                    $file_ps_doc = $request->file('euss_upload_doc');
                    $extension_ps_doc = $request->euss_upload_doc->extension();
                    $path_euss_doc = $request->euss_upload_doc->store('emp_euss', 'public');
                    $dataimgps = array(
                        'euss_upload_doc' => $path_euss_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgps);

                }

                if ($request->has('dbs_upload_doc')) {

                    $file_dbs_doc = $request->file('dbs_upload_doc');
                    $extension_dbs_doc = $request->dbs_upload_doc->extension();
                    $path_dbs_doc = $request->dbs_upload_doc->store('emp_dbs', 'public');
                    $dataimgdbs = array(
                        'dbs_upload_doc' => $path_dbs_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgdbs);

                }

                if ($request->has('nat_upload_doc')) {

                    $file_ps_doc = $request->file('nat_upload_doc');
                    $extension_ps_doc = $request->nat_upload_doc->extension();
                    $path_nat_doc = $request->nat_upload_doc->store('emp_nation', 'public');
                    $dataimgps = array(
                        'nat_upload_doc' => $path_nat_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgps);

                }

                $dataupdate = array(

                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_dob' => date('Y-m-d', strtotime($request->emp_dob)),
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'em_contact' => $request->em_contact,
                    'emp_gender' => $request->emp_gender,
                    'emp_father_name' => $request->emp_father_name,

                    'marital_status' => $request->marital_status,
                    'marital_date' => date('Y-m-d', strtotime($request->marital_date)),
                    'spouse_name' => $request->spouse_name,
                    'nationality' => $request->nationality,

                    'verify_status' => $request->verify_status,

                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_doj' => date('Y-m-d', strtotime($request->emp_doj)),
                    'emp_status' => $request->emp_status,
                    'date_confirm' => date('Y-m-d', strtotime($request->date_confirm)),
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'fte' => $request->fte,
                    'job_loc' => $request->job_loc,

                    'emp_reporting_auth' => $request->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,

                    'dis_remarks' => $request->dis_remarks,
                    'cri_remarks' => $request->cri_remarks,
                    'criminal' => $request->criminal,

                    'ni_no' => $request->ni_no,
                    'emp_blood_grp' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_weight' => $request->emp_weight,
                    'emp_height' => $request->emp_height,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,

                    'em_name' => $request->em_name,
                    'em_relation' => $request->em_relation,
                    'em_email' => $request->em_email,
                    'em_phone' => $request->em_phone,
                    'em_address' => $request->em_address,
                    'relation_others' => $request->relation_others,

                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_per_village' => $request->emp_per_village,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_state' => $request->emp_pr_state,

                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_state' => $request->emp_ps_state,

                    'nat_id' => $request->nat_id,
                    'place_iss' => $request->place_iss,
                    'iss_date' => $request->iss_date,
                    'exp_date' => date('Y-m-d', strtotime($request->exp_date)),
                    'pass_nation' => $request->pass_nation,
                    'country_residence' => $request->country_residence,
                    'country_birth' => $request->country_birth,
                    'place_birth' => $request->place_birth,

                    'pass_doc_no' => $request->pass_doc_no,
                    'pass_nat' => $request->pass_nat,
                    'issue_by' => $request->issue_by,
                    'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
                    'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
                    'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),
                    'eli_status' => $request->eli_status,

                    'cur_pass' => $request->cur_pass,
                    'remarks' => $request->remarks,

                    'visa_doc_no' => $request->visa_doc_no,
                    'visa_nat' => $request->visa_nat,
                    'visa_issue' => $request->visa_issue,
                    'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
                    'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
                    'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),
                    'visa_eli_status' => $request->visa_eli_status,

                    'visa_cur' => $request->visa_cur,
                    'visa_remarks' => $request->visa_remarks,

                    'drive_doc' => $request->drive_doc,
                    'licen_num' => $request->licen_num,
                    'lin_exp_date' => $request->lin_exp_date,

                    'emp_group_name' => $request->emp_group_name,
                    'emp_pay_scale' => $request->emp_pay_scale,
                    'emp_payment_type' => $request->emp_payment_type,
                    'daily' => $request->daily,
                    'min_work' => $request->min_work,
                    'min_rate' => $request->min_rate,
                    'tax_emp' => $request->tax_emp,
                    'tax_ref' => $request->tax_ref,
                    'tax_per' => $request->tax_per,

                    'emp_pay_type' => $request->emp_pay_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_account_no' => $request->emp_account_no,
                    'emp_sort_code' => $request->emp_sort_code,
                    'wedges_paymode' => $request->wedges_paymode,
                    'currency' => $request->currency,
                    'emid' => $Roledata->reg,
                    'titleof_license' => $request->titleof_license,
                    'cf_license_number' => $request->cf_license_number,
                    'cf_start_date' => date('Y-m-d', strtotime($request->cf_start_date)),
                    'cf_end_date' => date('Y-m-d', strtotime($request->cf_end_date)),

                    'euss_ref_no' => $request->euss_ref_no,
                    'euss_nation' => $request->euss_nation,
                    'euss_issue_date' => date('Y-m-d', strtotime($request->euss_issue_date)),
                    'euss_exp_date' => date('Y-m-d', strtotime($request->euss_exp_date)),
                    'euss_review_date' => date('Y-m-d', strtotime($request->euss_review_date)),
                    'euss_cur' => $request->euss_cur,
                    'euss_remarks' => $request->euss_remarks,

                    'dbs_ref_no' => $request->dbs_ref_no,
                    'dbs_nation' => $request->dbs_nation,
                    'dbs_issue_date' => date('Y-m-d', strtotime($request->dbs_issue_date)),
                    'dbs_exp_date' => date('Y-m-d', strtotime($request->dbs_exp_date)),
                    'dbs_review_date' => date('Y-m-d', strtotime($request->dbs_review_date)),
                    'dbs_cur' => $request->dbs_cur,
                    'dbs_remarks' => $request->dbs_remarks,
                    'dbs_type' => $request->dbs_type,

                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,

                    'nat_remarks' => $request->nat_remarks,
                    'updated_at' => date('Y-m-d H:i:s'),

                );

                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataupdate);

                $datachangecir = array(

                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),

                    'visa_upload_doc' => $sm_cch_visa_upload_doc,
                    'visaback_doc' => $sm_cch_visaback_doc,

                    'pass_docu' => $sm_cch_pass_docu,
                    'pr_add_proof' => $sm_cch_pr_add_proof,

                    'emp_designation' => $request->emp_designation,

                    'emp_ps_phone' => $request->emp_ps_phone,

                    'nationality' => $request->nationality,
                    'ni_no' => $request->ni_no,
                    'pass_doc_no' => $request->pass_doc_no,
                    'pass_nat' => $request->pass_nat,
                    'place_birth' => $request->place_birth,
                    'issue_by' => $request->issue_by,
                    'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
                    'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
                    'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),

                    'remarks' => $request->remarks,
                    'cur_pass' => $request->cur_pass,

                    'visa_doc_no' => $request->visa_doc_no,
                    'visa_nat' => $request->visa_nat,
                    'visa_issue' => $request->visa_issue,
                    'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
                    'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
                    'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),
                    'country_residence' => $request->country_residence,
                    'visa_remarks' => $request->visa_remarks,
                    'visa_cur' => $request->visa_cur,

                    'dbs_ref_no' => $request->dbs_ref_no,
                    'dbs_nation' => $request->dbs_nation,
                    'dbs_issue_date' => date('Y-m-d', strtotime($request->dbs_issue_date)),
                    'dbs_exp_date' => date('Y-m-d', strtotime($request->dbs_exp_date)),
                    'dbs_review_date' => date('Y-m-d', strtotime($request->dbs_review_date)),
                    'dbs_cur' => $request->dbs_cur,
                    'dbs_remarks' => $request->dbs_remarks,
                    'dbs_type' => $request->dbs_type,

                    'euss_ref_no' => $request->euss_ref_no,
                    'euss_nation' => $request->euss_nation,
                    'euss_issue_date' => date('Y-m-d', strtotime($request->euss_issue_date)),
                    'euss_exp_date' => date('Y-m-d', strtotime($request->euss_exp_date)),
                    'euss_review_date' => date('Y-m-d', strtotime($request->euss_review_date)),
                    'euss_cur' => $request->euss_cur,
                    'euss_remarks' => $request->euss_remarks,

                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,

                    'nat_remarks' => $request->nat_remarks,



                    'emp_dob' => date('Y-m-d', strtotime($request->emp_dob)),
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_per_village' => $request->emp_per_village,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_state' => $request->emp_pr_state,

                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_state' => $request->emp_ps_state,

                    'emp_code' => $decrypted_id,
                    'emid' => $Roledata->reg,
                    'hr' => '',
                    'home' => '',
                    'res_remark' => '',

                    'date_change' => date('Y-m-d', strtotime($request->emp_doj)),
                    'change_last' => '',
                    'stat_chage' => '',

                    'unique_law' => '',
                    'repo_ab' => '',
                    'laeve_date' => '',

                );

                DB::table('change_circumstances_history')->insert($datachangecir);

                DB::table('circumemployee_other_doc_history')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->delete();

                $employee_otherd_doc_rs = DB::table('employee_other_doc')

                    ->where('emp_code', '=', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                if (count($employee_otherd_doc_rs) != 0) {
                    foreach ($employee_otherd_doc_rs as $valuother) {
                        $datachangecirdox = array(

                            'emp_code' => $decrypted_id,
                            'doc_name' => $valuother->doc_name,
                            'emid' => $valuother->emid,
                            'doc_upload_doc' => $valuother->doc_upload_doc,

                            'doc_ref_no' => $valuother->doc_ref_no,
                            'doc_nation' => $valuother->doc_nation,
                            'doc_remarks' => $valuother->doc_remarks,
                            'doc_issue_date' => $valuother->doc_issue_date,
                            'doc_exp_date' => $valuother->doc_exp_date,
                            'doc_review_date' => $valuother->doc_review_date,
                            'doc_cur' => $valuother->doc_cur,

                        );

                        //DB::table('circumemployee_other_doc_history')->insert($datachangecirdox);

                    }
                }
                if (!empty($request->id_up_doc)) {

                    $tot_item_nat_edit = count($request->id_up_doc);

                    foreach ($request->id_up_doc as $valuee) {

                        if ($request->input('type_doc_' . $valuee) != '') {

                            if ($request->has('docu_nat_' . $valuee)) {

                                $extension_doc_edit_up = $request->file('docu_nat_' . $valuee)->extension();

                                $path_quli_doc_edit_up = $request->file('docu_nat_' . $valuee)->store('employee_upload_doc', 'public');
                                $dataimgeditup = array(
                                    'docu_nat' => $path_quli_doc_edit_up,
                                );

                                DB::table('employee_upload')
                                    ->where('id', $valuee)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->update($dataimgeditup);

                            }

                            $datauploadedit = array(
                                'emp_id' => $decrypted_id,
                                'type_doc' => $request->input('type_doc_' . $valuee),

                            );
                            DB::table('employee_upload')
                                ->where('id', $valuee)
                                ->where('emid', '=', $Roledata->reg)
                                ->update($datauploadedit);

                        }
                    }

                }

                if (!empty($request->doc_name)) {
                    $tot_item_nat = count($request->doc_name);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->doc_name[$i] != '') {
                            if ($request->has('doc_upload_doc')) {

                                $extension_upload_doc = $request->doc_upload_doc[$i]->extension();
                                $path_upload_otherdoc = $request->doc_upload_doc[$i]->store('emp_other_doc', 'public');

                            } else {
                                $path_upload_otherdoc = '';
                            }
                            $dataupload = array(
                                'emp_code' => $request->emp_code,
                                'doc_name' => $request->doc_name[$i],
                                'emid' => $Roledata->reg,
                                'doc_upload_doc' => $path_upload_otherdoc,

                                'doc_ref_no' => $request->doc_ref_no[$i],
                                'doc_nation' => $request->doc_nation[$i],
                                'doc_remarks' => $request->doc_remarks[$i],
                                'doc_issue_date' => date('Y-m-d', strtotime($request->doc_issue_date[$i])),
                                'doc_exp_date' => date('Y-m-d', strtotime($request->doc_exp_date[$i])),
                                'doc_review_date' => date('Y-m-d', strtotime($request->doc_review_date[$i])),
                                'doc_cur' => $request->doc_cur[$i],
                            );
                            DB::table('employee_other_doc')->insert($dataupload);
                        }
                    }
                }

                if (!empty($request->type_doc)) {
                    $tot_item_nat = count($request->type_doc);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->type_doc[$i] != '') {
                            if ($request->has('docu_nat')) {

                                $extension_upload_doc = $request->docu_nat[$i]->extension();
                                $path_upload_doc = $request->docu_nat[$i]->store('employee_upload_doc', 'public');

                            } else {
                                $path_upload_doc = '';
                            }
                            $dataupload = array(
                                'emp_id' => $request->emp_code,
                                'type_doc' => $request->type_doc[$i],
                                'emid' => $Roledata->reg,
                                'docu_nat' => $path_upload_doc,
                            );
                            DB::table('employee_upload')->insert($dataupload);
                        }
                    }
                }

                $tot_job_item = count($request->job_name);
                DB::table('employee_job')->where('emp_id', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->delete();
                for ($i = 0; $i < $tot_job_item; $i++) {
                    if ($request->job_name[$i] != '') {
                        $datajob = array(
                            'emp_id' => $decrypted_id,
                            'job_name' => $request->job_name[$i],
                            'job_start_date' => date('Y-m-d', strtotime($request->job_start_date[$i])),
                            'job_end_date' => date('Y-m-d', strtotime($request->job_end_date[$i])),
                            'des' => $request->des[$i],
                            'emid' => $Roledata->reg,
                            'exp' => $request->exp[$i],

                        );
                        DB::table('employee_job')->insert($datajob);
                    }
                }

                $tot_train_item = count($request->tarin_name);
                DB::table('employee_training')->where('emp_id', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->delete();

                for ($i = 0; $i < $tot_train_item; $i++) {
                    if ($request->tarin_name[$i] != '') {
                        $datatrain = array(
                            'emp_id' => $decrypted_id,
                            'train_des' => $request->train_des[$i],
                            'tarin_start_date' => date('Y-m-d', strtotime($request->tarin_start_date[$i])),
                            'tarin_end_date' => date('Y-m-d', strtotime($request->tarin_end_date[$i])),
                            'tarin_name' => $request->tarin_name[$i],

                            'emid' => $Roledata->reg,

                        );
                        DB::table('employee_training')->insert($datatrain);
                    }
                }

                if (!empty($request->quli)) {

                    $tot_item_quli = count($request->quli);

                    for ($i = 0; $i < $tot_item_quli; $i++) {
                        if ($request->quli[$i] != '') {
                            if ($request->has('doc')) {

                                $extension_quli_doc = $request->doc[$i]->extension();
                                $path_quli_doc = $request->doc[$i]->store('employee_quli_doc', 'public');

                            } else {
                                $path_quli_doc = '';
                            }
                            if ($request->has('doc2')) {

                                $extension_quli_doc2 = $request->doc2[$i]->extension();
                                $path_quli_doc2 = $request->doc2[$i]->store('employee_quli_doc2', 'public');

                            } else {
                                $path_quli_doc2 = '';
                            }
                            $dataquli = array(
                                'emp_id' => $request->emp_code,
                                'quli' => $request->quli[$i],
                                'dis' => $request->dis[$i],
                                'ins_nmae' => $request->ins_nmae[$i],
                                'board' => $request->board[$i],
                                'year_passing' => $request->year_passing[$i],
                                'perce' => $request->perce[$i],
                                'grade' => $request->grade[$i],
                                'doc' => $path_quli_doc,
                                'doc2' => $path_quli_doc2,
                                'emid' => $Roledata->reg,
                            );
                            DB::table('employee_qualification')->insert($dataquli);
                        }
                    }
                }

                $payupdate = array(

                    'da' => $request->da,
                    'hra' => $request->hra,
                    'conven_ta' => $request->conven_ta,
                    'perfomance' => $request->perfomance,
                    'monthly_al' => $request->monthly_al,

                    'pf_al' => $request->pf_al,
                    'income_tax' => $request->income_tax,
                    'cess' => $request->cess,
                    'esi' => $request->esi,
                    'professional_tax' => $request->professional_tax,

                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                );
                DB::table('employee_pay_structure')
                    ->where('employee_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($payupdate);
                Session::flash('message', 'Record has been successfully updated');
                return redirect('employees');

            } else {
                //Add mode
                $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Employee Code Code  Already Exists.');
                    return redirect('employees');
                }
                $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('employees');
                }
                $ckeck_email_em = DB::table('employee')->where('emp_ps_email', '=', $request->emp_ps_email)->first();
                if (!empty($ckeck_email_em)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('employees');
                }
                $pay = array(
                    'employee_code' => $request->emp_code,
                    'emid' => $Roledata->reg,
                    'da' => $request->da,
                    'hra' => $request->hra,
                    'conven_ta' => $request->conven_ta,
                    'perfomance' => $request->perfomance,
                    'monthly_al' => $request->monthly_al,

                    'pf_al' => $request->pf_al,
                    'income_tax' => $request->income_tax,
                    'cess' => $request->cess,
                    'esi' => $request->esi,
                    'professional_tax' => $request->professional_tax,

                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                );

                $sm_cch_pass_docu = '';
                $sm_cch_visa_upload_doc = '';
                $sm_cch_visaback_doc = '';
                $sm_cch_pr_add_proof = '';

                if ($request->has('emp_image')) {

                    $file = $request->file('emp_image');
                    $extension = $request->emp_image->extension();
                    $path = $request->emp_image->store('employee_logo', 'public');

                } else {

                    $path = '';

                }
                if ($request->has('pass_docu')) {

                    $file_doc = $request->file('pass_docu');
                    $extension_doc = $request->pass_docu->extension();
                    $path_doc = $request->pass_docu->store('employee_doc', 'public');
                    $sm_cch_pass_docu = $path_doc;

                } else {

                    $path_doc = '';

                }
                if ($request->has('visa_upload_doc')) {

                    $file_visa_doc = $request->file('visa_upload_doc');
                    $extension_visa_doc = $request->visa_upload_doc->extension();
                    $path_visa_doc = $request->visa_upload_doc->store('employee_vis_doc', 'public');
                    $sm_cch_visa_upload_doc = $path_visa_doc;
                } else {

                    $path_visa_doc = '';

                }

                if ($request->has('visaback_doc')) {

                    $file_visa_doc = $request->file('visaback_doc');
                    $extension_visa_doc = $request->visaback_doc->extension();
                    $path_visaback_doc = $request->visaback_doc->store('employee_vis_doc', 'public');
                    $sm_cch_visaback_doc = $path_visaback_doc;
                } else {

                    $path_visaback_doc = '';

                }

                if ($request->has('pr_add_proof')) {

                    $file_per_doc = $request->file('pr_add_proof');
                    $extension_per_doc = $request->pr_add_proof->extension();
                    $path_per_doc = $request->pr_add_proof->store('employee_per_add', 'public');
                    $sm_cch_pr_add_proof = $path_per_doc;
                } else {

                    $path_per_doc = '';

                }

                if ($request->has('ps_add_proof')) {

                    $file_ps_doc = $request->file('ps_add_proof');
                    $extension_ps_doc = $request->ps_add_proof->extension();
                    $path_ps_doc = $request->ps_add_proof->store('employee_ps_add', 'public');

                } else {

                    $path_ps_doc = '';

                }

                if ($request->has('euss_upload_doc')) {

                    $file_ps_doc = $request->file('euss_upload_doc');
                    $extension_ps_doc = $request->euss_upload_doc->extension();
                    $path_euss_doc = $request->euss_upload_doc->store('emp_euss', 'public');

                } else {

                    $path_euss_doc = '';

                }

                if ($request->has('dbs_upload_doc')) {

                    $file_dbs_doc = $request->file('dbs_upload_doc');
                    $extension_dbs_doc = $request->dbs_upload_doc->extension();
                    $path_dbs_doc = $request->dbs_upload_doc->store('emp_dbs', 'public');

                }else {

                    $path_dbs_doc = '';

                }



                if ($request->has('nat_upload_doc')) {

                    $file_ps_doc = $request->file('nat_upload_doc');
                    $extension_ps_doc = $request->nat_upload_doc->extension();
                    $path_nat_doc = $request->nat_upload_doc->store('emp_nation', 'public');

                } else {

                    $path_nat_doc = '';

                }

                $data = array(
                    'pr_add_proof' => $path_per_doc,
                    'ps_add_proof' => $path_ps_doc,
                    'emp_code' => $request->emp_code,
                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),
                    'emp_ps_email' => $request->emp_ps_email,
                    'emp_dob' => date('Y-m-d', strtotime($request->emp_dob)),
                    'emp_ps_phone' => $request->emp_ps_phone,
                    'em_contact' => $request->em_contact,
                    'emp_gender' => $request->emp_gender,
                    'emp_father_name' => $request->emp_father_name,
                    'marital_status' => $request->marital_status,
                    'marital_date' => date('Y-m-d', strtotime($request->marital_date)),
                    'spouse_name' => $request->spouse_name,
                    'nationality' => $request->nationality,

                    'verify_status' => 'not approved',

                    'emp_department' => $request->emp_department,
                    'emp_designation' => $request->emp_designation,
                    'emp_doj' => date('Y-m-d', strtotime($request->emp_doj)),
                    'emp_status' => $request->emp_status,
                    'date_confirm' => date('Y-m-d', strtotime($request->date_confirm)),
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'fte' => $request->fte,
                    'job_loc' => $request->job_loc,
                    'emp_image' => $path,
                    'emp_reporting_auth' => $request->emp_reporting_auth,
                    'emp_lv_sanc_auth' => $request->emp_lv_sanc_auth,

                    'dis_remarks' => $request->dis_remarks,
                    'cri_remarks' => $request->cri_remarks,
                    'criminal' => $request->criminal,

                    'ni_no' => $request->ni_no,
                    'emp_blood_grp' => $request->emp_blood_grp,
                    'emp_eye_sight_left' => $request->emp_eye_sight_left,
                    'emp_eye_sight_right' => $request->emp_eye_sight_right,
                    'emp_weight' => $request->emp_weight,
                    'emp_height' => $request->emp_height,
                    'emp_identification_mark_one' => $request->emp_identification_mark_one,
                    'emp_identification_mark_two' => $request->emp_identification_mark_two,
                    'emp_physical_status' => $request->emp_physical_status,

                    'em_name' => $request->em_name,
                    'em_relation' => $request->em_relation,
                    'em_email' => $request->em_email,
                    'em_phone' => $request->em_phone,
                    'em_address' => $request->em_address,
                    'relation_others' => $request->relation_others,
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_per_village' => $request->emp_per_village,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_state' => $request->emp_pr_state,

                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_state' => $request->emp_ps_state,

                    'nat_id' => $request->nat_id,
                    'place_iss' => $request->place_iss,
                    'iss_date' => $request->iss_date,
                    'exp_date' => date('Y-m-d', strtotime($request->exp_date)),
                    'pass_nation' => $request->pass_nation,
                    'country_residence' => $request->country_residence,
                    'country_birth' => $request->country_birth,
                    'place_birth' => $request->place_birth,

                    'pass_doc_no' => $request->pass_doc_no,
                    'pass_nat' => $request->pass_nat,
                    'issue_by' => $request->issue_by,
                    'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
                    'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
                    'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),
                    'eli_status' => $request->eli_status,
                    'pass_docu' => $path_doc,
                    'cur_pass' => $request->cur_pass,
                    'remarks' => $request->remarks,

                    'visa_doc_no' => $request->visa_doc_no,
                    'visa_nat' => $request->visa_nat,
                    'visa_issue' => $request->visa_issue,
                    'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
                    'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
                    'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),
                    'visa_eli_status' => $request->visa_eli_status,
                    'visa_upload_doc' => $path_visa_doc,
                    'visaback_doc' => $path_visaback_doc,
                    'visa_cur' => $request->visa_cur,
                    'visa_remarks' => $request->visa_remarks,

                    'drive_doc' => $request->drive_doc,
                    'licen_num' => $request->licen_num,
                    'lin_exp_date' => $request->lin_exp_date,

                    'emp_group_name' => $request->emp_group_name,
                    'emp_pay_scale' => $request->emp_pay_scale,
                    'emp_payment_type' => $request->emp_payment_type,
                    'daily' => $request->daily,
                    'min_work' => $request->min_work,
                    'min_rate' => $request->min_rate,
                    'tax_emp' => $request->tax_emp,
                    'tax_ref' => $request->tax_ref,
                    'tax_per' => $request->tax_per,

                    'emp_pay_type' => $request->emp_pay_type,
                    'emp_bank_name' => $request->emp_bank_name,
                    'bank_branch_id' => $request->bank_branch_id,
                    'emp_account_no' => $request->emp_account_no,
                    'emp_sort_code' => $request->emp_sort_code,
                    'currency' => $request->currency,
                    'emid' => $Roledata->reg,
                    'wedges_paymode' => $request->wedges_paymode,
                    'titleof_license' => $request->titleof_license,
                    'cf_license_number' => $request->cf_license_number,
                    'cf_start_date' => date('Y-m-d', strtotime($request->cf_start_date)),
                    'cf_end_date' => date('Y-m-d', strtotime($request->cf_end_date)),

                    'euss_ref_no' => $request->euss_ref_no,
                    'euss_nation' => $request->euss_nation,
                    'euss_issue_date' => date('Y-m-d', strtotime($request->euss_issue_date)),
                    'euss_exp_date' => date('Y-m-d', strtotime($request->euss_exp_date)),
                    'euss_review_date' => date('Y-m-d', strtotime($request->euss_review_date)),
                    'euss_cur' => $request->euss_cur,
                    'euss_upload_doc' => $path_euss_doc,
                    'euss_remarks' => $request->euss_remarks,

                    'dbs_ref_no' => $request->dbs_ref_no,
                    'dbs_nation' => $request->dbs_nation,
                    'dbs_issue_date' => date('Y-m-d', strtotime($request->dbs_issue_date)),
                    'dbs_exp_date' => date('Y-m-d', strtotime($request->dbs_exp_date)),
                    'dbs_review_date' => date('Y-m-d', strtotime($request->dbs_review_date)),
                    'dbs_cur' => $request->dbs_cur,
                    'dbs_remarks' => $request->dbs_remarks,
                    'dbs_type' => $request->dbs_type,
                    'dbs_upload_doc' => $path_dbs_doc,


                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,
                    'nat_upload_doc' => $path_nat_doc,

                    'nat_remarks' => $request->nat_remarks,

                );

                $tot_item_quli = count($request->quli);

                for ($i = 0; $i < $tot_item_quli; $i++) {
                    if ($request->quli[$i] != '') {
                        if ($request->has('doc')) {

                            $extension_quli_doc = $request->doc[$i]->extension();
                            $path_quli_doc = $request->doc[$i]->store('employee_quli_doc', 'public');

                        } else {
                            $path_quli_doc = '';
                        }
                        if ($request->has('doc2')) {

                            $extension_quli_doc2 = $request->doc2[$i]->extension();
                            $path_quli_doc2 = $request->doc2[$i]->store('employee_quli_doc2', 'public');

                        } else {
                            $path_quli_doc2 = '';
                        }
                        $dataquli = array(
                            'emp_id' => $request->emp_code,
                            'quli' => $request->quli[$i],
                            'dis' => $request->dis[$i],
                            'ins_nmae' => $request->ins_nmae[$i],
                            'board' => $request->board[$i],
                            'year_passing' => $request->year_passing[$i],
                            'perce' => $request->perce[$i],
                            'grade' => $request->grade[$i],
                            'doc' => $path_quli_doc,
                            'doc2' => $path_quli_doc2,
                            'emid' => $Roledata->reg,
                        );
                        DB::table('employee_qualification')->insert($dataquli);
                    }
                }

                $tot_job_item = count($request->job_name);

                for ($i = 0; $i < $tot_job_item; $i++) {
                    if ($request->job_name[$i] != '') {
                        $datajob = array(
                            'emp_id' => $request->emp_code,
                            'job_name' => $request->job_name[$i],
                            'job_start_date' => date('Y-m-d', strtotime($request->job_start_date[$i])),
                            'job_end_date' => date('Y-m-d', strtotime($request->job_end_date[$i])),
                            'des' => $request->des[$i],
                            'emid' => $Roledata->reg,
                            'exp' => $request->exp[$i],

                        );
                        DB::table('employee_job')->insert($datajob);
                    }
                }

                $tot_train_item = count($request->tarin_name);

                for ($i = 0; $i < $tot_train_item; $i++) {
                    if ($request->tarin_name[$i] != '') {
                        $datatrain = array(
                            'emp_id' => $request->emp_code,
                            'train_des' => $request->train_des[$i],
                            'tarin_start_date' => date('Y-m-d', strtotime($request->tarin_start_date[$i])),
                            'tarin_end_date' => date('Y-m-d', strtotime($request->tarin_end_date[$i])),
                            'tarin_name' => $request->tarin_name[$i],
                            'emid' => $Roledata->reg,

                        );
                        DB::table('employee_training')->insert($datatrain);
                    }
                }

                if (!empty($request->doc_name)) {
                    $tot_item_nat = count($request->doc_name);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->doc_name[$i] != '') {
                            if ($request->has('doc_upload_doc')) {

                                $extension_upload_doc = $request->doc_upload_doc[$i]->extension();
                                $path_upload_otherdoc = $request->doc_upload_doc[$i]->store('emp_other_doc', 'public');

                            } else {
                                $path_upload_otherdoc = '';
                            }
                            $dataupload = array(
                                'emp_code' => $request->emp_code,
                                'doc_name' => $request->doc_name[$i],
                                'emid' => $Roledata->reg,
                                'doc_upload_doc' => $path_upload_otherdoc,

                                'doc_ref_no' => $request->doc_ref_no[$i],
                                'doc_nation' => $request->doc_nation[$i],
                                'doc_remarks' => $request->doc_remarks[$i],
                                'doc_issue_date' => date('Y-m-d', strtotime($request->doc_issue_date[$i])),
                                'doc_exp_date' => date('Y-m-d', strtotime($request->doc_exp_date[$i])),
                                'doc_review_date' => date('Y-m-d', strtotime($request->doc_review_date[$i])),
                                'doc_cur' => $request->doc_cur[$i],
                            );
                            DB::table('employee_other_doc')->insert($dataupload);
                        }
                    }
                }

                if (!empty($request->type_doc)) {
                    $tot_item_nat = count($request->type_doc);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->type_doc[$i] != '') {
                            if ($request->has('docu_nat')) {

                                $extension_upload_doc = $request->docu_nat[$i]->extension();
                                $path_upload_doc = $request->docu_nat[$i]->store('employee_upload_doc', 'public');

                            } else {
                                $path_upload_doc = '';
                            }
                            $dataupload = array(
                                'emp_id' => $request->emp_code,
                                'type_doc' => $request->type_doc[$i],
                                'emid' => $Roledata->reg,
                                'docu_nat' => $path_upload_doc,
                            );
                            DB::table('employee_upload')->insert($dataupload);
                        }
                    }
                }

                DB::table('employee_pay_structure')->insert($pay);
                DB::table('employee')->insert($data);

                $datachangecir = array(

                    'emp_fname' => strtoupper($request->emp_fname),
                    'emp_mname' => strtoupper($request->emp_mid_name),
                    'emp_lname' => strtoupper($request->emp_lname),

                    'visa_upload_doc' => $sm_cch_visa_upload_doc,
                    'visaback_doc' => $sm_cch_visaback_doc,

                    'pass_docu' => $sm_cch_pass_docu,
                    'pr_add_proof' => $sm_cch_pr_add_proof,

                    'emp_designation' => $request->emp_designation,

                    'emp_ps_phone' => $request->emp_ps_phone,

                    'nationality' => $request->nationality,
                    'ni_no' => $request->ni_no,
                    'pass_doc_no' => $request->pass_doc_no,
                    'pass_nat' => $request->pass_nat,
                    'place_birth' => $request->place_birth,
                    'issue_by' => $request->issue_by,
                    'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
                    'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
                    'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),

                    'remarks' => $request->remarks,
                    'cur_pass' => $request->cur_pass,

                    'visa_doc_no' => $request->visa_doc_no,
                    'visa_nat' => $request->visa_nat,
                    'visa_issue' => $request->visa_issue,
                    'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
                    'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
                    'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),
                    'country_residence' => $request->country_residence,
                    'visa_remarks' => $request->visa_remarks,
                    'visa_cur' => $request->visa_cur,

                    'euss_ref_no' => $request->euss_ref_no,
                    'euss_nation' => $request->euss_nation,
                    'euss_issue_date' => date('Y-m-d', strtotime($request->euss_issue_date)),
                    'euss_exp_date' => date('Y-m-d', strtotime($request->euss_exp_date)),
                    'euss_review_date' => date('Y-m-d', strtotime($request->euss_review_date)),
                    'euss_cur' => $request->euss_cur,
                    'euss_upload_doc' => $path_euss_doc,
                    'euss_remarks' => $request->euss_remarks,

                    'dbs_ref_no' => $request->dbs_ref_no,
                    'dbs_nation' => $request->dbs_nation,
                    'dbs_issue_date' => date('Y-m-d', strtotime($request->dbs_issue_date)),
                    'dbs_exp_date' => date('Y-m-d', strtotime($request->dbs_exp_date)),
                    'dbs_review_date' => date('Y-m-d', strtotime($request->dbs_review_date)),
                    'dbs_cur' => $request->dbs_cur,
                    'dbs_remarks' => $request->dbs_remarks,
                    'dbs_type' => $request->dbs_type,
                    'dbs_upload_doc' => $path_dbs_doc,


                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,
                    'nat_upload_doc' => $path_nat_doc,

                    'nat_remarks' => $request->nat_remarks,

                    'emp_dob' => date('Y-m-d', strtotime($request->emp_dob)),
                    'emp_pr_street_no' => $request->emp_pr_street_no,
                    'emp_per_village' => $request->emp_per_village,
                    'emp_pr_city' => $request->emp_pr_city,
                    'emp_pr_country' => $request->emp_pr_country,
                    'emp_pr_pincode' => $request->emp_pr_pincode,
                    'emp_pr_state' => $request->emp_pr_state,

                    'emp_ps_street_no' => $request->emp_ps_street_no,
                    'emp_ps_village' => $request->emp_ps_village,
                    'emp_ps_city' => $request->emp_ps_city,
                    'emp_ps_country' => $request->emp_ps_country,
                    'emp_ps_pincode' => $request->emp_ps_pincode,
                    'emp_ps_state' => $request->emp_ps_state,

                    'emp_code' => $request->emp_code,
                    'emid' => $Roledata->reg,
                    'hr' => '',
                    'home' => '',
                    'res_remark' => '',

                    'date_change' => date('Y-m-d', strtotime($request->emp_doj)),
                    'change_last' => '',
                    'stat_chage' => '',

                    'unique_law' => '',
                    'repo_ab' => '',
                    'laeve_date' => '',

                );

                DB::table('change_circumstances_history')->insert($datachangecir);

                $p_dd = mt_rand(1000, 9999);
                $ins_data = array(
                    'employee_id' => $request->emp_code,
                    'name' => strtoupper($request->emp_fname) . strtoupper($request->emp_mid_name) . strtoupper($request->emp_lname),
                    'email' => $request->emp_ps_email,
                    'user_type' => 'employee',
                    'password' => $p_dd,
                    'emid' => $Roledata->reg,

                );
                DB::table('users')->insert($ins_data);

                $ins_data_role = array(
                    'menu' => '1',
                    'module_name' => '1',
                    'member_id' => $request->emp_ps_email,
                    'rights' => 'Add',

                    'emid' => $Roledata->reg,

                );

                DB::table('role_authorization')->insert($ins_data_role);

                $ins_data_role1 = array(
                    'menu' => '1',
                    'module_name' => '1',
                    'member_id' => $request->emp_ps_email,
                    'rights' => 'Edit',

                    'emid' => $Roledata->reg,

                );
                DB::table('role_authorization')->insert($ins_data_role1);

                $data = array('firstname' => $request->emp_fname, 'maname' => $request->emp_mid_name, 'email' => $request->emp_ps_email, 'lname' => $request->emp_lname, 'password' => $p_dd);
                $toemail = $request->emp_ps_email;
                // Mail::send('mail', $data, function ($message) use ($toemail) {
                //     $message->to($toemail, env('MAIL_FROM_NAME'))->subject
                //         ('Employee Login  Details');
                //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                // });

                Session::flash('message', 'Please assign the role.');
                return redirect('employees');
                // return redirect('pis/employee');
            }

        } else {
            return redirect('/');
        }
    }

    //end swch employee
    //employee list
    public function employeeblade()
    {
        $data["bonas"] = DB::table("employee")->get();
        return view("employee/employeeReport", $data);
    }
    //employee start
    public function getEmployeeAddFun()
    {
        $data["employee_code"] = rand(1000, 10000);
        $data["department"] = DB::table("department")->get();
        $data["cast"] = Cast::where("cast_status", "=", "active")->get();
        $data["sub_cast"] = Sub_cast::where(
            "sub_cast_status",
            "=",
            "active"
        )->get();
        $data["religion"] = DB::table("religion_master")->get();
        $data["designation"] = DB::table("designation")->get();
        $data["department"] = DB::table("department")->get();
        $data["employeelists"] = Employee::where("emp_status", "REGULAR")
            ->orWhere("emp_status", "PROBATIONARY EMPLOYEE")
            ->get();
        $data["MastersbankName"] = Bank::getMastersBank();
        $data["EARNING"] = DB::table("rate_masters")
            ->where("head_type", "earning")
            ->get();
        $data["DEDUCATION"] = DB::table("rate_masters")
            ->where("head_type", "deduction")
            ->get();
            $data['EmployeeType_master']=EmployeeType::get();

        return view("employee/employeeAdd", $data);
    }

    //ajax department phase
    public function employeebankajkxFun($emp_name)
    {
        $bank_name = Bank::getBranchMaster($emp_name);
        //    DB::table('emp-bank-master')->where('bankname',$emp_name)->get();

        $result_status1 = " <option value='' >Select</option> ";
        foreach ($bank_name as $val) {
            $result_status1 .=
                '<option value="' .
                $val->branch_name .
                '"> ' .
                $val->branch_name .
                "</option>";
        }

        echo $result_status1;
    }
    public function employeebranchajkxFun($branch)
    {
        $bank_name = Bank::getIfcsMaster($branch);
        // DB::table('emp-bank-master')->where('bankbranch',$branch)->get();

        $result_status1 = " <option value='' >Select</option> ";
        foreach ($bank_name as $val) {
            $result_status1 .=
                '<option value="' .
                $val->ifsc_code .
                '"> ' .
                $val->ifsc_code .
                "</option>";
        }

        echo $result_status1;
    }
    public function EmpDepartment($emp_department)
    {
        $department = Department::where("department_name", "=", $emp_department)
            ->where("department_status", "=", "active")

            ->first();
        $designation = Designation::where(
            "department_code",
            "=",
            $department->id
        )
            ->where("designation_status", "=", "active")

            ->get();
        $result = "";

        $result_status1 = " <option value='' >Select</option> ";
        foreach ($designation as $val) {
            $result_status1 .=
                '<option value="' .
                $val->designation_name .
                '"> ' .
                $val->designation_name .
                "</option>";
        }

        echo $result_status1;
    }
    //employee update
    public function employeeeditview($id)
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


            $data["employee_rs"] = Employee::where(
                "id",
                $id
            )->first();
             $data["MastersbankName"] = Bank::getMastersBank();
            // dd($data["employee_rs"]);
            // DB::table('')->where('',emp_bank_name)
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
            // dd($data["EmployeePayStructure"]);
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
            $data['employeeType_masters']=EmployeeType::get();
            return view("employee/edit-employee-new", $data);
        }
    }

    public function saveEmployeecoedit(Request $request)
    {
        // dd($request->all());
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            // $Roledata = Registration::where("email", "=", $email)
            //     ->first();

            // $data["Roledata"] = Registration::where("email", "=", $email)
            //     ->first();
                $employee_data=Employee::where('id',$request->employyeId)->first();
                $employee_id=$request->employyeId;
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
                    // "profileimage" => $request->profileimage,
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
                    // "pass_docu" => $request->pass_docu,
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
                    "emp_status"=>$request->employeetype,

                ];
                DB::table('employee')->where('id',$employee_id)->update($updateData);
                //end employee update

            //profile image upload
            if ($request->hasFile('profileimage')) {
                $image = $request->file('profileimage');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/emp_pic'), $imageName);
                DB::table('employee')->where('id',$employee_id)->update(["profileimage"=>$imageName]);
            }
            //end profile image
            //passport upload
            if ($request->hasFile('pass_docu')) {
                $image = $request->file('pass_docu');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/emp_pic'), $imageName);
                DB::table('employee')->where('id',$employee_id)->update(["pass_docu"=>$imageName]);
            }
            //end passposrt upload


        $documentNames = $request->input("document_name");
        $employeeId = $request->input("employyeId");
        $perId=$request->input("perid");
        if ($request->hasFile("document_upload")) {
            $documents = $request->file("document_upload");
            foreach ($documents as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new EmployeePersonalRecord();
                $documentModel->empid=$employeeId;
                $documentModel->document_name = $documentNames[$key];
                $documentModel->document_upload = $documentName;
                if($perId==null){
                   $documentModel->save();
                }else{
                     $documentModel->where('id',$perId[$key])->update([
                    "document_name"=>$documentNames[$key],
                    "document_upload"=>$documentName,
                ]);
                }
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
                if($erprec==null){
                   ExperienceRecords::insert([
                     'empid'=>$employeeId,
                    'emp_document_name'=>$emp_document_names[$key],
                    'boardss'=>$boardsss[$key],
                    'yearofpassing'=>$yearofpassings[$key],
                    'emp_grade'=>$emp_grades[$key],
                    'emp_document_upload'=>$documentName
                       ]);
                }else{
                     ExperienceRecords::where('id',$erprec[$key])->update([
                    'emp_document_name'=>$emp_document_names[$key],
                    'boardss'=>$boardsss[$key],
                    'yearofpassing'=>$yearofpassings[$key],
                    'emp_grade'=>$emp_grades[$key],
                    'emp_document_upload'=>$documentName
                ]);
                }
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
                 if($proId==null){
                   ProfessionalRecords::insert([
                    'empid'=>$employeeId,
                    'Organization'=>$Organization[$key],
                    'Desigination'=>$Desigination[$key],
                    'formdate'=>$formdate[$key],
                    'todate'=>$todate[$key],
                    'emp1_document_upload'=>$documentName
                       ]);
                }else{
                     $documentModel::where('id',$proId[$key])->update([
                    'Organization'=>$Organization[$key],
                    'Desigination'=>$Desigination[$key],
                    'formdate'=>$formdate[$key],
                    'todate'=>$todate[$key],
                    'emp1_document_upload'=>$documentName
                ]);
                }


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
                // miscdocuments
                if($miscId==null){
                    DB::table('miscdocuments')->insert([
                        'empid'=>$employeeId,
                        'emp_traning'=>$emp_tranings[$key],
                        'traning1_document_upload'=>$documentName
                        ]);
                }else{
                     $documentModel::where('id',$miscId[$key])->update([
                    'emp_traning'=>$emp_tranings[$key],
                    'traning1_document_upload'=>$documentName
                ]);
                }


            }
        }


            // //pay structure

            $pay = [];
            $pay["employee_code"] =$employeeId;
            $pay["basic_pay"] = $request->emp_basic_pay;
            $pay["apf_percent"] = $request->emp_apf_percent;
            $pay["pf_type"] = $request->emp_pf_type;
            // $pay["empid"] = $service_details_id;




            $pay["created_at"] = date("Y-m-d h:i:s");
            $pay["updated_at"] = date("Y-m-d h:i:s");

            if ($request->name_earn && count($request->name_earn) != 0) {
                $arr_un = count(array_unique($request->name_earn));
                if (count($request->name_earn) != $arr_un) {
                    Session::flash(
                        "error",
                        "Pay Structure Earning Head Must be unique"
                    );

                    return redirect("employeeslist");
                }
                // dd($request->value_emp);
                for ($i = 0; $i < count($request->name_earn); $i++) {
                    if ($request->name_earn[$i] != "") {
                        $pay[$request->name_earn[$i]] = $request->value_emp[$i];
                        $pay[$request->name_earn[$i] . "_type"] =
                            $request->head_type[$i];
                    }
                }
            }

            if ($request->name_deduct && count($request->name_deduct) != 0) {
                $arr_un = count(array_unique($request->name_deduct));
                if (count($request->name_deduct) != $arr_un) {
                    Session::flash(
                        "error",
                        "Pay Structure Deduction Head Must be unique"
                    );

                    return redirect("employeeslist");
                }
                for ($i = 0; $i < count($request->name_deduct); $i++) {
                    if ($request->name_deduct[$i] != "") {
                        $pay[$request->name_deduct[$i]] = $request->valuededuct[$i];
                        $pay[$request->name_deduct[$i] . "_type"] =
                            $request->head_typededuct[$i];
                    }
                }
            }
            // dd($pay);
            DB::table('employee_pay_structures')->where('empid', $employee_id)->update($pay);

            // EmployeePayStructure::insert($pay);

            //end pay structure


        Session::flash(
            "message",
            "Employee Information Successfully Saved."
        );

                return redirect("employeeslist");
            }else{
            return redirect("/");
        }
    }

    //employee add
    public function saveEmployeeaa(Request $request)
    {
        $userObj = DB::table("users")
            ->where("email", Session::get("emp_email"))
            ->first();
        $insertData = [];
        $employeeId = $this->generateUniqueEmployeeCode();
        $insertData = [
            "emid" => $userObj->employee_id,
            "emp_code" => $employeeId,
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
            "emp_status"=>$request->employeetype,
        ];

        $service_details_id = DB::table("employee")->insertGetId($insertData);

        //profile image upload
        if ($request->hasFile('profileimage')) {
            $image = $request->file('profileimage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/emp_pic'), $imageName);
            DB::table('employee')->where('id',$service_details_id)->update(["profileimage"=>$imageName]);
        }
        //end profile image
        //passport upload
        if ($request->hasFile('pass_docu')) {
            $image = $request->file('pass_docu');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/emp_pic'), $imageName);
            DB::table('employee')->where('id',$service_details_id)->update(["pass_docu"=>$imageName]);
        }
        //end passposrt upload


        //pay structure

        $pay = [];
        $pay["employee_code"] =$employeeId;
        $pay["basic_pay"] = $request->emp_basic_pay;
        $pay["apf_percent"] = $request->emp_apf_percent;
        $pay["pf_type"] = $request->emp_pf_type;
        $pay["empid"] = $service_details_id;


        $pay["created_at"] = date("Y-m-d h:i:s");
        $pay["updated_at"] = date("Y-m-d h:i:s");

        if ($request->name_earn && count($request->name_earn) != 0) {
            $arr_un = count(array_unique($request->name_earn));
            if (count($request->name_earn) != $arr_un) {
                Session::flash(
                    "error",
                    "Pay Structure Earning Head Must be unique"
                );

                return redirect("employees");
            }
            // dd($request->value_emp);
            for ($i = 0; $i < count($request->name_earn); $i++) {
                if ($request->name_earn[$i] != "") {
                    $pay[$request->name_earn[$i]] = $request->value_emp[$i];
                    $pay[$request->name_earn[$i] . "_type"] =
                        $request->head_type[$i];
                }
            }
        }

        if ($request->name_deduct && count($request->name_deduct) != 0) {
            $arr_un = count(array_unique($request->name_deduct));
            if (count($request->name_deduct) != $arr_un) {
                Session::flash(
                    "error",
                    "Pay Structure Deduction Head Must be unique"
                );

                return redirect("employees");
            }
            for ($i = 0; $i < count($request->name_deduct); $i++) {
                if ($request->name_deduct[$i] != "") {
                    $pay[$request->name_deduct[$i]] = $request->valuededuct[$i];
                    $pay[$request->name_deduct[$i] . "_type"] =
                        $request->head_typededuct[$i];
                }
            }
        }

        EmployeePayStructure::insert($pay);

        //end pay structure


        $documentNames = $request->input("document_name");
        $employeeId = $request->input("empid");

        if ($request->hasFile("document_upload")) {

            $documents = $request->file("document_upload");
            foreach ($documents as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new EmployeePersonalRecord();
                $documentModel->emp_code=$employeeId;
                $documentModel->document_name = $documentNames[$key];
                $documentModel->empid = $service_details_id;
                $documentModel->document_upload = $documentName;
                $documentModel->save();
            }
        }

        $emp_document_names = $request->input("emp_document_name");

        $boardsss = $request->input("boardss");
        $yearofpassings = $request->input("yearofpassing");
        $emp_grades = $request->input("emp_grade");

        if ($request->hasFile("emp_document_upload")) {

            $documents = $request->file("emp_document_upload");

            foreach ($documents as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new ExperienceRecords();

                $documentModel->emp_document_name = $emp_document_names[$key];
                $documentModel->boardss = $boardsss[$key];
                $documentModel->emp_grade = $yearofpassings[$key];
                $documentModel->emp_grade = $emp_grades[$key];
                $documentModel->emp_code=$employeeId;
                $documentModel->empid = $service_details_id;
                $documentModel->emp_document_upload = $documentName;
                $documentModel->save();
            }

        }


        $Organization = $request->input("Organization");
        $Desigination = $request->input("Desigination");
        $formdate = $request->input("formdate");
        $todate = $request->input("todate");

        if ($request->hasFile("emp1_document_upload")) {
            $documentss = $request->file("emp1_document_upload");
            foreach ($documentss as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new ProfessionalRecords();
                $documentModel->emp_code=$employeeId;
                $documentModel->Organization = $Organization[$key];
                $documentModel->Desigination = $Desigination[$key];
                $documentModel->formdate = $formdate[$key];
                $documentModel->todate = $todate[$key];

                $documentModel->empid = $service_details_id;
                $documentModel->emp1_document_upload = $documentName;
                $documentModel->save();
            }
        }

        $emp_tranings = $request->input("emp_traning");
        $traning1_document_upload=$request->input('traning1_document_upload');
        if ($request->hasFile("traning1_document_upload")) {
            $documentss = $request->file("traning1_document_upload");
            foreach ($documentss as $key => $document) {
                $documentName =
                    time() . "_" . $document->getClientOriginalName();
                $document->move(public_path("/emp_pic"), $documentName);
                $documentModel = new MiscDocuments();
                $documentModel->emp_code=$employeeId;
                $documentModel->emp_traning = $emp_tranings[$key];
                $documentModel->empid = $service_details_id;
                $documentModel->traning1_document_upload = $documentName;
                $documentModel->save();
            }
        }


        $name_earn = $request->input("name_earn");
        $head_type = $request->input("head_type");
        $value_emp = $request->input("value_emp");
        foreach ($name_earn as $key => $document) {
            $documentModel = new PayStructure();
            $documentModel->emp_code=$employeeId;
            $documentModel->name_earn = $name_earn[$key];
            $documentModel->empid = $service_details_id;
            $documentModel->head_type = $head_type[$key];
            $documentModel->value_emp = $value_emp[$key];
            $documentModel->save();
        }

        $name_deduct = $request->input("name_deduct");
        $head_typededuct = $request->input("head_typededuct");
        $valuededuct = $request->input("valuededuct");
        foreach ($name_deduct as $key => $document) {
            $documentModel = new Deduction();
            $documentModel->emp_code=$employeeId;
            $documentModel->name_deduct = $name_deduct[$key];
            $documentModel->empid = $service_details_id;
            $documentModel->head_typededuct = $head_typededuct[$key];
            $documentModel->valuededuct = $valuededuct[$key];
            $documentModel->save();
        }
        Session::flash(
            "message",
            "Employee Information Successfully Saved."
        );
        return redirect("employeeslist");

    }
    //end employee

    //emp code genaret fun
    private function generateUniqueEmployeeCode()
    {
        $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        while (\DB::table('employee')->where('emp_code', $code)->exists()) {
            $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }
    //end
    public function ajaxAddRowdeduct($row)
    {
        $data = Rate_master::get();

        $rownew = $row + 1;

        $result =
            ' <tr class="itemslotpaydeduct" id="' .
            $row .
            '" >
                    <td>' .
            $rownew .
            '</td>
                    <td>

                   <select class="form-control deductcls" name="name_deduct[]" id="name_deduct' .
            $row .
            '" onchange="checkdeducttype(this.value,' .
            $row .
            ');">

                                <option value="" selected>Select</option>
                                ';

        foreach ($data as $value) {
            if ($value->id == "1") {
                $name = "da";
            } elseif ($value->id == "2") {
                $name = "vda";
            } elseif ($value->id == "3") {
                $name = "hra";
            } elseif ($value->id == "4") {
                $name = "prof_tax";
            } elseif ($value->id == "5") {
                $name = "others_alw";
            } elseif ($value->id == "6") {
                $name = "tiff_alw";
            } elseif ($value->id == "7") {
                $name = "conv";
            } elseif ($value->id == "8") {
                $name = "medical";
            } elseif ($value->id == "9") {
                $name = "misc_alw";
            } elseif ($value->id == "10") {
                $name = "over_time";
            } elseif ($value->id == "11") {
                $name = "bouns";
            } elseif ($value->id == "12") {
                $name = "leave_inc";
            } elseif ($value->id == "13") {
                $name = "hta";
            } elseif ($value->id == "14") {
                $name = "tot_inc";
            } elseif ($value->id == "15") {
                $name = "pf";
            } elseif ($value->id == "16") {
                $name = "pf_int";
            } elseif ($value->id == "17") {
                $name = "apf";
            } elseif ($value->id == "18") {
                $name = "i_tax";
            } elseif ($value->id == "19") {
                $name = "insu_prem";
            } elseif ($value->id == "20") {
                $name = "pf_loan";
            } elseif ($value->id == "21") {
                $name = "esi";
            } elseif ($value->id == "22") {
                $name = "adv";
            } elseif ($value->id == "23") {
                $name = "hrd";
            } elseif ($value->id == "24") {
                $name = "co_op";
            } elseif ($value->id == "25") {
                $name = "furniture";
            } elseif ($value->id == "26") {
                $name = "misc_ded";
            } elseif ($value->id == "27") {
                $name = "tot_ded";
            } elseif ($value->id == "29") {
                $name = "pf_employerc";
            }
            if ($value->head_type == "deduction") {
                $result .=
                    '<option value="' .
                    $name .
                    '">' .
                    $value->head_name .
                    "</option>";
            }
        }

        $result .=
            '</select>

</td>
    <td><select class="form-control" name="head_typededuct[]" id="head_typededuct' .
            $row .
            '" onchange="checkdeductvalue(this.value,' .
            $row .
            ');">

                                <option value="" selected>Select</option>
                                <option value="F">Fixed</option>
                                <option value="V">Variable</option>
                                </select></td>
    <td><input type="text" name="valuededuct[]"  id="valuededuct' .
            $row .
            '" class="form-control"></td>



      <td><button class="btn-success" style="" type="button" id="adddeduct' .
            $rownew .
            '" onClick="addnewrowdeduct(' .
            $rownew .
            ')" data-id="deduct' .
            $row .
            '"> <i class="ti-plus"></i> </button>
     <button class="btn-danger deleteButtondeduct" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="deldeduct' .
            $row .
            '"  onClick="delRowdeduct(' .
            $row .
            ')"> <i class="ti-minus"></i> </button></td>
  </tr>';

        echo $result;
    }
    public function ajaxAddRowearn($row)
    {
        $data = Rate_master::get();

        $rownew = $row + 1;

        $result =
            ' <tr class="itemslotpayearn" id="' .
            $row .
            '" >
                    <td>' .
            $rownew .
            '</td>
                    <td>

                   <select class="form-control earninigcls" name="name_earn[]" id="name_earn' .
            $row .
            '" onchange="checkearntype(this.value,' .
            $row .
            ');">

                                <option value="" selected>Select</option>';

        foreach ($data as $value) {
            if ($value->id == "1") {
                $name = "da";
            } elseif ($value->id == "2") {
                $name = "vda";
            } elseif ($value->id == "3") {
                $name = "hra";
            } elseif ($value->id == "4") {
                $name = "prof_tax";
            } elseif ($value->id == "5") {
                $name = "others_alw";
            } elseif ($value->id == "6") {
                $name = "tiff_alw";
            } elseif ($value->id == "7") {
                $name = "conv";
            } elseif ($value->id == "8") {
                $name = "medical";
            } elseif ($value->id == "9") {
                $name = "misc_alw";
            } elseif ($value->id == "10") {
                $name = "over_time";
            } elseif ($value->id == "11") {
                $name = "bouns";
            } elseif ($value->id == "12") {
                $name = "leave_inc";
            } elseif ($value->id == "13") {
                $name = "hta";
            } elseif ($value->id == "14") {
                $name = "tot_inc";
            } elseif ($value->id == "15") {
                $name = "pf";
            } elseif ($value->id == "16") {
                $name = "pf_int";
            } elseif ($value->id == "17") {
                $name = "apf";
            } elseif ($value->id == "18") {
                $name = "i_tax";
            } elseif ($value->id == "19") {
                $name = "insu_prem";
            } elseif ($value->id == "20") {
                $name = "pf_loan";
            } elseif ($value->id == "21") {
                $name = "esi";
            } elseif ($value->id == "22") {
                $name = "adv";
            } elseif ($value->id == "23") {
                $name = "hrd";
            } elseif ($value->id == "24") {
                $name = "co_op";
            } elseif ($value->id == "25") {
                $name = "furniture";
            } elseif ($value->id == "26") {
                $name = "misc_ded";
            } elseif ($value->id == "27") {
                $name = "tot_ded";
            }
            if ($value->head_type == "earning") {
                $result .=
                    '<option value="' .
                    $name .
                    '">' .
                    $value->head_name .
                    "</option>";
            }
        }

        $result .=
            '</select>

</td>
    <td><select class="form-control" name="head_type[]" id="head_type' .
            $row .
            '" onchange="checkearnvalue(this.value,' .
            $row .
            ');">

                                <option value="" selected>Select</option>
                                <option value="F">Fixed</option>
                                <option value="V">Variable</option>
                                </select></td>
    <td><input type="text" name="value_emp[]"  id="value' .
            $row .
            '" class="form-control"></td>



     <td><button class="btn-success" style="" type="button" id="addearn' .
            $rownew .
            '" onClick="addnewrowearn(' .
            $rownew .
            ')" data-id="earn' .
            $rownew .
            '"> <i class="ti-plus"></i> </button>
     <button class="btn-danger deleteButtonearn" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="delearn' .
            $row .
            '"  onClick="delRowearn(' .
            $row .
            ')"> <i class="ti-minus"></i> </button></td>
  </tr>';

        echo $result;
    }

    //employee end
    // public function getEmployees()
    // {
    //     if (!empty(Session::get("emp_email"))) {
    //         $email = Session::get("emp_email");
    //         $Roledata = DB::table("registration")
    //             ->where("status", "=", "active")

    //             ->where("email", "=", $email)
    //             ->first();

    //         // $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

    //         //     $query->whereNull('employee.emp_status')
    //         //         ->orWhere('employee.emp_status', '!=', 'LEFT');
    //         // })->get();
    //         $data["employee_rs"] = DB::table("employee_bulk_data")->get();

    //         return view("employee/employee", $data);
    //     } else {
    //         return redirect("/");
    //     }
    // }

    public function getEmployeesLeft()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_rs"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->where("emp_status", "=", "LEFT")
                ->get();

            return view("employee/employee", $data);
        } else {
            return redirect("/");
        }
    }

    public function getEmployeesmigrant()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $data["employee_rs"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->where(function ($query) {
                    $query
                        ->whereNull("employee.emp_status")
                        ->orWhere("employee.emp_status", "!=", "LEFT");
                })
                //->where('employee.visa_exp_date','!=','1970-01-01')
                //->where('employee.euss_exp_date','!=','1970-01-01')
                ->where(function ($query) {
                    $query
                        ->orWhereNotNull("employee.visa_doc_no")
                        // ->orWhereNotNull('employee.visa_exp_date')
                        // ->orWhereNotNull('employee.euss_exp_date')

                        ->orWhereNotNull("employee.euss_ref_no");
                })
                ->get();

            //dd($data['employee_rs']);

            return view("employee/employee-migrant", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewAddEmployeereportnew($comp_id, $emp_id)
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("reg", "=", base64_decode($comp_id))
                ->first();
            $employeedata = DB::table("employee")

                ->where("emid", "=", base64_decode($comp_id))
                ->where("emp_code", "=", base64_decode($emp_id))
                ->first();

            $datap = ["Roledata" => $Roledata, "employeedata" => $employeedata];

            $pdf = PDF::loadView("mypdfemployee", $datap);
            return $pdf->download("employeereport.pdf");
        } else {
            return redirect("/");
        }
    }

    public function viewAddEmployeereportnewsenmail($comp_id, $emp_id)
    {
        $email = Session::get("emp_email");
        if (!empty($email)) {
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("reg", "=", base64_decode($comp_id))
                ->first();
            $employeedata = DB::table("employee")

                ->where("emid", "=", base64_decode($comp_id))
                ->where("emp_code", "=", base64_decode($emp_id))
                ->first();

            $dataup = [
                "Roledata" => $Roledata,
                "employeedata" => $employeedata,
            ];
            $toemail = $employeedata->emp_ps_email;

            Mail::send("mailemployemigrsend", $dataup, function ($message) use (
                $toemail
            ) {
                $message
                    ->to($toemail, "Workpermitcloud")
                    ->subject("Visa Expiry Reminder");

                $message->from(
                    "noreply@workpermitcloud.co.uk",
                    "Workpermitcloud"
                );
            });
            Session::flash("message", "Mail send Successfully.");

            return redirect("migrant-employees");
        } else {
            return redirect("/");
        }
    }

    // public function viewAddEmployee(Request $request)
    // {
    //     if (!empty(Session::get("emp_email"))) {
    //         $email = Session::get("emp_email");
    //         $Roledata = DB::table("registration")
    //             ->where("status", "=", "active")

    //             ->where("email", "=", $email)
    //             ->first();

    //         $data["Roledata"] = DB::table("registration")
    //             ->where("status", "=", "active")

    //             ->where("email", "=", $email)
    //             ->first();
    //         $data["payment_wedes_rs"] = DB::table("payment_type_wedes")
    //             ->where("emid", "=", $Roledata->reg)
    //             ->get();

    //         // $id = Input::get('q');
    //         $id = $request->q;
    //         if ($id) {
    //             //dd($id);
    //             function my_simple_crypt($string, $action = "encrypt")
    //             {
    //                 // you may change these values to your own
    //                 $secret_key = "bopt_saltlake_kolkata_secret_key";
    //                 $secret_iv = "bopt_saltlake_kolkata_secret_iv";

    //                 $output = false;
    //                 $encrypt_method = "AES-256-CBC";
    //                 $key = hash("sha256", $secret_key);
    //                 $iv = substr(hash("sha256", $secret_iv), 0, 16);

    //                 if ($action == "encrypt") {
    //                     $output = base64_encode(
    //                         openssl_encrypt(
    //                             $string,
    //                             $encrypt_method,
    //                             $key,
    //                             0,
    //                             $iv
    //                         )
    //                     );
    //                 } elseif ($action == "decrypt") {
    //                     $output = openssl_decrypt(
    //                         base64_decode($string),
    //                         $encrypt_method,
    //                         $key,
    //                         0,
    //                         $iv
    //                     );
    //                 }

    //                 return $output;
    //             }
    //             ///
    //             //$encrypted = my_simple_crypt( 'Hello World!', 'encrypt' );
    //             $decrypted_id = my_simple_crypt($id, "decrypt");

    //             $data["employee_rs"] = DB::table("employee")
    //                 ->join(
    //                     "employee_pay_structure",
    //                     "employee.emp_code",
    //                     "=",
    //                     "employee_pay_structure.employee_code"
    //                 )
    //                 ->where("employee.emp_code", "=", $decrypted_id)
    //                 ->where("employee.emid", "=", $Roledata->reg)
    //                 ->where("employee_pay_structure.emid", "=", $Roledata->reg)
    //                 ->select("employee.*", "employee_pay_structure.*")
    //                 ->get();

    //             $data["employee_job_rs"] = DB::table("employee_job")
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();

    //             $data["employee_quli_rs"] = DB::table("employee_qualification")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->get();

    //             $data["employee_otherd_doc_rs"] = DB::table(
    //                 "employee_other_doc"
    //             )
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("emp_code", "=", $decrypted_id)
    //                 ->get();
    //             $data["employee_train_rs"] = DB::table("employee_training")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->get();

    //             $data["employee_upload_rs"] = DB::table("employee_upload")
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();

    //             $empdepartmen = DB::table("department")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where(
    //                     "department_name",
    //                     "=",
    //                     $data["employee_rs"][0]->emp_department
    //                 )
    //                 ->where("department_status", "=", "active")
    //                 ->first();

    //             $data["department"] = DB::table("department")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("department_status", "=", "active")
    //                 ->get();

    //             if (!empty($empdepartmen)) {
    //                 $data["designation"] = DB::table("designation")
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->where("department_code", "=", $empdepartmen->id)
    //                     ->where("designation_status", "=", "active")
    //                     ->get();
    //             } else {
    //                 $data["designation"] = "";
    //             }

    //             $data["employee_type"] = DB::table("employee_type")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("employee_type_status", "=", "active")
    //                 ->get();
    //             $emppaygr = DB::table("pay_scale_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where(
    //                     "payscale_code",
    //                     "=",
    //                     $data["employee_rs"][0]->emp_group_name
    //                 )
    //                 ->first();
    //             $data["grade"] = DB::table("grade")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("grade_status", "=", "active")
    //                 ->get();
    //             if (!empty($emppaygr)) {
    //                 $data["annul"] = DB::table("pay_scale_basic_master")
    //                     ->where("pay_scale_master_id", "=", $emppaygr->id)
    //                     ->get();
    //             } else {
    //                 $data["annul"] = "";
    //             }

    //             $data["currency_user"] = DB::table("currencies")
    //                 ->orderBy("country", "asc")
    //                 ->get();
    //             $data["bank"] = DB::table("bank_masters")->get();
    //             $data["payscale_master"] = DB::table("pay_scale_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             $data["nation_master"] = DB::table("nationality_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->orderBy("name", "asc")
    //                 ->get();
    //             $data["payment_type_master"] = DB::table("payment_type_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             $data["currency_master"] = DB::table("currency_code")->get();
    //             $data["tax_master"] = DB::table("tax_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();

    //             $data["employeelists"] = DB::table("employee")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             if ($data["employee_rs"][0]->emp_pr_pincode != "") {
    //                 $data["employee_pin_rs"] =
    //                     "<option value=''>&nbsp;</option>";
    //             } else {
    //                 $data["employee_pin_rs"] =
    //                     "<option value=''>&nbsp;</option>";
    //             }
    //             // dd($data['nation_master']);
    //             return view("employee/edit-employee", $data);
    //         } else {
    //             $emp_cof = DB::table("registration")
    //                 ->where("status", "=", "active")
    //                 ->where("email", "=", $email)
    //                 ->first();

    //             $emp_totcof = DB::table("employee")

    //                 ->where("emid", "=", $emp_cof->reg)
    //                 ->orderBy("id", "desc")
    //                 ->get();

    //             if (count($emp_totcof) != 0) {
    //                 $firstRecordEmpCode = $emp_totcof[0]->emp_code;
    //             } else {
    //                 $firstRecordEmpCode = "001";
    //             }

    //             $result = explode(" ", trim($emp_cof->com_name));

    //             $rsnew = strtoupper(substr($result["0"], 0, 3));

    //             $lastCodeNum = str_replace($rsnew, "", $firstRecordEmpCode);

    //             // dd($emp_totcof);

    //             $countslug = DB::table("registration")
    //                 ->where("com_name", "like", $rsnew . "%")
    //                 ->where("status", "=", "active")
    //                 ->where("verify", "=", "approved")
    //                 ->where("email", "!=", $email)
    //                 ->where("licence", "=", "yes")
    //                 ->get();

    //             // dd($countslug);

    //             if (count($emp_totcof) != 0) {
    //                 // if (count($countslug) != 0) {
    //                 //     $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 4)) . ($lastCodeNum + 1);
    //                 // } else {
    //                 //     $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) . ($lastCodeNum + 1);
    //                 // }

    //                 //fix made 11-06-22 for exponential issue
    //                 $emp_code = $rsnew . ($lastCodeNum + 1);

    //                 if ($emp_code == $firstRecordEmpCode) {
    //                     if (count($countslug) != 0) {
    //                         $emp_code =
    //                             strtoupper(
    //                                 substr($emp_totcof[0]->emp_code, 0, 4)
    //                             ) .
    //                             ($lastCodeNum + 2);
    //                     } else {
    //                         $emp_code =
    //                             strtoupper(
    //                                 substr($emp_totcof[0]->emp_code, 0, 3)
    //                             ) .
    //                             ($lastCodeNum + 2);
    //                     }
    //                 }
    //                 //dd($emp_code);
    //             } else {
    //                 $countslug = DB::table("registration")
    //                     ->where("com_name", "like", $rsnew . "%")
    //                     ->where("status", "=", "active")
    //                     ->where("verify", "=", "approved")
    //                     ->where("email", "!=", $email)
    //                     ->where("licence", "=", "yes")
    //                     ->get();

    //                 if (count($countslug) != 0) {
    //                     $ko = 1;
    //                     $new = 0;
    //                     $countslug = DB::table("registration")
    //                         ->where("com_name", "like", $rsnew . "%")
    //                         ->where("status", "=", "active")
    //                         ->where("verify", "=", "approved")

    //                         ->where("licence", "=", "yes")
    //                         ->get();
    //                     foreach ($countslug as $valnew) {
    //                         if ($valnew->id == $emp_cof->id) {
    //                             $new = $ko++;
    //                         } else {
    //                             $ko++;
    //                         }
    //                     }

    //                     $rest = $rsnew . $new;
    //                 } else {
    //                     $rest = $rsnew;
    //                 }

    //                 $emp_code = $rest . (count($emp_totcof) + 1);
    //             }
    //             // dd($emp_code);
    //             $data["employee_code"] = $emp_code;
    //             $data["currency_user"] = DB::table("currencies")
    //                 ->orderBy("country", "asc")
    //                 ->get();
    //             $data["department"] = DB::table("department")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("department_status", "=", "active")
    //                 ->get();
    //             $data["designation"] = DB::table("designation")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("designation_status", "=", "active")
    //                 ->get();

    //             $data["employee_type"] = DB::table("employee_type")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("employee_type_status", "=", "active")
    //                 ->get();
    //             $data["grade"] = DB::table("grade")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->where("grade_status", "=", "active")
    //                 ->get();
    //             $data["bank"] = DB::table("bank_masters")->get();
    //             $data["payscale_master"] = DB::table("pay_scale_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             $data["nation_master"] = DB::table("nationality_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->orderBy("name", "asc")
    //                 ->get();
    //             $data["payment_type_master"] = DB::table("payment_type_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             $data["currency_master"] = DB::table("currency_code")->get();
    //             $data["tax_master"] = DB::table("tax_master")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();

    //             $data["employeelists"] = DB::table("employee")
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             //echo "<pre>";print_r($data['states']);exit;

    //             $data["grade_master"] = DB::table("grade_master")->get();
    //             // $data['class_master'] = DB::table('class_master')->get();
    //             $data["pin_code_master"] = DB::table("pin_code_master")->get();
    //             // $data['employee_type_master'] = DB::table('employee_type_master')->get();
    //             $data["ifsc_master"] = DB::table("ifsc_master")->get();
    //             $data["caste_master"] = DB::table("caste_master")->get();
    //             $data["religion_master"] = DB::table("religion_master")->get();
    //             $data["education_master"] = DB::table(
    //                 "education_master"
    //             )->get();
    //             $data["department"] = DB::table("department")->get();
    //             $data["designation"] = DB::table("designation")->get();
    //             // $data['employee_type_master'] = DB::table('employee_type_master')->get();
    //             return view("employee/add-employee", $data);
    //         }
    //     } else {
    //         return redirect("/");
    //     }

    //     //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    // }
    public function testqueexample()
    {
        dd($_POST);
    }
    public function viewAddEmployeemigrant()
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

            $id = Input::get("q");
            $data["payment_wedes_rs"] = DB::table("payment_type_wedes")
                ->where("emid", "=", $Roledata->reg)
                ->get();
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

                $data["employee_otherd_doc_rs"] = DB::table(
                    "employee_other_doc"
                )
                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_code", "=", $decrypted_id)
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

                $data["employee_type"] = DB::table("employ_type_master")
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

                $data["currency_user"] = DB::table("currencies")
                    ->orderBy("country", "asc")
                    ->get();
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
                $data["currency_master"] = DB::table("currency_code")->get();
                $data["tax_master"] = DB::table("tax_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                $data["employeelists"] = DB::table("employee")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                if ($data["employee_rs"][0]->emp_pr_pincode != "") {
                    $data["employee_pin_rs"] = "<option value=''>&nbsp;</option>
";
                } else {
                    $data["employee_pin_rs"] = "<option value=''>&nbsp;</option>
";
                }

                $data["employee_upload_rs"] = DB::table("employee_upload")
                    ->where("emp_id", "=", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                return view("employee/edit-employee-migrant", $data);
            } else {
                $emp_cof = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $emp_totcof = DB::table("employee")

                    ->where("emid", "=", $emp_cof->reg)
                    ->orderBy("id", "desc")
                    ->get();
                $result = explode(" ", trim($emp_cof->com_name));

                $rsnew = strtoupper(substr($result["0"], 0, 3));

                $countslug = DB::table("registration")
                    ->where("com_name", "like", $rsnew . "%")
                    ->where("status", "=", "active")
                    ->where("verify", "=", "approved")
                    ->where("email", "!=", $email)
                    ->where("licence", "=", "yes")
                    ->get();
                if (count($emp_totcof) != 0) {
                    if (count($countslug) != 0) {
                        $emp_code =
                            strtoupper(substr($emp_totcof[0]->emp_code, 0, 4)) .
                            (count($emp_totcof) + 1);
                    } else {
                        $emp_code =
                            strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) .
                            (count($emp_totcof) + 1);
                    }
                } else {
                    $countslug = DB::table("registration")
                        ->where("com_name", "like", $rsnew . "%")
                        ->where("status", "=", "active")
                        ->where("verify", "=", "approved")
                        ->where("email", "!=", $email)
                        ->where("licence", "=", "yes")
                        ->get();

                    if (count($countslug) != 0) {
                        $countslug = DB::table("registration")
                            ->where("com_name", "like", $rsnew . "%")
                            ->where("status", "=", "active")
                            ->where("verify", "=", "approved")

                            ->where("licence", "=", "yes")
                            ->get();

                        $ko = 1;
                        $new = 0;
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
                $data["employee_code"] = $emp_code;
                $data["currency_user"] = DB::table("currencies")
                    ->orderBy("country", "asc")
                    ->get();
                $data["department"] = DB::table("department")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("department_status", "=", "active")
                    ->get();
                $data["designation"] = DB::table("designation")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("designation_status", "=", "active")
                    ->get();

                $data["employee_type"] = DB::table("employee_type")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("employee_type_status", "=", "active")
                    ->get();
                $data["grade"] = DB::table("grade")
                    ->where("emid", "=", $Roledata->reg)
                    ->where("grade_status", "=", "active")
                    ->get();
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
                $data["currency_master"] = DB::table("currency_code")->get();
                $data["tax_master"] = DB::table("tax_master")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                $data["employeelists"] = DB::table("employee")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();

                //echo "<pre>";print_r($data['states']);exit;

                return view("employee/add-employee", $data);
            }
        } else {
            return redirect("/");
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function downloadExcel()
    {
        return Excel::download(
            new EmployeeBulkDataTableExport(null, null, null),
            "employees.xlsx"
        );
    }

    public function downloadSampleExcel()
    {
        $filePath = public_path("sample_employee_data_for_testing.xlsx");
        $headers = [
            "Content-Type" =>
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        ];

        return Response::download($filePath, "sample_employee.xlsx", $headers);
    }

    public function generateReport(Request $request)
    {
        $departments = DB::table("department")->get();
        $grades = DB::table("emp_class_master")->get();
        $designations = DB::table("designation")->get();
        return view(
            "employee/generate-report",
            compact("departments", "grades", "designations")
        );
    }

    public function downloadEmployeeReport(Request $request)
    {
        $selectedDepartments = $request->input("selectedDepartments", []);
        $selectedGrades = $request->input("selectedGrades", []);
        $selectedDesignations = $request->input("selectedDesignations", []);

        // You need to implement your report generation logic here
        // For this example, we'll use the EmployeeBulkDataTableExport export class
        $export = new EmployeeBulkDataTableExport(
            $selectedDepartments,
            $selectedGrades,
            $selectedDesignations
        );

        // Modify the query of the export based on selected criteria
        // $export->filterByDepartments($selectedDepartments);
        // $export->filterByGrades($selectedGrades);
        // $export->filterByDesignations($selectedDesignations);

        // Generate the report and return the download response
        return Excel::download($export, "employee_report.xlsx");
    }

    public function addEmployeeByForm(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            "si_no" => "required|max:300",
            "employee_id" => "required|max:300",
            "employee_code" => "required|max:300",
            "employee_name" => "required|max:300",
            "father_name" => "required|max:300",
            "department" => "required|max:300",
            "designation" => "required|max:300",
            "dob" => "required|max:300",
            "doj" => "required|max:300",
            "emp_status" => "required|max:300",
            "status" => "required|max:300",
            "address" => "required|max:300",
            "city" => "required|max:300",
            "state" => "required|max:300",
            "country" => "required|max:300",
            "pincode" => "required|max:300",
            "mobile_no" => "required|max:300",
            "class" => "required|max:300",
            "pf_no" => "required|max:300",
            "uan_no" => "required|max:300",
            "pan_no" => "required|max:300",
            "bank" => "required|max:300",
            "ifsc_code" => "required|max:300",
            "account_no" => "required|max:300",
        ]);

        // Prepare data to be inserted into the employee_bulk_data table
        $employeeData = [
            "si_no" => $request->si_no,
            "employee_id" => $request->employee_id,
            "employee_code" => $request->employee_code,
            "employee_name" => $request->employee_name,
            "father_name" => $request->father_name,
            "department" => $request->department,
            "designation" => $request->designation,
            "dob" => $request->dob,
            "doj" => $request->doj,
            "emp_status" => $request->emp_status,
            "status" => $request->status,
            "religion" => $request->religion,
            "caste" => $request->caste,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "country" => $request->country,
            "pincode" => $request->pincode,
            "mobile_no" => $request->mobile_no,
            "class" => $request->class,
            "pf_no" => $request->pf_no,
            "uan_no" => $request->uan_no,
            "pan_no" => $request->pan_no,
            "bank" => $request->bank,
            "ifsc_code" => $request->ifsc_code,
            "account_no" => $request->account_no,
        ];

        // Insert data into the employee_bulk_data table
        DB::table("employee_bulk_data")->insert($employeeData);

        // Redirect to a success page or take other actions
        return redirect()
            ->back()
            ->with("success", "CSV data has been uploaded successfully.");
    }
    public function uploadEmployee(Request $request)
    {
        // Get the uploaded Excel file
        $file = $request->file("excel_file");

        // Read the data from the Excel file
        $data = Excel::toArray([], $file);

        // Extract the header row
        $header = array_shift($data[0]);
        ini_set("max_execution_time", "300");
        // Process and insert the data into the database
        foreach ($data[0] as $row) {
            // Ensure the row has the same number of elements as the header
            if (count($row) !== count($header)) {
                continue;
            }

            $record = array_combine($header, $row);
            DB::table("employee_bulk_data")->insert($record);
        }
        return redirect()
            ->back()
            ->with("success", "CSV data has been uploaded successfully.");
    }

    public function edit($id)
    {
        $employee = DB::table("employee_bulk_data")->find($id);
        return view("employee/new-edit-employee", compact("employee"));
    }

    public function update(Request $request, $id)
    {
        // Prepare data to be inserted into the employee_bulk_data table
        $employeeData = [
            "si_no" => $request->si_no,
            "employee_id" => $request->employee_id,
            "employee_code" => $request->employee_code,
            "employee_name" => $request->employee_name,
            "father_name" => $request->father_name,
            "department" => $request->department,
            "designation" => $request->designation,
            "dob" => $request->dob,
            "doj" => $request->doj,
            "emp_status" => $request->emp_status,
            "status" => $request->status,
            "religion" => $request->religion,
            "caste" => $request->caste,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "country" => $request->country,
            "pincode" => $request->pincode,
            "mobile_no" => $request->mobile_no,
            "class" => $request->class,
            "pf_no" => $request->pf_no,
            "uan_no" => $request->uan_no,
            "pan_no" => $request->pan_no,
            "bank" => $request->bank,
            "ifsc_code" => $request->ifsc_code,
            "account_no" => $request->account_no,
        ];

        // Update the employee record
        DB::table("employee_bulk_data")
            ->where("id", $id)
            ->update($employeeData);

        return redirect("employees");
    }

    public function destroy($id)
    {
        DB::table("employee_bulk_data")
            ->where("id", $id)
            ->delete();
        return redirect("employees");
    }

    // public function saveEmployee(Request $request)
    // {
    //     if (!empty(Session::get("emp_email"))) {
    //         $email = Session::get("emp_email");
    //         $Roledata = DB::table("registration")
    //             ->where("status", "=", "active")

    //             ->where("email", "=", $email)
    //             ->first();

    //         $data["Roledata"] = DB::table("registration")
    //             ->where("status", "=", "active")

    //             ->where("email", "=", $email)
    //             ->first();

    //         function my_simple_crypt($string, $action = "encrypt")
    //         {
    //             // you may change these values to your own
    //             $secret_key = "bopt_saltlake_kolkata_secret_key";
    //             $secret_iv = "bopt_saltlake_kolkata_secret_iv";

    //             $output = false;
    //             $encrypt_method = "AES-256-CBC";
    //             $key = hash("sha256", $secret_key);
    //             $iv = substr(hash("sha256", $secret_iv), 0, 16);

    //             if ($action == "encrypt") {
    //                 $output = base64_encode(
    //                     openssl_encrypt($string, $encrypt_method, $key, 0, $iv)
    //                 );
    //             } elseif ($action == "decrypt") {
    //                 $output = openssl_decrypt(
    //                     base64_decode($string),
    //                     $encrypt_method,
    //                     $key,
    //                     0,
    //                     $iv
    //                 );
    //             }

    //             return $output;
    //         }

    //         //print_r($request->hasFile('emp_image')); print_r($request->edit_emp_image); exit;
    //         if (
    //             !empty($request->edit_emp_image) &&
    //             $request->hasFile("emp_image") == 1
    //         ) {
    //             $files = $request->file("emp_image");
    //             $filename = $files->store("emp_pic");
    //         } elseif (
    //             empty($request->edit_emp_image) &&
    //             $request->hasFile("emp_image") == 1
    //         ) {
    //             $files = $request->file("emp_image");
    //             $filename = $files->store("emp_pic");
    //         } elseif (
    //             !empty($request->edit_emp_image) &&
    //             $request->hasFile("emp_image") != 1
    //         ) {
    //             $filename = $request->edit_emp_image;
    //         } else {
    //             $filename = "";
    //         }

    //         $id = $request->get("q");

    //         if ($id) {
    //             //edit mode
    //             $decrypted_id = my_simple_crypt($id, "decrypt");

    //             $ckeck_dept = DB::table("employee")
    //                 ->where("emp_code", $request->emp_code)
    //                 ->where("emp_code", "!=", $decrypted_id)
    //                 ->where("emid", $Roledata->reg)
    //                 ->first();
    //             if (!empty($ckeck_dept)) {
    //                 Session::flash(
    //                     "message",
    //                     "Employee Code Code  Already Exists."
    //                 );
    //                 return redirect("employees");
    //             }

    //             $ckeck_email = DB::table("users")
    //                 ->where("email", "=", $request->emp_ps_email)
    //                 ->where("employee_id", "!=", $decrypted_id)
    //                 ->where("status", "=", "active")
    //                 ->where("emid", $Roledata->reg)
    //                 ->first();
    //             if (!empty($ckeck_email)) {
    //                 Session::flash("message", "E-mail id  Already Exists.");
    //                 return redirect("employees");
    //             }

    //             $ckeck_right = DB::table("right_works")
    //                 ->where("employee_id", "=", $decrypted_id)
    //                 ->where("emid", $Roledata->reg)
    //                 ->first();

    //             if (!empty($ckeck_right)) {
    //                 $datarigh_edit = [
    //                     "start_date" => date(
    //                         "Y-m-d",
    //                         strtotime($request->emp_doj)
    //                     ),
    //                 ];

    //                 DB::table("right_works")
    //                     ->where("employee_id", "=", $decrypted_id)
    //                     ->where("emid", $Roledata->reg)
    //                     ->update($datarigh_edit);
    //             }

    //             if (!empty($request->emqliup)) {
    //                 $tot_item_edit_quli = count($request->emqliup);

    //                 foreach ($request->emqliup as $value) {
    //                     if ($request->input("quli_" . $value) != "") {
    //                         if ($request->has("doc_" . $value)) {
    //                             $extension_doc_edit = $request
    //                                 ->file("doc_" . $value)
    //                                 ->extension();
    //                             $path_quli_doc_edit = $request
    //                                 ->file("doc_" . $value)
    //                                 ->store("employee_quli_doc", "public");
    //                             $dataimgedit = [
    //                                 "doc" => $path_quli_doc_edit,
    //                             ];
    //                             DB::table("employee_qualification")
    //                                 ->where("emid", "=", $Roledata->reg)
    //                                 ->where("id", $value)
    //                                 ->update($dataimgedit);
    //                         }
    //                         if ($request->has("doc2_" . $value)) {
    //                             $extension_doc_edit2 = $request
    //                                 ->file("doc2_" . $value)
    //                                 ->extension();
    //                             $path_quli_doc_edit2 = $request
    //                                 ->file("doc2_" . $value)
    //                                 ->store("employee_quli_doc2", "public");
    //                             $dataimgedit = [
    //                                 "doc2" => $path_quli_doc_edit2,
    //                             ];
    //                             DB::table("employee_qualification")
    //                                 ->where("id", $value)
    //                                 ->where("emid", "=", $Roledata->reg)
    //                                 ->update($dataimgedit);
    //                         }
    //                         $dataquli_edit = [
    //                             "emp_id" => $decrypted_id,
    //                             "quli" => $request->input("quli_" . $value),
    //                             "dis" => $request->input("dis_" . $value),
    //                             "ins_nmae" => $request->input(
    //                                 "ins_nmae_" . $value
    //                             ),
    //                             "board" => $request->input("board_" . $value),
    //                             "year_passing" => $request->input(
    //                                 "year_passing_" . $value
    //                             ),
    //                             "perce" => $request->input("perce_" . $value),
    //                             "grade" => $request->input("grade_" . $value),
    //                         ];

    //                         DB::table("employee_qualification")
    //                             ->where("id", $value)
    //                             ->where("emid", "=", $Roledata->reg)
    //                             ->update($dataquli_edit);
    //                     }
    //                 }
    //             }

    //             if (!empty($request->emqliotherdoc)) {
    //                 $tot_item_edit_quli = count($request->emqliotherdoc);

    //                 foreach ($request->emqliotherdoc as $value) {
    //                     if ($request->input("doc_name_" . $value) != "") {
    //                         if ($request->has("doc_upload_doc_" . $value)) {
    //                             $extension_doc_edit = $request
    //                                 ->file("doc_upload_doc_" . $value)
    //                                 ->extension();
    //                             $path_quli_doc_edit = $request
    //                                 ->file("doc_upload_doc_" . $value)
    //                                 ->store("emp_other_doc", "public");
    //                             $dataimgedit = [
    //                                 "doc_upload_doc" => $path_quli_doc_edit,
    //                             ];
    //                             DB::table("employee_other_doc")
    //                                 ->where("emid", "=", $Roledata->reg)
    //                                 ->where("id", $value)
    //                                 ->update($dataimgedit);
    //                         }

    //                         $dataquli_edit = [
    //                             "emp_code" => $decrypted_id,
    //                             "doc_name" => $request->input(
    //                                 "doc_name_" . $value
    //                             ),
    //                             "doc_ref_no" => $request->input(
    //                                 "doc_ref_no_" . $value
    //                             ),
    //                             "doc_nation" => $request->input(
    //                                 "doc_nation_" . $value
    //                             ),
    //                             "doc_issue_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime(
    //                                     $request->input(
    //                                         "doc_issue_date_" . $value
    //                                     )
    //                                 )
    //                             ),
    //                             "doc_review_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime(
    //                                     $request->input(
    //                                         "doc_review_date_" . $value
    //                                     )
    //                                 )
    //                             ),
    //                             "doc_exp_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime(
    //                                     $request->input(
    //                                         "doc_exp_date_" . $value
    //                                     )
    //                                 )
    //                             ),
    //                             "doc_cur" => $request->input(
    //                                 "doc_cur_" . $value
    //                             ),
    //                             "doc_remarks" => $request->input(
    //                                 "doc_remarks_" . $value
    //                             ),
    //                         ];

    //                         DB::table("employee_other_doc")
    //                             ->where("id", $value)
    //                             ->where("emid", "=", $Roledata->reg)
    //                             ->update($dataquli_edit);
    //                     }
    //                 }
    //             }

    //             $sm_cch_pass_docu = "";
    //             $sm_cch_visa_upload_doc = "";
    //             $sm_cch_visaback_doc = "";
    //             $sm_cch_pr_add_proof = "";

    //             if ($request->has("emp_image")) {
    //                 $file = $request->file("emp_image");
    //                 $extension = $request->emp_image->extension();
    //                 $path = $request->emp_image->store(
    //                     "employee_logo",
    //                     "public"
    //                 );
    //                 $dataimg = [
    //                     "emp_image" => $path,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimg);
    //             }
    //             if ($request->has("pass_docu")) {
    //                 $file_doc = $request->file("pass_docu");
    //                 $extension_doc = $request->pass_docu->extension();
    //                 $path_doc = $request->pass_docu->store(
    //                     "employee_doc",
    //                     "public"
    //                 );

    //                 $dataimgdoc = [
    //                     "pass_docu" => $path_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgdoc);

    //                 $sm_cch_pass_docu = $path_doc;
    //             }
    //             if ($request->has("visa_upload_doc")) {
    //                 $file_visa_doc = $request->file("visa_upload_doc");
    //                 $extension_visa_doc = $request->visa_upload_doc->extension();
    //                 $path_visa_doc = $request->visa_upload_doc->store(
    //                     "employee_vis_doc",
    //                     "public"
    //                 );
    //                 $dataimgvis = [
    //                     "visa_upload_doc" => $path_visa_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgvis);

    //                 $sm_cch_visa_upload_doc = $path_visa_doc;
    //             }

    //             if ($request->has("visaback_doc")) {
    //                 $file_visa_doc = $request->file("visaback_doc");
    //                 $extension_visa_doc = $request->visaback_doc->extension();
    //                 $path_visa_doc = $request->visaback_doc->store(
    //                     "employee_vis_doc",
    //                     "public"
    //                 );
    //                 $dataimgvis = [
    //                     "visaback_doc" => $path_visa_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgvis);

    //                 $sm_cch_visaback_doc = $path_visa_doc;
    //             }

    //             if ($request->has("pr_add_proof")) {
    //                 $file_peradd = $request->file("pr_add_proof");
    //                 $extension_per_add = $request->pr_add_proof->extension();
    //                 $path_peradd = $request->pr_add_proof->store(
    //                     "employee_per_add",
    //                     "public"
    //                 );
    //                 $dataimgper = [
    //                     "pr_add_proof" => $path_peradd,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgper);

    //                 $sm_cch_pr_add_proof = $path_peradd;
    //             }
    //             if ($request->has("ps_add_proof")) {
    //                 $file_ps_add = $request->file("pr_add_proof");
    //                 $extension_ps_add = $request->ps_add_proof->extension();
    //                 $path_ps_ad = $request->ps_add_proof->store(
    //                     "employee_ps_add",
    //                     "public"
    //                 );
    //                 $dataimgps = [
    //                     "ps_add_proof" => $path_ps_ad,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgps);
    //             }

    //             if ($request->has("euss_upload_doc")) {
    //                 $file_ps_doc = $request->file("euss_upload_doc");
    //                 $extension_ps_doc = $request->euss_upload_doc->extension();
    //                 $path_euss_doc = $request->euss_upload_doc->store(
    //                     "emp_euss",
    //                     "public"
    //                 );
    //                 $dataimgps = [
    //                     "euss_upload_doc" => $path_euss_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgps);
    //             }

    //             if ($request->has("dbs_upload_doc")) {
    //                 $file_dbs_doc = $request->file("dbs_upload_doc");
    //                 $extension_dbs_doc = $request->dbs_upload_doc->extension();
    //                 $path_dbs_doc = $request->dbs_upload_doc->store(
    //                     "emp_dbs",
    //                     "public"
    //                 );
    //                 $dataimgdbs = [
    //                     "dbs_upload_doc" => $path_dbs_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgdbs);
    //             }

    //             if ($request->has("nat_upload_doc")) {
    //                 $file_ps_doc = $request->file("nat_upload_doc");
    //                 $extension_ps_doc = $request->nat_upload_doc->extension();
    //                 $path_nat_doc = $request->nat_upload_doc->store(
    //                     "emp_nation",
    //                     "public"
    //                 );
    //                 $dataimgps = [
    //                     "nat_upload_doc" => $path_nat_doc,
    //                 ];
    //                 DB::table("employee")
    //                     ->where("emp_code", $decrypted_id)
    //                     ->where("emid", "=", $Roledata->reg)
    //                     ->update($dataimgps);
    //             }

    //             $dataupdate = [
    //                 "emp_fname" => strtoupper($request->emp_fname),
    //                 "emp_mname" => strtoupper($request->emp_mid_name),
    //                 "emp_lname" => strtoupper($request->emp_lname),
    //                 "emp_ps_email" => $request->emp_ps_email,
    //                 "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
    //                 "emp_ps_phone" => $request->emp_ps_phone,
    //                 "em_contact" => $request->em_contact,
    //                 "emp_gender" => $request->emp_gender,
    //                 "emp_father_name" => $request->emp_father_name,

    //                 "marital_status" => $request->marital_status,
    //                 "marital_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->marital_date)
    //                 ),
    //                 "spouse_name" => $request->spouse_name,
    //                 "nationality" => $request->nationality,

    //                 "verify_status" => $request->verify_status,

    //                 "emp_department" => $request->emp_department,
    //                 "emp_designation" => $request->emp_designation,
    //                 "emp_doj" => date("Y-m-d", strtotime($request->emp_doj)),
    //                 "emp_status" => $request->emp_status,
    //                 "date_confirm" => date(
    //                     "Y-m-d",
    //                     strtotime($request->date_confirm)
    //                 ),
    //                 "start_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->start_date)
    //                 ),
    //                 "end_date" => date("Y-m-d", strtotime($request->end_date)),
    //                 "fte" => $request->fte,
    //                 "job_loc" => $request->job_loc,

    //                 "emp_reporting_auth" => $request->emp_reporting_auth,
    //                 "emp_lv_sanc_auth" => $request->emp_lv_sanc_auth,

    //                 "dis_remarks" => $request->dis_remarks,
    //                 "cri_remarks" => $request->cri_remarks,
    //                 "criminal" => $request->criminal,

    //                 "ni_no" => $request->ni_no,
    //                 "emp_blood_grp" => $request->emp_blood_grp,
    //                 "emp_eye_sight_left" => $request->emp_eye_sight_left,
    //                 "emp_eye_sight_right" => $request->emp_eye_sight_right,
    //                 "emp_weight" => $request->emp_weight,
    //                 "emp_height" => $request->emp_height,
    //                 "emp_identification_mark_one" =>
    //                     $request->emp_identification_mark_one,
    //                 "emp_identification_mark_two" =>
    //                     $request->emp_identification_mark_two,
    //                 "emp_physical_status" => $request->emp_physical_status,

    //                 "em_name" => $request->em_name,
    //                 "em_relation" => $request->em_relation,
    //                 "em_email" => $request->em_email,
    //                 "em_phone" => $request->em_phone,
    //                 "em_address" => $request->em_address,
    //                 "relation_others" => $request->relation_others,

    //                 "emp_pr_street_no" => $request->emp_pr_street_no,
    //                 "emp_per_village" => $request->emp_per_village,
    //                 "emp_pr_city" => $request->emp_pr_city,
    //                 "emp_pr_country" => $request->emp_pr_country,
    //                 "emp_pr_pincode" => $request->emp_pr_pincode,
    //                 "emp_pr_state" => $request->emp_pr_state,

    //                 "emp_ps_street_no" => $request->emp_ps_street_no,
    //                 "emp_ps_village" => $request->emp_ps_village,
    //                 "emp_ps_city" => $request->emp_ps_city,
    //                 "emp_ps_country" => $request->emp_ps_country,
    //                 "emp_ps_pincode" => $request->emp_ps_pincode,
    //                 "emp_ps_state" => $request->emp_ps_state,

    //                 "nat_id" => $request->nat_id,
    //                 "place_iss" => $request->place_iss,
    //                 "iss_date" => $request->iss_date,
    //                 "exp_date" => date("Y-m-d", strtotime($request->exp_date)),
    //                 "pass_nation" => $request->pass_nation,
    //                 "country_residence" => $request->country_residence,
    //                 "country_birth" => $request->country_birth,
    //                 "place_birth" => $request->place_birth,

    //                 "pass_doc_no" => $request->pass_doc_no,
    //                 "pass_nat" => $request->pass_nat,
    //                 "issue_by" => $request->issue_by,
    //                 "pas_iss_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pas_iss_date)
    //                 ),
    //                 "pass_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_exp_date)
    //                 ),
    //                 "pass_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_review_date)
    //                 ),
    //                 "eli_status" => $request->eli_status,

    //                 "cur_pass" => $request->cur_pass,
    //                 "remarks" => $request->remarks,

    //                 "visa_doc_no" => $request->visa_doc_no,
    //                 "visa_nat" => $request->visa_nat,
    //                 "visa_issue" => $request->visa_issue,
    //                 "visa_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_issue_date)
    //                 ),
    //                 "visa_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_exp_date)
    //                 ),
    //                 "visa_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_review_date)
    //                 ),
    //                 "visa_eli_status" => $request->visa_eli_status,

    //                 "visa_cur" => $request->visa_cur,
    //                 "visa_remarks" => $request->visa_remarks,

    //                 "drive_doc" => $request->drive_doc,
    //                 "licen_num" => $request->licen_num,
    //                 "lin_exp_date" => $request->lin_exp_date,

    //                 "emp_group_name" => $request->emp_group_name,
    //                 "emp_pay_scale" => $request->emp_pay_scale,
    //                 "emp_payment_type" => $request->emp_payment_type,
    //                 "daily" => $request->daily,
    //                 "min_work" => $request->min_work,
    //                 "min_rate" => $request->min_rate,
    //                 "tax_emp" => $request->tax_emp,
    //                 "tax_ref" => $request->tax_ref,
    //                 "tax_per" => $request->tax_per,

    //                 "emp_pay_type" => $request->emp_pay_type,
    //                 "emp_bank_name" => $request->emp_bank_name,
    //                 "bank_branch_id" => $request->bank_branch_id,
    //                 "emp_account_no" => $request->emp_account_no,
    //                 "emp_sort_code" => $request->emp_sort_code,
    //                 "wedges_paymode" => $request->wedges_paymode,
    //                 "currency" => $request->currency,
    //                 "emid" => $Roledata->reg,
    //                 "titleof_license" => $request->titleof_license,
    //                 "cf_license_number" => $request->cf_license_number,
    //                 "cf_start_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->cf_start_date)
    //                 ),
    //                 "cf_end_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->cf_end_date)
    //                 ),

    //                 "euss_ref_no" => $request->euss_ref_no,
    //                 "euss_nation" => $request->euss_nation,
    //                 "euss_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_issue_date)
    //                 ),
    //                 "euss_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_exp_date)
    //                 ),
    //                 "euss_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_review_date)
    //                 ),
    //                 "euss_cur" => $request->euss_cur,
    //                 "euss_remarks" => $request->euss_remarks,

    //                 "dbs_ref_no" => $request->dbs_ref_no,
    //                 "dbs_nation" => $request->dbs_nation,
    //                 "dbs_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_issue_date)
    //                 ),
    //                 "dbs_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_exp_date)
    //                 ),
    //                 "dbs_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_review_date)
    //                 ),
    //                 "dbs_cur" => $request->dbs_cur,
    //                 "dbs_remarks" => $request->dbs_remarks,
    //                 "dbs_type" => $request->dbs_type,

    //                 "nat_id_no" => $request->nat_id_no,
    //                 "nat_nation" => $request->nat_nation,
    //                 "nat_country_res" => $request->nat_country_res,
    //                 "nat_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_issue_date)
    //                 ),
    //                 "nat_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_exp_date)
    //                 ),
    //                 "nat_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_review_date)
    //                 ),
    //                 "nat_cur" => $request->nat_cur,

    //                 "nat_remarks" => $request->nat_remarks,
    //                 "updated_at" => date("Y-m-d H:i:s"),
    //             ];

    //             DB::table("employee")
    //                 ->where("emp_code", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->update($dataupdate);

    //             $datachangecir = [
    //                 "emp_fname" => strtoupper($request->emp_fname),
    //                 "emp_mname" => strtoupper($request->emp_mid_name),
    //                 "emp_lname" => strtoupper($request->emp_lname),

    //                 "visa_upload_doc" => $sm_cch_visa_upload_doc,
    //                 "visaback_doc" => $sm_cch_visaback_doc,

    //                 "pass_docu" => $sm_cch_pass_docu,
    //                 "pr_add_proof" => $sm_cch_pr_add_proof,

    //                 "emp_designation" => $request->emp_designation,

    //                 "emp_ps_phone" => $request->emp_ps_phone,

    //                 "nationality" => $request->nationality,
    //                 "ni_no" => $request->ni_no,
    //                 "pass_doc_no" => $request->pass_doc_no,
    //                 "pass_nat" => $request->pass_nat,
    //                 "place_birth" => $request->place_birth,
    //                 "issue_by" => $request->issue_by,
    //                 "pas_iss_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pas_iss_date)
    //                 ),
    //                 "pass_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_exp_date)
    //                 ),
    //                 "pass_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_review_date)
    //                 ),

    //                 "remarks" => $request->remarks,
    //                 "cur_pass" => $request->cur_pass,

    //                 "visa_doc_no" => $request->visa_doc_no,
    //                 "visa_nat" => $request->visa_nat,
    //                 "visa_issue" => $request->visa_issue,
    //                 "visa_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_issue_date)
    //                 ),
    //                 "visa_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_exp_date)
    //                 ),
    //                 "visa_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_review_date)
    //                 ),
    //                 "country_residence" => $request->country_residence,
    //                 "visa_remarks" => $request->visa_remarks,
    //                 "visa_cur" => $request->visa_cur,

    //                 "dbs_ref_no" => $request->dbs_ref_no,
    //                 "dbs_nation" => $request->dbs_nation,
    //                 "dbs_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_issue_date)
    //                 ),
    //                 "dbs_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_exp_date)
    //                 ),
    //                 "dbs_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_review_date)
    //                 ),
    //                 "dbs_cur" => $request->dbs_cur,
    //                 "dbs_remarks" => $request->dbs_remarks,
    //                 "dbs_type" => $request->dbs_type,

    //                 "euss_ref_no" => $request->euss_ref_no,
    //                 "euss_nation" => $request->euss_nation,
    //                 "euss_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_issue_date)
    //                 ),
    //                 "euss_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_exp_date)
    //                 ),
    //                 "euss_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_review_date)
    //                 ),
    //                 "euss_cur" => $request->euss_cur,
    //                 "euss_remarks" => $request->euss_remarks,

    //                 "nat_id_no" => $request->nat_id_no,
    //                 "nat_nation" => $request->nat_nation,
    //                 "nat_country_res" => $request->nat_country_res,
    //                 "nat_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_issue_date)
    //                 ),
    //                 "nat_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_exp_date)
    //                 ),
    //                 "nat_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_review_date)
    //                 ),
    //                 "nat_cur" => $request->nat_cur,

    //                 "nat_remarks" => $request->nat_remarks,

    //                 "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
    //                 "emp_pr_street_no" => $request->emp_pr_street_no,
    //                 "emp_per_village" => $request->emp_per_village,
    //                 "emp_pr_city" => $request->emp_pr_city,
    //                 "emp_pr_country" => $request->emp_pr_country,
    //                 "emp_pr_pincode" => $request->emp_pr_pincode,
    //                 "emp_pr_state" => $request->emp_pr_state,

    //                 "emp_ps_street_no" => $request->emp_ps_street_no,
    //                 "emp_ps_village" => $request->emp_ps_village,
    //                 "emp_ps_city" => $request->emp_ps_city,
    //                 "emp_ps_country" => $request->emp_ps_country,
    //                 "emp_ps_pincode" => $request->emp_ps_pincode,
    //                 "emp_ps_state" => $request->emp_ps_state,

    //                 "emp_code" => $decrypted_id,
    //                 "emid" => $Roledata->reg,
    //                 "hr" => "",
    //                 "home" => "",
    //                 "res_remark" => "",

    //                 "date_change" => date(
    //                     "Y-m-d",
    //                     strtotime($request->emp_doj)
    //                 ),
    //                 "change_last" => "",
    //                 "stat_chage" => "",

    //                 "unique_law" => "",
    //                 "repo_ab" => "",
    //                 "laeve_date" => "",
    //             ];

    //             DB::table("change_circumstances_history")->insert(
    //                 $datachangecir
    //             );

    //             DB::table("circumemployee_other_doc_history")
    //                 ->where("emp_code", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->delete();

    //             $employee_otherd_doc_rs = DB::table("employee_other_doc")

    //                 ->where("emp_code", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->get();
    //             if (count($employee_otherd_doc_rs) != 0) {
    //                 foreach ($employee_otherd_doc_rs as $valuother) {
    //                     $datachangecirdox = [
    //                         "emp_code" => $decrypted_id,
    //                         "doc_name" => $valuother->doc_name,
    //                         "emid" => $valuother->emid,
    //                         "doc_upload_doc" => $valuother->doc_upload_doc,

    //                         "doc_ref_no" => $valuother->doc_ref_no,
    //                         "doc_nation" => $valuother->doc_nation,
    //                         "doc_remarks" => $valuother->doc_remarks,
    //                         "doc_issue_date" => $valuother->doc_issue_date,
    //                         "doc_exp_date" => $valuother->doc_exp_date,
    //                         "doc_review_date" => $valuother->doc_review_date,
    //                         "doc_cur" => $valuother->doc_cur,
    //                     ];

    //                     //DB::table('circumemployee_other_doc_history')->insert($datachangecirdox);
    //                 }
    //             }
    //             if (!empty($request->id_up_doc)) {
    //                 $tot_item_nat_edit = count($request->id_up_doc);

    //                 foreach ($request->id_up_doc as $valuee) {
    //                     if ($request->input("type_doc_" . $valuee) != "") {
    //                         if ($request->has("docu_nat_" . $valuee)) {
    //                             $extension_doc_edit_up = $request
    //                                 ->file("docu_nat_" . $valuee)
    //                                 ->extension();

    //                             $path_quli_doc_edit_up = $request
    //                                 ->file("docu_nat_" . $valuee)
    //                                 ->store("employee_upload_doc", "public");
    //                             $dataimgeditup = [
    //                                 "docu_nat" => $path_quli_doc_edit_up,
    //                             ];

    //                             DB::table("employee_upload")
    //                                 ->where("id", $valuee)
    //                                 ->where("emid", "=", $Roledata->reg)
    //                                 ->update($dataimgeditup);
    //                         }

    //                         $datauploadedit = [
    //                             "emp_id" => $decrypted_id,
    //                             "type_doc" => $request->input(
    //                                 "type_doc_" . $valuee
    //                             ),
    //                         ];
    //                         DB::table("employee_upload")
    //                             ->where("id", $valuee)
    //                             ->where("emid", "=", $Roledata->reg)
    //                             ->update($datauploadedit);
    //                     }
    //                 }
    //             }

    //             if (!empty($request->doc_name)) {
    //                 $tot_item_nat = count($request->doc_name);

    //                 for ($i = 0; $i < $tot_item_nat; $i++) {
    //                     if ($request->doc_name[$i] != "") {
    //                         if ($request->has("doc_upload_doc")) {
    //                             $extension_upload_doc = $request->doc_upload_doc[
    //                                 $i
    //                             ]->extension();
    //                             $path_upload_otherdoc = $request->doc_upload_doc[
    //                                 $i
    //                             ]->store("emp_other_doc", "public");
    //                         } else {
    //                             $path_upload_otherdoc = "";
    //                         }
    //                         $dataupload = [
    //                             "emp_code" => $request->emp_code,
    //                             "doc_name" => $request->doc_name[$i],
    //                             "emid" => $Roledata->reg,
    //                             "doc_upload_doc" => $path_upload_otherdoc,

    //                             "doc_ref_no" => $request->doc_ref_no[$i],
    //                             "doc_nation" => $request->doc_nation[$i],
    //                             "doc_remarks" => $request->doc_remarks[$i],
    //                             "doc_issue_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_issue_date[$i])
    //                             ),
    //                             "doc_exp_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_exp_date[$i])
    //                             ),
    //                             "doc_review_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_review_date[$i])
    //                             ),
    //                             "doc_cur" => $request->doc_cur[$i],
    //                         ];
    //                         DB::table("employee_other_doc")->insert(
    //                             $dataupload
    //                         );
    //                     }
    //                 }
    //             }

    //             if (!empty($request->type_doc)) {
    //                 $tot_item_nat = count($request->type_doc);

    //                 for ($i = 0; $i < $tot_item_nat; $i++) {
    //                     if ($request->type_doc[$i] != "") {
    //                         if ($request->has("docu_nat")) {
    //                             $extension_upload_doc = $request->docu_nat[
    //                                 $i
    //                             ]->extension();
    //                             $path_upload_doc = $request->docu_nat[
    //                                 $i
    //                             ]->store("employee_upload_doc", "public");
    //                         } else {
    //                             $path_upload_doc = "";
    //                         }
    //                         $dataupload = [
    //                             "emp_id" => $request->emp_code,
    //                             "type_doc" => $request->type_doc[$i],
    //                             "emid" => $Roledata->reg,
    //                             "docu_nat" => $path_upload_doc,
    //                         ];
    //                         DB::table("employee_upload")->insert($dataupload);
    //                     }
    //                 }
    //             }

    //             $tot_job_item = count($request->job_name);
    //             DB::table("employee_job")
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->delete();
    //             for ($i = 0; $i < $tot_job_item; $i++) {
    //                 if ($request->job_name[$i] != "") {
    //                     $datajob = [
    //                         "emp_id" => $decrypted_id,
    //                         "job_name" => $request->job_name[$i],
    //                         "job_start_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->job_start_date[$i])
    //                         ),
    //                         "job_end_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->job_end_date[$i])
    //                         ),
    //                         "des" => $request->des[$i],
    //                         "emid" => $Roledata->reg,
    //                         "exp" => $request->exp[$i],
    //                     ];
    //                     DB::table("employee_job")->insert($datajob);
    //                 }
    //             }

    //             $tot_train_item = count($request->tarin_name);
    //             DB::table("employee_training")
    //                 ->where("emp_id", "=", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->delete();

    //             for ($i = 0; $i < $tot_train_item; $i++) {
    //                 if ($request->tarin_name[$i] != "") {
    //                     $datatrain = [
    //                         "emp_id" => $decrypted_id,
    //                         "train_des" => $request->train_des[$i],
    //                         "tarin_start_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->tarin_start_date[$i])
    //                         ),
    //                         "tarin_end_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->tarin_end_date[$i])
    //                         ),
    //                         "tarin_name" => $request->tarin_name[$i],

    //                         "emid" => $Roledata->reg,
    //                     ];
    //                     DB::table("employee_training")->insert($datatrain);
    //                 }
    //             }

    //             if (!empty($request->quli)) {
    //                 $tot_item_quli = count($request->quli);

    //                 for ($i = 0; $i < $tot_item_quli; $i++) {
    //                     if ($request->quli[$i] != "") {
    //                         if ($request->has("doc")) {
    //                             $extension_quli_doc = $request->doc[
    //                                 $i
    //                             ]->extension();
    //                             $path_quli_doc = $request->doc[$i]->store(
    //                                 "employee_quli_doc",
    //                                 "public"
    //                             );
    //                         } else {
    //                             $path_quli_doc = "";
    //                         }
    //                         if ($request->has("doc2")) {
    //                             $extension_quli_doc2 = $request->doc2[
    //                                 $i
    //                             ]->extension();
    //                             $path_quli_doc2 = $request->doc2[$i]->store(
    //                                 "employee_quli_doc2",
    //                                 "public"
    //                             );
    //                         } else {
    //                             $path_quli_doc2 = "";
    //                         }
    //                         $dataquli = [
    //                             "emp_id" => $request->emp_code,
    //                             "quli" => $request->quli[$i],
    //                             "dis" => $request->dis[$i],
    //                             "ins_nmae" => $request->ins_nmae[$i],
    //                             "board" => $request->board[$i],
    //                             "year_passing" => $request->year_passing[$i],
    //                             "perce" => $request->perce[$i],
    //                             "grade" => $request->grade[$i],
    //                             "doc" => $path_quli_doc,
    //                             "doc2" => $path_quli_doc2,
    //                             "emid" => $Roledata->reg,
    //                         ];
    //                         DB::table("employee_qualification")->insert(
    //                             $dataquli
    //                         );
    //                     }
    //                 }
    //             }

    //             $payupdate = [
    //                 "da" => $request->da,
    //                 "hra" => $request->hra,
    //                 "conven_ta" => $request->conven_ta,
    //                 "perfomance" => $request->perfomance,
    //                 "monthly_al" => $request->monthly_al,

    //                 "pf_al" => $request->pf_al,
    //                 "income_tax" => $request->income_tax,
    //                 "cess" => $request->cess,
    //                 "esi" => $request->esi,
    //                 "professional_tax" => $request->professional_tax,

    //                 "created_at" => date("Y-m-d h:i:s"),
    //                 "updated_at" => date("Y-m-d h:i:s"),
    //             ];
    //             DB::table("employee_pay_structure")
    //                 ->where("employee_code", $decrypted_id)
    //                 ->where("emid", "=", $Roledata->reg)
    //                 ->update($payupdate);
    //             Session::flash(
    //                 "message",
    //                 "Record has been successfully updated"
    //             );
    //             return redirect("employees");
    //         } else {
    //             //Add mode
    //             $ckeck_dept = DB::table("employee")
    //                 ->where("emp_code", $request->emp_code)
    //                 ->where("emid", $Roledata->reg)
    //                 ->first();
    //             if (!empty($ckeck_dept)) {
    //                 Session::flash(
    //                     "message",
    //                     "Employee Code Code  Already Exists."
    //                 );
    //                 return redirect("employees");
    //             }
    //             $ckeck_email = DB::table("users")
    //                 ->where("email", "=", $request->emp_ps_email)
    //                 ->first();
    //             if (!empty($ckeck_email)) {
    //                 Session::flash("message", "E-mail id  Already Exists.");
    //                 return redirect("employees");
    //             }
    //             $ckeck_email_em = DB::table("employee")
    //                 ->where("emp_ps_email", "=", $request->emp_ps_email)
    //                 ->first();
    //             if (!empty($ckeck_email_em)) {
    //                 Session::flash("message", "E-mail id  Already Exists.");
    //                 return redirect("employees");
    //             }
    //             $pay = [
    //                 "employee_code" => $request->emp_code,
    //                 "emid" => $Roledata->reg,
    //                 "da" => $request->da,
    //                 "hra" => $request->hra,
    //                 "conven_ta" => $request->conven_ta,
    //                 "perfomance" => $request->perfomance,
    //                 "monthly_al" => $request->monthly_al,

    //                 "pf_al" => $request->pf_al,
    //                 "income_tax" => $request->income_tax,
    //                 "cess" => $request->cess,
    //                 "esi" => $request->esi,
    //                 "professional_tax" => $request->professional_tax,

    //                 "created_at" => date("Y-m-d h:i:s"),
    //                 "updated_at" => date("Y-m-d h:i:s"),
    //             ];

    //             $sm_cch_pass_docu = "";
    //             $sm_cch_visa_upload_doc = "";
    //             $sm_cch_visaback_doc = "";
    //             $sm_cch_pr_add_proof = "";

    //             if ($request->has("emp_image")) {
    //                 $file = $request->file("emp_image");
    //                 $extension = $request->emp_image->extension();
    //                 $path = $request->emp_image->store(
    //                     "employee_logo",
    //                     "public"
    //                 );
    //             } else {
    //                 $path = "";
    //             }
    //             if ($request->has("pass_docu")) {
    //                 $file_doc = $request->file("pass_docu");
    //                 $extension_doc = $request->pass_docu->extension();
    //                 $path_doc = $request->pass_docu->store(
    //                     "employee_doc",
    //                     "public"
    //                 );
    //                 $sm_cch_pass_docu = $path_doc;
    //             } else {
    //                 $path_doc = "";
    //             }
    //             if ($request->has("visa_upload_doc")) {
    //                 $file_visa_doc = $request->file("visa_upload_doc");
    //                 $extension_visa_doc = $request->visa_upload_doc->extension();
    //                 $path_visa_doc = $request->visa_upload_doc->store(
    //                     "employee_vis_doc",
    //                     "public"
    //                 );
    //                 $sm_cch_visa_upload_doc = $path_visa_doc;
    //             } else {
    //                 $path_visa_doc = "";
    //             }

    //             if ($request->has("visaback_doc")) {
    //                 $file_visa_doc = $request->file("visaback_doc");
    //                 $extension_visa_doc = $request->visaback_doc->extension();
    //                 $path_visaback_doc = $request->visaback_doc->store(
    //                     "employee_vis_doc",
    //                     "public"
    //                 );
    //                 $sm_cch_visaback_doc = $path_visaback_doc;
    //             } else {
    //                 $path_visaback_doc = "";
    //             }

    //             if ($request->has("pr_add_proof")) {
    //                 $file_per_doc = $request->file("pr_add_proof");
    //                 $extension_per_doc = $request->pr_add_proof->extension();
    //                 $path_per_doc = $request->pr_add_proof->store(
    //                     "employee_per_add",
    //                     "public"
    //                 );
    //                 $sm_cch_pr_add_proof = $path_per_doc;
    //             } else {
    //                 $path_per_doc = "";
    //             }

    //             if ($request->has("ps_add_proof")) {
    //                 $file_ps_doc = $request->file("ps_add_proof");
    //                 $extension_ps_doc = $request->ps_add_proof->extension();
    //                 $path_ps_doc = $request->ps_add_proof->store(
    //                     "employee_ps_add",
    //                     "public"
    //                 );
    //             } else {
    //                 $path_ps_doc = "";
    //             }

    //             if ($request->has("euss_upload_doc")) {
    //                 $file_ps_doc = $request->file("euss_upload_doc");
    //                 $extension_ps_doc = $request->euss_upload_doc->extension();
    //                 $path_euss_doc = $request->euss_upload_doc->store(
    //                     "emp_euss",
    //                     "public"
    //                 );
    //             } else {
    //                 $path_euss_doc = "";
    //             }

    //             if ($request->has("dbs_upload_doc")) {
    //                 $file_dbs_doc = $request->file("dbs_upload_doc");
    //                 $extension_dbs_doc = $request->dbs_upload_doc->extension();
    //                 $path_dbs_doc = $request->dbs_upload_doc->store(
    //                     "emp_dbs",
    //                     "public"
    //                 );
    //             } else {
    //                 $path_dbs_doc = "";
    //             }

    //             if ($request->has("nat_upload_doc")) {
    //                 $file_ps_doc = $request->file("nat_upload_doc");
    //                 $extension_ps_doc = $request->nat_upload_doc->extension();
    //                 $path_nat_doc = $request->nat_upload_doc->store(
    //                     "emp_nation",
    //                     "public"
    //                 );
    //             } else {
    //                 $path_nat_doc = "";
    //             }

    //             $data = [
    //                 "pr_add_proof" => $path_per_doc,
    //                 "ps_add_proof" => $path_ps_doc,
    //                 "emp_code" => $request->emp_code,
    //                 "emp_fname" => strtoupper($request->emp_fname),
    //                 "emp_mname" => strtoupper($request->emp_mid_name),
    //                 "emp_lname" => strtoupper($request->emp_lname),
    //                 "emp_ps_email" => $request->emp_ps_email,
    //                 "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
    //                 "emp_ps_phone" => $request->emp_ps_phone,
    //                 "em_contact" => $request->em_contact,
    //                 "emp_gender" => $request->emp_gender,
    //                 "emp_father_name" => $request->emp_father_name,
    //                 "marital_status" => $request->marital_status,
    //                 "marital_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->marital_date)
    //                 ),
    //                 "spouse_name" => $request->spouse_name,
    //                 "nationality" => $request->nationality,

    //                 "verify_status" => "not approved",

    //                 "emp_department" => $request->emp_department,
    //                 "emp_designation" => $request->emp_designation,
    //                 "emp_doj" => date("Y-m-d", strtotime($request->emp_doj)),
    //                 "emp_status" => $request->emp_status,
    //                 "date_confirm" => date(
    //                     "Y-m-d",
    //                     strtotime($request->date_confirm)
    //                 ),
    //                 "start_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->start_date)
    //                 ),
    //                 "end_date" => date("Y-m-d", strtotime($request->end_date)),
    //                 "fte" => $request->fte,
    //                 "job_loc" => $request->job_loc,
    //                 "emp_image" => $path,
    //                 "emp_reporting_auth" => $request->emp_reporting_auth,
    //                 "emp_lv_sanc_auth" => $request->emp_lv_sanc_auth,

    //                 "dis_remarks" => $request->dis_remarks,
    //                 "cri_remarks" => $request->cri_remarks,
    //                 "criminal" => $request->criminal,

    //                 "ni_no" => $request->ni_no,
    //                 "emp_blood_grp" => $request->emp_blood_grp,
    //                 "emp_eye_sight_left" => $request->emp_eye_sight_left,
    //                 "emp_eye_sight_right" => $request->emp_eye_sight_right,
    //                 "emp_weight" => $request->emp_weight,
    //                 "emp_height" => $request->emp_height,
    //                 "emp_identification_mark_one" =>
    //                     $request->emp_identification_mark_one,
    //                 "emp_identification_mark_two" =>
    //                     $request->emp_identification_mark_two,
    //                 "emp_physical_status" => $request->emp_physical_status,

    //                 "em_name" => $request->em_name,
    //                 "em_relation" => $request->em_relation,
    //                 "em_email" => $request->em_email,
    //                 "em_phone" => $request->em_phone,
    //                 "em_address" => $request->em_address,
    //                 "relation_others" => $request->relation_others,
    //                 "emp_pr_street_no" => $request->emp_pr_street_no,
    //                 "emp_per_village" => $request->emp_per_village,
    //                 "emp_pr_city" => $request->emp_pr_city,
    //                 "emp_pr_country" => $request->emp_pr_country,
    //                 "emp_pr_pincode" => $request->emp_pr_pincode,
    //                 "emp_pr_state" => $request->emp_pr_state,

    //                 "emp_ps_street_no" => $request->emp_ps_street_no,
    //                 "emp_ps_village" => $request->emp_ps_village,
    //                 "emp_ps_city" => $request->emp_ps_city,
    //                 "emp_ps_country" => $request->emp_ps_country,
    //                 "emp_ps_pincode" => $request->emp_ps_pincode,
    //                 "emp_ps_state" => $request->emp_ps_state,

    //                 "nat_id" => $request->nat_id,
    //                 "place_iss" => $request->place_iss,
    //                 "iss_date" => $request->iss_date,
    //                 "exp_date" => date("Y-m-d", strtotime($request->exp_date)),
    //                 "pass_nation" => $request->pass_nation,
    //                 "country_residence" => $request->country_residence,
    //                 "country_birth" => $request->country_birth,
    //                 "place_birth" => $request->place_birth,

    //                 "pass_doc_no" => $request->pass_doc_no,
    //                 "pass_nat" => $request->pass_nat,
    //                 "issue_by" => $request->issue_by,
    //                 "pas_iss_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pas_iss_date)
    //                 ),
    //                 "pass_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_exp_date)
    //                 ),
    //                 "pass_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_review_date)
    //                 ),
    //                 "eli_status" => $request->eli_status,
    //                 "pass_docu" => $path_doc,
    //                 "cur_pass" => $request->cur_pass,
    //                 "remarks" => $request->remarks,

    //                 "visa_doc_no" => $request->visa_doc_no,
    //                 "visa_nat" => $request->visa_nat,
    //                 "visa_issue" => $request->visa_issue,
    //                 "visa_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_issue_date)
    //                 ),
    //                 "visa_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_exp_date)
    //                 ),
    //                 "visa_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_review_date)
    //                 ),
    //                 "visa_eli_status" => $request->visa_eli_status,
    //                 "visa_upload_doc" => $path_visa_doc,
    //                 "visaback_doc" => $path_visaback_doc,
    //                 "visa_cur" => $request->visa_cur,
    //                 "visa_remarks" => $request->visa_remarks,

    //                 "drive_doc" => $request->drive_doc,
    //                 "licen_num" => $request->licen_num,
    //                 "lin_exp_date" => $request->lin_exp_date,

    //                 "emp_group_name" => $request->emp_group_name,
    //                 "emp_pay_scale" => $request->emp_pay_scale,
    //                 "emp_payment_type" => $request->emp_payment_type,
    //                 "daily" => $request->daily,
    //                 "min_work" => $request->min_work,
    //                 "min_rate" => $request->min_rate,
    //                 "tax_emp" => $request->tax_emp,
    //                 "tax_ref" => $request->tax_ref,
    //                 "tax_per" => $request->tax_per,

    //                 "emp_pay_type" => $request->emp_pay_type,
    //                 "emp_bank_name" => $request->emp_bank_name,
    //                 "bank_branch_id" => $request->bank_branch_id,
    //                 "emp_account_no" => $request->emp_account_no,
    //                 "emp_sort_code" => $request->emp_sort_code,
    //                 "currency" => $request->currency,
    //                 "emid" => $Roledata->reg,
    //                 "wedges_paymode" => $request->wedges_paymode,
    //                 "titleof_license" => $request->titleof_license,
    //                 "cf_license_number" => $request->cf_license_number,
    //                 "cf_start_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->cf_start_date)
    //                 ),
    //                 "cf_end_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->cf_end_date)
    //                 ),

    //                 "euss_ref_no" => $request->euss_ref_no,
    //                 "euss_nation" => $request->euss_nation,
    //                 "euss_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_issue_date)
    //                 ),
    //                 "euss_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_exp_date)
    //                 ),
    //                 "euss_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_review_date)
    //                 ),
    //                 "euss_cur" => $request->euss_cur,
    //                 "euss_upload_doc" => $path_euss_doc,
    //                 "euss_remarks" => $request->euss_remarks,

    //                 "dbs_ref_no" => $request->dbs_ref_no,
    //                 "dbs_nation" => $request->dbs_nation,
    //                 "dbs_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_issue_date)
    //                 ),
    //                 "dbs_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_exp_date)
    //                 ),
    //                 "dbs_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_review_date)
    //                 ),
    //                 "dbs_cur" => $request->dbs_cur,
    //                 "dbs_remarks" => $request->dbs_remarks,
    //                 "dbs_type" => $request->dbs_type,
    //                 "dbs_upload_doc" => $path_dbs_doc,

    //                 "nat_id_no" => $request->nat_id_no,
    //                 "nat_nation" => $request->nat_nation,
    //                 "nat_country_res" => $request->nat_country_res,
    //                 "nat_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_issue_date)
    //                 ),
    //                 "nat_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_exp_date)
    //                 ),
    //                 "nat_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_review_date)
    //                 ),
    //                 "nat_cur" => $request->nat_cur,
    //                 "nat_upload_doc" => $path_nat_doc,

    //                 "nat_remarks" => $request->nat_remarks,
    //             ];

    //             $tot_item_quli = count($request->quli);

    //             for ($i = 0; $i < $tot_item_quli; $i++) {
    //                 if ($request->quli[$i] != "") {
    //                     if ($request->has("doc")) {
    //                         $extension_quli_doc = $request->doc[
    //                             $i
    //                         ]->extension();
    //                         $path_quli_doc = $request->doc[$i]->store(
    //                             "employee_quli_doc",
    //                             "public"
    //                         );
    //                     } else {
    //                         $path_quli_doc = "";
    //                     }
    //                     if ($request->has("doc2")) {
    //                         $extension_quli_doc2 = $request->doc2[
    //                             $i
    //                         ]->extension();
    //                         $path_quli_doc2 = $request->doc2[$i]->store(
    //                             "employee_quli_doc2",
    //                             "public"
    //                         );
    //                     } else {
    //                         $path_quli_doc2 = "";
    //                     }
    //                     $dataquli = [
    //                         "emp_id" => $request->emp_code,
    //                         "quli" => $request->quli[$i],
    //                         "dis" => $request->dis[$i],
    //                         "ins_nmae" => $request->ins_nmae[$i],
    //                         "board" => $request->board[$i],
    //                         "year_passing" => $request->year_passing[$i],
    //                         "perce" => $request->perce[$i],
    //                         "grade" => $request->grade[$i],
    //                         "doc" => $path_quli_doc,
    //                         "doc2" => $path_quli_doc2,
    //                     ];
    //                     DB::table("employee_qualification")->insert($dataquli);
    //                 }
    //             }

    //             $tot_job_item = count($request->job_name);

    //             for ($i = 0; $i < $tot_job_item; $i++) {
    //                 if ($request->job_name[$i] != "") {
    //                     $datajob = [
    //                         "emp_id" => $request->emp_code,
    //                         "job_name" => $request->job_name[$i],
    //                         "job_start_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->job_start_date[$i])
    //                         ),
    //                         "job_end_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->job_end_date[$i])
    //                         ),
    //                         "des" => $request->des[$i],
    //                         "emid" => $Roledata->reg,
    //                         "exp" => $request->exp[$i],
    //                     ];
    //                     DB::table("employee_job")->insert($datajob);
    //                 }
    //             }

    //             $tot_train_item = count($request->tarin_name);

    //             for ($i = 0; $i < $tot_train_item; $i++) {
    //                 if ($request->tarin_name[$i] != "") {
    //                     $datatrain = [
    //                         "emp_id" => $request->emp_code,
    //                         "train_des" => $request->train_des[$i],
    //                         "tarin_start_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->tarin_start_date[$i])
    //                         ),
    //                         "tarin_end_date" => date(
    //                             "Y-m-d",
    //                             strtotime($request->tarin_end_date[$i])
    //                         ),
    //                         "tarin_name" => $request->tarin_name[$i],
    //                         "emid" => $Roledata->reg,
    //                     ];
    //                     DB::table("employee_training")->insert($datatrain);
    //                 }
    //             }

    //             if (!empty($request->doc_name)) {
    //                 $tot_item_nat = count($request->doc_name);

    //                 for ($i = 0; $i < $tot_item_nat; $i++) {
    //                     if ($request->doc_name[$i] != "") {
    //                         if ($request->has("doc_upload_doc")) {
    //                             $extension_upload_doc = $request->doc_upload_doc[
    //                                 $i
    //                             ]->extension();
    //                             $path_upload_otherdoc = $request->doc_upload_doc[
    //                                 $i
    //                             ]->store("emp_other_doc", "public");
    //                         } else {
    //                             $path_upload_otherdoc = "";
    //                         }
    //                         $dataupload = [
    //                             "emp_code" => $request->emp_code,
    //                             "doc_name" => $request->doc_name[$i],
    //                             "emid" => $Roledata->reg,
    //                             "doc_upload_doc" => $path_upload_otherdoc,

    //                             "doc_ref_no" => $request->doc_ref_no[$i],
    //                             "doc_nation" => $request->doc_nation[$i],
    //                             "doc_remarks" => $request->doc_remarks[$i],
    //                             "doc_issue_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_issue_date[$i])
    //                             ),
    //                             "doc_exp_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_exp_date[$i])
    //                             ),
    //                             "doc_review_date" => date(
    //                                 "Y-m-d",
    //                                 strtotime($request->doc_review_date[$i])
    //                             ),
    //                             "doc_cur" => $request->doc_cur[$i],
    //                         ];
    //                         DB::table("employee_other_doc")->insert(
    //                             $dataupload
    //                         );
    //                     }
    //                 }
    //             }

    //             if (!empty($request->type_doc)) {
    //                 $tot_item_nat = count($request->type_doc);

    //                 for ($i = 0; $i < $tot_item_nat; $i++) {
    //                     if ($request->type_doc[$i] != "") {
    //                         if ($request->has("docu_nat")) {
    //                             $extension_upload_doc = $request->docu_nat[
    //                                 $i
    //                             ]->extension();
    //                             $path_upload_doc = $request->docu_nat[
    //                                 $i
    //                             ]->store("employee_upload_doc", "public");
    //                         } else {
    //                             $path_upload_doc = "";
    //                         }
    //                         $dataupload = [
    //                             "emp_id" => $request->emp_code,
    //                             "type_doc" => $request->type_doc[$i],
    //                             "emid" => $Roledata->reg,
    //                             "docu_nat" => $path_upload_doc,
    //                         ];
    //                         DB::table("employee_upload")->insert($dataupload);
    //                     }
    //                 }
    //             }

    //             DB::table("employee_pay_structure")->insert($pay);
    //             DB::table("employee")->insert($data);

    //             $datachangecir = [
    //                 "emp_fname" => strtoupper($request->emp_fname),
    //                 "emp_mname" => strtoupper($request->emp_mid_name),
    //                 "emp_lname" => strtoupper($request->emp_lname),

    //                 "visa_upload_doc" => $sm_cch_visa_upload_doc,
    //                 "visaback_doc" => $sm_cch_visaback_doc,

    //                 "pass_docu" => $sm_cch_pass_docu,
    //                 "pr_add_proof" => $sm_cch_pr_add_proof,

    //                 "emp_designation" => $request->emp_designation,

    //                 "emp_ps_phone" => $request->emp_ps_phone,

    //                 "nationality" => $request->nationality,
    //                 "ni_no" => $request->ni_no,
    //                 "pass_doc_no" => $request->pass_doc_no,
    //                 "pass_nat" => $request->pass_nat,
    //                 "place_birth" => $request->place_birth,
    //                 "issue_by" => $request->issue_by,
    //                 "pas_iss_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pas_iss_date)
    //                 ),
    //                 "pass_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_exp_date)
    //                 ),
    //                 "pass_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->pass_review_date)
    //                 ),

    //                 "remarks" => $request->remarks,
    //                 "cur_pass" => $request->cur_pass,

    //                 "visa_doc_no" => $request->visa_doc_no,
    //                 "visa_nat" => $request->visa_nat,
    //                 "visa_issue" => $request->visa_issue,
    //                 "visa_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_issue_date)
    //                 ),
    //                 "visa_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_exp_date)
    //                 ),
    //                 "visa_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->visa_review_date)
    //                 ),
    //                 "country_residence" => $request->country_residence,
    //                 "visa_remarks" => $request->visa_remarks,
    //                 "visa_cur" => $request->visa_cur,

    //                 "euss_ref_no" => $request->euss_ref_no,
    //                 "euss_nation" => $request->euss_nation,
    //                 "euss_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_issue_date)
    //                 ),
    //                 "euss_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_exp_date)
    //                 ),
    //                 "euss_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->euss_review_date)
    //                 ),
    //                 "euss_cur" => $request->euss_cur,
    //                 "euss_upload_doc" => $path_euss_doc,
    //                 "euss_remarks" => $request->euss_remarks,

    //                 "dbs_ref_no" => $request->dbs_ref_no,
    //                 "dbs_nation" => $request->dbs_nation,
    //                 "dbs_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_issue_date)
    //                 ),
    //                 "dbs_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_exp_date)
    //                 ),
    //                 "dbs_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->dbs_review_date)
    //                 ),
    //                 "dbs_cur" => $request->dbs_cur,
    //                 "dbs_remarks" => $request->dbs_remarks,
    //                 "dbs_type" => $request->dbs_type,
    //                 "dbs_upload_doc" => $path_dbs_doc,

    //                 "nat_id_no" => $request->nat_id_no,
    //                 "nat_nation" => $request->nat_nation,
    //                 "nat_country_res" => $request->nat_country_res,
    //                 "nat_issue_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_issue_date)
    //                 ),
    //                 "nat_exp_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_exp_date)
    //                 ),
    //                 "nat_review_date" => date(
    //                     "Y-m-d",
    //                     strtotime($request->nat_review_date)
    //                 ),
    //                 "nat_cur" => $request->nat_cur,
    //                 "nat_upload_doc" => $path_nat_doc,

    //                 "nat_remarks" => $request->nat_remarks,

    //                 "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
    //                 "emp_pr_street_no" => $request->emp_pr_street_no,
    //                 "emp_per_village" => $request->emp_per_village,
    //                 "emp_pr_city" => $request->emp_pr_city,
    //                 "emp_pr_country" => $request->emp_pr_country,
    //                 "emp_pr_pincode" => $request->emp_pr_pincode,
    //                 "emp_pr_state" => $request->emp_pr_state,

    //                 "emp_ps_street_no" => $request->emp_ps_street_no,
    //                 "emp_ps_village" => $request->emp_ps_village,
    //                 "emp_ps_city" => $request->emp_ps_city,
    //                 "emp_ps_country" => $request->emp_ps_country,
    //                 "emp_ps_pincode" => $request->emp_ps_pincode,
    //                 "emp_ps_state" => $request->emp_ps_state,

    //                 "emp_code" => $request->emp_code,
    //                 "emid" => $Roledata->reg,
    //                 "hr" => "",
    //                 "home" => "",
    //                 "res_remark" => "",

    //                 "date_change" => date(
    //                     "Y-m-d",
    //                     strtotime($request->emp_doj)
    //                 ),
    //                 "change_last" => "",
    //                 "stat_chage" => "",

    //                 "unique_law" => "",
    //                 "repo_ab" => "",
    //                 "laeve_date" => "",
    //             ];

    //             DB::table("change_circumstances_history")->insert(
    //                 $datachangecir
    //             );

    //             $p_dd = mt_rand(1000, 9999);
    //             $ins_data = [
    //                 "employee_id" => $request->emp_code,
    //                 "name" =>
    //                     strtoupper($request->emp_fname) .
    //                     strtoupper($request->emp_mid_name) .
    //                     strtoupper($request->emp_lname),
    //                 "email" => $request->emp_ps_email,
    //                 "user_type" => "employee",
    //                 "password" => $p_dd,
    //                 "emid" => $Roledata->reg,
    //             ];
    //             DB::table("users")->insert($ins_data);

    //             $ins_data_role = [
    //                 "menu" => "1",
    //                 "module_name" => "1",
    //                 "member_id" => $request->emp_ps_email,
    //                 "rights" => "Add",

    //                 "emid" => $Roledata->reg,
    //             ];

    //             DB::table("role_authorization")->insert($ins_data_role);

    //             $ins_data_role1 = [
    //                 "menu" => "1",
    //                 "module_name" => "1",
    //                 "member_id" => $request->emp_ps_email,
    //                 "rights" => "Edit",

    //                 "emid" => $Roledata->reg,
    //             ];
    //             DB::table("role_authorization")->insert($ins_data_role1);

    //             $data = [
    //                 "firstname" => $request->emp_fname,
    //                 "maname" => $request->emp_mid_name,
    //                 "email" => $request->emp_ps_email,
    //                 "lname" => $request->emp_lname,
    //                 "password" => $p_dd,
    //             ];
    //             $toemail = $request->emp_ps_email;
    //             Mail::send("mail", $data, function ($message) use ($toemail) {
    //                 $message
    //                     ->to($toemail, "Workpermitcloud")
    //                     ->subject("Employee Login  Details");
    //                 $message->from(
    //                     "noreply@workpermitcloud.co.uk",
    //                     "Workpermitcloud"
    //                 );
    //             });

    //             Session::flash("message", "Please assign the role.");
    //             return redirect("employees");
    //             // return redirect('pis/employee');
    //         }
    //     } else {
    //         return redirect("/");
    //     }
    // }

    public function saveEmployeemigrant(Request $request)
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
                    return redirect("employees");
                }

                $ckeck_email = DB::table("users")
                    ->where("email", "=", $request->emp_ps_email)
                    ->where("employee_id", "!=", $decrypted_id)
                    ->where("status", "=", "active")
                    ->where("emid", $Roledata->reg)
                    ->first();
                if (!empty($ckeck_email)) {
                    Session::flash("message", "E-mail id  Already Exists.");
                    return redirect("employees");
                }
                $ckeck_right = DB::table("right_works")
                    ->where("employee_id", "=", $decrypted_id)
                    ->where("emid", $Roledata->reg)
                    ->first();

                if (!empty($ckeck_right)) {
                    $datarigh_edit = [
                        "start_date" => date(
                            "Y-m-d",
                            strtotime($request->emp_doj)
                        ),
                    ];

                    DB::table("right_works")
                        ->where("employee_id", "=", $decrypted_id)
                        ->where("emid", $Roledata->reg)
                        ->update($datarigh_edit);
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

                if ($request->has("visaback_doc")) {
                    $file_visa_doc = $request->file("visaback_doc");
                    $extension_visa_doc = $request->visaback_doc->extension();
                    $path_visa_doc = $request->visaback_doc->store(
                        "employee_vis_doc",
                        "public"
                    );
                    $dataimgvis = [
                        "visaback_doc" => $path_visa_doc,
                    ];
                    DB::table("employee")
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimgvis);
                }
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
                                    ->where("emid", "=", $Roledata->reg)
                                    ->where("id", $value)
                                    ->update($dataimgedit);
                            }

                            $dataquli_edit = [
                                "emp_code" => $decrypted_id,
                                "doc_name" => $request->input(
                                    "doc_name_" . $value
                                ),
                                "doc_ref_no" => $request->input(
                                    "doc_ref_no_" . $value
                                ),
                                "doc_nation" => $request->input(
                                    "doc_nation_" . $value
                                ),
                                "doc_issue_date" => date(
                                    "Y-m-d",
                                    strtotime(
                                        $request->input(
                                            "doc_issue_date_" . $value
                                        )
                                    )
                                ),
                                "doc_review_date" => date(
                                    "Y-m-d",
                                    strtotime(
                                        $request->input(
                                            "doc_review_date_" . $value
                                        )
                                    )
                                ),
                                "doc_exp_date" => date(
                                    "Y-m-d",
                                    strtotime(
                                        $request->input(
                                            "doc_exp_date_" . $value
                                        )
                                    )
                                ),
                                "doc_cur" => $request->input(
                                    "doc_cur_" . $value
                                ),
                                "doc_remarks" => $request->input(
                                    "doc_remarks_" . $value
                                ),
                            ];

                            DB::table("employee_other_doc")
                                ->where("id", $value)
                                ->where("emid", "=", $Roledata->reg)
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
                                "emp_code" => $request->emp_code,
                                "doc_name" => $request->doc_name[$i],
                                "emid" => $Roledata->reg,
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
                            DB::table("employee_other_doc")->insert(
                                $dataupload
                            );
                        }
                    }
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
                            } else {
                                $path_upload_doc = "";
                            }
                            $dataupload = [
                                "emp_id" => $request->emp_code,
                                "type_doc" => $request->type_doc[$i],
                                "emid" => $Roledata->reg,
                                "docu_nat" => $path_upload_doc,
                            ];
                            DB::table("employee_upload")->insert($dataupload);
                        }
                    }
                }

                if ($request->has("euss_upload_doc")) {
                    $file_ps_doc = $request->file("euss_upload_doc");
                    $extension_ps_doc = $request->euss_upload_doc->extension();
                    $path_euss_doc = $request->euss_upload_doc->store(
                        "emp_euss",
                        "public"
                    );
                    $dataimgps = [
                        "euss_upload_doc" => $path_euss_doc,
                    ];
                    DB::table("employee")
                        ->where("emp_code", $decrypted_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->update($dataimgps);
                }

                if ($request->has("nat_upload_doc")) {
                    $file_ps_doc = $request->file("nat_upload_doc");
                    $extension_ps_doc = $request->nat_upload_doc->extension();
                    $path_nat_doc = $request->nat_upload_doc->store(
                        "emp_nation",
                        "public"
                    );
                    $dataimgps = [
                        "nat_upload_doc" => $path_nat_doc,
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
                    "emp_ps_email" => $request->emp_ps_email,
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

                    "verify_status" => $request->verify_status,

                    "emp_department" => $request->emp_department,
                    "emp_designation" => $request->emp_designation,
                    "emp_doj" => date("Y-m-d", strtotime($request->emp_doj)),
                    "emp_status" => $request->emp_status,
                    "date_confirm" => date(
                        "Y-m-d",
                        strtotime($request->date_confirm)
                    ),
                    "start_date" => date(
                        "Y-m-d",
                        strtotime($request->start_date)
                    ),
                    "end_date" => date("Y-m-d", strtotime($request->end_date)),
                    "fte" => $request->fte,
                    "job_loc" => $request->job_loc,

                    "emp_reporting_auth" => $request->emp_reporting_auth,
                    "emp_lv_sanc_auth" => $request->emp_lv_sanc_auth,

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
                    "relation_others" => $request->relation_others,
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
                    "wedges_paymode" => $request->wedges_paymode,
                    "emp_group_name" => $request->emp_group_name,
                    "emp_pay_scale" => $request->emp_pay_scale,
                    "emp_payment_type" => $request->emp_payment_type,
                    "daily" => $request->daily,
                    "min_work" => $request->min_work,
                    "min_rate" => $request->min_rate,
                    "tax_emp" => $request->tax_emp,
                    "tax_ref" => $request->tax_ref,
                    "tax_per" => $request->tax_per,

                    "emp_pay_type" => $request->emp_pay_type,
                    "emp_bank_name" => $request->emp_bank_name,
                    "bank_branch_id" => $request->bank_branch_id,
                    "emp_account_no" => $request->emp_account_no,
                    "emp_sort_code" => $request->emp_sort_code,
                    "currency" => $request->currency,
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
                    "euss_ref_no" => $request->euss_ref_no,
                    "euss_nation" => $request->euss_nation,

                    "euss_issue_date" => date(
                        "Y-m-d",
                        strtotime($request->euss_issue_date)
                    ),
                    "euss_exp_date" => date(
                        "Y-m-d",
                        strtotime($request->euss_exp_date)
                    ),
                    "euss_review_date" => date(
                        "Y-m-d",
                        strtotime($request->euss_review_date)
                    ),
                    "euss_cur" => $request->euss_cur,

                    "euss_remarks" => $request->euss_remarks,

                    "nat_id_no" => $request->nat_id_no,
                    "nat_nation" => $request->nat_nation,
                    "nat_country_res" => $request->nat_country_res,
                    "nat_issue_date" => date(
                        "Y-m-d",
                        strtotime($request->nat_issue_date)
                    ),
                    "nat_exp_date" => date(
                        "Y-m-d",
                        strtotime($request->nat_exp_date)
                    ),
                    "nat_review_date" => date(
                        "Y-m-d",
                        strtotime($request->nat_review_date)
                    ),
                    "nat_cur" => $request->nat_cur,

                    "nat_remarks" => $request->nat_remarks,
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
                            } else {
                                $path_quli_doc = "";
                            }
                            if ($request->has("doc2")) {
                                $extension_quli_doc2 = $request->doc2[
                                    $i
                                ]->extension();
                                $path_quli_doc2 = $request->doc2[$i]->store(
                                    "employee_quli_doc2",
                                    "public"
                                );
                            } else {
                                $path_quli_doc2 = "";
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

                $payupdate = [
                    "da" => $request->da,
                    "hra" => $request->hra,
                    "conven_ta" => $request->conven_ta,
                    "perfomance" => $request->perfomance,
                    "monthly_al" => $request->monthly_al,

                    "pf_al" => $request->pf_al,
                    "income_tax" => $request->income_tax,
                    "cess" => $request->cess,
                    "esi" => $request->esi,
                    "professional_tax" => $request->professional_tax,

                    "created_at" => date("Y-m-d h:i:s"),
                    "updated_at" => date("Y-m-d h:i:s"),
                ];
                DB::table("employee_pay_structure")
                    ->where("employee_code", $decrypted_id)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($payupdate);
                Session::flash(
                    "message",
                    "Record has been successfully updated"
                );
                return redirect("migrant-employees");
            } else {
                $ckeck_dept = DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", $Roledata->reg)
                    ->first();
                if (!empty($ckeck_dept)) {
                    Session::flash(
                        "message",
                        "Employee Code Code  Already Exists."
                    );
                    return redirect("employees");
                }
                $ckeck_email = DB::table("users")
                    ->where("email", "=", $request->emp_ps_email)
                    ->first();
                if (!empty($ckeck_email)) {
                    Session::flash("message", "E-mail id  Already Exists.");
                    return redirect("employees");
                }
                $ckeck_email_em = DB::table("employee")
                    ->where("emp_ps_email", "=", $request->emp_ps_email)
                    ->first();
                if (!empty($ckeck_email_em)) {
                    Session::flash("message", "E-mail id  Already Exists.");
                    return redirect("employees");
                }
                $pay = [
                    "employee_code" => $request->emp_code,
                    "emid" => $Roledata->reg,
                    "da" => $request->da,
                    "hra" => $request->hra,
                    "conven_ta" => $request->conven_ta,
                    "perfomance" => $request->perfomance,
                    "monthly_al" => $request->monthly_al,

                    "pf_al" => $request->pf_al,
                    "income_tax" => $request->income_tax,
                    "cess" => $request->cess,
                    "esi" => $request->esi,
                    "professional_tax" => $request->professional_tax,

                    "created_at" => date("Y-m-d h:i:s"),
                    "updated_at" => date("Y-m-d h:i:s"),
                ];
                if ($request->has("emp_image")) {
                    $file = $request->file("emp_image");
                    $extension = $request->emp_image->extension();
                    $path = $request->emp_image->store(
                        "employee_logo",
                        "public"
                    );
                } else {
                    $path = "";
                }
                if ($request->has("pass_docu")) {
                    $file_doc = $request->file("pass_docu");
                    $extension_doc = $request->pass_docu->extension();
                    $path_doc = $request->pass_docu->store(
                        "employee_doc",
                        "public"
                    );
                } else {
                    $path_doc = "";
                }
                if ($request->has("visa_upload_doc")) {
                    $file_visa_doc = $request->file("visa_upload_doc");
                    $extension_visa_doc = $request->visa_upload_doc->extension();
                    $path_visa_doc = $request->visa_upload_doc->store(
                        "employee_vis_doc",
                        "public"
                    );
                } else {
                    $path_visa_doc = "";
                }
                if ($request->has("visaback_doc")) {
                    $file_visa_doc = $request->file("visaback_doc");
                    $extension_visa_doc = $request->visaback_doc->extension();
                    $path_visa_backdoc = $request->visaback_doc->store(
                        "employee_vis_doc",
                        "public"
                    );
                } else {
                    $path_visa_backdoc = "";
                }

                if ($request->has("pr_add_proof")) {
                    $file_per_doc = $request->file("pr_add_proof");
                    $extension_per_doc = $request->pr_add_proof->extension();
                    $path_per_doc = $request->pr_add_proof->store(
                        "employee_per_add",
                        "public"
                    );
                } else {
                    $path_per_doc = "";
                }
                if ($request->has("ps_add_proof")) {
                    $file_ps_doc = $request->file("ps_add_proof");
                    $extension_ps_doc = $request->ps_add_proof->extension();
                    $path_ps_doc = $request->ps_add_proof->store(
                        "employee_ps_add",
                        "public"
                    );
                } else {
                    $path_ps_doc = "";
                }

                $data = [
                    "pr_add_proof" => $path_per_doc,
                    "ps_add_proof" => $path_ps_doc,
                    "emp_code" => $request->emp_code,
                    "emp_fname" => strtoupper($request->emp_fname),
                    "emp_mname" => strtoupper($request->emp_mid_name),
                    "emp_lname" => strtoupper($request->emp_lname),
                    "emp_ps_email" => $request->emp_ps_email,
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

                    "verify_status" => "not approved",

                    "emp_department" => $request->emp_department,
                    "emp_designation" => $request->emp_designation,
                    "emp_doj" => date("Y-m-d", strtotime($request->emp_doj)),
                    "emp_status" => $request->emp_status,
                    "date_confirm" => date(
                        "Y-m-d",
                        strtotime($request->date_confirm)
                    ),
                    "start_date" => date(
                        "Y-m-d",
                        strtotime($request->start_date)
                    ),
                    "end_date" => date("Y-m-d", strtotime($request->end_date)),
                    "fte" => $request->fte,
                    "job_loc" => $request->job_loc,
                    "emp_image" => $path,
                    "emp_reporting_auth" => $request->emp_reporting_auth,
                    "emp_lv_sanc_auth" => $request->emp_lv_sanc_auth,

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
                    "relation_others" => $request->relation_others,
                    "emp_pr_street_no" => $request->emp_pr_street_no,
                    "emp_per_village" => $request->emp_per_village,
                    "emp_pr_city" => $request->emp_pr_city,
                    "emp_pr_country" => $request->emp_pr_country,
                    "emp_pr_pincode" => $request->emp_pr_pincode,
                    "emp_pr_state" => $request->emp_pr_state,
                    "wedges_paymode" => $request->wedges_paymode,

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
                    "pass_docu" => $path_doc,
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
                    "visa_upload_doc" => $path_visa_doc,
                    "visaback_doc" => $path_visa_backdoc,
                    "visa_cur" => $request->visa_cur,
                    "visa_remarks" => $request->visa_remarks,

                    "drive_doc" => $request->drive_doc,
                    "licen_num" => $request->licen_num,
                    "lin_exp_date" => $request->lin_exp_date,

                    "emp_group_name" => $request->emp_group_name,
                    "emp_pay_scale" => $request->emp_pay_scale,
                    "emp_payment_type" => $request->emp_payment_type,
                    "daily" => $request->daily,
                    "min_work" => $request->min_work,
                    "min_rate" => $request->min_rate,
                    "tax_emp" => $request->tax_emp,
                    "tax_ref" => $request->tax_ref,
                    "tax_per" => $request->tax_per,

                    "emp_pay_type" => $request->emp_pay_type,
                    "emp_bank_name" => $request->emp_bank_name,
                    "bank_branch_id" => $request->bank_branch_id,
                    "emp_account_no" => $request->emp_account_no,
                    "emp_sort_code" => $request->emp_sort_code,
                    "currency" => $request->currency,
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
                        ];
                        DB::table("employee_qualification")->insert($dataquli);
                    }
                }

                $tot_job_item = count($request->job_name);

                for ($i = 0; $i < $tot_job_item; $i++) {
                    if ($request->job_name[$i] != "") {
                        $datajob = [
                            "emp_id" => $request->emp_code,
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

                for ($i = 0; $i < $tot_train_item; $i++) {
                    if ($request->tarin_name[$i] != "") {
                        $datatrain = [
                            "emp_id" => $request->emp_code,
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

                DB::table("employee_pay_structure")->insert($pay);
                DB::table("employee")->insert($data);

                $p_dd = mt_rand(1000, 9999);
                $ins_data = [
                    "employee_id" => $request->emp_code,
                    "name" =>
                        strtoupper($request->emp_fname) .
                        strtoupper($request->emp_mid_name) .
                        strtoupper($request->emp_lname),
                    "email" => $request->emp_ps_email,
                    "user_type" => "employee",
                    "password" => $p_dd,
                    "emid" => $Roledata->reg,
                ];
                DB::table("users")->insert($ins_data);

                $ins_data_role = [
                    "menu" => "1",
                    "module_name" => "1",
                    "member_id" => $request->emp_ps_email,
                    "rights" => "Add",

                    "emid" => $Roledata->reg,
                ];
                DB::table("role_authorization")->insert($ins_data_role);

                $ins_data_role1 = [
                    "menu" => "1",
                    "module_name" => "1",
                    "member_id" => $request->emp_ps_email,
                    "rights" => "Edit",

                    "emid" => $Roledata->reg,
                ];
                DB::table("role_authorization")->insert($ins_data_role1);

                $data = [
                    "firstname" => $request->emp_fname,
                    "maname" => $request->emp_mid_name,
                    "email" => $request->emp_ps_email,
                    "lname" => $request->emp_lname,
                    "password" => $p_dd,
                ];
                $toemail = $request->emp_ps_email;
                Mail::send("mail", $data, function ($message) use ($toemail) {
                    $message
                        ->to($toemail, "Workpermitcloud")
                        ->subject("Employee Login  Details");
                    $message->from(
                        "noreply@workpermitcloud.co.uk",
                        "Workpermitcloud"
                    );
                });

                Session::flash("message", "Please assign the role.");
                return redirect("employees");
                // return redirect('pis/employee');
            }
        } else {
            return redirect("/");
        }
    }

    public function viewchangecircumstancesedit()
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

            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();

            return view("employee/change-list", $data);
        } else {
            return redirect("/");
        }
    }
    public function savechangecircumstancesedit(Request $request)
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
            $employee_type = $request->employee_type;

            $data["result"] = "";
            //dd($leave_allocation_rs);

            $f = 2;

            $employeet = DB::table("employee")
                ->where("emp_code", "=", $employee_code)
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $date1 = date("Y", strtotime($employeet->emp_doj)) . date("m-d");
            $date2 = date("Y-m-d");

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365 * 60 * 60 * 24));
            //date('Y', strtotime($date1));

            $endtyear = date("Y", strtotime($date1)) + $years;
            //dd($endtyear);
            $employeetnew = DB::table("employee")
                ->where("emp_code", "=", $employee_code)
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $employeetcircumnew = DB::table("change_circumstances_history")
                ->where("emp_code", "=", $employee_code)
                ->where("emid", "=", $Roledata->reg)
                ->orderBy("id", "DESC")
                ->first();

            //dd($employeetcircumnew);

            $employeetemployeeother = DB::table(
                "circumemployee_other_doc_history"
            )
                ->where("emp_code", "=", $employee_code)
                ->where("emid", "=", $Roledata->reg)
                ->orderBy("id", "DESC")
                ->get();

            $dataeotherdoc = "";

            if (count($employeetemployeeother) != 0) {
                foreach ($employeetemployeeother as $valother) {
                    if ($valother->doc_exp_date != "1970-01-01") {
                        if ($valother->doc_exp_date != "") {
                            $other_exp_date = date(
                                "d/m/Y",
                                strtotime($valother->doc_exp_date)
                            );
                        } else {
                            $other_exp_date = "";
                        }
                    } else {
                        $other_exp_date = "";
                    }
                    $dataeotherdoc .=
                        $valother->doc_name . "( " . $other_exp_date . ")";
                }
            }

            if (!empty($employeetcircumnew)) {
                $date_doj = date(
                    "d/m/Y",
                    strtotime($employeetcircumnew->date_change)
                );
                $anual_datenew = date(
                    "Y-m-d",
                    strtotime($employeetcircumnew->date_change . "  + 1 year")
                );
                $peradd = "";
                $peradd = $employeetcircumnew->emp_pr_street_no;
                if ($employeetcircumnew->emp_per_village) {
                    $peradd .= "," . $employeetcircumnew->emp_per_village;
                }
                if ($employeetcircumnew->emp_pr_state) {
                    $peradd .= "," . $employeetcircumnew->emp_pr_state;
                }
                if ($employeetcircumnew->emp_pr_city) {
                    $peradd .= "," . $employeetcircumnew->emp_pr_city;
                }
                if ($employeetcircumnew->emp_pr_pincode) {
                    $peradd .= "," . $employeetcircumnew->emp_pr_pincode;
                }
                if ($employeetcircumnew->emp_pr_country) {
                    $peradd .= "," . $employeetcircumnew->emp_pr_country;
                }

                if ($employeetcircumnew->visa_exp_date != "1970-01-01") {
                    if ($employeetcircumnew->visa_exp_date != "") {
                        $visa_exp_date = date(
                            "d/m/Y",
                            strtotime($employeetcircumnew->visa_exp_date)
                        );
                    } else {
                        $visa_exp_date = "";
                    }
                } else {
                    $visa_exp_date = "";
                }
                if ($employeetcircumnew->pass_exp_date != "1970-01-01") {
                    if ($employeetcircumnew->pass_exp_date != "") {
                        $stfol = date(
                            "d/m/Y",
                            strtotime($employeetcircumnew->pass_exp_date)
                        );
                    } else {
                        $stfol = "";
                    }
                } else {
                    $stfol = "";
                }

                $euss_exp = "";
                if ($employeetcircumnew->euss_exp_date != "1970-01-01") {
                    if (
                        $employeetcircumnew->euss_exp_date != "null" &&
                        $employeetcircumnew->euss_exp_date != null
                    ) {
                        $euss_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetcircumnew->euss_exp_date)
                            );
                    }
                }
                $euss_exp = $employeetcircumnew->euss_ref_no . $euss_exp;

                $dbs_exp = "";
                if ($employeetcircumnew->dbs_exp_date != "1970-01-01") {
                    if (
                        $employeetcircumnew->dbs_exp_date != "null" &&
                        $employeetcircumnew->dbs_exp_date != null
                    ) {
                        $dbs_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetcircumnew->dbs_exp_date)
                            );
                    }
                }
                $dbs_exp = $employeetcircumnew->dbs_ref_no . $dbs_exp;

                $nid_exp = "";
                if ($employeetcircumnew->nat_exp_date != "1970-01-01") {
                    if (
                        $employeetcircumnew->nat_exp_date != "null" &&
                        $employeetcircumnew->nat_exp_date != null
                    ) {
                        $nid_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetcircumnew->nat_exp_date)
                            );
                    }
                }
                $nid_exp = $employeetcircumnew->nat_id_no . $nid_exp;

                $desinf = $employeetcircumnew->emp_designation;
                $newph = $employeetcircumnew->emp_ps_phone;
                $newpnati = $employeetcircumnew->nationality;
                $newpnavia = $employeetcircumnew->visa_doc_no;
                $newpnapasas = $employeetcircumnew->pass_doc_no;
            } else {
                $date_doj = date("d/m/Y", strtotime($employeet->emp_doj));
                $anual_datenew = date(
                    "Y-m-d",
                    strtotime($employeet->emp_doj . "  + 1 year")
                );
                $peradd = "";
                $peradd = $employeetnew->emp_pr_street_no;
                if ($employeetnew->emp_per_village) {
                    $peradd .= "," . $employeetnew->emp_per_village;
                }
                if ($employeetnew->emp_pr_state) {
                    $peradd .= "," . $employeetnew->emp_pr_state;
                }
                if ($employeetnew->emp_pr_city) {
                    $peradd .= "," . $employeetnew->emp_pr_city;
                }
                if ($employeetnew->emp_pr_pincode) {
                    $peradd .= "," . $employeetnew->emp_pr_pincode;
                }
                if ($employeetnew->emp_pr_country) {
                    $peradd .= "," . $employeetnew->emp_pr_country;
                }

                if ($employeetnew->visa_exp_date != "1970-01-01") {
                    if ($employeetnew->visa_exp_date != "") {
                        $visa_exp_date = date(
                            "d/m/Y",
                            strtotime($employeetnew->visa_exp_date)
                        );
                    } else {
                        $visa_exp_date = "";
                    }
                } else {
                    $visa_exp_date = "";
                }
                if ($employeetnew->pass_exp_date != "1970-01-01") {
                    if ($employeetnew->pass_exp_date != "") {
                        $stfol = date(
                            "d/m/Y",
                            strtotime($employeetnew->pass_exp_date)
                        );
                    } else {
                        $stfol = "";
                    }
                } else {
                    $stfol = "";
                }

                $euss_exp = "";
                if ($employeetnew->euss_exp_date != "1970-01-01") {
                    if (
                        $employeetnew->euss_exp_date != "null" &&
                        $employeetnew->euss_exp_date != null
                    ) {
                        $euss_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetnew->euss_exp_date)
                            );
                    }
                }
                $euss_exp = $employeetnew->euss_ref_no . $euss_exp;

                $dbs_exp = "";
                if ($employeetnew->dbs_exp_date != "1970-01-01") {
                    if (
                        $employeetnew->dbs_exp_date != "null" &&
                        $employeetnew->dbs_exp_date != null
                    ) {
                        $dbs_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetnew->dbs_exp_date)
                            );
                    }
                }
                $dbs_exp = $employeetnew->dbs_ref_no . $dbs_exp;

                $nid_exp = "";
                if ($employeetnew->nat_exp_date != "1970-01-01") {
                    if (
                        $employeetnew->nat_exp_date != "null" &&
                        $employeetnew->nat_exp_date != null
                    ) {
                        $nid_exp =
                            "  EXPIRE:" .
                            date(
                                "jS F Y",
                                strtotime($employeetnew->nat_exp_date)
                            );
                    }
                }
                $nid_exp = $employeetnew->nat_id_no . $nid_exp;

                $desinf = $employeetnew->emp_designation;
                $newph = $employeetnew->emp_ps_phone;
                $newpnati = $employeetnew->nationality;
                $newpnavia = $employeetnew->visa_doc_no;
                $newpnapasas = $employeetnew->pass_doc_no;
            }

            $emp_name_history = $employeetnew->emp_fname;
            if (
                isset($employeetcircumnew->emp_mname) &&
                $employeetcircumnew->emp_mname != "" &&
                $employeetcircumnew->emp_mname != null
            ) {
                $emp_name_history =
                    $emp_name_history . " " . $employeetcircumnew->emp_mname;
            } else {
                $emp_name_history =
                    $emp_name_history . " " . $employeetnew->emp_mname;
            }
            if (
                isset($employeetcircumnew->emp_lname) &&
                $employeetcircumnew->emp_lname != "" &&
                $employeetcircumnew->emp_lname != null
            ) {
                $emp_name_history =
                    $emp_name_history . " " . $employeetcircumnew->emp_lname;
            } else {
                $emp_name_history =
                    $emp_name_history . " " . $employeetnew->emp_lname;
            }

            $data["result"] .=
                '<tr>
			<td>1</td>
													<td>' .
                $date_doj .
                '</td>
													<td>' .
                $employee_type .
                '</td>
													<td>' .
                $employee_code .
                '</td>
													<td>' .
                $emp_name_history .
                '</td>

													<td>' .
                $desinf .
                '</td>
														<td>' .
                $peradd .
                '</td>

													<td>' .
                $newph .
                '</td>
														<td>' .
                $newpnati .
                '</td>

															<td>' .
                $newpnavia .
                '</td>
															<td>' .
                $visa_exp_date .
                '</td>
																<td>Not Applicable </td>
															<td>' .
                $newpnapasas .
                '
														( ' .
                $stfol .
                ' )</td>
                                                        <td>' .
                $euss_exp .
                '</td>
                                                        <td>' .
                $dbs_exp .
                '</td>
                                                        <td>' .
                $nid_exp .
                '</td>
															<td>' .
                $dataeotherdoc .
                '</td>
															<td></td>
															<td></td>
															<td>' .
                date("d/m/Y", strtotime($anual_datenew)) .
                ' &nbsp &nbsp <a href="' .
                env("BASE_URL") .
                "dashboard/change/" .
                base64_encode($employee_code) .
                "/" .
                base64_encode($anual_datenew) .
                '" target="_blank"><i class="fas fa-eye" ></i></a>


															 &nbsp &nbsp <a href="' .
                env("BASE_URL") .
                "employee/changesendlet/" .
                base64_encode($employee_code) .
                "/" .
                base64_encode($anual_datenew) .
                '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';

            for (
                $m = date("Y", strtotime($employeet->emp_doj));
                $m <= $endtyear;
                $m++
            ) {
                $strartye = date($m . "-01-01");
                $endtye = date($m . "-12-31");

                $leave_allocation_rs = DB::table("change_circumstances")
                    ->join(
                        "employee",
                        "change_circumstances.emp_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where(
                        "change_circumstances.emp_code",
                        "=",
                        $employee_code
                    )
                    ->where("change_circumstances.emid", "=", $Roledata->reg)
                    ->where("employee.emp_code", "=", $employee_code)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("employee.emp_status", "=", $employee_type)
                    ->whereBetween("date_change", [$strartye, $endtye])
                    ->orderBy("date_change", "ASC")
                    ->select("change_circumstances.*")

                    ->get();

                if (count($leave_allocation_rs) != 0) {
                    //dd($leave_allocation_rs);

                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $peradd = "";
                        $peradd = $leave_allocation->emp_pr_street_no;
                        if ($leave_allocation->emp_per_village) {
                            $peradd .= "," . $leave_allocation->emp_per_village;
                        }
                        if ($leave_allocation->emp_pr_state) {
                            $peradd .= "," . $leave_allocation->emp_pr_state;
                        }
                        if ($leave_allocation->emp_pr_city) {
                            $peradd .= "," . $leave_allocation->emp_pr_city;
                        }
                        if ($leave_allocation->emp_pr_pincode) {
                            $peradd .= "," . $leave_allocation->emp_pr_pincode;
                        }
                        if ($leave_allocation->emp_pr_country) {
                            $peradd .= "," . $leave_allocation->emp_pr_country;
                        }

                        $preadd = "";
                        $preadd = $leave_allocation->emp_ps_street_no;

                        if ($leave_allocation->emp_ps_village) {
                            $preadd .= "," . $leave_allocation->emp_ps_village;
                        }
                        if ($leave_allocation->emp_ps_state) {
                            $preadd .= "," . $leave_allocation->emp_ps_state;
                        }
                        if ($leave_allocation->emp_ps_city) {
                            $preadd .= "," . $leave_allocation->emp_ps_city;
                        }
                        if ($leave_allocation->emp_ps_pincode) {
                            $preadd .= "," . $leave_allocation->emp_ps_pincode;
                        }
                        if ($leave_allocation->emp_ps_country) {
                            $preadd .= "," . $leave_allocation->emp_ps_country;
                        }
                        if ($leave_allocation->emp_dob != "1970-01-01") {
                            if ($leave_allocation->emp_dob != "") {
                                $dov = date(
                                    "d/m/Y",
                                    strtotime($leave_allocation->emp_dob)
                                );
                            } else {
                                $dov = "";
                            }
                        } else {
                            $dov = "";
                        }

                        if ($leave_allocation->visa_exp_date != "1970-01-01") {
                            if ($leave_allocation->visa_exp_date != "") {
                                $visa_exp_date = date(
                                    "d/m/Y",
                                    strtotime($leave_allocation->visa_exp_date)
                                );
                            } else {
                                $visa_exp_date = "";
                            }
                        } else {
                            $visa_exp_date = "";
                        }

                        if ($leave_allocation->pass_exp_date != "1970-01-01") {
                            if ($leave_allocation->pass_exp_date != "") {
                                $stfol = date(
                                    "d/m/Y",
                                    strtotime($leave_allocation->pass_exp_date)
                                );
                            } else {
                                $stfol = "";
                            }
                        } else {
                            $stfol = "";
                        }

                        $euss_exp = "";
                        if ($leave_allocation->euss_exp_date != "1970-01-01") {
                            if (
                                $leave_allocation->euss_exp_date != "null" &&
                                $leave_allocation->euss_exp_date != null
                            ) {
                                $euss_exp =
                                    "  EXPIRE:" .
                                    date(
                                        "jS F Y",
                                        strtotime(
                                            $leave_allocation->euss_exp_date
                                        )
                                    );
                            }
                        }
                        $euss_exp = $leave_allocation->euss_ref_no . $euss_exp;

                        $dbs_exp = "";
                        if ($leave_allocation->dbs_exp_date != "1970-01-01") {
                            if (
                                $leave_allocation->dbs_exp_date != "null" &&
                                $leave_allocation->dbs_exp_date != null
                            ) {
                                $dbs_exp =
                                    "  EXPIRE:" .
                                    date(
                                        "jS F Y",
                                        strtotime(
                                            $leave_allocation->dbs_exp_date
                                        )
                                    );
                            }
                        }
                        $dbs_exp = $leave_allocation->dbs_ref_no . $dbs_exp;

                        $nid_exp = "";
                        if ($leave_allocation->nat_exp_date != "1970-01-01") {
                            if (
                                $leave_allocation->nat_exp_date != "null" &&
                                $leave_allocation->nat_exp_date != null
                            ) {
                                $nid_exp =
                                    "  EXPIRE:" .
                                    date(
                                        "jS F Y",
                                        strtotime(
                                            $leave_allocation->nat_exp_date
                                        )
                                    );
                            }
                        }
                        $nid_exp = $leave_allocation->nat_id_no . $nid_exp;

                        $employeet = DB::table("employee")
                            ->where(
                                "emp_code",
                                "=",
                                $leave_allocation->emp_code
                            )
                            ->where("emid", "=", $Roledata->reg)
                            ->first();

                        $dojg = date("m-d", strtotime($employeet->emp_doj));

                        $anual_date = date(
                            "Y-m-d",
                            strtotime($m . "-" . $dojg . "  + 1 year")
                        );

                        $employeetemployeeother = DB::table(
                            "circumemployee_other_doc"
                        )
                            ->where(
                                "emp_code",
                                "=",
                                $leave_allocation->emp_code
                            )
                            ->where("emid", "=", $Roledata->reg)
                            ->where("cir_id", "=", $leave_allocation->id)
                            ->orderBy("id", "DESC")
                            ->get();

                        $dataeotherdoc = "";

                        if (count($employeetemployeeother) != 0) {
                            foreach ($employeetemployeeother as $valother) {
                                if ($valother->doc_exp_date != "1970-01-01") {
                                    if ($valother->doc_exp_date != "") {
                                        $other_exp_date = date(
                                            "d/m/Y",
                                            strtotime($valother->doc_exp_date)
                                        );
                                    } else {
                                        $other_exp_date = "";
                                    }
                                } else {
                                    $other_exp_date = "";
                                }
                                $dataeotherdoc .=
                                    $valother->doc_name .
                                    "( " .
                                    $other_exp_date .
                                    ")";
                            }
                        }

                        $emp_name_coc = $employeet->emp_fname;
                        if ($leave_allocation->emp_mname != "") {
                            $emp_name_coc =
                                $emp_name_coc .
                                " " .
                                $leave_allocation->emp_mname;
                        } else {
                            $emp_name_coc =
                                $emp_name_coc . " " . $employeet->emp_mname;
                        }

                        if ($leave_allocation->emp_lname != "") {
                            $emp_name_coc =
                                $emp_name_coc .
                                " " .
                                $leave_allocation->emp_lname;
                        } else {
                            $emp_name_coc =
                                $emp_name_coc . " " . $employeet->emp_lname;
                        }

                        $data["result"] .=
                            "<tr><td>" .
                            $f .
                            '</td>
													<td>' .
                            date(
                                "d/m/Y",
                                strtotime($leave_allocation->date_change)
                            ) .
                            '</td>
													<td>' .
                            $employee_type .
                            '</td>
													<td>' .
                            $leave_allocation->emp_code .
                            '</td>
													<td>' .
                            $emp_name_coc .
                            '</td>

													<td>' .
                            $leave_allocation->emp_designation .
                            '</td>
														<td>' .
                            $peradd .
                            '</td>

													<td>' .
                            $leave_allocation->emp_ps_phone .
                            '</td>
														<td>' .
                            $leave_allocation->nationality .
                            '</td>

															<td>' .
                            $leave_allocation->visa_doc_no .
                            '</td>
															<td>' .
                            $visa_exp_date .
                            '</td>
																<td>' .
                            $leave_allocation->res_remark .
                            '</td>
															<td>' .
                            $leave_allocation->pass_doc_no .
                            '
														( ' .
                            $stfol .
                            ' )</td>
                                                        <td>' .
                            $euss_exp .
                            '</td>
                                                        <td>' .
                            $dbs_exp .
                            '</td>
                                                        <td>' .
                            $nid_exp .
                            '</td>
														<td>' .
                            $dataeotherdoc .
                            '</td>
															<td>' .
                            $leave_allocation->hr .
                            '</td>
															<td>' .
                            $leave_allocation->home .
                            '</td>
															<td>' .
                            date("d/m/Y", strtotime($anual_date)) .
                            ' &nbsp &nbsp <a href="' .
                            env("BASE_URL") .
                            "dashboard/change/" .
                            base64_encode($employee_code) .
                            "/" .
                            base64_encode($anual_date) .
                            '" target="_blank"><i class="fas fa-eye" ></i></a>


															 &nbsp &nbsp <a href="' .
                            env("BASE_URL") .
                            "employee/changesendlet/" .
                            base64_encode($employee_code) .
                            "/" .
                            base64_encode($anual_date) .
                            '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';

                        $f++;
                    }
                } else {
                    $dojg = date("m-d", strtotime($employeet->emp_doj));
                    $anual_date = date(
                        "Y-m-d",
                        strtotime($m . "-" . $dojg . "  + 1 year")
                    );
                    $no = "";
                    if (date("Y", strtotime($employeet->emp_doj)) != $m) {
                        if ($endtyear != $m) {
                            $no = "not change ";
                        } else {
                            $no = "";
                        }
                        $data["result"] .=
                            '<tr>
				                                    <td>' .
                            $f .
                            '</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>

													<td></td>
														<td></td>

													<td></td>
														<td></td>

															<td></td>
															<td> </td>
																	<td>' .
                            $no .
                            '</td>
																	<td></td>
															<td></td>
															<td></td>
															<td></td>
                                                            <td></td>
															<td></td>
															<td></td>
															<td>' .
                            date("d/m/Y", strtotime($anual_date)) .
                            ' &nbsp &nbsp <a href="' .
                            env("BASE_URL") .
                            "dashboard/change/" .
                            base64_encode($employee_code) .
                            "/" .
                            base64_encode($anual_date) .
                            '" target="_blank"><i class="fas fa-eye" ></i></a>&nbsp &nbsp <a href="' .
                            env("BASE_URL") .
                            "employee/changesendlet/" .
                            base64_encode($employee_code) .
                            "/" .
                            base64_encode($anual_date) .
                            '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';
                        $f++;
                    }
                }
            }

            for ($o = $endtyear + 1; $o <= $endtyear + 4; $o++) {
                $dojg = date("m-d", strtotime($employeet->emp_doj));
                $anual_date = date(
                    "Y-m-d",
                    strtotime($o . "-" . $dojg . "  + 1 year")
                );

                $data["result"] .=
                    '<tr>
				<td>' .
                    $f .
                    '</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>

													<td></td>
														<td></td>

													<td></td>
														<td></td>

															<td></td>
															<td> </td>
																<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
                                                            <td></td>
															<td></td>
															<td></td>
															<td>' .
                    date("d/m/Y", strtotime($anual_date)) .
                    ' &nbsp &nbsp <a href="' .
                    env("BASE_URL") .
                    "dashboard/change/" .
                    base64_encode($employee_code) .
                    "/" .
                    base64_encode($anual_date) .
                    '" target="_blank"><i class="fas fa-eye" ></i></a>&nbsp &nbsp <a href="' .
                    env("BASE_URL") .
                    "employee/changesendlet/" .
                    base64_encode($employee_code) .
                    "/" .
                    base64_encode($anual_date) .
                    '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';
                $f++;
            }

            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();
            $data["employee_code"] = $employee_code;
            $data["employee_type"] = $employee_type;
            return view("employee/change-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewemployeeagreement()
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

            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();

            return view("employee/contract-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function saveemployeeagreement(Request $request)
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
            $employee_type = $request->employee_type;

            $data["result"] = "";
            if ($employee_code != "") {
                $leave_allocation_rs = DB::table("employee")

                    ->where("emp_code", "=", $employee_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_status", "=", $employee_type)

                    ->select("employee.*")
                    ->get();
            } else {
                $leave_allocation_rs = DB::table("employee")

                    ->where("emid", "=", $Roledata->reg)
                    ->where("emp_status", "=", $employee_type)

                    ->select("employee.*")
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {
                $f = 1;

                foreach ($leave_allocation_rs as $leave_allocation) {
                    $peradd = "";
                    $peradd = $leave_allocation->emp_pr_street_no;
                    if ($leave_allocation->emp_per_village) {
                        $peradd .= "," . $leave_allocation->emp_per_village;
                    }
                    if ($leave_allocation->emp_pr_state) {
                        $peradd .= "," . $leave_allocation->emp_pr_state;
                    }
                    if ($leave_allocation->emp_pr_city) {
                        $peradd .= "," . $leave_allocation->emp_pr_city;
                    }
                    if ($leave_allocation->emp_pr_pincode) {
                        $peradd .= "," . $leave_allocation->emp_pr_pincode;
                    }
                    if ($leave_allocation->emp_pr_country) {
                        $peradd .= "," . $leave_allocation->emp_pr_country;
                    }

                    $preadd = "";
                    $preadd = $leave_allocation->emp_ps_street_no;
                    if ($leave_allocation->emp_ps_village) {
                        $preadd .= "," . $leave_allocation->emp_ps_village;
                    }
                    if ($leave_allocation->emp_ps_state) {
                        $preadd .= "," . $leave_allocation->emp_ps_state;
                    }
                    if ($leave_allocation->emp_ps_city) {
                        $preadd .= "," . $leave_allocation->emp_ps_city;
                    }
                    if ($leave_allocation->emp_ps_pincode) {
                        $preadd .= "," . $leave_allocation->emp_ps_pincode;
                    }
                    if ($leave_allocation->emp_ps_country) {
                        $preadd .= "," . $leave_allocation->emp_ps_country;
                    }

                    $employeet = DB::table("employee")
                        ->where("emp_code", "=", $leave_allocation->emp_code)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();

                    $dteemployeet = "";
                    if ($employeet->visa_exp_date != "1970-01-01") {
                        $dteemployeet = date(
                            "d/m/Y",
                            strtotime($employeet->visa_exp_date)
                        );
                    }
                    $data["result"] .=
                        '<tr>
				<td>' .
                        $f .
                        '</td>
													<td>' .
                        $employee_type .
                        '</td>
													<td>' .
                        $leave_allocation->emp_code .
                        '</td>
													<td>' .
                        $employeet->emp_fname .
                        "  " .
                        $employeet->emp_mname .
                        " " .
                        $employeet->emp_lname .
                        '</td>
													<td>' .
                        date("d/m/Y", strtotime($leave_allocation->emp_dob)) .
                        '</td>
													<td>' .
                        $leave_allocation->emp_ps_phone .
                        '</td>
														<td>' .
                        $leave_allocation->nationality .
                        '</td>
														<td>' .
                        $leave_allocation->ni_no .
                        '</td>
															<td>' .
                        $dteemployeet .
                        '</td>
															<td>' .
                        $leave_allocation->pass_doc_no .
                        '</td>
															<td>' .
                        $peradd .
                        '</td>


													<td><a href="contract-agreement-edit/' .
                        base64_encode($leave_allocation->emp_code) .
                        '"><i class="fas fa-file-pdf"></i></a>
													<a href="contract-word/' .
                        base64_encode($leave_allocation->emp_code) .
                        '"><i class="fas fa-file-word"></i></a></td>




						</tr>';
                    $f++;
                }
            }
            $data["employee_type_rs"] = DB::table("employee_type")
                ->where("emid", "=", $Roledata->reg)
                ->where("employee_type_status", "=", "Active")
                ->get();
            $data["employee_code"] = $request->employee_code;
            $data["employee_type"] = $request->employee_type;
            return view("employee/contract-list", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewemployeeagreementdit($emp_id)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $first_day_this_year = date("Y-01-01");
            $last_day_this_year = date("Y-12-31");
            $offarr = 0;
            $emjob = DB::table("employee")
                ->where("emp_code", "=", base64_decode($emp_id))
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $currency_auth = DB::table("currencies")

                ->where("code", "=", $emjob->currency)
                ->orderBy("id", "DESC")
                ->first();
            $pay_type_auth = DB::table("payment_type_master")

                ->where("id", "=", $emjob->emp_payment_type)
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
                    ->where("employee_id", "=", base64_decode($emp_id))
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
                    base64_decode($emp_id)
                )
                ->where("leave_allocation.emid", "=", $Roledata->reg)
                ->whereBetween("leave_allocation.created_at", [
                    $first_day_this_year,
                    $last_day_this_year,
                ])

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
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = "";
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = "";
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
                "symbol" => $symbol,
                "week_time" => $offarr,
                "year_time" => $years,
                "pay_type" => $pay_ty,
                "LeaveAllocation" => $data["LeaveAllocation"],
                "birth" => $emjob->country_birth,
                "emp_de" => $emjob,
                "Roledata" => $Roledata,
            ];

            $pdf = PDF::loadView("mypdfagree", $datap);
            return $pdf->download("contract.pdf");
            Session::flash(
                "message",
                "Contract Agreement Create Successfully."
            );
            return redirect("employee/contract-agreement");
        } else {
            return redirect("/");
        }
    }

    public function msword($emp_id)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            $first_day_this_year = date("Y-01-01");
            $last_day_this_year = date("Y-12-31");
            $offarr = 0;
            $emjob = DB::table("employee")
                ->where("emp_code", "=", base64_decode($emp_id))
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $currency_auth = DB::table("currencies")

                ->where("code", "=", $emjob->currency)
                ->orderBy("id", "DESC")
                ->first();
            $pay_type_auth = DB::table("payment_type_master")

                ->where("id", "=", $emjob->emp_payment_type)
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
                    ->where("employee_id", "=", base64_decode($emp_id))
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

            $LeaveAllocation = DB::table("leave_allocation")
                ->join(
                    "leave_type",
                    "leave_allocation.leave_type_id",
                    "=",
                    "leave_type.id"
                )
                ->where(
                    "leave_allocation.employee_code",
                    "=",
                    base64_decode($emp_id)
                )
                ->where("leave_allocation.emid", "=", $Roledata->reg)
                ->whereBetween("leave_allocation.created_at", [
                    $first_day_this_year,
                    $last_day_this_year,
                ])

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
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = "";
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = "";
            }

            $laeve_arr = [];
            $laeve_srt = "";
            $laeve_arr1 = [];
            $laeve_srt1 = "";

            if (count($LeaveAllocation) != 0) {
                foreach ($LeaveAllocation as $value) {
                    $laeve_arr[] =
                        $value->leave_in_hand .
                        "  days  " .
                        strtolower($value->leave_type_name);
                    $laeve_arr1[] =
                        $value->max_no .
                        "  days  " .
                        strtolower($value->leave_type_name);
                }

                $laeve_srt = implode(",", $laeve_arr);
                $laeve_srt1 = implode(",", $laeve_arr1);
            } else {
                $laeve_srt = "";
                $laeve_srt1 = "";
            }

            $address_emp = "";
            $em_name =
                $emjob->emp_fname .
                " " .
                $emjob->emp_mname .
                " " .
                $emjob->emp_lname;
            $address_emp .= $emjob->emp_pr_street_no;
            if ($emjob->emp_per_village) {
                $address_emp .= ", " . $emjob->emp_per_village;
            }
            if ($emjob->emp_pr_state) {
                $address_emp .= ", " . $emjob->emp_pr_state;
            }
            if ($emjob->emp_pr_city) {
                $address_emp .= ", " . $emjob->emp_pr_city;
            }
            if ($emjob->emp_pr_pincode) {
                $address_emp .= ", " . $emjob->emp_pr_pincode;
            }
            if ($emjob->emp_pr_country) {
                $address_emp .= ", " . $emjob->emp_pr_country;
            }

            if ($emjob->start_date != "1970-01-01") {
                if ($emjob->start_date != "") {
                    $date_con = date("d/m/Y", strtotime($emjob->start_date));
                }
            } else {
                $date_con = "";
            }

            $job_r = DB::table("company_job_list")

                ->where("emid", "=", $Roledata->reg)
                ->where("title", "=", $emjob->emp_designation)

                ->orderBy("id", "DESC")
                ->first();
            if (!empty($job_r)) {
                $job_p = $job_r->des_job;
            } else {
                $job_p = "";
            }
            if (!empty($emjob->emp_payment_type)) {
                $emp_payment_type = DB::table("payment_type_master")

                    ->where("id", "=", $emjob->emp_payment_type)

                    ->orderBy("id", "DESC")
                    ->first();
                if (strpos($emp_payment_type->pay_type, "Weekly") !== false) {
                    $pay_y = "Weekly";
                } else {
                    $pay_y = $emp_payment_type->pay_type;
                }

                $offarr = $emjob->min_work;
                $rate = $emjob->min_rate;
            } else {
                $pay_y = "";
                $offarr = "";
                $rate = "";
            }
            $perwd = "";

            if (!empty($emjob->wedges_paymode)) {
                $emp_wedgpayment_type = DB::table("payment_type_wedes")

                    ->where("id", "=", $emjob->wedges_paymode)

                    ->orderBy("id", "DESC")
                    ->first();
                $perwd = $emp_wedgpayment_type->pay_type;
            }
            $cash = "";
            if ($Roledata->logo != "") {
                $imgf =
                    '<img src="' .
                    env("BASE_URL") .
                    "public/" .
                    $Roledata->logo .
                    '" alt="" width="100" height="100"  >';
            } else {
                $imgf = "";
            }
            if (
                !empty($emjob->emp_pay_type) &&
                $emjob->emp_pay_type == "Bank"
            ) {
                $cash = "BACS";
            } elseif ($emjob->emp_pay_type == "Cash") {
                $cash = "cash";
            } else {
                $cash = "BACS";
            }
            $mainadd = $Roledata->address;
            if ($Roledata->address2 != "") {
                $mainadd .= $Roledata->address2;
            }
            if ($Roledata->road != "") {
                $mainadd .= $Roledata->road;
            }
            if ($Roledata->city != "") {
                $mainadd .= $Roledata->city;
            }
            if ($Roledata->zip != "") {
                $mainadd .= $Roledata->zip;
            }
            if ($Roledata->country != "") {
                $mainadd .= $Roledata->country;
            }

            $headers = [
                "Content-type" => "text/html",
                "name" => "Arial",
                "size" => 20,
                "bold" => true,
                "Content-Disposition" => "attachment;Filename=contract.doc",
            ];

            $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Agreement</title>
</head>


  <body>
  <table width="100%" style="text-align: left;">
    <tbody>
      <tr>
 <th style="text-align: left;">';
            $content .= $imgf;
            $content .= ' </th>
   </tr>
      <tr><th><h2 style="margin: 0;text-align: left;">';
            $content .= $Roledata->com_name;

            $content .= '  <tr><th><h1 style="text-align:left;"><span style="border-bottom: 1px solid">Contract of Employment</span></h1></th></tr>
    <tr>
        <td><p style="margin: 0;font-weight:600;">Between the Employer, ';
            $content .= $Roledata->com_name;

            $content .= ' <p style="margin: 0;font-weight:600;">';
            $content .= $mainadd;
            $content .= '
</p>
          <p style="margin: 0;font-weight:600;">and the Employee, ';
            $content .= $em_name;

            $content .= '</p>
          <p style="margin: 0;font-weight:600;">';
            $content .= $address_emp;

            $content .= '   </p>
        </td>
      </tr>
      <tr><td><h3 style="font-weight: 600">Start of Employment and Duration of Contract</h3>
        <p>The employment will start on ';
            $content .= $date_con;

            $content .= '  and
        the Initial duration of work is a 3 year period. This contract may be extended in future subject to your performance and subject to immigration control if
        it is required for your visa condition.</p></td></tr>
<tr><td>
        <h3 style="font-weight: 600;">Probationary Period</h3>
        <p>The employment is subject to the completion of a 3 months probationary period.</p>

<p>If, at the end of the probationary period, the Employee performance is considered to be of a satisfactory standard, the appointment will be made permanent.</p>

<p>During the probationary period, one-week notice may be given by either party to terminate this contract.</p>
<p>In lieu of notice during the probationary period, the Employer may pay the Employee the salary that he would have earned till the end of probationary period.</p></td>
      </tr>
      <tr><td>

<h3 style="font-weight: 600;">Job Description</h3>
<p>The Employee is engaged initially to perform the duties of   ';
            $content .= $emjob->emp_designation;

            $content .= " </p> ";
            $content .= $job_p;

            $content .= ' <p>The Employee will, however, be expected to carry out any other reasonable duties in line with his responsibilities to assist in the smooth operation of the business.</p>
</td>
      </tr>

      <tr><td>
<h3 style="font-weight: 600;">Qualifications</h3>
<p>If the Employee employment with the Employer is dependent upon the possession of particular qualifications or registration with a statutory Body or other Authority, then evidence of this must be produced on request.</p>

<p>Failure to produce such evidence may lead to the termination of the employment.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Place of Work</h3>
<p>The normal place of work will be at the Employer address shown above.</p>

<p>Following reasonable notice and consultation, however, the Employee would be expected to work at any other premises if required.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Working Hours</h3>
<p>The working hours are ';
            $content .= $offarr;

            $content .= '    per week.</p>

<p>The Employer may require the Employee to vary the pattern of his working hours to meet the needs of the service.</p>

<p>The Employee entitlement to have paid refreshment breaks.</p>
<p><b>Remuneration</b></p>
<p>You are entitled to be paid GBP ';
            $content .= $rate;

            $content .= "   per ";
            $content .= $pay_y;

            $content .= " . Your salary will be paid ";
            $content .= $perwd;

            $content .= " by ";
            $content .= $cash;
            $content .= '.</p>

<p>Your rate of pay will be reviewed in every six months. Your rate of pay will not necessarily increase as a result of the review. </p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Overtime payments</h3>
<p>Additional payments will be made for overtime worked as per company policy.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Holidays</h3>
<p>The Management holiday year runs from 1st January to 31st December inclusive. If you work part time your pro-rata entitlement will be based on the number of hours you work. If you work as a full time employee you will be entitled to have 28 days paid holiday in each year, in addition to statutory holidays.You are allowed to take an unpaid holiday subject to special circumstances, but it must be prior approved by the management.</p>

<p>You must obtain authorization from the Management before making any holiday arrangements. The date
of holidays must be agreed with the Employer and a Holiday Request must be completed and authorized by the Employer at least 14 days prior to your proposed holiday dates.
<b>Any unauthorized absence for more than 10 days will be notified to the Home Office UKVI if it is required for your visa condition.</b>
Furthermore, disciplinary action may be taken against you. You must inform the management immediately if there is any change of circumstance,such as change of contact details, change of your immigration status etc</p>

</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Sickness</h3>
<p>Subject to you complying with the above notification and certification requirements, plus any additional rules introduced from time to time, you will, if eligible, be paid Statutory Sick Pay in accordance with the legislation applying from time to time.</p>

<p>For the purpose of Statutory Sick Pay, your qualifying days are Monday to Friday.</p>

<p>The Employer does not operate a sick pay scheme other than Statutory Sick Pay.</p>
</td>
      </tr>
      <tr><td>

<h3 style="font-weight: 600;">Pension Scheme</h3>
<p>The Company will comply with its employer pension duties in accordance with relevant legislation (if applicable). Details in this respect will be furnished to you separately.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Notice of Termination</h3>
<p>Where there is just cause for termination, the Employer may terminate the Employee employment without notice, as permitted by law.</p>

<p>The Employee and the Employer agree that reasonable and sufficient notice of termination of employment by the Employer is the greater of four (4) weeks or any minimum notice required by law.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Redundancy</h3>
<p>If the Employer decides to reduce manning levels, suitable volunteers will be asked for.</p>

<p>In addition, the Employer may select other employees for redundancy on the basis of an assessment of relative capabilities, performance, service length, conduct, reliability, attendance record and suitability for the remaining work.</p>

<p>In the event of redundancy, statutory redundancy terms will apply.</p>

</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Rules of Conduct</h3>
<p>The Employee must:</p>
<ul>
<li>not endanger the health or safety of any employee whilst at work;</li>
<li>at all times use as instructed any protective clothing or equipment which has been issued;</li>
<li>immediately report accidents, no matter how slight;</li>
<li>observe all rules concerning smoking and fire hazards;</li>
<li>act wholeheartedly in the interests of the Employer at all times;</li>
<li>acquaint (himself/herself) with all authorised notices displayed at his place of work;</li>
<li>inform the Employer if he contracts a contagious illness;</li>
<li>not remove any material or equipment from his place of work without prior permission;</li>
<li>not use the Employer time, material or equipment for unauthorised work;</li>
<li>at all times follow Employer working and operation procedures.</li>

</ul>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Misconduct Leading to Summary Dismissal Without Notice</h3>
<ul>
<li>theft of the Employer property;</li>
<li>fighting, physical assault or dangerous horseplay;</li>
<li>failure to carry out a direct instruction from a superior during working hours;</li>
<li>use of bad language or aggressive behavior on the Employer premises or in front of customers;</li>
<li>wilful and/or deliberate damage of the Employer property;</li>
<li>incapability through alcohol or illegal drugs;</li>
<li>loss of driving licence where driving is an essential part of the job;</li>
<li>endangering the health or safety of another person at the place of work;</li>
<li>deliberately falsifying the Employer records;</li>
<li>receiving bribes to affect the placing of business with a supplier of goods or services;</li>
<li>falsely claiming to be sick in order to defraud the Employer;</li>
<li>immoral conduct.</li>
</ul>
</td>
      </tr>
      <tr><td>


<h3 style="font-weight: 600;">Disciplinary Action</h3>
<p>Should the need for disciplinary action be deemed necessary, this will be taken in accordance with the Employer Policy and Procedure on Disciplinary Action.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Grievances</h3>
<p>Where the Employee has a grievance relating to any aspect of their employment,they should contact their immediate manager and give full details of his grievance, in confidence.</p>

<p>The Employee should allow reasonable time for consideration of all the facts before remedial action can be taken.</p>
</td>
      </tr>
      <tr><td>
<p>Where the Employee immediate manager is not able satisfactorily to resolve the grievance, the Employee should refer the matter in writing to the most senior manager available.</p>

<p>The Employee has the right to be accompanied by a work colleague or by another person as in accordance with the current legislation throughout the grievance procedure.</p>


<p style="font-weight: 600;">If you agree with the above terms and conditions please sign both copies of this Contract, retain one and return the other to me.</p>

      </td>
    </tr>
<tr>
  <td><p style="font-weight: 600;">Signed  ______________________________<br>for ';
            $content .= $Roledata->com_name;

            $content .= ' , <span style="float:right;">Date: ';
            $content .= "  _______________";

            $content .= '  </span></p>
<br>
    <p style="font-weight: 600;">Signed ______________________________<br>for ';
            $content .= $em_name;

            $content .= ' , <span style="float:right;">Date:';
            $content .= "  _______________";

            $content .= ' </span> </p>
  </td>
</tr>
    </tbody>
  </table>





  </body>
</html>';

            return \Response::make($content, 200, $headers);
        } else {
            return redirect("/");
        }
    }

    public function newaddEmployee($reg_id, $emp_id)
    {
        $data["currencies"] = DB::table("currencies")
            ->orderBy("country", "asc")
            ->get();
        $data["reg"] = base64_decode($reg_id);
        $data["employee"] = DB::table("company_employee")
            ->where("emid", "=", base64_decode($reg_id))
            ->where("id", "=", base64_decode($emp_id))
            ->first();
        $data["currency_user"] = DB::table("currencies")
            ->orderBy("country", "asc")
            ->get();
        if (!empty($data["employee"])) {
            return view("employee/basic-info", $data);
        } else {
            return redirect("/");
        }
    }

    public function savenewEmployee(Request $request)
    {
        $Employee = DB::table("users")
            ->where("email", "=", $request->emp_ps_email)
            ->first();

        if (empty($Employee)) {
            $datapaytyy = [
                "pay_type" => $request->emp_payment_type,
                "work_hour" => $request->min_work,

                "rate" => $request->min_rate,
                "emid" => $request->emid,
            ];

            $deptnmdb = DB::table("payment_type_master")
                ->where("pay_type", "=", $request->emp_payment_type)
                ->where("emid", $request->emid)
                ->first();

            if (empty($deptnmdb)) {
                DB::table("payment_type_master")->insert($datapaytyy);
            }
            $deptnmdhjkb = DB::table("payment_type_master")
                ->where("pay_type", "=", $request->emp_payment_type)
                ->where("emid", $request->emid)
                ->first();
            $st_date = "";
            if ($request->start_date != "") {
                $st_date = date("Y-m-d", strtotime($request->start_date));
            } else {
                $st_date = "";
            }
            $en_date = "";
            if ($request->end_date != "") {
                $en_date = date("Y-m-d", strtotime($request->end_date));
            } else {
                $en_date = "";
            }
            $data = [
                "emp_fname" => strtoupper($request->emp_fname),
                "emp_mname" => strtoupper($request->emp_mid_name),
                "emp_lname" => strtoupper($request->emp_lname),
                "emp_ps_email" => $request->emp_ps_email,

                "emp_ps_phone" => $request->emp_ps_phone,
                "emp_department" => $request->emp_department,
                "emp_designation" => $request->emp_designation,
                "emp_status" => $request->emp_status,

                "emp_payment_type" => $deptnmdhjkb->id,
                "min_work" => $request->min_work,

                "min_rate" => $request->min_rate,
                "start_date" => $st_date,
                "end_date" => $en_date,
                "emp_pr_street_no" => $request->emp_pr_street_no,
                "emp_per_village" => $request->emp_per_village,
                "emp_pr_city" => $request->emp_pr_city,
                "emp_pr_country" => $request->emp_pr_country,
                "emp_pr_pincode" => $request->emp_pr_pincode,
                "emp_pr_state" => $request->emp_pr_state,

                "emp_code" => $request->emp_code,
                "verify_status" => "not approved",

                "emid" => $request->emid,
            ];
            $ckeck_dept = DB::table("employee")
                ->where("emp_code", $request->emp_code)
                ->where("emid", $request->emid)
                ->first();
            if (!empty($ckeck_dept)) {
                Session::flash("message", "Employee  Code  Already Exists.");
                return redirect(
                    "new-employee/" .
                        base64_encode($request->emid) .
                        "/" .
                        base64_encode($request->o_id)
                );
            }
            $ckeck_dept_email = DB::table("employee")
                ->where("emp_ps_email", "=", $request->emp_ps_email)
                ->first();
            if (!empty($ckeck_dept_email)) {
                Session::flash("message", "Email id already exits");
                return redirect(
                    "new-employee/" .
                        base64_encode($request->emid) .
                        "/" .
                        base64_encode($request->o_id)
                );
            }

            $pay = [
                "employee_code" => $request->emp_code,
                "emid" => $request->emid,
                "da" => $request->da,
                "hra" => $request->hra,
                "conven_ta" => $request->conven_ta,
                "perfomance" => $request->perfomance,
                "monthly_al" => $request->monthly_al,

                "pf_al" => $request->pf_al,
                "income_tax" => $request->income_tax,
                "cess" => $request->cess,
                "esi" => $request->esi,
                "professional_tax" => $request->professional_tax,

                "created_at" => date("Y-m-d h:i:s"),
                "updated_at" => date("Y-m-d h:i:s"),
            ];
            DB::table("employee")->insert($data);

            DB::table("employee_pay_structure")->insert($pay);
            $p_dd = mt_rand(1000, 9999);
            $ins_data = [
                "employee_id" => $request->emp_code,
                "name" =>
                    strtoupper($request->emp_fname) .
                    strtoupper($request->emp_mid_name) .
                    strtoupper($request->emp_lname),
                "email" => $request->emp_ps_email,
                "user_type" => "employee",
                "password" => $p_dd,
                "emid" => $request->emid,
            ];

            DB::table("users")->insert($ins_data);

            $ins_data_role = [
                "menu" => "1",
                "module_name" => "1",
                "member_id" => $request->emp_ps_email,
                "rights" => "Add",

                "emid" => $request->emid,
            ];
            DB::table("role_authorization")->insert($ins_data_role);

            $ins_data_role1 = [
                "menu" => "1",
                "module_name" => "1",
                "member_id" => $request->emp_ps_email,
                "rights" => "Edit",

                "emid" => $request->emid,
            ];

            DB::table("role_authorization")->insert($ins_data_role1);

            $data = [
                "firstname" => $request->emp_fname,
                "maname" => $request->emp_mid_name,
                "email" => $request->emp_ps_email,
                "lname" => $request->emp_lname,
                "password" => $p_dd,
            ];
            $toemail = $request->emp_ps_email;
            Mail::send("mail", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, "Workpermitcloud")
                    ->subject("Employee Login  Details");
                $message->from(
                    "noreply@workpermitcloud.co.uk",
                    "Workpermitcloud"
                );
            });

            $Roledataemp = DB::table("registration")

                ->where("reg", "=", $request->emid)
                ->first();

            $data = [
                "emp_code" => $request->emp_code,
                "emp_fname" => $request->emp_fname,
                "emp_mid_name" => $request->emp_mid_name,
                "emp_lname" => $request->emp_lname,
                "emp_ps_email" => $request->emp_ps_email,
                "emp_ps_phone" => $request->emp_ps_phone,
            ];
            $toemail = $Roledataemp->email;
            Mail::send("mailempnew", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, "Workpermitcloud")
                    ->subject("New Employee   Details");
                $message->from(
                    "noreply@workpermitcloud.co.uk",
                    "Workpermitcloud"
                );
            });

            Session::flash(
                "message",
                " Thank you,Employee Details Saved Successfully."
            );
            return redirect("new-employe/thank-you");
        } else {
            Session::flash("message", "Email id already exits.");
            return redirect(
                "new-employee/" .
                    base64_encode($request->emid) .
                    "/" .
                    base64_encode($request->o_id)
            );
        }
    }
    public function thanknewEmployee()
    {
        return view("employee/thank-you");
    }

    public function viewchangecircumstanceseditadd()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["employee_rs"] = DB::table("change_circumstances")
                ->where("emid", "=", $Roledata->reg)
                ->orderBy("id", "ASC")
                ->get();

            return view("employee/change-of-circumstances", $data);
        } else {
            return redirect("/");
        }
    }

    public function viewchangecircumstanceseditnew()
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $data["employee_rs"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->where(function ($query) {
                    $query
                        ->whereNull("employee.emp_status")
                        ->orWhere("employee.emp_status", "!=", "LEFT");
                })
                ->get();

            $data["nation_master"] = DB::table("nationality_master")
                ->where("emid", "=", $Roledata->reg)
                ->get();
            $data["currency_user"] = DB::table("currencies")
                ->orderBy("country", "asc")
                ->get();

            $data["department"] = DB::table("department")
                ->where("emid", "=", $Roledata->reg)
                ->where("department_status", "=", "active")
                ->get();

            return view("employee/edit-circumstances", $data);
        } else {
            return redirect("/");
        }
    }

    public function savechangecircumstanceseditnewsave(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            //dd($request->all());

            //for employee table update
            $dataupdate = [
                "emp_mname" => $request->emp_mname,
                "emp_lname" => $request->emp_lname,
                "emp_department" => $request->department,
                "emp_designation" => $request->emp_designation,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "place_birth" => $request->place_birth,
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

                "dbs_ref_no" => $request->dbs_ref_no,
                "dbs_nation" => $request->dbs_nation,
                "dbs_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_issue_date)
                ),
                "dbs_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_exp_date)
                ),
                "dbs_review_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_review_date)
                ),
                "dbs_cur" => $request->dbs_cur,
                "dbs_remarks" => $request->dbs_remarks,
                "dbs_type" => $request->dbs_type,

                "euss_ref_no" => $request->euss_ref_no,
                "euss_nation" => $request->euss_nation,
                "euss_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_issue_date)
                ),
                "euss_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_exp_date)
                ),
                "euss_review_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_review_date)
                ),
                "euss_cur" => $request->euss_cur,
                "euss_remarks" => $request->euss_remarks,

                "nat_id_no" => $request->nat_id_no,
                "nat_nation" => $request->nat_nation,
                "nat_country_res" => $request->nat_country_res,
                "nat_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_issue_date)
                ),
                "nat_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_exp_date)
                ),
                "nat_review_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_review_date)
                ),
                "nat_cur" => $request->nat_cur,
                "nat_remarks" => $request->nat_remarks,

                "emp_pr_street_no" => $request->emp_pr_street_no,
                "emp_per_village" => $request->emp_per_village,
                "emp_pr_city" => $request->emp_pr_city,
                "emp_pr_country" => $request->emp_pr_country,
                "emp_pr_pincode" => $request->emp_pr_pincode,
                "emp_pr_state" => $request->emp_pr_state,

                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgdoc);
                $pass_docu = $path_doc;
            } else {
                $pass_docu = "";
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgvis);

                $visa_upload_doc = $path_visa_doc;
            } else {
                $visa_upload_doc = "";
            }
            if ($request->has("visaback_doc")) {
                $file_visa_doc = $request->file("visaback_doc");
                $extension_visa_doc = $request->visaback_doc->extension();
                $path_visa_doc = $request->visaback_doc->store(
                    "employee_vis_doc",
                    "public"
                );
                $dataimgvis = [
                    "visaback_doc" => $path_visa_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgvis);

                $visaback_doc = $path_visa_doc;
            } else {
                $visaback_doc = "";
            }
            if ($request->has("dbs_upload_doc")) {
                $file_dbs_doc = $request->file("dbs_upload_doc");
                $extension_dbs_doc = $request->dbs_upload_doc->extension();
                $path_dbs_doc = $request->dbs_upload_doc->store(
                    "emp_dbs",
                    "public"
                );
                $dataimgdbs = [
                    "dbs_upload_doc" => $path_dbs_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgdbs);

                $dbs_upload_doc = $path_dbs_doc;
            } else {
                $dbs_upload_doc = "";
            }

            if ($request->has("euss_upload_doc")) {
                $file_euss_doc = $request->file("euss_upload_doc");
                $extension_euss_doc = $request->euss_upload_doc->extension();
                $path_euss_doc = $request->euss_upload_doc->store(
                    "emp_euss",
                    "public"
                );
                $dataimgeuss = [
                    "euss_upload_doc" => $path_euss_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgeuss);

                $euss_upload_doc = $path_euss_doc;
            } else {
                $euss_upload_doc = "";
            }

            if ($request->has("nat_upload_doc")) {
                $file_nat_doc = $request->file("nat_upload_doc");
                $extension_nat_doc = $request->nat_upload_doc->extension();
                $path_nat_doc = $request->nat_upload_doc->store(
                    "emp_nation",
                    "public"
                );
                $dataimgnat = [
                    "nat_upload_doc" => $path_nat_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgnat);

                $nat_upload_doc = $path_nat_doc;
            } else {
                $nat_upload_doc = "";
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgper);

                $pr_add_proof = $path_peradd;
            } else {
                $pr_add_proof = "";
            }

            DB::table("employee")
                ->where("emp_code", "=", $request->emp_code)
                ->where("emid", "=", $Roledata->reg)
                ->update($dataupdate);

            //for change of circumstance table
            $data = [
                "visa_upload_doc" => $visa_upload_doc,
                "visaback_doc" => $visaback_doc,
                "pass_docu" => $pass_docu,
                "pr_add_proof" => $pr_add_proof,
                "emp_mname" => $request->emp_mname,
                "emp_lname" => $request->emp_lname,

                "emp_department" => $request->department,
                "emp_designation" => $request->emp_designation,

                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "place_birth" => $request->place_birth,
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

                "dbs_ref_no" => $request->dbs_ref_no,
                "dbs_nation" => $request->dbs_nation,
                "dbs_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_issue_date)
                ),
                "dbs_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_exp_date)
                ),
                "dbs_review_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_review_date)
                ),
                "dbs_cur" => $request->dbs_cur,
                "dbs_remarks" => $request->dbs_remarks,
                "dbs_type" => $request->dbs_type,
                "dbs_upload_doc" => $dbs_upload_doc,

                "euss_ref_no" => $request->euss_ref_no,
                "euss_nation" => $request->euss_nation,
                "euss_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_issue_date)
                ),
                "euss_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_exp_date)
                ),
                "euss_review_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_review_date)
                ),
                "euss_cur" => $request->euss_cur,
                "euss_remarks" => $request->euss_remarks,
                "euss_upload_doc" => $euss_upload_doc,

                "nat_id_no" => $request->nat_id_no,
                "nat_nation" => $request->nat_nation,
                "nat_country_res" => $request->nat_country_res,
                "nat_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_issue_date)
                ),
                "nat_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_exp_date)
                ),
                "nat_review_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_review_date)
                ),
                "nat_cur" => $request->nat_cur,
                "nat_remarks" => $request->nat_remarks,
                "nat_upload_doc" => $nat_upload_doc,

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

                "emp_code" => $request->emp_code,
                "emid" => $Roledata->reg,
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
                "previous_emp_name" => $request->previous_emp_name,
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
                                ->where("emid", "=", $Roledata->reg)
                                ->where("id", $value)
                                ->update($dataimgedit);
                        }

                        $dataquli_edit = [
                            "emp_code" => $request->emp_code,
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
                            ->where("emid", "=", $Roledata->reg)
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
                            "emp_code" => $request->emp_code,
                            "doc_name" => $request->doc_name[$i],
                            "emid" => $Roledata->reg,
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

                ->where("emp_code", "=", $request->emp_code)
                ->where("emid", "=", $Roledata->reg)
                ->orderBy("id", "desc")
                ->first();

            $employee_otherd_doc_rs = DB::table("employee_other_doc")

                ->where("emp_code", "=", $request->emp_code)
                ->where("emid", "=", $Roledata->reg)
                ->get();
            if (count($employee_otherd_doc_rs) != 0) {
                foreach ($employee_otherd_doc_rs as $valuother) {
                    $datachangecirdox = [
                        "emp_code" => $request->emp_code,
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
            return redirect("employee/change-of-circumstances-add");
        } else {
            return redirect("/");
        }
    }

    public function reportEmployeesstaff(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $employee_code = $request->employee_code;
            $employee_type = $request->employee_type;

            $data["Roledata"] = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            if ($employee_code != "") {
                $leave_allocation_rs = DB::table("change_circumstances")
                    ->join(
                        "employee",
                        "change_circumstances.emp_code",
                        "=",
                        "employee.emp_code"
                    )
                    ->where(
                        "change_circumstances.emp_code",
                        "=",
                        $employee_code
                    )
                    ->where("change_circumstances.emid", "=", $Roledata->reg)
                    ->where("employee.emp_code", "=", $employee_code)
                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("employee.emp_status", "=", $employee_type)

                    ->select("change_circumstances.*")
                    ->get();
            } else {
                $leave_allocation_rs = DB::table("change_circumstances")

                    ->join(
                        "employee",
                        "change_circumstances.emp_code",
                        "=",
                        "employee.emp_code"
                    )

                    ->where("change_circumstances.emid", "=", $Roledata->reg)
                    ->where("employee.emp_status", "=", $employee_type)

                    ->where("employee.emid", "=", $Roledata->reg)
                    ->select("change_circumstances.*")
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
                "leave_allocation_rs" => $leave_allocation_rs,
                "emid" => $Roledata->reg,
                "employee_type" => $employee_type,
                "employee_code" => $employee_code,
            ];

            $pdf = PDF::loadView("mypdfcircumstances", $datap);
            $pdf->setPaper("A4", "landscape");
            return $pdf->download("circumstancesreport.pdf");
        } else {
            return redirect("/");
        }
    }

    public function reportEmployeesexcelstaff(Request $request)
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
            $employee_type = $request->employee_type;

            if ($employee_code != "") {
                $new_emp = $employee_code;
            } else {
                $new_emp = "all";
            }

            return Excel::download(
                new ExcelFileExportCircumstances(
                    $Roledata->reg,
                    $new_emp,
                    $employee_type
                ),
                "circumstancesreport.xlsx"
            );
        } else {
            return redirect("/");
        }
    }

    public function viewsendcandidatedetailsthirdsend_iddate($send_id, $date)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $pdf = "";
            $fo = "";
            $date = base64_decode($date);
            $job = DB::table("employee")
                ->where("emp_code", "=", base64_decode($send_id))
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $jocirb = DB::table("change_circumstances")
                ->where("emp_code", "=", base64_decode($send_id))
                ->where("emid", "=", $Roledata->reg)
                ->first();

            $data = [
                "com_name" => $Roledata->com_name,
                "Roledata" => $Roledata,
                "job" => $job,
                "circum" => $jocirb,
                "date" => $date,
            ];

            $toemail = $job->emp_ps_email;

            Mail::send("mailcircum", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, "Workpermitcloud")
                    ->subject("Change of Circumstances - Annual Reminder");

                $message->from(
                    "noreply@workpermitcloud.co.uk",
                    "Workpermitcloud"
                );
            });
            $toemail = $Roledata->authemail;
            Mail::send("mailcircum", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, "Workpermitcloud")
                    ->subject(" Change of Circumstances - Annual Reminder");

                $message->from(
                    "noreply@workpermitcloud.co.uk",
                    "Workpermitcloud"
                );
            });

            Session::flash("message", "Annual  Reminder send Successfully.");

            return redirect("employee/change-of-circumstances");
        } else {
            return redirect("/");
        }
    }
    public function viewAddchangeew($comp_id)
    {
        if (!empty(Session::get("emp_email"))) {
            $comp_id = base64_decode($comp_id);

            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();

            //echo $Roledata->reg;

            $data["employee_rs"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->get();
            $data["employee_changers"] = DB::table("change_circumstances")
                ->where("emid", "=", $Roledata->reg)
                ->where("id", "=", $comp_id)
                ->first();

            $data["employee_newrs"] = DB::table("employee")
                ->where("emid", "=", $Roledata->reg)
                ->where("emp_code", "=", $data["employee_changers"]->emp_code)
                ->first();

            $data["nation_master"] = DB::table("nationality_master")
                ->where("emid", "=", $Roledata->reg)
                ->get();
            $data["currency_user"] = DB::table("currencies")
                ->orderBy("country", "asc")
                ->get();

            $data["department"] = DB::table("department")
                ->where("emid", "=", $Roledata->reg)
                ->where("department_status", "=", "active")
                ->get();

            // $emp_department_code = DB::table('department')
            //     ->where('emid', '=', $Roledata->reg)
            //     ->where('department_name', '=', $data['employee_changers']->emp_department)->first();

            $data["designation"] = DB::table("designation")
                ->where("emid", "=", $Roledata->reg)
                //->where('department_code', '=', $emp_department_code->department_code)
                ->where("designation_status", "=", "active")
                ->get();

            //dd($emp_department_code);

            $data["employee_otherd_doc_rs"] = DB::table(
                "circumemployee_other_doc"
            )
                ->where("emid", "=", $Roledata->reg)
                ->where("emp_code", "=", $data["employee_changers"]->emp_code)
                ->get();
            return view("employee/editnew-circumstances", $data);
        } else {
            return redirect("/");
        }
    }

    public function saveAddchangegynew(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")

                ->where("email", "=", $email)
                ->first();
            $dataupdate = [
                "emp_mname" => $request->emp_mname,
                "emp_lname" => $request->emp_lname,
                "emp_department" => $request->department,
                "emp_designation" => $request->emp_designation,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "place_birth" => $request->place_birth,
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

                "dbs_ref_no" => $request->dbs_ref_no,
                "dbs_nation" => $request->dbs_nation,
                "dbs_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_issue_date)
                ),
                "dbs_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_exp_date)
                ),
                "dbs_review_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_review_date)
                ),
                "dbs_cur" => $request->dbs_cur,
                "dbs_remarks" => $request->dbs_remarks,
                "dbs_type" => $request->dbs_type,

                "euss_ref_no" => $request->euss_ref_no,
                "euss_nation" => $request->euss_nation,
                "euss_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_issue_date)
                ),
                "euss_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_exp_date)
                ),
                "euss_review_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_review_date)
                ),
                "euss_cur" => $request->euss_cur,
                "euss_remarks" => $request->euss_remarks,

                "nat_id_no" => $request->nat_id_no,
                "nat_nation" => $request->nat_nation,
                "nat_country_res" => $request->nat_country_res,
                "nat_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_issue_date)
                ),
                "nat_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_exp_date)
                ),
                "nat_review_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_review_date)
                ),
                "nat_cur" => $request->nat_cur,
                "nat_remarks" => $request->nat_remarks,

                "emp_pr_street_no" => $request->emp_pr_street_no,
                "emp_per_village" => $request->emp_per_village,
                "emp_pr_city" => $request->emp_pr_city,
                "emp_pr_country" => $request->emp_pr_country,
                "emp_pr_pincode" => $request->emp_pr_pincode,
                "emp_pr_state" => $request->emp_pr_state,

                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "emp_dob" => date("Y-m-d", strtotime($request->emp_dob)),
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgdoc);
                $pass_docu = $path_doc;
            } else {
                $pass_docu = "";
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgvis);

                $visa_upload_doc = $path_visa_doc;
            } else {
                $visa_upload_doc = "";
            }

            if ($request->has("dbs_upload_doc")) {
                $file_dbs_doc = $request->file("dbs_upload_doc");
                $extension_dbs_doc = $request->dbs_upload_doc->extension();
                $path_dbs_doc = $request->dbs_upload_doc->store(
                    "emp_dbs",
                    "public"
                );
                $dataimgdbs = [
                    "dbs_upload_doc" => $path_dbs_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgdbs);

                $dbs_upload_doc = $path_dbs_doc;
            } else {
                $dbs_upload_doc = "";
            }

            if ($request->has("euss_upload_doc")) {
                $file_euss_doc = $request->file("euss_upload_doc");
                $extension_euss_doc = $request->euss_upload_doc->extension();
                $path_euss_doc = $request->euss_upload_doc->store(
                    "emp_euss",
                    "public"
                );
                $dataimgeuss = [
                    "euss_upload_doc" => $path_euss_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgeuss);

                $euss_upload_doc = $path_euss_doc;
            } else {
                $euss_upload_doc = "";
            }

            if ($request->has("nat_upload_doc")) {
                $file_nat_doc = $request->file("nat_upload_doc");
                $extension_nat_doc = $request->nat_upload_doc->extension();
                $path_nat_doc = $request->nat_upload_doc->store(
                    "emp_nation",
                    "public"
                );
                $dataimgnat = [
                    "nat_upload_doc" => $path_nat_doc,
                ];
                DB::table("employee")
                    ->where("emp_code", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgnat);

                $nat_upload_doc = $path_nat_doc;
            } else {
                $nat_upload_doc = "";
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
                    ->where("emp_code", "=", $request->emp_code)
                    ->where("emid", "=", $Roledata->reg)
                    ->update($dataimgper);

                $pr_add_proof = $path_peradd;
            } else {
                $pr_add_proof = "";
            }

            DB::table("employee")
                ->where("emp_code", "=", $request->emp_code)
                ->where("emid", "=", $Roledata->reg)
                ->update($dataupdate);

            $data = [
                "emp_mname" => $request->emp_mname,
                "emp_lname" => $request->emp_lname,
                "emp_department" => $request->department,
                "emp_designation" => $request->emp_designation,

                "emp_ps_phone" => $request->emp_ps_phone,

                "nationality" => $request->nationality,
                "ni_no" => $request->ni_no,
                "pass_doc_no" => $request->pass_doc_no,
                "pass_nat" => $request->pass_nat,
                "place_birth" => $request->place_birth,
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

                "dbs_ref_no" => $request->dbs_ref_no,
                "dbs_nation" => $request->dbs_nation,
                "dbs_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_issue_date)
                ),
                "dbs_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_exp_date)
                ),
                "dbs_review_date" => date(
                    "Y-m-d",
                    strtotime($request->dbs_review_date)
                ),
                "dbs_cur" => $request->dbs_cur,
                "dbs_remarks" => $request->dbs_remarks,
                "dbs_type" => $request->dbs_type,

                "euss_ref_no" => $request->euss_ref_no,
                "euss_nation" => $request->euss_nation,
                "euss_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_issue_date)
                ),
                "euss_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_exp_date)
                ),
                "euss_review_date" => date(
                    "Y-m-d",
                    strtotime($request->euss_review_date)
                ),
                "euss_cur" => $request->euss_cur,
                "euss_remarks" => $request->euss_remarks,

                "nat_id_no" => $request->nat_id_no,
                "nat_nation" => $request->nat_nation,
                "nat_country_res" => $request->nat_country_res,
                "nat_issue_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_issue_date)
                ),
                "nat_exp_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_exp_date)
                ),
                "nat_review_date" => date(
                    "Y-m-d",
                    strtotime($request->nat_review_date)
                ),
                "nat_cur" => $request->nat_cur,
                "nat_remarks" => $request->nat_remarks,

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

                "emp_code" => $request->emp_code,
                "emid" => $Roledata->reg,
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
                "previous_emp_name" => $request->previous_emp_name,
            ];

            DB::table("change_circumstances")
                ->where("id", "=", $request->newid)
                ->update($data);

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
                DB::table("change_circumstances")
                    ->where("id", "=", $request->newid)
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
                DB::table("change_circumstances")
                    ->where("id", "=", $request->newid)
                    ->update($dataimgdoc);
                $pass_docu = $path_doc;
            } else {
                $pass_docu = "";
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
                DB::table("change_circumstances")
                    ->where("id", "=", $request->newid)
                    ->update($dataimgvis);

                $visa_upload_doc = $path_visa_doc;
            } else {
                $visa_upload_doc = "";
            }

            if ($request->has("dbs_upload_doc")) {
                $file_dbs_doc = $request->file("dbs_upload_doc");
                $extension_dbs_doc = $request->dbs_upload_doc->extension();
                $path_dbs_doc = $request->dbs_upload_doc->store(
                    "emp_dbs",
                    "public"
                );
                $dataimgdbs = [
                    "dbs_upload_doc" => $path_dbs_doc,
                ];

                DB::table("change_circumstances")
                    ->where("id", "=", $request->newid)
                    ->update($dataimgdbs);

                $dbs_upload_doc = $path_dbs_doc;
            } else {
                $dbs_upload_doc = "";
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
                DB::table("change_circumstances")
                    ->where("id", "=", $request->newid)
                    ->update($dataimgper);

                $pr_add_proof = $path_peradd;
            } else {
                $pr_add_proof = "";
            }

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
                                ->where("emid", "=", $Roledata->reg)
                                ->where("id", $value)
                                ->update($dataimgedit);
                        }

                        $dataquli_edit = [
                            "emp_code" => $request->emp_code,
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
                            ->where("emid", "=", $Roledata->reg)
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
                            "emp_code" => $request->emp_code,
                            "doc_name" => $request->doc_name[$i],
                            "emid" => $Roledata->reg,
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

            DB::table("circumemployee_other_doc")
                ->where("cir_id", "=", $request->newid)
                ->where("emid", "=", $Roledata->reg)
                ->delete();

            $employee_otherd_doc_rs = DB::table("employee_other_doc")

                ->where("emp_code", "=", $request->emp_code)
                ->where("emid", "=", $Roledata->reg)
                ->get();
            if (count($employee_otherd_doc_rs) != 0) {
                foreach ($employee_otherd_doc_rs as $valuother) {
                    $datachangecirdox = [
                        "emp_code" => $request->emp_code,
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
                        "cir_id" => $request->newid,
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
            return redirect("employee/change-of-circumstances-add");
        } else {
            return redirect("/");
        }
    }
    public function ajaxAddvalue($headname, $val, $emp_basic_pay)
    {
        if ($headname == "da") {
            $id = "1";
        } elseif ($headname == "vda") {
            $id = "2";
        } elseif ($headname == "hra") {
            $id = "3";
        } elseif ($headname == "prof_tax") {
            $id = "4";
        } elseif ($headname == "others_alw") {
            $id = "5";
        } elseif ($headname == "tiff_alw") {
            $id = "6";
        } elseif ($headname == "conv") {
            $id = "7";
        } elseif ($headname == "medical") {
            $id = "8";
        } elseif ($headname == "misc_alw") {
            $id = "9";
        } elseif ($headname == "over_time") {
            $id = "10";
        } elseif ($headname == "bouns") {
            $id = "11";
        } elseif ($headname == "leave_inc") {
            $id = "12";
        } elseif ($headname == "hta") {
            $id = "13";
        } elseif ($headname == "tot_inc") {
            $id = "14";
        } elseif ($headname == "pf") {
            $id = "15";
        } elseif ($headname == "pf_int") {
            $id = "16";
        } elseif ($headname == "apf") {
            $id = "17";
        } elseif ($headname == "i_tax") {
            $id = "18";
        } elseif ($headname == "insu_prem") {
            $id = "19";
        } elseif ($headname == "pf_loan") {
            $id = "20";
        } elseif ($headname == "esi") {
            $id = "21";
        } elseif ($headname == "adv") {
            $id = "22";
        } elseif ($headname == "hrd") {
            $id = "23";
        } elseif ($headname == "co_op") {
            $id = "24";
        } elseif ($headname == "furniture") {
            $id = "25";
        } elseif ($headname == "misc_ded") {
            $id = "26";
        } elseif ($headname == "tot_ded") {
            $id = "27";
        }

        if ($id == "4") {
            // use App\Models\RateDetail;
            // use App\Models\Rate_master;

            // $rate_details=DB::table('rate_details')
            // ->join('rate-master', 'rate-master.id', '=', 'rate_details.rate_id')
            // ->select('rate_details.*', 'rate-master.headname', 'rate-master.headtype')
            // ->where('rate_details.rate_id', '=', $id)
            //     ->orderBy('rate_details.id', 'desc')
            //     ->get();

            $rate_details = RateDetail::join(
                "rate_masters",
                "rate_details.rate_id",
                "=",
                "rate_masters.id"
            )
                ->where("rate_details.rate_id", "=", $id)
                ->select(
                    "rate_details.*",
                    "rate_masters.head_name",
                    "rate_masters.head_type"
                )
                ->get();

            $result = "0";

            foreach ($rate_details as $val) {
                if ($val->inpercentage != "0") {
                    $result = ($emp_basic_pay * $val->inpercentage) / 100;
                } else {
                    if (
                        $emp_basic_pay <= $val->max_basic &&
                        $emp_basic_pay >= $val->min_basic
                    ) {
                        $result = $val->inrupees;
                    }
                    if (
                        $emp_basic_pay >= $val->max_basic &&
                        $emp_basic_pay <= $val->min_basic
                    ) {
                        $result = $val->inrupees;
                    }
                }
            }
        } else {
            // $rate_details = RateDetail::leftJoin('rate-master', 'rate-master.id', '=', 'RateDetail.rate_id')
            //     ->select('RateDetail.*', 'rate-master.headname', 'rate-master.headtype')
            // ->where('rate_details.from_date', '>=', date('Y-01-01'))
            // ->where('rate_details.to_date', '<=', date('Y-12-31'))
            // ->where('RateDetail.rate_id', '=', $id)

            // ->first();

            // $rate_details=DB::table('rate_details')
            // ->join('rate-master', 'rate-master.id', '=', 'rate_details.rate_id')
            // ->select('rate_details.*', 'rate-master.headname', 'rate-master.headtype')
            // ->where('rate_details.rate_id', '=', $id)
            // ->first();
            //  dd('blll',$rate_details);

            $rate_details = RateDetail::join(
                "rate_masters",
                "rate_details.rate_id",
                "=",
                "rate_masters.id"
            )
                ->where("rate_details.rate_id", "=", $id)
                ->select(
                    "rate_details.*",
                    "rate_masters.head_name",
                    "rate_masters.head_type"
                )
                ->first();
            if ($id == "15") {
                if ($emp_basic_pay > 15000) {
                    $result = 1800;
                } else {
                    $result =
                        ($emp_basic_pay * $rate_details->inpercentage) / 100;
                }
            } else {
                $result = ($emp_basic_pay * $rate_details->inpercentage) / 100;
            }
        }
        echo $result;
    }

    public function viewAddEmployeereportnewexcel($comp_id, $emp_id)
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
            $employeedata = DB::table("employee")

                ->where("emid", "=", base64_decode($comp_id))
                ->where("emp_code", "=", base64_decode($emp_id))
                ->first();

            return Excel::download(
                new ExcelFileExportemployeeInformation(
                    $Roledata->reg,
                    base64_decode($emp_id)
                ),
                "employeereportexcel.xlsx"
            );
        } else {
            return redirect("/");
        }
    }
}
