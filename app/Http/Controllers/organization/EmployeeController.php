<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Validator;
use view;
use Exception;

class EmployeeController extends Controller
{
    //
    protected $_routePrefix;
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.employee';
        //$this->_model       = new CompanyJobs();
    }

    public function viewAddEmployee(Request $request)
    {
         
         //dd('okk');
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
                //dd($Roledata->reg);
                //$data['employee_type'] = DB::table('employ_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['employee_type'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->get();

                //dd($data['employee_type']);
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
                // return view('employee/edit-employee', $data);
                return view($this->_routePrefix . '.edit-employee',$data);

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
                //return view('employee/add-employee', $data);
                return view($this->_routePrefix . '.add-employee',$data);
            }

        } else {
            return redirect('/');
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function saveEmployee(Request $request)
    {
        //dd($request->all());
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


                    // new code for change of circumtances 
                    $existingData = DB::table('change_circumstances_history')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', $Roledata->reg)
                    ->latest('date_change')  // Get the latest record if there are multiple
                    ->first();

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
                        'date_change' => date('Y-m-d', strtotime($request->emp_doj)),
                    );

                    if ($existingData) {
                        $existingDataArray = (array)$existingData;
                        unset($existingDataArray['id'], $existingDataArray['date_change'], $existingDataArray['created_at'], $existingDataArray['updated_at']);
                        $changes = array_diff_assoc($datachangecir, $existingDataArray);
                    } else {
                        $changes = $datachangecir;
                    }

                    if (!empty($changes)) {
                        DB::table('change_circumstances_history')->insert($datachangecir);
                    }
                    DB::table('circumemployee_other_doc_history')
                        ->where('emp_code', '=', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->delete();

                // old code by ranjan 
                // $datachangecir = array(

                //     'emp_fname' => strtoupper($request->emp_fname),
                //     'emp_mname' => strtoupper($request->emp_mid_name),
                //     'emp_lname' => strtoupper($request->emp_lname),

                //     'visa_upload_doc' => $sm_cch_visa_upload_doc,
                //     'visaback_doc' => $sm_cch_visaback_doc,

                //     'pass_docu' => $sm_cch_pass_docu,
                //     'pr_add_proof' => $sm_cch_pr_add_proof,

                //     'emp_designation' => $request->emp_designation,

                //     'emp_ps_phone' => $request->emp_ps_phone,

                //     'nationality' => $request->nationality,
                //     'ni_no' => $request->ni_no,
                //     'pass_doc_no' => $request->pass_doc_no,
                //     'pass_nat' => $request->pass_nat,
                //     'place_birth' => $request->place_birth,
                //     'issue_by' => $request->issue_by,
                //     'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
                //     'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
                //     'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),

                //     'remarks' => $request->remarks,
                //     'cur_pass' => $request->cur_pass,

                //     'visa_doc_no' => $request->visa_doc_no,
                //     'visa_nat' => $request->visa_nat,
                //     'visa_issue' => $request->visa_issue,
                //     'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
                //     'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
                //     'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),
                //     'country_residence' => $request->country_residence,
                //     'visa_remarks' => $request->visa_remarks,
                //     'visa_cur' => $request->visa_cur,

                //     'dbs_ref_no' => $request->dbs_ref_no,
                //     'dbs_nation' => $request->dbs_nation,
                //     'dbs_issue_date' => date('Y-m-d', strtotime($request->dbs_issue_date)),
                //     'dbs_exp_date' => date('Y-m-d', strtotime($request->dbs_exp_date)),
                //     'dbs_review_date' => date('Y-m-d', strtotime($request->dbs_review_date)),
                //     'dbs_cur' => $request->dbs_cur,
                //     'dbs_remarks' => $request->dbs_remarks,
                //     'dbs_type' => $request->dbs_type,

                //     'euss_ref_no' => $request->euss_ref_no,
                //     'euss_nation' => $request->euss_nation,
                //     'euss_issue_date' => date('Y-m-d', strtotime($request->euss_issue_date)),
                //     'euss_exp_date' => date('Y-m-d', strtotime($request->euss_exp_date)),
                //     'euss_review_date' => date('Y-m-d', strtotime($request->euss_review_date)),
                //     'euss_cur' => $request->euss_cur,
                //     'euss_remarks' => $request->euss_remarks,

                //     'nat_id_no' => $request->nat_id_no,
                //     'nat_nation' => $request->nat_nation,
                //     'nat_country_res' => $request->nat_country_res,
                //     'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                //     'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                //     'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                //     'nat_cur' => $request->nat_cur,

                //     'nat_remarks' => $request->nat_remarks,



                //     'emp_dob' => date('Y-m-d', strtotime($request->emp_dob)),
                //     'emp_pr_street_no' => $request->emp_pr_street_no,
                //     'emp_per_village' => $request->emp_per_village,
                //     'emp_pr_city' => $request->emp_pr_city,
                //     'emp_pr_country' => $request->emp_pr_country,
                //     'emp_pr_pincode' => $request->emp_pr_pincode,
                //     'emp_pr_state' => $request->emp_pr_state,

                //     'emp_ps_street_no' => $request->emp_ps_street_no,
                //     'emp_ps_village' => $request->emp_ps_village,
                //     'emp_ps_city' => $request->emp_ps_city,
                //     'emp_ps_country' => $request->emp_ps_country,
                //     'emp_ps_pincode' => $request->emp_ps_pincode,
                //     'emp_ps_state' => $request->emp_ps_state,

                //     'emp_code' => $decrypted_id,
                //     'emid' => $Roledata->reg,
                //     'hr' => '',
                //     'home' => '',
                //     'res_remark' => '',

                //     'date_change' => date('Y-m-d', strtotime($request->emp_doj)),
                //     'change_last' => '',
                //     'stat_chage' => '',

                //     'unique_law' => '',
                //     'repo_ab' => '',
                //     'laeve_date' => '',

                // );
                // DB::table('change_circumstances_history')->insert($datachangecir);
                // DB::table('circumemployee_other_doc_history')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->delete();

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
                return redirect('organization/emplist');

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
                return redirect('organization/emplist');
                // return redirect('pis/employee');
            }

        } else {
            return redirect('/');
        }
    }

    public function example(Request $request){
        return view($this->_routePrefix . '.empty');
    }


}
