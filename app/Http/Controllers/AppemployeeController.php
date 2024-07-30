<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportCircumstances;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PDF;
use Session;
use Validator;
use view;

class AppemployeeController extends Controller
{
    public function getamployeedas()
    {try {

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $data['employee_active'] = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

            ->where('employee.emid', '=', $Roledata->reg)
            ->where('users.emid', '=', $Roledata->reg)
            ->where('users.status', '=', 'active')
            ->where('users.user_type', '=', 'employee')
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->select('users.*')->get();
        $data['employee_inactive'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

        $data['employee_suspened'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'SUSPEND')
            ->get();
        $data['employee_complete'] = DB::table('employee')
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->get();
        $data['employee_incomplete'] = DB::table('employee')
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'not approved')
            ->get();

        $data['employee_constuct'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'CONTRACTUAL')
            ->get();
        $data['employee_fulltime'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'FULL TIME')
            ->get();
        $data['employee_regular'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'REGULAR')
            ->get();
        $data['employee_parttime'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'PART TIME')
            ->get();
        $data['employee_ex_empoyee'] = DB::table('employee')

            ->where('emid', '=', $Roledata->reg)
            ->where('verify_status', '=', 'approved')
            ->where('emp_status', '=', 'LEFT')
            ->get();
        return view('employee/dashboard', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }
    }

    public function getEmployees($emp_id)
    {

        try {

            $data['employee_rs'] = DB::table('employee')
                ->where('emid', '=', base64_decode($emp_id))
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            $data['emid'] = base64_decode($emp_id);

            return view('appemployee/employee', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }
    public function getallEmployees($emp_id, $all)
    {

        try {

            if ($all == 'all') {
                $data['employee_rs'] = DB::table('employee')
                    ->where('emid', '=', base64_decode($emp_id))
                    ->where(function ($query) {
                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })
                    ->get();
            } else if ($all == 'migrant') {
                $data['employee_rs'] = DB::table('employee')->where('emid', '=', base64_decode($emp_id))
                    ->where(function ($query) {
                        $query->whereNotNull('employee.visa_doc_no')
                            //->orWhereNotNull('employee.visa_exp_date')
                            //->orWhereNotNull('employee.euss_exp_date')
                            ->orWhereNotNull('employee.euss_ref_no')
                            ;
                    })
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })

                    ->get();
            }

            $data['all'] = $all;

            $data['emid'] = base64_decode($emp_id);

            return view('appemployee/employee-all', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }
    public function getmigrantEmployees($emp_id)
    {
        try {

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', base64_decode($emp_id))
                ->where(function ($query) {
                    $query->whereNotNull('employee.visa_doc_no')
                        //->orWhereNotNull('employee.visa_exp_date')
                        //->orWhereNotNull('employee.euss_exp_date')
                        ->orWhereNotNull('employee.euss_ref_no')
                        ;
                })
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            $data['emid'] = base64_decode($emp_id);

            return view('appemployee/employee-migrant', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }

    public function viewAddEmployeereportnew($comp_id, $emp_id)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($comp_id))
                ->first();
            $employeedata = DB::table('employee')

                ->where('emid', '=', base64_decode($comp_id))
                ->where('emp_code', '=', base64_decode($emp_id))
                ->first();

            $datap = ['Roledata' => $Roledata, 'employeedata' => $employeedata];

            $pdf = PDF::loadView('mypdfemployee', $datap);
            return $pdf->download('employeereport.pdf');
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function viewAddEmployee($emp_id)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $data['emid'] = base64_decode($emp_id);
            $id = Input::get('q');
            if ($id) {

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

                $empdepartmen = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_name', '=', $data['employee_rs'][0]->emp_department)->where('department_status', '=', 'active')->first();
                $data['department'] = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_status', '=', 'active')->get();
                if (!empty($empdepartmen)) {
                    $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('department_code', '=', $empdepartmen->id)->where('designation_status', '=', 'active')->get();
                } else {
                    $data['designation'] = '';
                }
                $data['payment_wedes_rs'] = DB::table('payment_type_wedes')->where('emid', '=', $Roledata->reg)->get();

                $data['employee_type'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'active')->get();
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
                $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->get();
                $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['currency_master'] = DB::table('currency_code')->get();
                $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

                $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '!=', $decrypted_id)->get();

                return view('appemployee/edit-employee', $data);

            } else {
                $data['payment_wedes_rs'] = DB::table('payment_type_wedes')->where('emid', '=', $Roledata->reg)->get();
                $emp_cof = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $data['Roledata']->email)
                    ->first();

                $emp_totcof = DB::table('employee')

                    ->where('emid', '=', $emp_cof->reg)

                    ->orderBy('id', 'desc')
                    ->get();
                $result = explode(" ", trim($emp_cof->com_name));

                $rsnew = strtoupper(substr($result['0'], 0, 3));

                $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('email', '=', $data['Roledata']->email)
                    ->where('licence', '=', 'yes')
                    ->get();
                if (count($emp_totcof) != 0) {
                    if (count($countslug) != 0) {
                        if (date('Y-m-d', strtotime($emp_cof->updated_at)) >= '2021-10-18') {
                            $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 4)) . (count($emp_totcof) + 1);
                        } else {
                            $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) . (count($emp_totcof) + 1);
                        }
                    } else {
                        $emp_code = strtoupper(substr($emp_totcof[0]->emp_code, 0, 3)) . (count($emp_totcof) + 1);
                    }
                } else {
                    $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('email', '!=', $data['Roledata']->email)
                        ->where('licence', '=', 'yes')
                        ->get();

                    if (count($countslug) != 0) {
                        $countslug = DB::table('registration')->where('com_name', 'like', $rsnew . '%')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')

                            ->where('licence', '=', 'yes')
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
                $data['employee_code'] = $emp_code;
                $data['currency_user'] = DB::table('currencies')->orderBy('country', 'asc')->get();
                $data['department'] = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_status', '=', 'active')->get();
                $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('designation_status', '=', 'active')->get();

                $data['employee_type'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'active')->get();
                $data['grade'] = DB::table('grade')->where('emid', '=', $Roledata->reg)->where('grade_status', '=', 'active')->get();
                $data['bank'] = DB::table('bank_masters')->get();
                $data['payscale_master'] = DB::table('pay_scale_master')->where('emid', '=', $Roledata->reg)->get();
                $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->get();
                $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['currency_master'] = DB::table('currency_code')->get();
                $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

                $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })->get();
                //echo "<pre>";print_r($data['states']);exit;
                return view('appemployee/add-employee', $data);

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function viewAddEmployeenew($emp_id, $eploye_id)
    {try {

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $data['emid'] = base64_decode($emp_id);

        $decrypted_id = base64_decode($eploye_id);

        $data['employee_rs'] = DB::table('employee')
            ->join('employee_pay_structure', 'employee.emp_code', '=', 'employee_pay_structure.employee_code')
            ->where('employee.emp_code', '=', $decrypted_id)
            ->where('employee.emid', '=', $Roledata->reg)
            ->where('employee_pay_structure.emid', '=', $Roledata->reg)
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
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

        $data['payment_wedes_rs'] = DB::table('payment_type_wedes')->where('emid', '=', $Roledata->reg)->get();
        $empdepartmen = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_name', '=', $data['employee_rs'][0]->emp_department)->where('department_status', '=', 'active')->first();
        $data['department'] = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_status', '=', 'active')->get();
        if (!empty($empdepartmen)) {
            $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('department_code', '=', $empdepartmen->id)->where('designation_status', '=', 'active')->get();
        } else {
            $data['designation'] = '';
        }

        $data['employee_type'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'active')->get();
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
        $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->get();
        $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
        $data['currency_master'] = DB::table('currency_code')->get();
        $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

        $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '!=', $decrypted_id)->get();

        return view('appemployee/edit-employee-new', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function saveEmployeenew(Request $request)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $decrypted_id = $request->emp_code;

            $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emp_code', '!=', $decrypted_id)->where('emid', $Roledata->reg)->first();
            if (!empty($ckeck_dept)) {
                Session::flash('message', 'Employee Code Code  Already Exists.');
                return redirect('appaddemployee-new/' . base64_encode($request->reg) . '/' . base64_encode($request->emp_code));
            }

            $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->where('employee_id', '!=', $decrypted_id)->where('status', '=', 'active')->where('emid', $Roledata->reg)->first();
            if (!empty($ckeck_email)) {
                Session::flash('message', 'E-mail id  Already Exists.');
                return redirect('appaddemployee-new/' . base64_encode($request->reg) . '/' . base64_encode($request->emp_code));
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
            if (!empty($request->imagedatapass)) {
                $image = $request->imagedatapass;
                $folderPath1 = "employee_doc/";
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $image_name = 'passport_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                $image_base64_1 = base64_decode($request->imagedatapass);
                $file1 = $folderPath1 . $image_name;

                Storage::disk('public')->put($file1, $image);

                $path_doc = $file1;
                $dataimgdoc = array(
                    'pass_docu' => $path_doc,
                );
                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataimgdoc);

            }

            if (!empty($request->imagedatavisa)) {
                $image = $request->imagedatavisa;
                $folderPath1 = "employee_vis_doc/";
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                $image_base64_1 = base64_decode($request->imagedatavisa);
                $file1 = $folderPath1 . $image_name;

                Storage::disk('public')->put($file1, $image);

                $path_visa_doc = $file1;
                $dataimgvis = array(
                    'visa_upload_doc' => $path_visa_doc,
                );
                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataimgvis);

            }

            if (!empty($request->imagedatavisaback)) {
                $image = $request->imagedatavisaback;
                $folderPath1 = "employee_vis_doc/";
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                $image_base64_1 = base64_decode($request->imagedatavisaback);
                $file1 = $folderPath1 . $image_name;

                Storage::disk('public')->put($file1, $image);

                $path_visa_doc = $file1;
                $dataimgvis = array(
                    'visaback_doc' => $path_visa_doc,
                );
                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataimgvis);

            }

            if (!empty($request->imagedataproof)) {
                $image = $request->imagedataproof;
                $folderPath1 = "employee_per_add/";
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $image_name = 'address_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                $image_base64_1 = base64_decode($request->imagedataproof);
                $file1 = $folderPath1 . $image_name;

                Storage::disk('public')->put($file1, $image);

                $path_per_doc = $file1;
                $dataimgper = array(
                    'pr_add_proof' => $path_per_doc,
                );
                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataimgper);

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

                'emp_department' => $request->emp_department,
                'emp_designation' => $request->emp_designation,
                'emp_doj' => date('Y-m-d', strtotime($request->emp_doj)),
                'emp_status' => $request->emp_status,
                'date_confirm' => date('Y-m-d', strtotime($request->date_confirm)),
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
                'fte' => $request->fte,
                'job_loc' => $request->job_loc,

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

                'nat_id_no' => $request->nat_id_no,
                'nat_nation' => $request->nat_nation,
                'nat_country_res' => $request->nat_country_res,
                'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                'nat_cur' => $request->nat_cur,

                'nat_remarks' => $request->nat_remarks,

            );

            DB::table('employee')
                ->where('emp_code', $decrypted_id)
                ->where('emid', '=', $Roledata->reg)
                ->update($dataupdate);

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

            return response()->json(['msg' => 'Employee Information Successfully saved.', 'status' => 'true']);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function saveEmployee(Request $request)
    {

        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
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

            $id = Input::get('q');
            if ($id) {
                $decrypted_id = my_simple_crypt($id, 'decrypt');

                $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emp_code', '!=', $decrypted_id)->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Employee Code Code  Already Exists.');
                    return redirect('appemployees/' . base64_encode($request->reg));
                }

                $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->where('employee_id', '!=', $decrypted_id)->where('status', '=', 'active')->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('appemployees/' . base64_encode($request->reg));
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

                if (!empty($request->imagedatapass)) {

                    $image = $request->imagedatapass;
                    $folderPath1 = "employee_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'passport_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatapass);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_doc = $file1;
                    $dataimgdoc = array(
                        'pass_docu' => $path_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgdoc);

                }

                if (!empty($request->imagedatavisa)) {
                    $image = $request->imagedatavisa;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisa);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visa_doc = $file1;
                    $dataimgvis = array(
                        'visa_upload_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                }

                if (!empty($request->imagedatavisaback)) {
                    $image = $request->imagedatavisaback;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisaback);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visa_doc = $file1;
                    $dataimgvis = array(
                        'visaback_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                }

                if (!empty($request->imagedataproof)) {
                    $image = $request->imagedataproof;
                    $folderPath1 = "employee_per_add/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'address_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedataproof);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_per_doc = $file1;
                    $dataimgper = array(
                        'pr_add_proof' => $path_per_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgper);

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

                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,

                    'nat_remarks' => $request->nat_remarks,

                );

                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataupdate);

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
                return redirect('appemployees/' . base64_encode($request->reg));
            } else {

                $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Employee Code Code  Already Exists.');
                    return redirect('appemployees/' . base64_encode($request->reg));
                }
                $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('appemployees/' . base64_encode($request->reg));
                }
                $ckeck_email_em = DB::table('employee')->where('emp_ps_email', '=', $request->emp_ps_email)->first();
                if (!empty($ckeck_email_em)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    return redirect('appemployees/' . base64_encode($request->reg));
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
                if ($request->has('emp_image')) {

                    $file = $request->file('emp_image');
                    $extension = $request->emp_image->extension();
                    $path = $request->emp_image->store('employee_logo', 'public');

                } else {

                    $path = '';

                }

                if (!empty($request->imagedatapass)) {
                    $image = $request->imagedatapass;
                    $folderPath1 = "employee_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'passport_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatapass);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_doc = $file1;

                } else {

                    $path_doc = '';

                }

                if (!empty($request->imagedatavisa)) {
                    $image = $request->imagedatavisa;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisa);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visa_doc = $file1;

                } else {

                    $path_visa_doc = '';

                }

                if (!empty($request->imagedatavisaback)) {
                    $image = $request->imagedatavisaback;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisaback);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visaback_doc = $file1;

                } else {

                    $path_visaback_doc = '';

                }

                if (!empty($request->imagedataproof)) {
                    $image = $request->imagedataproof;
                    $folderPath1 = "employee_per_add/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'address_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedataproof);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_per_doc = $file1;

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
                    'euss_upload_doc' => $path_euss_doc,

                    'euss_remarks' => $request->euss_remarks,

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

                DB::table('employee_pay_structure')->insert($pay);
                DB::table('employee')->insert($data);

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
                Mail::send('mail', $data, function ($message) use ($toemail) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ('Employee Login  Details');
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });

                Session::flash('message', 'Please assign the role.');
                return redirect('appemployees/' . base64_encode($request->reg));
                // return redirect('pis/employee');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function saveemployeeagreement(Request $request)
    {try {
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $employee_code = $request->employee_code;
        $employee_type = $request->employee_type;

        $data['result'] = '';if ($employee_code != '') {

            $leave_allocation_rs = DB::table('employee')

                ->where('emp_code', '=', $employee_code)
                ->where('emid', '=', $Roledata->reg)
                ->where('emp_status', '=', $employee_type)

                ->select('employee.*')
                ->get();
        } else {
            $leave_allocation_rs = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('emp_status', '=', $employee_type)

                ->select('employee.*')
                ->get();
        }

        //dd($leave_allocation_rs);
        if ($leave_allocation_rs) {$f = 1;

            foreach ($leave_allocation_rs as $leave_allocation) {

                $peradd = '';
                $peradd = $leave_allocation->emp_pr_street_no;
                if ($leave_allocation->emp_per_village) {$peradd .= ',' . $leave_allocation->emp_per_village;}
                if ($leave_allocation->emp_pr_state) {$peradd .= ',' . $leave_allocation->emp_pr_state
                    ;}if ($leave_allocation->emp_pr_city) {$peradd .= ',' . $leave_allocation->emp_pr_city;}
                if ($leave_allocation->emp_pr_pincode) {$peradd .= ',' . $leave_allocation->emp_pr_pincode;}
                if ($leave_allocation->emp_pr_country) {$peradd .= ',' . $leave_allocation->emp_pr_country;};

                $preadd = '';
                $preadd = $leave_allocation->emp_ps_street_no;
                if ($leave_allocation->emp_ps_village) {$preadd .= ',' . $leave_allocation->emp_ps_village;}
                if ($leave_allocation->emp_ps_state) {$preadd .= ',' . $leave_allocation->emp_ps_state
                    ;}if ($leave_allocation->emp_ps_city) {$preadd .= ',' . $leave_allocation->emp_ps_city;}
                if ($leave_allocation->emp_ps_pincode) {$preadd .= ',' . $leave_allocation->emp_ps_pincode;}
                if ($leave_allocation->emp_ps_country) {$preadd .= ',' . $leave_allocation->emp_ps_country;};

                $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)->first();

                $dteemployeet = '';
                if ($employeet->visa_exp_date != '1970-01-01') {$dteemployeet = date('d/m/Y', strtotime($employeet->visa_exp_date));}
                $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $leave_allocation->emp_code . '</td>
													<td>' . $employeet->emp_fname . '  ' . $employeet->emp_mname . ' ' . $employeet->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->emp_dob)) . '</td>
													<td>' . $leave_allocation->emp_ps_phone . '</td>
														<td>' . $leave_allocation->nationality . '</td>
														<td>' . $leave_allocation->ni_no . '</td>
															<td>' . $dteemployeet . '</td>
															<td>' . $leave_allocation->pass_doc_no . '</td>
															<td>' . $peradd . '</td>


													<td><a href="contract-agreement-edit/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-pdf"></i></a>
													<a href="contract-word/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-word"></i></a></td>


						</tr>';
                $f++;}
        }
        $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

        return view('employee/contract-list', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function viewemployeeagreementdit($emp_id)
    {try {

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $first_day_this_year = date('Y-01-01');
        $last_day_this_year = date('Y-12-31');
        $offarr = 0;
        $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

        $currency_auth = DB::table('currencies')

            ->where('code', '=', $emjob->currency)
            ->orderBy('id', 'DESC')
            ->first();
        $pay_type_auth = DB::table('payment_type_master')

            ->where('id', '=', $emjob->emp_payment_type)
            ->orderBy('id', 'DESC')
            ->first();

        if (!empty($emjob->emp_department)) {

            $employee_depers = DB::table('department')
                ->where('department_name', '=', $emjob->emp_department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            $employee_desigrs = DB::table('designation')
                ->where('designation_name', '=', $emjob->emp_designation)
                ->where('department_code', '=', $employee_depers->id)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            $duty_auth = DB::table('duty_roster')
                ->where('department', '=', $employee_depers->id)
                ->where('designation', '=', $employee_desigrs->id)
                ->where('employee_id', '=', base64_decode($emp_id))
                ->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($duty_auth)) {
                $shift_auth = DB::table('shift_management')
                    ->where('department', '=', $employee_depers->id)
                    ->where('id', '=', $duty_auth->shift_code)
                    ->where('designation', '=', $employee_desigrs->id)

                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                $off_auth = DB::table('offday')
                    ->where('department', '=', $employee_depers->id)
                    ->where('shift_code', '=', $duty_auth->shift_code)
                    ->where('designation', '=', $employee_desigrs->id)

                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                $difference = abs($dateout - $datein) / 60;
                $hours = floor($difference / 60);
                $minutes = ($difference % 60);
                $duty_hours = $hours;
                $offarr = 0;
                if (!empty($off_auth)) {
                    if ($off_auth->sun == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;

                    }

                    if ($off_auth->mon == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->tue == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->wed == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->thu == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->fri == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }
                    if ($off_auth->sat == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }
                }

            }

        } else {
            $offarr = 0;
        }

        $data['LeaveAllocation'] = DB::table('leave_allocation')
            ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
            ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
            ->where('leave_allocation.emid', '=', $Roledata->reg)
            ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

            ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
            ->get();
        $sdate = $emjob->start_date;
        $edate = $emjob->end_date;

        $date_diff = abs(strtotime($edate) - strtotime($sdate));

        $years = floor($date_diff / (365 * 60 * 60 * 24));
        if (!empty($currency_auth)) {
            $symbol = $currency_auth->symbol;
        } else {
            $symbol = '';
        }
        if (!empty($pay_type_auth)) {
            $pay_ty = $pay_type_auth->pay_type;
        } else {
            $pay_ty = '';
        }
        $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'date' => $emjob->emp_doj, 'date_con' => $emjob->start_date, 'date_end' => $emjob->end_date, 'job_loc' => $emjob->job_loc, 'emid' => $emjob->emid, 'emp_code' => $emjob->emp_code, 'emp_pay_scale' => $emjob->emp_pay_scale, 'em_name' => $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname, 'em_pos' => $emjob->emp_designation, 'em_depart' => $emjob->emp_department, 'address_emp' => $emjob->emp_pr_street_no . ',' . $emjob->emp_per_village . ',' . $emjob->emp_pr_state . ',' . $emjob->emp_pr_city . ',' . $emjob->emp_pr_pincode . ',' . $emjob->emp_pr_country, 'em_co' => $Roledata->country, 'currency' => $emjob->currency, 'symbol' => $symbol, 'week_time' => $offarr, 'year_time' => $years, 'pay_type' => $pay_ty, 'LeaveAllocation' => $data['LeaveAllocation'], 'birth' => $emjob->country_birth];

        $pdf = PDF::loadView('mypdfagree', $datap);
        return $pdf->download('contract.pdf');
        Session::flash('message', 'Contract Agreement Create Successfully.');
        return redirect('employee/contract-agreement');
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }
    }

    public function msword($emp_id)
    {try {
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $first_day_this_year = date('Y-01-01');
        $last_day_this_year = date('Y-12-31');
        $offarr = 0;
        $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

        $currency_auth = DB::table('currencies')

            ->where('code', '=', $emjob->currency)
            ->orderBy('id', 'DESC')
            ->first();
        $pay_type_auth = DB::table('payment_type_master')

            ->where('id', '=', $emjob->emp_payment_type)
            ->orderBy('id', 'DESC')
            ->first();

        if (!empty($emjob->emp_department)) {

            $employee_depers = DB::table('department')
                ->where('department_name', '=', $emjob->emp_department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            $employee_desigrs = DB::table('designation')
                ->where('designation_name', '=', $emjob->emp_designation)
                ->where('department_code', '=', $employee_depers->id)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            $duty_auth = DB::table('duty_roster')
                ->where('department', '=', $employee_depers->id)
                ->where('designation', '=', $employee_desigrs->id)
                ->where('employee_id', '=', base64_decode($emp_id))
                ->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($duty_auth)) {
                $shift_auth = DB::table('shift_management')
                    ->where('department', '=', $employee_depers->id)
                    ->where('id', '=', $duty_auth->shift_code)
                    ->where('designation', '=', $employee_desigrs->id)

                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                $off_auth = DB::table('offday')
                    ->where('department', '=', $employee_depers->id)
                    ->where('shift_code', '=', $duty_auth->shift_code)
                    ->where('designation', '=', $employee_desigrs->id)

                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                $difference = abs($dateout - $datein) / 60;
                $hours = floor($difference / 60);
                $minutes = ($difference % 60);
                $duty_hours = $hours;
                $offarr = 0;
                if (!empty($off_auth)) {
                    if ($off_auth->sun == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;

                    }

                    if ($off_auth->mon == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->tue == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->wed == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->thu == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }

                    if ($off_auth->fri == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }
                    if ($off_auth->sat == '1') {
                        $offarr = $offarr + 0;
                    } else {
                        $offarr = $offarr + $duty_hours;
                    }
                }

            }

        } else {
            $offarr = 0;
        }

        $LeaveAllocation = DB::table('leave_allocation')
            ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
            ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
            ->where('leave_allocation.emid', '=', $Roledata->reg)
            ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

            ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
            ->get();
        $sdate = $emjob->start_date;
        $edate = $emjob->end_date;

        $date_diff = abs(strtotime($edate) - strtotime($sdate));

        $years = floor($date_diff / (365 * 60 * 60 * 24));
        if (!empty($currency_auth)) {
            $symbol = $currency_auth->symbol;
        } else {
            $symbol = '';
        }
        if (!empty($pay_type_auth)) {
            $pay_ty = $pay_type_auth->pay_type;
        } else {
            $pay_ty = '';
        }

        $laeve_arr = array();
        $laeve_srt = '';
        $laeve_arr1 = array();
        $laeve_srt1 = '';

        if (count($LeaveAllocation) != 0) {
            foreach ($LeaveAllocation as $value) {
                $laeve_arr[] = $value->leave_in_hand . '  days  ' . strtolower($value->leave_type_name);
                $laeve_arr1[] = $value->max_no . '  days  ' . strtolower($value->leave_type_name);
            }

            $laeve_srt = implode(',', $laeve_arr);
            $laeve_srt1 = implode(',', $laeve_arr1);

        } else {
            $laeve_srt = '';
            $laeve_srt1 = '';
        }

        $em_name = $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname;
        $address_emp = $emjob->emp_pr_street_no . ',' . $emjob->emp_per_village . ',' . $emjob->emp_pr_state . ',' . $emjob->emp_pr_city . ',' . $emjob->emp_pr_pincode . ',' . $emjob->emp_pr_country;
        $date_r = date('dS F Y', strtotime($emjob->emp_doj));
        $date_con = date('dS F Y', strtotime($emjob->start_date));
        $headers = array(

            "Content-type" => "text/html",
            'name' => 'Arial', 'size' => 20, 'bold' => true,
            "Content-Disposition" => "attachment;Filename=contract.doc",

        );

        $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Agreement</title>
</head>

<body>

<table style="width:100%;">
<tbody>
  <tr>
    <th style="margin-bottom:15px"><img src="' . env("BASE_URL") . 'public/';
        $content .= $Roledata->logo;
        $content .= '" alt="" /></th>
  </tr>
  <tr><th><h2 style="margin:0">CONTRACT OF EMPLOYMENT</h2></th></tr>
  <tr><th><h3 style="margin:0">';
        $content .= $Roledata->com_name;

        $content .= ' </h3></th></tr>
  <tr><th><h3 style="margin:0">And</h3></th></tr>
  <tr><th><h3 style="margin:0">';
        $content .= $em_name;

        $content .= '</h3></th></tr>


<tr>
  <td style="margin-top:20px;"><span style="font-weight:600">Name:</span> ';
        $content .= $em_name;

        $content .= '</td>
  </tr>
  <tr>
  <td><span style="font-weight:600">Job Title:</span>';
        $content .= $emjob->emp_designation;

        $content .= '   </td>
  </tr>
  <tr>
  <td><span style="font-weight:600">Address:</span> ';
        $content .= $emjob->job_loc;

        $content .= '  </td>
  </tr>
<tr>
<td><span style="font-weight:600">Date:</span>  ';
        $content .= $date_r;

        $content .= ' </td>
</tr>

<tr><td style="padding-top:30px">The basic terms and conditions of your employment are as set out in this Contract of Employment (the "Contract"), the Employer policies, procedures and rules as may be introduced and/or amended from time to time.  Together these documents incorporate the written particulars of employment required to be given to you by statute.  There are no collective agreements affecting your terms and conditions of employment.</td></tr>

<tr>
 <td>
  	<h4>1.  <u>Duration of Contract</u></h4>

Your employment with the Employer under this Contract commenced on ';
        $content .= $date_con;

        $content .= '  and shall continue, subject to your terms and conditions of employment, until and unless your employment is terminated earlier in accordance with clause 14.

  </td>
 </tr>
 <tr>
    <td>
  	<h4>2. <u>Period of Continuous Employment</u></h4>

No period of employment prior to your start date counts as part of your period of continuous employment and accordingly your period of continuous employment for the purposes of the Employment Rights Act 1996 commenced on the Commencement Date and also subject to visa approval. The Initial duration of work is a';
        $content .= $years;

        $content .= '  -year period. This contract may be extended in future subject to your performance and immigration rules.
  </td>
</tr>
<tr>
  <td><h4>3.	<u>Job Title and Flexibility</u></h4>
    <p>3.1	You are employed as a  ';
        $content .= $emjob->emp_designation;

        $content .= '   of';
        $content .= $Roledata->com_name;

        $content .= ' .</p>
	<p>3.2. You are expected to perform all duties which may be required of you in this role as set out in the attached Job Description. You must comply with all reasonable instructions given to you and observe all the policies, procedures Health and Safety rules of the Management as may be introduced and/or amended from time to time.</p>
  </td>
</tr>

<tr>
 <td><h4>4.	<u>Place of Work</u></h4>
  <p>4.1       Your normal place of work is located at';
        $content .= $emjob->job_loc;

        $content .= ' .
             The Management may require you however to work at such other locations on a temporary basis as the Employer may from time to time require. The management reserves the right to relocate you on reasonable notice to such other similar branches as the Management may from time to time require.
</p>
<p>4.2	You may be required to travel throughout the ';
        $content .= $Roledata->country;

        $content .= ' in order to fulfill the duties of your employment.   If using your own car to undertake work related to ';
        $content .= $emjob->emp_department;

        $content .= '  you are required to ensure that you have adequate insurance cover for business use. However you are entitled for the expenses.</p>
 </td>
</tr>
<tr>
  <td><h4>5.	<u>Normal Working Hours</u></h4>
   <p>5.1	Your normal working hours are';
        $content .= $offarr;

        $content .= '  hours per week to be worked at such times as the Management reasonably requires.</p>
   <p>5.2	You are required to work such additional hours as may be necessary or appropriate from time to time to enable you to carry out your duties properly.  You shall not be entitled to receive any additional remuneration for work outside your normal hours.</p>
   <p>5.3	The Management reserves the right, if it reasonably requires, increasing, reducing and/or otherwise varying or altering your hours or times of work. The alteration of hours and wages are subject to Immigration rules and other employment law.</p>

  </td>

</tr>
<tr>
<td><h4>6.	<b>General Obligations During Employment</b></h4>
 <p>6.1	During your normal working hours and at such other times as may reasonably be required of you, you shall devote the whole of your time, attention, skill and abilities to the performance of your duties under this Contract and shall act in the best interests of the Management. You shall not undertake any work or employment, other than  ';
        $content .= $Roledata->com_name;

        $content .= ' during your hours of work.</p>
</td>
</tr>
<tr>
 <td><h4>7.	<u>Remuneration</u></h4></td>
</tr>
<tr><td><h4>7.1  <u>Rate of Pay</u></h4>
 <p>You are entitled to be paid at the rate of ';
        $content .= $symbol;
        $content .= ' ' . number_format($emjob->emp_pay_scale, 2);
        $content .= ' ' . $emjob->currency;
        $content .= '     per Annum. Your salary will be paid ';
        $content .= $pay_ty;
        $content .= '   in arrears by bank transfer.</p>
</td></tr>
<tr>
  <td><p>7.2	Your rate of pay will be reviewed in every six months. Your rate of pay will not necessarily increase as a result of the review.</p></td>
</tr>
<tr>
<td><h4>7.3  <u>Expenses </u></h4>
  <p>You are entitled to be reimbursed for all reasonable expenses properly incurred in the performance of your duties in accordance with the Companys Expenses Policy. The Employer reserves the right to amend, vary or alter the policy on expenses at any time.	</p>
</td>
</tr>
<tr>
  <td><h4>8. <u>Benefits</u></h4></td>
</tr>
<tr>
  <td><h4>8.1. <u>Pension Scheme</u></h4>
   <p>The Company will comply with its employer pension duties in accordance with relevant legislation (if applicable). Details in this respect will be furnished to you separately.</p>
  </td>
</tr>
<tr>
  <td><h4>9.	<u>Holidays</u></h4>
  <p>9.1	The Management"s holiday year runs from 1st January to 31st December inclusive.  Your pro-rata entitlement, based on the number of hours you work and ';
        $content .= $laeve_srt;
        $content .= '  in each year. You are allowed to take unpaid holiday subject to special circumstances but it must be prior approved by the management.</p>
  <p>9.2	All paid holiday pay will be calculated at your basic rate of pay and will be subject to normal deductions.</p>
  <p>9.3	Your entitlement to holidays shall, subject to the provisions of clause 9.5 below, accrue pro rata throughout each holiday year.  For the purpose of calculating the amount of accrued holiday entitlement, only complete calendar months will count. You will not, except in exceptional circumstances, be permitted to take more than  ';
        $content .= $laeve_srt1;
        $content .= '  at any one time.</p>
  <p>9.4	You are encouraged to take your full holiday entitlement each year.  Any holiday entitlement outstanding at the end of the holiday year shall not be carried forward to any subsequent year (except in exceptional circumstances) and the Employer will not make any payment in lieu of any holidays not taken. </p>
  <p>9.5	If you leave the Employer"s employment the following applies:-</p>
  <p>&deg;	You will be paid in lieu of any accrued but untaken holiday entitlement which may exist as at the date of termination of your employment.</p>
  <p>&deg;	If by the termination of your employment you have taken more holidays than you have accrued, you will be required to repay to the Employer pay received for holidays taken in excess of your basic holiday entitlement.  Any sums so due may, if necessary, be deducted from any money owing to you from the Employer.  </p>

  <p>9.6	You must obtain authorisation from the Management before making any holiday arrangements. The date of holidays must be agreed with the Employer and a Holiday Request must be completed and authorized by the Employer at least 14 days prior to your proposed holiday dates. Any unauthorised absence for more than 10 days will be notified to the UKBA. Furthermore disciplinary action may be taken against you. You must inform the management immediately if there is any change of circumstance, such as change of contact details, change of your immigration status etc.</p>
  </td>
</tr>
<tr>
  <td><h4>10.	<u>Sickness Absence</u></h4>
  <p>10.1      <u>Sickness Absence Reporting </u></p>

	<p>You are required to inform any sickness prior to the shift. Failure to comply with the notification and certification procedures may result in disciplinary action and non-payment of sick pay.</p>
<p>10.2  <u>Sick Pay</u></p>
<p>Subject to you complying with the above notification and certification requirements, plus any additional rules introduced from time to time, you will, if eligible, be paid Statutory Sick Pay in accordance with the legislation applying from time to time.  For the purpose of Statutory Sick Pay, your qualifying days are Monday to Friday.</p>
<p>10.3	The Employer does not operate a sick pay scheme other than Statutory Sick Pay. </p>
  </td>
</tr>
<tr>
<td><h4>11.	Health and Safety</h4>
<p>11.1	The Employer recognises that safe working practice is a joint concern for the Employer and its employees.  The Employer is responsible for ensuring that working conditions conform to statutory requirements.  To comply with these requirements there must be an acceptance on your part to act in a responsible manner and not to indulge in unsafe working practices.  You are required at all times to observe and co-operate with safety.</p>
<p>11.2	You are required to familiarise yourself with the Health and Safety regulations in force and to ensure that at all times you take care not to endanger yourself or any other person. You are required at all times to observe the Health and Safety policy of the Management. </p>

<p>11.3	You should be aware that irrespective of any action taken by the Employer, if you are found contravening safety regulations you could be liable to criminal proceedings under the provisions of the Health and Safety at Work etc Act 1974.</p>
</td>
</tr>
<tr>
 <td><h4>12.	<u>Disciplinary and Grievance Procedures</u></h4>
  <p>12.1	The Employer"s Disciplinary and Grievance Policies and Procedures are set out in the Handbook. The Disciplinary and Grievance Procedures do not form part of your contractual terms and conditions of employment.  You are also referred to the Employer"s policies on Harassment and Bullying and The Disclosure of Suspected Wrongdoing and Legal Concerns.</p>
  <p>12.2	The Employer may, in its absolute discretion, suspend you on full pay pending the outcome of any investigation or process undertaken under any of the above procedures.  </p>
 </td>
</tr>
<tr>
  <td><h4>13.	<u>Notice Period</u></h4>
  <p>13.1	Your employment is subject to a probationary period of 3 month from the commencement date.  The length of your probationary period may be extended if the Employer in its absolute discretion deems it appropriate.</p>
  <p>13.2	During your probationary period, this Contract can be terminated by either party giving to the other not less than one week written notice.</p>
  <p>13.3	Subject always to the statutory minimum notice requirements, following the end of your probationary period, this Contract can be terminated by either party giving to the other not less than one week"s written notice.</p>
  <p>13.4	The Employer reserves the right to pay salary in lieu of notice.</p>
  <p>13.5	The Employer reserves the right to terminate your employment without notice or salary in lieu of notice in appropriate circumstances.  Appropriate circumstances include, but are not limited to, situations of gross misconduct, gross incompetence and/or gross negligence. And other legal reasons. You must make your own arrangement to return to you Native Country';
        $content .= $emjob->country_birth;
        $content .= ' . The management is not responsible for your return cost of flight and other expenses.</p>
  </td>
</tr>
<tr>
  <td><h4>14.	<u>Jurisdiction</u></h4>
   <p>This Contract shall be governed by and interpreted in accordance with English law and each of the parties submits to the exclusive jurisdiction of the English Courts and Tribunals as regards any claim or matter arising under this Contract.</p>
  </td>
</tr>
<tr><td>Signed for and on behalf of  ';
        $content .= $Roledata->com_name;
        $content .= '  </td></tr>

<tr>
  <td style="border: 2px solid #000;padding: 15px;margin-bottom:25px"><p>By</p>
    <p style="line-height:25px">Signature of the Management.................................................    Date	............................................

Name of Authorised Signatory for ';
        $content .= $Roledata->com_name;
        $content .= '     ................................................</p>

</td>
</tr>

<tr>
 <td style="border: 2px solid #000;padding: 15px;"><p>I accept employment on the terms outlined in this Contract.</p>

<p style="line-height:25px">Signature of Employee 	.................................................. 		Date...........................................

Name of Employee	................................................</p>
</td>
</tr>
</tbody>
</table>
</body>
</html>

';

        return \Response::make($content, 200, $headers);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function newaddEmployee($reg_id, $emp_id)
    {try {

        $data['currencies'] = DB::table('currencies')->orderBy('country', 'asc')->get();
        $data['reg'] = base64_decode($reg_id);
        $data['employee'] = DB::table('company_employee')
            ->where('emid', '=', base64_decode($reg_id))
            ->where('id', '=', base64_decode($emp_id))
            ->first();
        return view('employee/basic-info', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }
    }

    public function savenewEmployee(Request $request)
    {try {

        $Employee = DB::table('users')->where('email', '=', $request->emp_ps_email)->first();

        if (empty($Employee)) {

            $data = array(

                'emp_fname' => strtoupper($request->emp_fname),
                'emp_mname' => strtoupper($request->emp_mid_name),
                'emp_lname' => strtoupper($request->emp_lname),
                'emp_ps_email' => $request->emp_ps_email,

                'emp_ps_phone' => $request->emp_ps_phone,
                'emp_department' => $request->emp_department,
                'emp_designation' => $request->emp_designation,
                'emp_status' => $request->emp_status,

                'emp_code' => $request->emp_code,
                'verify_status' => 'not approved',

                'emid' => $request->emid,

            );
            $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emid', $request->emid)->first();
            if (!empty($ckeck_dept)) {
                Session::flash('message', 'Employee  Code  Already Exists.');
                return redirect('new-employee/' . base64_encode($request->emid) . '/' . base64_encode($request->o_id));
            }
            $ckeck_dept_email = DB::table('employee')->where('emp_ps_email', '=', $request->emp_ps_email)->first();
            if (!empty($ckeck_dept_email)) {

                Session::flash('message', 'Email id already exits');
                return redirect('new-employee/' . base64_encode($request->emid) . '/' . base64_encode($request->o_id));

            }

            $ckeck_right = DB::table('right_works')->where('employee_id', '=', $request->emp_code)->where('emid', $request->emid)->first();

            if (!empty($ckeck_right)) {
                $datarigh_edit = array(
                    'start_date' => date('Y-m-d', strtotime($request->emp_doj)),

                );

                DB::table('right_works')
                    ->where('employee_id', '=', $decrypted_id)
                    ->where('emid', $Roledata->reg)
                    ->update($datarigh_edit);
            }
            $pay = array(
                'employee_code' => $request->emp_code,
                'emid' => $request->emid,
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
            DB::table('employee')->insert($data);

            DB::table('employee_pay_structure')->insert($pay);
            $p_dd = mt_rand(1000, 9999);
            $ins_data = array(
                'employee_id' => $request->emp_code,
                'name' => strtoupper($request->emp_fname) . strtoupper($request->emp_mid_name) . strtoupper($request->emp_lname),
                'email' => $request->emp_ps_email,
                'user_type' => 'employee',
                'password' => $p_dd,
                'emid' => $request->emid,

            );

            DB::table('users')->insert($ins_data);

            $ins_data_role = array(
                'menu' => '1',
                'module_name' => '1',
                'member_id' => $request->emp_ps_email,
                'rights' => 'Add',

                'emid' => $request->emid,

            );
            DB::table('role_authorization')->insert($ins_data_role);

            $ins_data_role1 = array(
                'menu' => '1',
                'module_name' => '1',
                'member_id' => $request->emp_ps_email,
                'rights' => 'Edit',

                'emid' => $request->emid,

            );
            DB::table('role_authorization')->insert($ins_data_role1);

            $data = array('firstname' => $request->emp_fname, 'maname' => $request->emp_mid_name, 'email' => $request->emp_ps_email, 'lname' => $request->emp_lname, 'password' => $p_dd);
            $toemail = $request->emp_ps_email;
            Mail::send('mail', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Employee Login  Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $Roledataemp = DB::table('registration')

                ->where('reg', '=', $request->emid)
                ->first();

            $data = array('emp_code' => $request->emp_code, 'emp_fname' => $request->emp_fname, 'emp_mid_name' => $request->emp_mid_name, 'emp_lname' => $request->emp_lname, 'emp_ps_email' => $request->emp_ps_email, 'emp_ps_phone' => $request->emp_ps_phone);
            $toemail = $Roledataemp->email;
            Mail::send('mailempnew', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('New Employee   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', ' Thank you,Employee Details Saved Successfully.');
            return redirect('new-employe/thank-you');

        } else {
            Session::flash('message', 'Email id already exits.');
            return redirect('new-employee/' . base64_encode($request->emid) . '/' . base64_encode($request->o_id));

        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }
    public function thanknewEmployee()
    {try {
        return view('employee/thank-you');
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }
    }

    public function viewchangecircumstances($emp_id, $eploye_id)
    {try {
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $data['emid'] = base64_decode($emp_id);
        $decrypted_id = base64_decode($eploye_id);
        $data['emp_code'] = $decrypted_id;

        $data['employee_rs'] = DB::table('change_circumstances')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

        $data['employeet'] = DB::table('employee')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->first();

        return view('appemployee/change-of-circumstances', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function viewchangecircumstancesedit($emp_id, $eploye_id)
    {try {
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emp_id))
            ->first();
        $data['emid'] = base64_decode($emp_id);
        $decrypted_id = base64_decode($eploye_id);
        $data['emp_code'] = $decrypted_id;
        $data['employee_rs'] = DB::table('employee')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->first();

        $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->get();
        $data['currency_user'] = DB::table('currencies')->orderBy('country', 'asc')->get();

        $data['employee_otherd_doc_rs'] = DB::table('employee_other_doc')
            ->where('emid', '=', $decrypted_id)
            ->where('emp_code', '=', $Roledata->reg)
            ->get();

        return view('appemployee/edit-circumstances', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function savechangecircumstancesedit(Request $request)
    {try {
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->emid)
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->emid)
            ->first();

        $decrypted_id = $request->emp_code;
        $dataupdate = array(

            'emp_ps_phone' => $request->emp_ps_phone,

            'nationality' => $request->nationality,
            'ni_no' => $request->ni_no,
            'pass_doc_no' => $request->pass_doc_no,
            'pass_nat' => $request->pass_nat,
            'issue_by' => $request->issue_by,
            'pas_iss_date' => date('Y-m-d', strtotime($request->pas_iss_date)),
            'pass_exp_date' => date('Y-m-d', strtotime($request->pass_exp_date)),
            'pass_review_date' => date('Y-m-d', strtotime($request->pass_review_date)),
            'visa_doc_no' => $request->visa_doc_no,
            'visa_nat' => $request->visa_nat,
            'visa_issue' => $request->visa_issue,
            'visa_issue_date' => date('Y-m-d', strtotime($request->visa_issue_date)),
            'visa_exp_date' => date('Y-m-d', strtotime($request->visa_exp_date)),
            'visa_review_date' => date('Y-m-d', strtotime($request->visa_review_date)),

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

        );

        if (!empty($request->imagedatapass)) {
            $image = $request->imagedatapass;
            $folderPath1 = "employee_doc/";
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $image_name = 'passport_' . strtotime(date('Y-m-d H:i:s')) . '.png';

            $image_base64_1 = base64_decode($request->imagedatapass);
            $file1 = $folderPath1 . $image_name;

            Storage::disk('public')->put($file1, $image);

            $path_doc = $file1;
            $dataimgdoc = array(
                'pass_docu' => $path_doc,
            );
            DB::table('employee')
                ->where('emp_code', '=', $request->emp_code)->where('emid', '=', $request->emid)
                ->update($dataimgdoc);

        }

        if (!empty($request->imagedatavisa)) {
            $image = $request->imagedatavisa;
            $folderPath1 = "employee_vis_doc/";
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

            $image_base64_1 = base64_decode($request->imagedatavisa);
            $file1 = $folderPath1 . $image_name;

            Storage::disk('public')->put($file1, $image);

            $path_visa_doc = $file1;
            $dataimgvis = array(
                'visa_upload_doc' => $path_visa_doc,
            );
            DB::table('employee')
                ->where('emp_code', '=', $request->emp_code)->where('emid', '=', $request->emid)
                ->update($dataimgvis);

        }

        if (!empty($request->imagedataproof)) {
            $image = $request->imagedataproof;
            $folderPath1 = "employee_per_add/";
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $image_name = 'address_' . strtotime(date('Y-m-d H:i:s')) . '.png';

            $image_base64_1 = base64_decode($request->imagedataproof);
            $file1 = $folderPath1 . $image_name;

            Storage::disk('public')->put($file1, $image);

            $path_per_doc = $file1;
            $dataimgper = array(
                'pr_add_proof' => $path_per_doc,
            );
            DB::table('employee')
                ->where('emp_code', '=', $request->emp_code)->where('emid', '=', $request->emid)
                ->update($dataimgper);

        }

        if ($request->has('ps_add_proof')) {

            $file_ps_add = $request->file('pr_add_proof');
            $extension_ps_add = $request->ps_add_proof->extension();
            $path_ps_ad = $request->ps_add_proof->store('employee_ps_add', 'public');
            $dataimgps = array(
                'ps_add_proof' => $path_ps_ad,
            );
            DB::table('employee')
                ->where('emp_code', '=', $request->emp_code)->where('emid', '=', $request->emid)
                ->update($dataimgps);

        }

        DB::table('employee')
            ->where('emp_code', '=', $request->emp_code)->where('emid', '=', $request->emid)
            ->update($dataupdate);

        if ($request->has('stat_up')) {

            $file_ps_doc = $request->file('stat_up');
            $extension_ps_doc = $request->stat_up->extension();
            $path_ps_doc = $request->stat_up->store('employee_ps_stat', 'public');

        } else {

            $path_ps_doc = '';

        }

        if ($request->has('pap_up')) {

            $file_per_doc = $request->file('pap_up');
            $extension_per_doc = $request->pap_up->extension();
            $path_per_doc = $request->pap_up->store('employee_pap_up', 'public');

        } else {

            $path_per_doc = '';

        }

        $data = array(

            'pap_up' => $path_per_doc,
            'stat_up' => $path_ps_doc,

            'emp_designation' => $request->emp_designation,

            'emp_ps_phone' => $request->emp_ps_phone,

            'nationality' => $request->nationality,
            'ni_no' => $request->ni_no,
            'pass_doc_no' => $request->pass_doc_no,
            'pass_nat' => $request->pass_nat,
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
            'emid' => $request->emid,

            'hr' => $request->hr,
            'home' => $request->home,
            'res_remark' => $request->res_remark,

            'date_change' => date('Y-m-d', strtotime($request->date_change)),
            'change_last' => $request->change_last,
            'stat_chage' => $request->stat_chage,

            'unique_law' => $request->unique_law,
            'repo_ab' => $request->repo_ab,
            'laeve_date' => $request->laeve_date,

        );
        DB::table('change_circumstances')->insert($data);

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
                            ->where('emid', '=', $request->emid)
                            ->where('id', $value)
                            ->update($dataimgedit);

                    }

                    $dataquli_edit = array(
                        'emp_code' => $request->emp_code,
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
                        ->where('emid', '=', $request->emid)
                        ->update($dataquli_edit);
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
                        'emid' => $request->emid,
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

        $employeecircumsta = DB::table('change_circumstances')

            ->where('emp_code', '=', $request->emp_code)
            ->where('emid', '=', $request->emid)
            ->orderBy('id', 'desc')
            ->first();

        $employee_otherd_doc_rs = DB::table('employee_other_doc')

            ->where('emp_code', '=', $request->emp_code)
            ->where('emid', '=', $request->emid)
            ->get();
        if (count($employee_otherd_doc_rs) != 0) {
            foreach ($employee_otherd_doc_rs as $valuother) {
                $datachangecirdox = array(

                    'emp_code' => $request->emp_code,
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
                    'cir_id' => $employeecircumsta->id,

                );

                DB::table('circumemployee_other_doc')->insert($datachangecirdox);

            }
        }

        Session::flash('message', 'Change Of Circumstances Updated Successfully.');
        return redirect('appaddchange-of-circumstances/' . base64_encode($request->emid) . '/' . base64_encode($request->emp_code));

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function viewemployeeagreement($emp_id, $eploye_id)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $data['emid'] = base64_decode($emp_id);
            $decrypted_id = base64_decode($eploye_id);
            $data['emp_code'] = $decrypted_id;

            $data['employee_rs'] = DB::table('employee')->where('emp_code', '=', $decrypted_id)->where('emid', '=', $Roledata->reg)->get();
            return view('appemployee/contract', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function saveemployeeagreementnew($emid_id, $emp_id)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid_id))
                ->first();
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid_id))
                ->first();
            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');
            $offarr = 0;
            $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

            $currency_auth = DB::table('currencies')

                ->where('code', '=', $emjob->currency)
                ->orderBy('id', 'DESC')
                ->first();
            $pay_type_auth = DB::table('payment_type_master')

                ->where('id', '=', $emjob->emp_payment_type)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($emjob->emp_department)) {

                $employee_depers = DB::table('department')
                    ->where('department_name', '=', $emjob->emp_department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table('designation')
                    ->where('designation_name', '=', $emjob->emp_designation)
                    ->where('department_code', '=', $employee_depers->id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $duty_auth = DB::table('duty_roster')
                    ->where('department', '=', $employee_depers->id)
                    ->where('designation', '=', $employee_desigrs->id)
                    ->where('employee_id', '=', base64_decode($emp_id))
                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table('shift_management')
                        ->where('department', '=', $employee_depers->id)
                        ->where('id', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_auth = DB::table('offday')
                        ->where('department', '=', $employee_depers->id)
                        ->where('shift_code', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = ($difference % 60);
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;

                        }

                        if ($off_auth->mon == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }

                }

            } else {
                $offarr = 0;
            }

            $data['LeaveAllocation'] = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
                ->where('leave_allocation.emid', '=', $Roledata->reg)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                ->get();
            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = '';
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = '';
            }
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'date' => $emjob->emp_doj, 'date_con' => $emjob->start_date, 'date_end' => $emjob->end_date, 'job_loc' => $emjob->job_loc, 'emid' => $emjob->emid, 'emp_code' => $emjob->emp_code, 'emp_pay_scale' => $emjob->emp_pay_scale, 'em_name' => $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname, 'em_pos' => $emjob->emp_designation, 'em_depart' => $emjob->emp_department, 'address_emp' => $emjob->emp_pr_street_no . ',' . $emjob->emp_per_village . ',' . $emjob->emp_pr_state . ',' . $emjob->emp_pr_city . ',' . $emjob->emp_pr_pincode . ',' . $emjob->emp_pr_country, 'em_co' => $Roledata->country, 'currency' => $emjob->currency, 'symbol' => $symbol, 'week_time' => $offarr, 'year_time' => $years, 'pay_type' => $pay_ty, 'LeaveAllocation' => $data['LeaveAllocation'], 'birth' => $emjob->country_birth
                , 'emp_de' => $emjob, 'Roledata' => $Roledata];

            $pdf = PDF::loadView('mypdfagree', $datap);
            return $pdf->download('contract.pdf');

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }

    public function viewofferdownsendcandidatedetails($emp_id, $send_id)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/firstmail', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function viewofferdownsendcandidatedetailssecond($emp_id, $send_id)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/secondmail', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function viewofferdownsendcandidatedetailsthired($emp_id, $send_id)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/thirdmail', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function viewallAddEmployee($emp_id, $all)
    {

        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emp_id))
                ->first();
            $data['emid'] = base64_decode($emp_id);
            $id = Input::get('q');
            if ($id) {

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

                $empdepartmen = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_name', '=', $data['employee_rs'][0]->emp_department)->where('department_status', '=', 'active')->first();
                $data['department'] = DB::table('department')->where('emid', '=', $Roledata->reg)->where('department_status', '=', 'active')->get();
                if (!empty($empdepartmen)) {
                    $data['designation'] = DB::table('designation')->where('emid', '=', $Roledata->reg)->where('department_code', '=', $empdepartmen->id)->where('designation_status', '=', 'active')->get();
                } else {
                    $data['designation'] = '';
                }
                $data['payment_wedes_rs'] = DB::table('payment_type_wedes')->where('emid', '=', $Roledata->reg)->get();

                $data['employee_type'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'active')->get();
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
                $data['nation_master'] = DB::table('nationality_master')->where('emid', '=', $Roledata->reg)->get();
                $data['payment_type_master'] = DB::table('payment_type_master')->where('emid', '=', $Roledata->reg)->get();
                $data['currency_master'] = DB::table('currency_code')->get();
                $data['tax_master'] = DB::table('tax_master')->where('emid', '=', $Roledata->reg)->get();

                $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '!=', $decrypted_id)->get();
                $data['all'] = $all;
                return view('appemployee/edit-allemployee', $data);

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

        //return view('pis/employee-master')->with(['company'=>$company,'employee'=>$employee_type]);
    }

    public function saveallEmployee(Request $request)
    {

        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
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

            $id = Input::get('q');
            if ($id) {
                $decrypted_id = my_simple_crypt($id, 'decrypt');

                $ckeck_dept = DB::table('employee')->where('emp_code', $request->emp_code)->where('emp_code', '!=', $decrypted_id)->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Employee Code Code  Already Exists.');
                    if ($request->all == 'all') {
                        return redirect('appdashemployees/' . base64_encode($request->reg) . '/all');

                    }
                    if ($request->all == 'migrant') {
                        return redirect('appdashemployees/' . base64_encode($request->reg) . '/migrant');

                    }
                }

                $ckeck_email = DB::table('users')->where('email', '=', $request->emp_ps_email)->where('employee_id', '!=', $decrypted_id)->where('status', '=', 'active')->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'E-mail id  Already Exists.');
                    if ($request->all == 'all') {
                        return redirect('appdashemployees/' . base64_encode($request->reg) . '/all');

                    }
                    if ($request->all == 'migrant') {
                        return redirect('appdashemployees/' . base64_encode($request->reg) . '/migrant');

                    }
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
                if (!empty($request->imagedatapass)) {
                    $image = $request->imagedatapass;
                    $folderPath1 = "employee_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'passport_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatapass);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_doc = $file1;
                    $dataimgdoc = array(
                        'pass_docu' => $path_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgdoc);

                }

                if (!empty($request->imagedatavisa)) {
                    $image = $request->imagedatavisa;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisa);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visa_doc = $file1;
                    $dataimgvis = array(
                        'visa_upload_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                }

                if (!empty($request->imagedatavisaback)) {
                    $image = $request->imagedatavisaback;
                    $folderPath1 = "employee_vis_doc/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'visa_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedatavisaback);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_visa_doc = $file1;
                    $dataimgvis = array(
                        'visaback_doc' => $path_visa_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgvis);

                }

                if (!empty($request->imagedataproof)) {
                    $image = $request->imagedataproof;
                    $folderPath1 = "employee_per_add/";
                    list($type, $image) = explode(';', $image);
                    list(, $image) = explode(',', $image);
                    $image = base64_decode($image);
                    $image_name = 'address_' . strtotime(date('Y-m-d H:i:s')) . '.png';

                    $image_base64_1 = base64_decode($request->imagedataproof);
                    $file1 = $folderPath1 . $image_name;

                    Storage::disk('public')->put($file1, $image);

                    $path_per_doc = $file1;
                    $dataimgper = array(
                        'pr_add_proof' => $path_per_doc,
                    );
                    DB::table('employee')
                        ->where('emp_code', $decrypted_id)
                        ->where('emid', '=', $Roledata->reg)
                        ->update($dataimgper);

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

                    'nat_id_no' => $request->nat_id_no,
                    'nat_nation' => $request->nat_nation,
                    'nat_country_res' => $request->nat_country_res,
                    'nat_issue_date' => date('Y-m-d', strtotime($request->nat_issue_date)),
                    'nat_exp_date' => date('Y-m-d', strtotime($request->nat_exp_date)),
                    'nat_review_date' => date('Y-m-d', strtotime($request->nat_review_date)),
                    'nat_cur' => $request->nat_cur,

                    'nat_remarks' => $request->nat_remarks,

                );

                DB::table('employee')
                    ->where('emp_code', $decrypted_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->update($dataupdate);

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
                if ($request->all == 'all') {
                    return redirect('appdashemployees/' . base64_encode($request->reg) . '/all');

                }
                if ($request->all == 'migrant') {
                    return redirect('appdashemployees/' . base64_encode($request->reg) . '/migrant');

                }
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }

    public function getrightworks($emp_id)
    {

        try {

            $data['employee_rs'] = DB::table('right_works')->where('emid', '=', base64_decode($emp_id))->get();

            $data['emid'] = base64_decode($emp_id);

            return view('appemployee/right-works', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }

    public function viewsendcandidatedetailswork($send_id)
    {
        try {

            $data['work_rs'] = DB::table('right_works')->where('id', '=', base64_decode($send_id))->first();

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $data['work_rs']->emid)
                ->first();

            $date['Roledata'] = DB::table('registration')

                ->where('reg', '=', $data['work_rs']->emid)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $data['work_rs']->employee_id)->first();

            if ($data['work_rs']->date >= '2021-07-01') {
                return view('dashboard/view-work', $data);

            } else {
                return view('dashboard/view-work-new', $data);
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function getEmployeesdossier()
    {

        try {

            return view('appemployee/employee-dossier');
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }
    public function getCompaniesofficerkey($send_id)
    {
        try {
            $data['companies_rs'] = DB::table('registration')

                ->where('reg', '=', base64_decode($send_id))
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($send_id))
                ->first();

            return view('appemployee/employee-key-link', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function viewchangecircumstanceseditnew($send_id)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($send_id))
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($send_id))
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            return view('appemployee/changing-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function savechangecircumstanceseditnew(Request $request)
    {try {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->emid)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->emid)
            ->first();

        $employee_code = $request->employee_code;
        $employee_type = $request->employee_type;

        $data['result'] = '';
        //dd($leave_allocation_rs);
        $f = 2;

        $employeet = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->first();
        $date1 = date('Y', strtotime($employeet->emp_doj)) . date('m-d');
        $date2 = date('Y-m-d');

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365 * 60 * 60 * 24));
        date('Y', strtotime($date1));
        $endtyear = date('Y', strtotime($date1)) + ($years);
        $employeetnew = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->first();
        $employeetcircumnew = DB::table('change_circumstances_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'ASC')->first();

        $employeetemployeeother = DB::table('circumemployee_other_doc_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

        $dataeotherdoc = '';

        if (count($employeetemployeeother) != 0) {

            foreach ($employeetemployeeother as $valother) {
                if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
                    $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
                } else {
                    $other_exp_date = '';
                }} else {
                    $other_exp_date = '';
                }
                $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
            }

        }

        if (!empty($employeetcircumnew)) {
            $date_doj = date('d/m/Y', strtotime($employeetcircumnew->date_change));
            $anual_datenew = date('Y-m-d', strtotime($employeetcircumnew->date_change . '  + 1 year'));
            $peradd = '';
            $peradd = $employeetcircumnew->emp_pr_street_no;
            if ($employeetcircumnew->emp_per_village) {$peradd .= ',' . $employeetcircumnew->emp_per_village;}
            if ($employeetcircumnew->emp_pr_state) {$peradd .= ',' . $employeetcircumnew->emp_pr_state
                ;}if ($employeetcircumnew->emp_pr_city) {$peradd .= ',' . $employeetcircumnew->emp_pr_city;}
            if ($employeetcircumnew->emp_pr_pincode) {$peradd .= ',' . $employeetcircumnew->emp_pr_pincode;}
            if ($employeetcircumnew->emp_pr_country) {$peradd .= ',' . $employeetcircumnew->emp_pr_country;};

            if ($employeetcircumnew->visa_exp_date != '1970-01-01') {if ($employeetcircumnew->visa_exp_date != '') {
                $visa_exp_date = date('d/m/Y', strtotime($employeetcircumnew->visa_exp_date));
            } else {
                $visa_exp_date = '';
            }} else {
                $visa_exp_date = '';
            }
            if ($employeetcircumnew->pass_exp_date != '1970-01-01') {if ($employeetcircumnew->pass_exp_date != '') {
                $stfol = date('d/m/Y', strtotime($employeetcircumnew->pass_exp_date));
            } else {
                $stfol = '';
            }} else {
                $stfol = '';

            }
            $desinf = $employeetcircumnew->emp_designation;
            $newph = $employeetcircumnew->emp_ps_phone;
            $newpnati = $employeetcircumnew->nationality;
            $newpnavia = $employeetcircumnew->visa_doc_no;
            $newpnapasas = $employeetcircumnew->pass_doc_no;
        } else { $date_doj = date('d/m/Y', strtotime($employeet->emp_doj));

            $anual_datenew = date('Y-m-d', strtotime($employeet->emp_doj . '  + 1 year'));
            $peradd = '';
            $peradd = $employeetnew->emp_pr_street_no;
            if ($employeetnew->emp_per_village) {$peradd .= ',' . $employeetnew->emp_per_village;}
            if ($employeetnew->emp_pr_state) {$peradd .= ',' . $employeetnew->emp_pr_state
                ;}if ($employeetnew->emp_pr_city) {$peradd .= ',' . $employeetnew->emp_pr_city;}
            if ($employeetnew->emp_pr_pincode) {$peradd .= ',' . $employeetnew->emp_pr_pincode;}
            if ($employeetnew->emp_pr_country) {$peradd .= ',' . $employeetnew->emp_pr_country;};

            if ($employeetnew->visa_exp_date != '1970-01-01') {if ($employeetnew->visa_exp_date != '') {
                $visa_exp_date = date('d/m/Y', strtotime($employeetnew->visa_exp_date));
            } else {
                $visa_exp_date = '';
            }} else {
                $visa_exp_date = '';
            }
            if ($employeetnew->pass_exp_date != '1970-01-01') {if ($employeetnew->pass_exp_date != '') {
                $stfol = date('d/m/Y', strtotime($employeetnew->pass_exp_date));
            } else {
                $stfol = '';
            }} else {
                $stfol = '';
            }

            $desinf = $employeetnew->emp_designation;
            $newph = $employeetnew->emp_ps_phone;
            $newpnati = $employeetnew->nationality;
            $newpnavia = $employeetnew->visa_doc_no;
            $newpnapasas = $employeetnew->pass_doc_no;
        }
        $data['result'] .= '<tr>
			<td>1</td>
													<td>' . $date_doj . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $employee_code . '</td>
													<td>' . $employeetnew->emp_fname . '  ' . $employeetnew->emp_mname . ' ' . $employeetnew->emp_lname . '</td>

													<td>' . $desinf . '</td>
														<td>' . $peradd . '</td>

													<td>' . $newph . '</td>
														<td>' . $newpnati . '</td>

															<td>' . $newpnavia . '</td>
															<td>' . $visa_exp_date . '</td>
																<td>Not Applicable </td>
															<td>' . $newpnapasas . '
														( ' . $stfol . ' )</td>
														<td>' . $dataeotherdoc . '</td>
															<td></td>
															<td></td>
															<td>' . date('d/m/Y', strtotime($anual_datenew)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'appchange/change/' . base64_encode($request->emid) . '/' . base64_encode($employee_code) . '/' . base64_encode($anual_datenew) . '" target="_blank"><i class="fas fa-eye" style="font-size: x-large"></i></a>




						</tr>';

        for ($m = date('Y', strtotime($employeet->emp_doj)); $m <= $endtyear; $m++) {

            $strartye = date($m . '-01-01');
            $endtye = date($m . '-12-31');

            $leave_allocation_rs = DB::table('change_circumstances')
                ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')
                ->where('change_circumstances.emp_code', '=', $employee_code)
                ->where('change_circumstances.emid', '=', $Roledata->reg)
                ->where('employee.emp_code', '=', $employee_code)
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('employee.emp_status', '=', $employee_type)
                ->whereBetween('date_change', [$strartye, $endtye])
                ->orderBy('date_change', 'ASC')
                ->select('change_circumstances.*')

                ->get();
            if (count($leave_allocation_rs) != 0) {

                foreach ($leave_allocation_rs as $leave_allocation) {

                    $peradd = '';
                    $peradd = $leave_allocation->emp_pr_street_no;
                    if ($leave_allocation->emp_per_village) {$peradd .= ',' . $leave_allocation->emp_per_village;}
                    if ($leave_allocation->emp_pr_state) {$peradd .= ',' . $leave_allocation->emp_pr_state
                        ;}if ($leave_allocation->emp_pr_city) {$peradd .= ',' . $leave_allocation->emp_pr_city;}
                    if ($leave_allocation->emp_pr_pincode) {$peradd .= ',' . $leave_allocation->emp_pr_pincode;}
                    if ($leave_allocation->emp_pr_country) {$peradd .= ',' . $leave_allocation->emp_pr_country;};

                    $preadd = '';
                    $preadd = $leave_allocation->emp_ps_street_no;
                    if ($leave_allocation->emp_ps_village) {$preadd .= ',' . $leave_allocation->emp_ps_village;}
                    if ($leave_allocation->emp_ps_state) {$preadd .= ',' . $leave_allocation->emp_ps_state
                        ;}if ($leave_allocation->emp_ps_city) {$preadd .= ',' . $leave_allocation->emp_ps_city;}
                    if ($leave_allocation->emp_ps_pincode) {$preadd .= ',' . $leave_allocation->emp_ps_pincode;}
                    if ($leave_allocation->emp_ps_country) {$preadd .= ',' . $leave_allocation->emp_ps_country;};
                    if ($leave_allocation->emp_dob != '1970-01-01') {if ($leave_allocation->emp_dob != '') {
                        $dov = date('d/m/Y', strtotime($leave_allocation->emp_dob));
                    } else {
                        $dov = '';
                    }} else {
                        $dov = '';
                    }
                    if ($leave_allocation->visa_exp_date != '1970-01-01') {if ($leave_allocation->visa_exp_date != '') {
                        $visa_exp_date = date('d/m/Y', strtotime($leave_allocation->visa_exp_date));
                    } else {
                        $visa_exp_date = '';
                    }} else {
                        $visa_exp_date = '';
                    }
                    if ($leave_allocation->pass_exp_date != '1970-01-01') {if ($leave_allocation->pass_exp_date != '') {
                        $stfol = date('d/m/Y', strtotime($leave_allocation->pass_exp_date));
                    } else {
                        $stfol = '';
                    }} else {
                        $stfol = '';
                    }
                    $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)->first();

                    $dojg = date('m-d', strtotime($employeet->emp_doj));

                    $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));

                    $employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)
                        ->where('cir_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->get();

                    $dataeotherdoc = '';

                    if (count($employeetemployeeother) != 0) {

                        foreach ($employeetemployeeother as $valother) {
                            if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
                                $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
                            } else {
                                $other_exp_date = '';
                            }} else {
                                $other_exp_date = '';
                            }
                            $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
                        }

                    }

                    $data['result'] .= '<tr>
			<td>' . $f . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->date_change)) . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $leave_allocation->emp_code . '</td>
													<td>' . $employeet->emp_fname . '  ' . $employeet->emp_mname . ' ' . $employeet->emp_lname . '</td>

													<td>' . $leave_allocation->emp_designation . '</td>
														<td>' . $peradd . '</td>

													<td>' . $leave_allocation->emp_ps_phone . '</td>
														<td>' . $leave_allocation->nationality . '</td>

															<td>' . $leave_allocation->visa_doc_no . '</td>
															<td>' . $visa_exp_date . '</td>
																<td>' . $leave_allocation->res_remark . '</td>
															<td>' . $leave_allocation->pass_doc_no . '
														( ' . $stfol . ' )</td>
														<td>' . $dataeotherdoc . '</td>
															<td>' . $leave_allocation->hr . '</td>
															<td>' . $leave_allocation->home . '</td>
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'appchange/change/' . base64_encode($request->emid) . '/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" style="font-size: x-large"></i></a>

															</td>


						</tr>';

                    $f++;}
            } else {

                $dojg = date('m-d', strtotime($employeet->emp_doj));
                $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));
                $no = '';
                if (date('Y', strtotime($employeet->emp_doj)) != $m) {
                    if ($endtyear != $m) {
                        $no = 'no change ';
                    } else {
                        $no = '';
                    }
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
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
																<td>' . $no . '</td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'appchange/change/' . base64_encode($request->emid) . '/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" style="font-size: x-large"></i></a>

															</td>

						</tr>';
                    $f++;}
            }

        }

        for ($o = ($endtyear + 1); $o <= ($endtyear + 4); $o++) {

            $dojg = date('m-d', strtotime($employeet->emp_doj));
            $anual_date = date('Y-m-d', strtotime($o . '-' . $dojg . '  + 1 year'));

            $data['result'] .= '<tr>
				<td>' . $f . '</td>
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
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'appchange/change/' . base64_encode($request->emid) . '/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" style="font-size: x-large"></i></a>

															</td>

						</tr>';
            $f++;
        }

        $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
        $data['employee_code'] = $employee_code;
        $data['employee_type'] = $employee_type;
        return view('appemployee/changing-list', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function viewofferdownsendcandidatedetailssend_iddate($emid, $send_id, $date)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid))
                ->first();
            $pdf = '';
            $fo = '';
            $date = base64_decode($date);

            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $jocirb = DB::table('change_circumstances')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'job' => $job, 'circum' => $jocirb, 'date' => ($date));

            return View('dashboard/mailcircum', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function reportEmployeesstaff($emid, $emp_id, $emp_type)
    {try {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emid))
            ->first();
        $employee_code = base64_decode($emp_id);
        $employee_type = base64_decode($emp_type);

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', base64_decode($emid))
            ->first();

        if ($employee_code != '') {

            $leave_allocation_rs = DB::table('change_circumstances')
                ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')
                ->where('change_circumstances.emp_code', '=', $employee_code)
                ->where('change_circumstances.emid', '=', $Roledata->reg)
                ->where('employee.emp_code', '=', $employee_code)
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('employee.emp_status', '=', $employee_type)

                ->select('change_circumstances.*')
                ->get();
        } else {
            $leave_allocation_rs = DB::table('change_circumstances')

                ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')

                ->where('change_circumstances.emid', '=', $Roledata->reg)
                ->where('employee.emp_status', '=', $employee_type)

                ->where('employee.emid', '=', $Roledata->reg)
                ->select('change_circumstances.*')
                ->get();
        }

        $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'leave_allocation_rs' => $leave_allocation_rs, 'emid' => $Roledata->reg, 'employee_type' => $employee_type, 'employee_code' => $employee_code];

        $pdf = PDF::loadView('mypdfcircumstances', $datap);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('circumstancesreport.pdf');
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }
    public function reportEmployeesexcelstaff($emid, $emp_id, $emp_type)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid))
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid))
                ->first();

            $employee_code = base64_decode($emp_id);
            $employee_type = base64_decode($emp_type);

            if ($employee_code != '') {
                $new_emp = $employee_code;
            } else {
                $new_emp = 'all';
            }

            return Excel::download(new ExcelFileExportCircumstances($Roledata->reg, $new_emp, $employee_type), 'circumstancesreport.xlsx');

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }
    public function viewemployeeagreementnew($send_id)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($send_id))
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($send_id))
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            return view('appemployee/contract-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function saveemployeeagreementnewne(Request $request)
    {
        try {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->emid)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->emid)
                ->first();

            $employee_code = $request->employee_code;
            $employee_type = $request->employee_type;

            $data['result'] = '';if ($employee_code != '') {

                $leave_allocation_rs = DB::table('employee')

                    ->where('emp_code', '=', $employee_code)
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_status', '=', $employee_type)

                    ->select('employee.*')
                    ->get();
            } else {
                $leave_allocation_rs = DB::table('employee')

                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_status', '=', $employee_type)

                    ->select('employee.*')
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {$f = 1;

                foreach ($leave_allocation_rs as $leave_allocation) {

                    $peradd = '';
                    $peradd = $leave_allocation->emp_pr_street_no;
                    if ($leave_allocation->emp_per_village) {$peradd .= ',' . $leave_allocation->emp_per_village;}
                    if ($leave_allocation->emp_pr_state) {$peradd .= ',' . $leave_allocation->emp_pr_state
                        ;}if ($leave_allocation->emp_pr_city) {$peradd .= ',' . $leave_allocation->emp_pr_city;}
                    if ($leave_allocation->emp_pr_pincode) {$peradd .= ',' . $leave_allocation->emp_pr_pincode;}
                    if ($leave_allocation->emp_pr_country) {$peradd .= ',' . $leave_allocation->emp_pr_country;};

                    $preadd = '';
                    $preadd = $leave_allocation->emp_ps_street_no;
                    if ($leave_allocation->emp_ps_village) {$preadd .= ',' . $leave_allocation->emp_ps_village;}
                    if ($leave_allocation->emp_ps_state) {$preadd .= ',' . $leave_allocation->emp_ps_state
                        ;}if ($leave_allocation->emp_ps_city) {$preadd .= ',' . $leave_allocation->emp_ps_city;}
                    if ($leave_allocation->emp_ps_pincode) {$preadd .= ',' . $leave_allocation->emp_ps_pincode;}
                    if ($leave_allocation->emp_ps_country) {$preadd .= ',' . $leave_allocation->emp_ps_country;};

                    $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)->first();

                    $dteemployeet = '';
                    if ($employeet->visa_exp_date != '1970-01-01') {$dteemployeet = date('d/m/Y', strtotime($employeet->visa_exp_date));}
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $leave_allocation->emp_code . '</td>
													<td>' . $employeet->emp_fname . '  ' . $employeet->emp_mname . ' ' . $employeet->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->emp_dob)) . '</td>
													<td>' . $leave_allocation->emp_ps_phone . '</td>
														<td>' . $leave_allocation->nationality . '</td>
														<td>' . $leave_allocation->ni_no . '</td>
															<td>' . $dteemployeet . '</td>
															<td>' . $leave_allocation->pass_doc_no . '</td>
															<td>' . $peradd . '</td>


													<td><a href="contract-agreement-editnew/' . base64_encode($leave_allocation->emid) . '/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-pdf" style="font-size: x-large"></i></a>
													<a href="contract-word/' . base64_encode($leave_allocation->emid) . '/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-word" style="font-size: x-large"></i></a></td>


						</tr>';
                    $f++;}
            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['employee_code'] = $employee_code;
            $data['employee_type'] = $employee_type;
            return view('appemployee/contract-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }
    public function mswordnew($emid, $emp_id)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid))
                ->first();

            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');
            $offarr = 0;
            $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

            $currency_auth = DB::table('currencies')

                ->where('code', '=', $emjob->currency)
                ->orderBy('id', 'DESC')
                ->first();
            $pay_type_auth = DB::table('payment_type_master')

                ->where('id', '=', $emjob->emp_payment_type)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($emjob->emp_department)) {

                $employee_depers = DB::table('department')
                    ->where('department_name', '=', $emjob->emp_department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table('designation')
                    ->where('designation_name', '=', $emjob->emp_designation)
                    ->where('department_code', '=', $employee_depers->id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $duty_auth = DB::table('duty_roster')
                    ->where('department', '=', $employee_depers->id)
                    ->where('designation', '=', $employee_desigrs->id)
                    ->where('employee_id', '=', base64_decode($emp_id))
                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table('shift_management')
                        ->where('department', '=', $employee_depers->id)
                        ->where('id', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_auth = DB::table('offday')
                        ->where('department', '=', $employee_depers->id)
                        ->where('shift_code', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = ($difference % 60);
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;

                        }

                        if ($off_auth->mon == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }

                }

            } else {
                $offarr = 0;
            }

            $LeaveAllocation = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
                ->where('leave_allocation.emid', '=', $Roledata->reg)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                ->get();
            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = '';
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = '';
            }

            $laeve_arr = array();
            $laeve_srt = '';
            $laeve_arr1 = array();
            $laeve_srt1 = '';

            if (count($LeaveAllocation) != 0) {
                foreach ($LeaveAllocation as $value) {
                    $laeve_arr[] = $value->leave_in_hand . '  days  ' . strtolower($value->leave_type_name);
                    $laeve_arr1[] = $value->max_no . '  days  ' . strtolower($value->leave_type_name);
                }

                $laeve_srt = implode(',', $laeve_arr);
                $laeve_srt1 = implode(',', $laeve_arr1);

            } else {
                $laeve_srt = '';
                $laeve_srt1 = '';
            }

            $address_emp = '';
            $em_name = $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname;
            $address_emp .= $emjob->emp_pr_street_no;
            if ($emjob->emp_per_village) {$address_emp .= ', ' . $emjob->emp_per_village;}
            if ($emjob->emp_pr_state) {$address_emp .= ', ' . $emjob->emp_pr_state;}if ($emjob->emp_pr_city) {$address_emp .= ', ' . $emjob->emp_pr_city;}
            if ($emjob->emp_pr_pincode) {$address_emp .= ', ' . $emjob->emp_pr_pincode;}if ($emjob->emp_pr_country) {$address_emp .= ', ' . $emjob->emp_pr_country;}

            if ($emjob->start_date != '1970-01-01') {
                if ($emjob->start_date != '') {
                    $date_con = date('d/m/Y', strtotime($emjob->start_date));}
            } else {
                $date_con = '';
            }

            $job_r = DB::table('company_job_list')

                ->where('title', '=', $emjob->emp_designation)

                ->orderBy('id', 'DESC')
                ->first();
            if (!empty($job_r)) {
                $job_p = strip_tags($job_r->des_job);

            } else {
                $job_p = '';
            }
            if (!empty($emjob->emp_payment_type)) {
                $emp_payment_type = DB::table('payment_type_master')

                    ->where('id', '=', $emjob->emp_payment_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                if (strpos($emp_payment_type->pay_type, 'Weekly') !== false) {
                    $pay_y = 'Weekly';
                } else {
                    $pay_y = $emp_payment_type->pay_type;
                }

                $offarr = $emjob->min_work;
                $rate = $emjob->min_rate;
            } else {
                $pay_y = '';
                $offarr = '';
                $rate = '';
            }
            $perwd = '';

            if (!empty($emjob->wedges_paymode)) {
                $emp_wedgpayment_type = DB::table('payment_type_wedes')

                    ->where('id', '=', $emjob->wedges_paymode)

                    ->orderBy('id', 'DESC')
                    ->first();
                $perwd = $emp_wedgpayment_type->pay_type;
            }
            $cash = '';
            if ($Roledata->logo != '') {
                $imgf = '<img src="' . env("BASE_URL") . 'public/' . $Roledata->logo . '" alt="" width="100" height="100"  >';
            } else {
                $imgf = '';
            }
            if (!empty($emjob->emp_pay_type) && $emjob->emp_pay_type == 'Bank') {
                $cash = 'BACS';} else if ($emjob->emp_pay_type == 'Cash') {$cash = 'cash';} else {
                $cash = 'BACS';
            }
            $mainadd = $Roledata->address;
            if ($Roledata->address2 != '') {
                $mainadd .= $Roledata->address2;
            }
            if ($Roledata->road != '') {
                $mainadd .= $Roledata->road;
            }
            if ($Roledata->city != '') {
                $mainadd .= $Roledata->city;
            }
            if ($Roledata->zip != '') {
                $mainadd .= $Roledata->zip;
            }
            if ($Roledata->country != '') {
                $mainadd .= $Roledata->country;
            }

            $headers = array(

                "Content-type" => "text/html",
                'name' => 'Arial', 'size' => 20, 'bold' => true,
                "Content-Disposition" => "attachment;Filename=contract.doc",

            );

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

            $content .= ' </p> ';
            $content .= $job_p;

            $content .= ' <p>The Employee will, however, be expected to carry out any other reasonable duties in line with his responsibilities to assist in the smooth operation of the business.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Medical Fitness</h3>
<p>It is a condition of the employment that the Employer is satisfied on the Employee medical fitness to carry out duties.</p>

<p>This appointment is conditional on a satisfactory Occupational Health Service/Employer Doctor assessment.</p>

<p>Should it be deemed necessary during the employment, the Employee may be required to attend for a medical examination from the Employer Doctor/Occupational Health Service.</p>
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

            $content .= '   per ';
            $content .= $pay_y;

            $content .= ' . Your salary will be paid ';
            $content .= $perwd;

            $content .= ' by ';
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
<p>The Management holiday year runs from 1st January to 31st December inclusive. Your pro-rata entitlement based on the number of hours you work, and 28 days paid holiday in each year, in addition to statutory holidays.. You are allowed to take an unpaidholiday subject to special circumstances, but it must be prior approved by the management.</p>

<p>You must obtain authorization from the Management before making any holiday arrangements. The date of holidays must be agreed with the Employer and a Holiday Request must be completed and authorized by the Employer at least 14days prior to your proposed holiday dates. <b>Any unauthorized absence for more than 10 days will be notified to the Home Office UKVI if it is required for your visa condition.</b> Furthermore, disciplinary action may be taken against you. You mustinform the management immediately if there is any change of circumstance,such as change of contact details, change of your immigration status etc.</p>
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
<p>We"ll automatically enrol you into our occupational pension scheme within two months of the start of the employment in accordance with our obligations under Part 1 of the Pensions Act 2008. You will have the option to opt out of automatic enrolment. Details of the scheme will be provided once you join.</p>
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
            $content .= '  _______________';

            $content .= '  </span></p>
<br>
    <p style="font-weight: 600;">Signed ______________________________<br>for ';
            $content .= $em_name;

            $content .= ' , <span style="float:right;">Date:';
            $content .= '  _______________';

            $content .= ' </span> </p>
  </td>
</tr>
    </tbody>
  </table>





  </body>
</html>';

            return \Response::make($content, 200, $headers);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }
    }

    public function viewemployeeagreementditshow($emid, $emp_id)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($emid))
                ->first();

            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');
            $offarr = 0;
            $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

            $currency_auth = DB::table('currencies')

                ->where('code', '=', $emjob->currency)
                ->orderBy('id', 'DESC')
                ->first();
            $pay_type_auth = DB::table('payment_type_master')

                ->where('id', '=', $emjob->emp_payment_type)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($emjob->emp_department)) {

                $employee_depers = DB::table('department')
                    ->where('department_name', '=', $emjob->emp_department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table('designation')
                    ->where('designation_name', '=', $emjob->emp_designation)
                    ->where('department_code', '=', $employee_depers->id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $duty_auth = DB::table('duty_roster')
                    ->where('department', '=', $employee_depers->id)
                    ->where('designation', '=', $employee_desigrs->id)
                    ->where('employee_id', '=', base64_decode($emp_id))
                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table('shift_management')
                        ->where('department', '=', $employee_depers->id)
                        ->where('id', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_auth = DB::table('offday')
                        ->where('department', '=', $employee_depers->id)
                        ->where('shift_code', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = ($difference % 60);
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;

                        }

                        if ($off_auth->mon == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }

                }

            } else {
                $offarr = 0;
            }

            $data['LeaveAllocation'] = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
                ->where('leave_allocation.emid', '=', $Roledata->reg)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                ->get();
            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = '';
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = '';
            }
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'date' => $emjob->emp_doj, 'date_con' => $emjob->start_date, 'date_end' => $emjob->end_date, 'job_loc' => $emjob->job_loc, 'emid' => $emjob->emid, 'emp_code' => $emjob->emp_code, 'emp_pay_scale' => $emjob->emp_pay_scale, 'em_name' => $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname, 'em_pos' => $emjob->emp_designation, 'em_depart' => $emjob->emp_department, 'address_emp' => $emjob->emp_pr_street_no . ',' . $emjob->emp_per_village . ',' . $emjob->emp_pr_state . ',' . $emjob->emp_pr_city . ',' . $emjob->emp_pr_pincode . ',' . $emjob->emp_pr_country, 'em_co' => $Roledata->country, 'currency' => $emjob->currency, 'symbol' => $symbol, 'week_time' => $offarr, 'year_time' => $years, 'pay_type' => $pay_ty, 'LeaveAllocation' => $data['LeaveAllocation'], 'birth' => $emjob->country_birth
                , 'emp_de' => $emjob, 'Roledata' => $Roledata];

            $pdf = PDF::loadView('mypdfagree', $datap);
            return $pdf->download('contract.pdf');

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function leaveapprivere($employee_id)
    {
        try {
            $employee_id = base64_decode($employee_id);
            $users = DB::table('users')->where('id', '=', $employee_id)->where('status', '=', 'active')->first();

            $emp_code = $users->employee_id;

            $LeaveApply = DB::table('leave_apply')
                ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
                ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')
                ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')

                ->where('leave_apply.emid', '=', $users->emid)
                ->where(function ($result) use ($emp_code) {
                    if ($emp_code) {
                        $result->where('leave_apply.emp_reporting_auth', $emp_code)
                            ->orWhere('leave_apply.emp_lv_sanc_auth', $emp_code);
                    }
                })

                ->orderBy('date_of_apply', 'DESC')
                ->get();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $users->emid)
                ->first();
            $data['employee_id'] = ($employee_id);

            $data['LeaveApply'] = $LeaveApply;

            return view('appemployee/leavelist', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontWebException($e->getMessage());
        }

    }

    public function leaveapprivereedit($employee_id, $id)
    {try {

        $employee_id = base64_decode($employee_id);

        $users = DB::table('users')->where('id', '=', $employee_id)->where('status', '=', 'active')->first();

        $id = base64_decode($id);

        $LeaveApply = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')

            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')
            ->where('leave_apply.id', '=', $id)
            ->where('leave_apply.emid', '=', $users->emid)
            ->first();

        // dd($data['LeaveApply']);

        $lv_aply = DB::table('leave_apply')
            ->where('id', '=', $id)
            ->pluck('employee_id');
        $lv_type = DB::table('leave_apply')
            ->where('id', '=', $id) // dd($lv_aply);
            ->first();
        $Prev_leave = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')

            ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')

            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')
            ->where('leave_apply.leave_type', '=', $lv_type->leave_type)
            ->where('leave_apply.employee_id', '=', $lv_type->employee_id)
            ->where('leave_apply.emid', '=', $users->emid)
            ->where('leave_apply.status', '=', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $from = date('Y-01-01');
        $to = date('Y-12-31');
        $totleave = DB::table('leave_apply')

            ->where('status', '=', 'APPROVED')
            ->select(DB::raw('SUM(no_of_leave) AS totleave'))

            ->where('leave_type', '=', $lv_type->leave_type)
            ->where('employee_id', '=', $lv_type->employee_id)
            ->where('emid', '=', $users->emid)
            ->whereBetween('from_date', [$from, $to])
            ->whereBetween('to_date', [$from, $to])
            ->orderBy('date_of_apply', 'desc')
            ->first();
        $data['employee_id'] = ($employee_id);

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $users->emid)
            ->first();
        if (!empty($LeaveApply)) {
            $data['LeaveApply'] = $LeaveApply;
            $data['Prev_leave'] = $Prev_leave;
            $data['totleave'] = $totleave;

            return view('appemployee/leave-approved-right', $data);

        } else {
            Session::flash('error', 'Leave not found');

            return redirect('leaveapprovelist/' . base64_encode($employee_id));

        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function SaveLeavePermission(Request $request)
    {try {
        // dd($request);
        $users = DB::table('users')->where('id', '=', $request->employeenew_id)->where('status', '=', 'active')->first();

        $Allocation = DB::table('leave_allocation')
            ->where('employee_code', '=', $request->employee_id)
            ->where('leave_type_id', '=', $request->leave_type)
            ->where('emid', '=', $users->emid)

            ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
            ->get();

        $inhand = $Allocation[0]->leave_in_hand;

        $lv_sanc_auth = DB::table('employee')
            ->where('emp_code', '=', $request->employee_id)
            ->where('emid', '=', $users->emid)

            ->first();

        if (!empty($lv_sanc_auth)) {
            $lv_sanc_auth_name = $lv_sanc_auth->emp_lv_sanc_auth;
        } else {
            $lv_sanc_auth_name = '';
        }

        if ($request->leave_check == 'APPROVED') {

            $lv_inhand = $inhand - ($request->no_of_leave);

            if ($lv_inhand < 0) {

                Session::flash('error', 'Insufficient Leave Balance ');
                return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));

            } else {
                echo 'ef';
                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocation')
                    ->where('leave_type_id', '=', $request->leave_type)
                    ->where('employee_code', '=', $request->employee_id)
                    ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    ->update(['leave_in_hand' => $lv_inhand]);

                Session::flash('message', 'Leave APPROVED Successfully!');
                return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));
            }
        } else if ($request->leave_check == 'REJECTED') {
            DB::table('leave_apply')
                ->where('id', $request->apply_id)
                ->where('employee_id', $request->employee_id)
                ->where('emid', '=', $users->emid)
                ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

            Session::flash('message', 'Leave Rejected Successfully!');
            return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));

        } else if ($request->leave_check == 'RECOMMENDED') {

            $lv_inhand = $inhand - $request->no_of_leave;
            // dd($lv_inhand);
            if ($lv_inhand < 0) {
                Session::flash('error', 'Insufficient Leave Balance');

                return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));

            } else {

                $emp_code = $request->employee_id;

                $sanc_auth = DB::table('employee')->where('emp_code', $request->employee_id)->where('emid', '=', $users->emid)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                Session::flash('message', 'Leave Recommended Successfully!');

                return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));

            }

        } else {

            $current_status = DB::table('leave_apply')->where('id', $request->apply_id)->first();
            if ($current_status->status == 'APPROVED' && $request->leave_check == 'CANCEL') {

                $lv_inhand = $inhand + $request->no_of_leave;
                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocation')
                    ->where('leave_type_id', $request->leave_type)
                    ->where('emid', '=', $users->emid)
                    ->where('employee_code', $request->employee_id)
                    ->update(['leave_in_hand' => $lv_inhand]);

            } else {
                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
            }

            Session::flash('message', 'Leave Cancel Successfully');

            return redirect('leaveapprovelist/' . base64_encode($request->employeenew_id));

        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function getemployeerepo($emp_id)
    {try {

        $reg = base64_decode($emp_id);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $reg)
            ->first();
        $data['Roledata'] = DB::table('registration')

            ->where('reg', '=', $reg)
            ->first();
        $data['employee_rs'] = DB::table('employee')
            ->join('users', 'employee.emp_code', '=', 'users.employee_id')
            ->where('employee.emid', '=', $Roledata->reg)
            ->where('users.emid', '=', $Roledata->reg)
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->get();

        return view('appemployee/employee-up', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }
    }

    public function downorganisantionrepoemployee(Request $request)
    {try {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();
        $data['Roledata'] = DB::table('registration')

            ->where('reg', '=', $request->reg)
            ->first();

        $company_rs = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $request->em_code)->orderBy('id', 'DESC')
            ->first();

        $empid = $request->em_code;
        $desig_rs = DB::table('employee')

            ->where('emp_code', '=', $empid)
            ->where('emid', '=', $Roledata->reg)
            ->first();

        $employee_rs = DB::table('employee_qualification')

            ->where('emp_id', '=', $empid)
            ->where('emid', '=', $Roledata->reg)
            ->get();

        $employee_upload_rs = DB::table('employee_upload')

            ->where('emp_id', '=', $empid)
            ->where('emid', '=', $Roledata->reg)
            ->get();
        $result = '';
        $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
        foreach ($employee_rs as $bank) {
            if ($bank->doc != '') {
                $result_status1 .= '<option value="' . $bank->quli . ' Transcript Document">' . $bank->quli . ' Transcript Document</option>';

            }
            if ($bank->doc2 != '') {
                $result_status1 .= '<option value="' . $bank->quli . ' Certificate Document">' . $bank->quli . ' Certificate Document</option>';

            }
        }

        foreach ($employee_upload_rs as $bankjj) {
            if ($bankjj->type_doc != '') {
                $result_status1 .= '<option value="' . $bankjj->type_doc . '">' . $bankjj->type_doc . '</option>';

            }

        }
        if ($desig_rs->pr_add_proof != '') {
            $result_status1 .= '<option value="pr_add_proof">Proof Of Correspondence   Address </option>';

        }
        if ($desig_rs->pass_docu != '') {
            $result_status1 .= '<option value="pass_docu">Passport    Document </option>';

        }
        if ($desig_rs->visa_upload_doc != '') {
            $result_status1 .= '<option value="visa_upload_doc">Visa    Document </option>';

        }

        $employee_otherd_doc_rs = DB::table('employee_other_doc')
            ->where('emid', '=', $Roledata->reg)
            ->where('emp_code', '=', $empid)
            ->get();
        foreach ($employee_otherd_doc_rs as $bankjjnew) {
            if ($bankjjnew->doc_upload_doc != '') {
                $result_status1 .= '<option value="' . $bankjjnew->doc_name . '">' . $bankjjnew->doc_name . '</option>';

            }

        }
        if ($desig_rs->euss_upload_doc != '') {
            $result_status1 .= '<option value="euss_upload_doc">EUSS    Document </option>';

        }
        if ($desig_rs->nat_upload_doc != '') {
            $result_status1 .= '<option value="nat_upload_doc">National Id    Document </option>';

        }
        $data['em_gan'] = $request->em_gan;
        $data['resgan'] = $result_status1;
        $data['emp_code'] = $request->em_code;

        if ($request->em_gan == 'pr_add_proof') {

            if ($company_rs->pr_add_proof != '') {
                $path = public_path() . '/' . $company_rs->pr_add_proof;
                $text = str_replace('employee_per_add/', '', $company_rs->pr_add_proof);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->pr_add_proof;

                return view('appemployee/employee-up', $data);

            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }
        }

        if ($request->em_gan == 'pass_docu') {

            if ($company_rs->pass_docu != '') {
                $path = public_path() . '/' . $company_rs->pass_docu;
                $text = str_replace('employee_doc/', '', $company_rs->pass_docu);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->pass_docu;

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }
        }

        if ($request->em_gan == 'visa_upload_doc') {

            if ($company_rs->visa_upload_doc != '') {
                $path = public_path() . '/' . $company_rs->visa_upload_doc;
                $text = str_replace('employee_vis_doc/', '', $company_rs->visa_upload_doc);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->visa_upload_doc;

                if ($company_rs->visaback_doc != '') {
                    $data['path'] .= ',' . $company_rs->visaback_doc;
                }

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }
        }

        if ($request->em_gan == 'euss_upload_doc') {

            if ($company_rs->euss_upload_doc != '') {

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->euss_upload_doc;

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }
        }
        $employee_otherd_doc_rs = DB::table('employee_other_doc')
            ->where('emid', '=', $Roledata->reg)
            ->where('emp_code', '=', $request->em_code)
            ->get();
        foreach ($employee_otherd_doc_rs as $bankjjnew) {
            if ($bankjjnew->doc_upload_doc != '' && $bankjjnew->doc_name == $request->em_gan) {

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $bankjj->doc_upload_doc;
                return view('appemployee/employee-up', $data);
            }

        }

        if ($request->em_gan == 'nat_upload_doc') {

            if ($company_rs->nat_upload_doc != '') {

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->nat_upload_doc;

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }
        }

        $word = "Transcript Document";
        $word1 = "Certificate Document";
        if (strpos($request->em_gan, $word) !== false) {

            $newstr = explode("Transcript Document", $request->em_gan);
            $new_gan = trim($newstr[0]);

            $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)->where('emp_id', '=', $request->em_code)->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
                ->first();

            if (!empty($company_uprs) && $company_uprs->doc != '') {
                $path = public_path() . '/' . $company_uprs->doc;
                $text = str_replace('employee_quli_doc/', '', $company_uprs->doc);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_uprs->doc;

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }

        } else if (strpos($request->em_gan, $word1) !== false) {

            $newstr = explode("Certificate Document", $request->em_gan);
            $new_gan = trim($newstr[0]);

            $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)->where('emp_id', '=', $request->em_code)->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
                ->first();

            if (!empty($company_uprs) && $company_uprs->doc2 != '') {
                $path = public_path() . '/' . $company_uprs->doc2;
                $text = str_replace('employee_quli_doc2/', '', $company_uprs->doc2);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_uprs->doc2;

                return view('appemployee/employee-up', $data);
            } else {
                Session::flash('message', 'File Not Uploaded.');

                return redirect('appemployee/employee-report');
            }

        }

        $employee_upload_rs = DB::table('employee_upload')

            ->where('emp_id', '=', $request->em_code)
            ->where('emid', '=', $Roledata->reg)
            ->where('type_doc', '=', $request->em_gan)
            ->get();

        if (count($employee_upload_rs) != 0) {
            foreach ($employee_upload_rs as $bankjj) {
                if ($bankjj->type_doc != '' && $bankjj->type_doc == $request->em_gan) {
                    $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                    $data['path'] = $bankjj->docu_nat;

                    return view('appemployee/employee-up', $data);

                }

            }
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontWebException($e->getMessage());
    }

    }

    public function viewattendancereport($emp_id)
    {try {

        $reg = base64_decode($emp_id);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $reg)
            ->first();
        $data['Roledata'] = DB::table('registration')

            ->where('reg', '=', $reg)
            ->first();
        $data['employee_rs'] = DB::table('employee')
            ->join('users', 'employee.emp_code', '=', 'users.employee_id')->where('employee.emid', '=', $Roledata->reg)->where('users.emid', '=', $Roledata->reg)->get();
        $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
        $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

        return view('appemployee/report-list', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function getReportAttandance(Request $request)
    {
        try {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();
            $data['Roledata'] = DB::table('registration')

                ->where('reg', '=', $request->reg)
                ->first();

            $employee_code = $request->employee_code;
            $department = $request->department;
            $designation = $request->designation;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $employee_desigrs = DB::table('designation')
                ->where('id', '=', $designation)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            $employee_depers = DB::table('department')
                ->where('id', '=', $department)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            if ($employee_code != '') {
                $job_detailstot = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

            } else {
                $job_detailstot = DB::table('employee')->where('emid', '=', $Roledata->reg)
                    ->where('emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('emp_department', '=', $employee_depers->department_name)
                    ->orderBy('id', 'DESC')->get();

            }

            $employee_depers = DB::table('department')
                ->where('id', '=', $department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            if (date('m', strtotime($end_date)) != date('m', strtotime($start_date))) {
                Session::flash('message', 'Month are not same');
                return redirect('appattendance/attendance-report/' . base64_encode($Roledata->reg));
            } else {

                $data['result'] = '';
                if (count($job_detailstot) != 0) {
                    foreach ($job_detailstot as $job_details) {

                        if ($job_details->emp_doj != '1970-01-01') {if ($job_details->emp_doj != '') {$join_date = $job_details->emp_doj;}} else {
                            $join_date = '';
                        }

                        $total_wk_days = 0;
                        $date1_ts = strtotime($start_date);
                        $date2_ts = strtotime($end_date);
                        $diff = $date2_ts - $date1_ts;

                        $total_wk_days = (round($diff / 86400) + 1);

                        $holidays = DB::table('holiday')->where('from_date', '>=', $start_date)
                            ->where('to_date', '<=', $end_date)
                            ->where('emid', '=', $Roledata->reg)
                            ->get();
                        $totday = 0;

                        $offgholi = array();
                        foreach ($holidays as $holiday) {
                            $totday = $totday + $holiday->day;
                            if ($holiday->day > 1) {

                                for ($weh = date('d', strtotime($holiday->from_date)); $weh <= date('d', strtotime($holiday->to_date)); $weh++) {
                                    if ($weh < 10 && $weh != '01') {
                                        $weh = '0' . $weh;
                                    } else if ($weh == '01') {
                                        $weh = $weh;
                                    } else {
                                        $weh = $weh;
                                    }

                                    $offgholi[] = date('Y-m', strtotime($holiday->from_date)) . '-' . $weh;
                                }
                            } else {
                                $offgholi[] = $holiday->from_date;
                            }
                        }

                        $new_off = 0;
                        $fh = 1;

                        if (date('d', strtotime($start_date)) > $total_wk_days) {
                            $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                        } else if (date('d', strtotime($start_date)) != 1) {
                            $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                        } else {
                            $total_wk_days = $total_wk_days;
                        }

                        if (date('d', strtotime($start_date)) == date('d', strtotime($end_date))) {
                            $total_wk_days = date('d', strtotime($start_date));
                        }

                        for ($we = date('d', strtotime($start_date)); $we <= $total_wk_days; $we++) {
                            if ($we < 10 && $we != '01') {
                                $we = '0' . $we;
                            } else if ($we == '01') {
                                $we = $we;
                            } else {
                                $we = $we;
                            }

                            $new_f = date('Y-m', strtotime($start_date)) . '-' . $we;
                            $duty_auth = DB::table('duty_roster')

                                ->where('employee_id', '=', $job_details->emp_code)
                                ->where('emid', '=', $Roledata->reg)

                                ->whereDate('start_date', '<=', $new_f)
                                ->whereDate('end_date', '>=', $new_f)

                                ->orderBy('id', 'ASC')
                                ->first();

                            $offg = array();
                            if (!empty($duty_auth)) {

                                $shift_auth = DB::table('shift_management')

                                    ->where('id', '=', $duty_auth->shift_code)

                                    ->where('emid', '=', $Roledata->reg)
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                $off_auth = DB::table('offday')

                                    ->where('shift_code', '=', $duty_auth->shift_code)

                                    ->where('emid', '=', $Roledata->reg)
                                    ->orderBy('id', 'DESC')
                                    ->first();

                                $off_day = 0;
                                if (!empty($off_auth)) {
                                    if ($off_auth->sun == '1') {

                                        $off_day = $off_day + 1;
                                        $offg[] = 'Sunday';
                                    }
                                    if ($off_auth->mon == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Monday';
                                    }

                                    if ($off_auth->tue == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Tuesday';
                                    }

                                    if ($off_auth->wed == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Wednesday';
                                    }

                                    if ($off_auth->thu == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Thursday';
                                    }

                                    if ($off_auth->fri == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Friday';
                                    }
                                    if ($off_auth->sat == '1') {
                                        $off_day = $off_day + 1;
                                        $offg[] = 'Saturday';
                                    }

                                }
                            }

                            if ($join_date <= $new_f) {

                                if (!empty($duty_auth)) {

                                    $employee_attendence =
                                    DB::table('employee')

                                        ->where('emp_code', '=', $job_details->emp_code)
                                        ->where('emid', '=', $Roledata->reg)

                                        ->first();

                                    $laeveppnre = DB::table('leave_apply')

                                        ->where('employee_id', '=', $job_details->emp_code)
                                        ->where('emid', '=', $Roledata->reg)
                                        ->where('from_date', '<=', $new_f)
                                        ->where('to_date', '>=', $new_f)
                                        ->where('status', '=', 'APPROVED')
                                        ->orderBy('id', 'DESC')
                                        ->first();

                                    $laeveppnrejj = DB::table('leave_apply')

                                        ->where('employee_id', '=', $job_details->emp_code)
                                        ->where('emid', '=', $Roledata->reg)
                                        ->where('from_date', '<=', $new_f)
                                        ->where('to_date', '>=', $new_f)
                                        ->where('status', '!=', 'APPROVED')
                                        ->orderBy('id', 'DESC')
                                        ->first();

                                    $add = '';
                                    if ($off_day >= 0) {
                                        if (!empty($laeveppnre) || !empty($laeveppnrejj)) {
                                            if (!empty($laeveppnre)) {
                                                $leave_typenewmm = $laeveppnre->leave_type;
                                            }
                                            if (!empty($laeveppnrejj)) {
                                                $leave_typenewmm = $laeveppnrejj->leave_type;
                                            }
                                            $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                            if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($new_f)), $offg)) {
                                                $add = 'yes';

                                            } else {
                                                $add = 'no';
                                            }

                                        } else {
                                            $add = 'no';
                                        }

                                        if ((!empty($laeveppnre) || !empty($laeveppnrejj)) && $join_date != $new_f && $add == 'no') {

                                            if (!empty($laeveppnre)) {
                                                $laeveppnrnamee = DB::table('leave_type')

                                                    ->where('id', '=', $laeveppnre->leave_type)

                                                    ->first();
                                                if ($laeveppnrnamee->leave_type_name == 'Holiday') {
                                                    $lc = 'Annual Leave';
                                                } else {
                                                    $lc = $laeveppnrnamee->leave_type_name;
                                                }
                                            }

                                            if (!empty($laeveppnrejj) && $join_date != $new_f) {
                                                $laeveppnrnamee = DB::table('leave_type')

                                                    ->where('id', '=', $laeveppnrejj->leave_type)

                                                    ->first();
                                                $lc = 'Unauthorized Absent';
                                            }
                                            $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>' . $lc . '</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						</tr>';

                                            $fh++;
                                        } else {
                                            if (in_array(date('l', strtotime($new_f)), $offg)) {

                                                if (in_array($new_f, $offgholi)) {
                                                    $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Public Holiday</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						</tr>';

                                                    $fh++;

                                                } else if ($join_date == $new_f) {
                                                    $month_entrynew = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))->where('date', '=', $new_f)->where('employee_code', '=', $job_details->emp_code)->where('emid', '=', $data['Roledata']->reg)->first();

                                                    if (count($month_entrynew) != 0) {
                                                        foreach ($month_entrynew as $month_entry) {

                                                            $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                                            $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                                            $difference = abs($dateout - $datein) / 60;
                                                            $hours = floor($difference / 60);
                                                            $minutes = ($difference % 60);
                                                            $duty_hours = $hours . ":" . $minutes;
                                                            $time_in = '';
                                                            if ($month_entry->time_in != '') {

                                                                $time_in = date('h:i a', strtotime($month_entry->time_in));
                                                            }
                                                            $time_out = '';
                                                            if ($month_entry->time_out != '') {

                                                                $time_out = date('h:i a', strtotime($month_entry->time_out));
                                                            }
                                                            $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $month_entry->employee_code . '</td>
													<td>' . $job_details->emp_fname . ' ' . $job_details->emp_mname . ' ' . $job_details->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($month_entry->date)) . '</td>
														<td>' . $time_in . '</td>
													<td>' . $month_entry->time_in_location . '</td>
														<td>' . $time_out . '</td>
													<td>' . $month_entry->time_out_location . '</td>
													<td>' . $month_entry->duty_hours . '</td>

						</tr>';

                                                            $fh++;
                                                        }
                                                    }

                                                } else {

                                                    $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Offday</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>

						</tr>';

                                                    $fh++;
                                                }

                                            } else {
                                                if (in_array($new_f, $offgholi)) {

                                                    $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Public Holiday</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						</tr>';

                                                    $fh++;
                                                } else {

                                                    $month_entrynew = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))
                                                        ->where('date', '=', $new_f)->where('employee_code', '=', $job_details->emp_code)->where('emid', '=', $data['Roledata']->reg)->get();

                                                    if (count($month_entrynew) != 0) {
                                                        foreach ($month_entrynew as $month_entry) {

                                                            $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                                            $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                                            $difference = abs($dateout - $datein) / 60;
                                                            $hours = floor($difference / 60);
                                                            $minutes = ($difference % 60);
                                                            $duty_hours = $hours . ":" . $minutes;
                                                            $time_in = '';
                                                            if ($month_entry->time_in != '') {

                                                                $time_in = date('h:i a', strtotime($month_entry->time_in));
                                                            }
                                                            $time_out = '';
                                                            if ($month_entry->time_out != '') {

                                                                $time_out = date('h:i a', strtotime($month_entry->time_out));
                                                            }
                                                            $data['result'] .= '<tr>


				<td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $month_entry->employee_code . '</td>
													<td>' . $job_details->emp_fname . ' ' . $job_details->emp_mname . ' ' . $job_details->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($month_entry->date)) . '</td>
													<td>' . $time_in . '</td>
													<td>' . $month_entry->time_in_location . '</td>
														<td>' . $time_out . '</td>
													<td>' . $month_entry->time_out_location . '</td>
													<td>' . $month_entry->duty_hours . '</td>

						</tr>';

                                                            $fh++;
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                    }

                                }

                            }
                        }

                    }

                }

            }

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            $data['employee_code'] = $request->employee_code;
            $data['department'] = $request->department;
            $data['designation'] = $request->designation;
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));

            return view('appemployee/report-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewshift($emp_idbase64)
    {
        try {
            $emp_id = base64_decode($emp_idbase64);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['employee_type_rs'] = DB::table('shift_management')->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'DESC')->get();

            return view('appemployee/shift-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewAddNewShift($emp_idbase64)
    {
        try {
            $emp_id = base64_decode($emp_idbase64);

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->get();
            if (Input::get('id')) {
                $duty_roaster=DB::table('duty_roster')->where('emid', '=',$data['Roledata']->reg)->where('shift_code', '=',Input::get('id'))->get();

                if(count($duty_roaster)>0){
                    Session::flash('error', 'Shift Information in use and cannot be updated.');
                    return redirect('approta/shift-management');
                }

                $dt = DB::table('shift_management')->where('id', '=', Input::get('id'))->first();
                if (!empty($dt)) {
                    $data['shift_management'] = DB::table('shift_management')->where('id', '=', Input::get('id'))->first();
                    $data['desig'] = DB::table('designation')->where('id', '=', $data['shift_management']->designation)->get();
                    return view('appemployee/add-new-shift', $data);
                } else {
                    $emp_id = ($emp_idbase64);

                    return redirect('approta/shift-management/' . $emp_id);
                }

            } else {
                return view('appemployee/add-new-shift', $data);
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveShiftData(Request $request)
    {

        try {
            $department_name = strtoupper(trim($request->shift_code));

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            if (isset($request->id) && $request->id != '') {

                $data = array(
                    'department' => $request->department,

                    'shift_des' => $request->shift_des,
                    'time_in' => $request->time_in,
                    'time_out' => $request->time_out,
                    'rec_time_in' => $request->rec_time_in,
                    'rec_time_out' => $request->rec_time_out,
                    'designation' => $request->designation,
                );

                $dataInsert = DB::table('shift_management')
                    ->where('id', $request->id)
                    ->update($data);
                Session::flash('message', 'Shift Information Successfully Updated.');

                $emp_id = base64_encode($request->reg);
                return redirect('approta/shift-management/' . $emp_id);

            } else {

                $ckeck_dept = DB::table('shift_management')->where('emid', $Roledata->reg)->orderBy('id', 'DESC')->first();
                if (empty($ckeck_dept)) {
                    $pid = 'SHIFT-001';
                } else {

                    $whatIWant = substr($ckeck_dept->shift_code, strpos($ckeck_dept->shift_code, "-") + 1);
                    $pid = 'SHIFT-00' . ($whatIWant + 1);
                }

                $data = array(
                    'department' => $request->department,
                    'shift_code' => $pid,
                    'shift_des' => $request->shift_des,
                    'time_in' => $request->time_in,
                    'time_out' => $request->time_out,
                    'rec_time_in' => $request->rec_time_in,
                    'rec_time_out' => $request->rec_time_out,
                    'designation' => $request->designation,
                    'emid' => $Roledata->reg,

                );

                DB::table('shift_management')->insert($data);
                Session::flash('message', 'Shift Information Successfully Saved.');

                $emp_id = base64_encode($request->reg);

                return redirect('approta/shift-management/' . $emp_id);

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewlate($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['employee_type_rs'] = DB::table('late_policy')->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

        return view('appemployee/late-list', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewAddNewlate($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->get();
        if (Input::get('id')) {
            $dt = DB::table('late_policy')->where('id', '=', Input::get('id'))->first();
            if (!empty($dt)) {
                $data['shift_management'] = DB::table('late_policy')->where('id', '=', Input::get('id'))->first();
                $data['desig'] = DB::table('designation')->where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = DB::table('shift_management')->where('id', '=', $data['shift_management']->shift_code)->get();
                return view('appemployee/add-new-late', $data);
            } else {
                $emp_id = ($emp_idbase64);

                return redirect('approta/late-policy/' . $emp_id);
            }

        } else {
            return view('appemployee/add-new-late', $data);
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function savelateData(Request $request)
    {
        try {

            $department_name = strtoupper(trim($request->shift_code));

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            if (isset($request->id) && $request->id != '') {

                $data = array(
                    'department' => $request->department,
                    'shift_code' => $request->shift_code,
                    'max_grace' => $request->max_grace,
                    'no_allow' => $request->no_allow,
                    'no_day_red' => $request->no_day_red,

                    'designation' => $request->designation,
                );

                $dataInsert = DB::table('late_policy')
                    ->where('id', $request->id)
                    ->update($data);
                Session::flash('message', 'Late Policy Information Successfully Updated.');

                $emp_id = base64_encode($request->reg);
                return redirect('approta/late-policy/' . $emp_id);

            } else {

                $data = array(
                    'department' => $request->department,
                    'shift_code' => $request->shift_code,
                    'max_grace' => $request->max_grace,
                    'no_allow' => $request->no_allow,
                    'no_day_red' => $request->no_day_red,

                    'designation' => $request->designation,
                    'emid' => $Roledata->reg,

                );

                DB::table('late_policy')->insert($data);
                Session::flash('message', 'Late Policy Information Successfully Saved.');

                $emp_id = base64_encode($request->reg);

                return redirect('approta/late-policy/' . $emp_id);

            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewoffday($emp_idbase64)
    {
        try {
            $emp_id = base64_decode($emp_idbase64);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['employee_type_rs'] = DB::table('offday')->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

            return view('appemployee/offday-list', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewAddNewoffday($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->get();
        if (Input::get('id')) {
            $dt = DB::table('offday')->where('id', '=', Input::get('id'))->first();
            $duty_roaster=DB::table('duty_roster')->where('emid', '=',$data['Roledata']->reg)->where('shift_code', '=',$dt->shift_code)->get();
                //dd($duty_roaster);

                if(count($duty_roaster)>0){
                    $emp_id = ($emp_idbase64);

                    return redirect('approta/offday/' . $emp_id);
                }

            if (!empty($dt)) {
                $data['shift_management'] = DB::table('offday')->where('id', '=', Input::get('id'))->first();
                $data['desig'] = DB::table('designation')->where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = DB::table('shift_management')->where('id', '=', $data['shift_management']->shift_code)->get();
                return view('appemployee/add-new-offday', $data);
            } else {
                $emp_id = ($emp_idbase64);

                return redirect('approta/offday/' . $emp_id);
            }

        } else {
            return view('appemployee/add-new-offday', $data);
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function saveoffdayData(Request $request)
    {try {
        $department_name = strtoupper(trim($request->shift_code));

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        if (isset($request->id) && $request->id != '') {

            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'sun' => $request->sun,
                'mon' => $request->mon,
                'tue' => $request->tue,
                'wed' => $request->wed,

                'thu' => $request->thu,
                'fri' => $request->fri,
                'sat' => $request->sat,

                'designation' => $request->designation,
            );

            $dataInsert = DB::table('offday')
                ->where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Offday Information Successfully Updated.');

            $emp_id = base64_encode($request->reg);
            return redirect('approta/offday/' . $emp_id);

        } else {

            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'sun' => $request->sun,
                'mon' => $request->mon,
                'tue' => $request->tue,
                'wed' => $request->wed,

                'thu' => $request->thu,
                'fri' => $request->fri,
                'sat' => $request->sat,

                'designation' => $request->designation,
                'emid' => $Roledata->reg,

            );

            DB::table('offday')->insert($data);
            Session::flash('message', 'Offday Information Successfully Saved.');

            $emp_id = base64_encode($request->reg);

            return redirect('approta/offday/' . $emp_id);

        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewgrace($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['employee_type_rs'] = DB::table('grace_period')->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

        return view('appemployee/grace-period-list', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewAddNewgrace($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->get();
        if (Input::get('id')) {
            $dt = DB::table('grace_period')->where('id', '=', Input::get('id'))->first();
            if (!empty($dt)) {
                $data['shift_management'] = DB::table('grace_period')->where('id', '=', Input::get('id'))->first();
                $data['desig'] = DB::table('designation')->where('id', '=', $data['shift_management']->designation)->get();
                $data['shiftc'] = DB::table('shift_management')->where('id', '=', $data['shift_management']->shift_code)->get();
                return view('appemployee/add-new-grace-period', $data);
            } else {
                $emp_id = ($emp_idbase64);

                return redirect('approta/grace-period/' . $emp_id);
            }

        } else {
            return view('appemployee/add-new-grace-period', $data);
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function savegraceData(Request $request)
    {

        try {

            $department_name = strtoupper(trim($request->shift_code));

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            if (isset($request->id) && $request->id != '') {

                $data = array(
                    'department' => $request->department,
                    'shift_code' => $request->shift_code,
                    'time_in' => $request->time_in,
                    'grace_time' => $request->grace_time,

                    'designation' => $request->designation,
                );

                $dataInsert = DB::table('grace_period')
                    ->where('id', $request->id)
                    ->update($data);
                Session::flash('message', 'Grace Period Information Successfully Updated.');

                $emp_id = base64_encode($request->reg);
                return redirect('approta/grace-period/' . $emp_id);
            } else {

                $data = array(
                    'department' => $request->department,
                    'shift_code' => $request->shift_code,
                    'time_in' => $request->time_in,
                    'grace_time' => $request->grace_time,

                    'designation' => $request->designation,
                    'emid' => $Roledata->reg,

                );

                DB::table('grace_period')->insert($data);
                Session::flash('message', 'Grace Period Information Successfully Saved.');

                $emp_id = base64_encode($request->reg);

                return redirect('approta/grace-period/' . $emp_id);

            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewroster($emp_idbase64)
    {
        try {
            $emp_id = base64_decode($emp_idbase64);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->orderBy('id', 'DESC')->get();

            return view('appemployee/roster-list', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saverosterData(Request $request)
    {try {
        $department_name = strtoupper(trim($request->shift_code));
        $emp_id = $request->reg;
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $employee_code = $request->employee_code;
        $department = $request->department;
        $designation = $request->designation;

        $employee_desigrs = DB::table('designation')
            ->where('id', '=', $designation)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_depers = DB::table('department')
            ->where('id', '=', $department)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $date = date('Y-m-d', strtotime($request->date));

        $data['result'] = '';if ($employee_code != '') {

            $leave_allocation_rs = DB::table('duty_roster')
                ->join('employee', 'duty_roster.employee_id', '=', 'employee.emp_code')
                ->where('duty_roster.employee_id', '=', $employee_code)
                ->where('employee.emp_code', '=', $employee_code)
                ->where('duty_roster.emid', '=', $Roledata->reg)
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                ->where('employee.emp_department', '=', $employee_depers->department_name)
                ->where('duty_roster.start_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                ->where('duty_roster.end_date', '<=', date('Y-m-d', strtotime($request->end_date)))
                ->select('duty_roster.*')
                ->get();
        } else {
            $leave_allocation_rs = DB::table('duty_roster')
                ->join('employee', 'duty_roster.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('duty_roster.emid', '=', $Roledata->reg)
                ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                ->where('employee.emp_department', '=', $employee_depers->department_name)
                ->where('duty_roster.start_date', '>=', date('Y-m-d', strtotime($request->start_date)))
                ->where('duty_roster.end_date', '<=', date('Y-m-d', strtotime($request->end_date)))
                ->select('duty_roster.*')
                ->get();

        }
        //dd($leave_allocation_rs);
        if ($leave_allocation_rs) {$f = 1;
            foreach ($leave_allocation_rs as $leave_allocation) {

                $employee_shift = DB::table('shift_management')
                    ->where('id', '=', $leave_allocation->shift_code)

                    ->first();
                $employee_shift_emp = DB::table('employee')
                    ->where('emp_code', '=', $leave_allocation->employee_id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $data['result'] .= '<tr>

				<td>' . $employee_depers->department_name . '</td>
				<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $employee_shift_emp->emp_fname . '  ' . $employee_shift_emp->emp_mname . '  ' . $employee_shift_emp->emp_lname . ' (' . $leave_allocation->employee_id . ')</td>
														<td>' . $employee_shift->shift_code . '   ( ' . $employee_shift->shift_des . ' )</td>


													<td>' . date('h:i a', strtotime($employee_shift->time_in)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->time_out)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->rec_time_in)) . '</td>
													<td>' . date('h:i a', strtotime($employee_shift->rec_time_out)) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->start_date)) . '</td>
															<td>' . date('d/m/Y', strtotime($leave_allocation->end_date)) . '</td>



						</tr>';
                $f++;}
        }
        $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
        $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->get();

        $data['employee_code'] = $request->employee_code;
        $data['department'] = $request->department;
        $data['designation'] = $request->designation;
        $data['designation'] = $request->designation;
        $data['start_date'] = date('Y-m-d', strtotime($request->start_date));

        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        return view('appemployee/roster-list', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewAddNewdepartmentduty($emp_idbase64)
    {
        try {
            $emp_id = base64_decode($emp_idbase64);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->orderBy('id', 'DESC')->get();

            return view('appemployee/add-new-department-roster', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function savedepartmentdutyData(Request $request)
    {try {
        $emp_id = $request->reg;

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $department = $request->department;
        $designation = $request->designation;

        $employee_desigrs = DB::table('designation')
            ->where('id', '=', $designation)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_depers = DB::table('department')
            ->where('id', '=', $department)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_duty_ros = DB::table('duty_roster')
            ->where('department', '=', $department)
            ->where('designation', '=', $designation)
            ->where('emid', '=', $Roledata->reg)
            ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))

            ->get();

        $emp_dury = array();
        if ($employee_duty_ros) {
            foreach ($employee_duty_ros as $employee_duty) {
                $emp_dury[] = $employee_duty->employee_id;
            }
        }

        $leave_allocation_rs = DB::table('employee')

            ->where('employee.emid', '=', $Roledata->reg)

            ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
            ->where('employee.emp_department', '=', $employee_depers->department_name)

            ->get();

        if ($leave_allocation_rs) {$newid = 1;
            $newnid = 1;
            foreach ($leave_allocation_rs as $leave_allocation) {

                if (in_array($leave_allocation->emp_code, $emp_dury)) {
                    $newid++;
                } else {
                    $newnid++;
                    $data = array(
                        'department' => $request->department,
                        'shift_code' => $request->shift_code,
                        'employee_id' => $leave_allocation->emp_code,

                        'start_date' => date('Y-m-d', strtotime($request->start_date)),
                        'end_date' => date('Y-m-d', strtotime($request->end_date)),
                        'designation' => $request->designation,
                        'emid' => $Roledata->reg,

                    );

                    $ckeck_dept = DB::table('duty_roster')->where('department', $request->department)->where('designation', $request->designation)->where('employee_id', $leave_allocation->emp_code)
                        ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))

                        ->where('emid', $Roledata->reg)->first();
                    if (!empty($ckeck_dept)) {

                    } else {

                        DB::table('duty_roster')->insert($data);
                    }

                }

            }

        } else {
            $emp_id = base64_encode($request->reg);
            Session::flash('message', 'No Employee Found.');
            return redirect('approta/duty-roster/' . $emp_id);
        }

        $emp_id = base64_encode($request->reg);
        if ($newnid > 1) {
            Session::flash('message', 'Duty Roster Information Successfully Saved.');
            return redirect('approta/duty-roster/' . $emp_id);
        }
        if ($newid > 1) {
            Session::flash('message', 'Department  Already Exists.  For This time Period .');
            return redirect('approta/duty-roster/' . $emp_id);
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewAddNewemployeeduty($emp_idbase64)
    {try {

        $emp_id = base64_decode($emp_idbase64);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['departs'] = DB::table('department')->where('emid', '=', $data['Roledata']->reg)->orderBy('id', 'DESC')->get();

        return view('appemployee/add-new-employee-roster', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function saveemployeedutyData(Request $request)
    {try {
        $emp_id = $request->reg;
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $department = $request->department;
        $designation = $request->designation;

        $employee_desigrs = DB::table('designation')
            ->where('id', '=', $designation)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_depers = DB::table('department')
            ->where('id', '=', $department)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        $employee_duty_ros = DB::table('duty_roster')
            ->where('department', '=', $department)
            ->where('designation', '=', $designation)
            ->where('employee_id', '=', $request->employee_id)
            ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))

            ->where('emid', '=', $Roledata->reg)
            ->first();

        if (!empty($employee_duty_ros)) {
            $emp_id = base64_encode($request->reg);
            Session::flash('message', 'Employee Id  Already Exists For This time Period .');
            return redirect('approta/duty-roster/' . $emp_id);
        } else {
            $data = array(
                'department' => $request->department,
                'shift_code' => $request->shift_code,
                'employee_id' => $request->employee_id,
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),

                'designation' => $request->designation,
                'emid' => $Roledata->reg,

            );

            DB::table('duty_roster')->insert($data);
            $emp_id = base64_encode($request->reg);
            Session::flash('message', 'Duty Roster Of Employee Information Successfully Saved.');
            return redirect('approta/duty-roster/' . $emp_id);
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewallcompanywork($emp_id)
    {

        try {
            $reg = base64_decode($emp_id);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $reg)
                ->first();
            $data['Roledata'] = DB::table('registration')

                ->where('reg', '=', $reg)
                ->first();
            $data['employee_rs'] = DB::table('employee')
                ->join('users', 'employee.emp_code', '=', 'users.employee_id')
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('users.emid', '=', $Roledata->reg)
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            return View('appemployee/employer-work-list', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveemployeedework(Request $request)
    {try {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();
        $data['Roledata'] = DB::table('registration')

            ->where('reg', '=', $request->reg)
            ->first();

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        if ($request->employee_id != 'all') {
            $leave_allocation_rs = DB::table('rota_employee')
                ->whereBetween('date', [$start_date, $end_date])
                ->where('employee_id', '=', $request->employee_id)
                ->where('emid', '=', $Roledata->reg)
                ->get();
            $leave_allocation__grouprs = DB::table('rota_employee')
                ->whereBetween('date', [$start_date, $end_date])
                ->where('employee_id', '=', $request->employee_id)
                ->where('emid', '=', $Roledata->reg)
                ->groupBy('employee_id')

                ->get();

        } else {
            $leave_allocation_rs = DB::table('rota_employee')

                ->whereBetween('date', [$start_date, $end_date])
                ->where('emid', '=', $Roledata->reg)
                ->get();
            $leave_allocation__grouprs = DB::table('rota_employee')
                ->whereBetween('date', [$start_date, $end_date])
                ->where('emid', '=', $Roledata->reg)

                ->groupBy('employee_id')
                ->get();

        }

        $data['result'] = '';
        $sum = 0;
        $hy = 0;
        if ($leave_allocation_rs) {$f = 1;

            foreach ($leave_allocation_rs as $leave_allocation) {
                $pass = DB::Table('employee')

                    ->where('emp_code', '=', $leave_allocation->employee_id)

                    ->where('emid', '=', $leave_allocation->emid)

                    ->first();

                if ($leave_allocation->file != '') {
                    $file = '
			   <a href="https://workpermitcloud.co.uk/hrms/public/' . $leave_allocation->file . '" data-toggle="tooltip" data-placement="bottom" title="Download" download>

              <img style="width: 14px;" src="https://workpermitcloud.co.uk/hrms/public/assets/img/download.png"></a>';
                } else {
                    $file = '';
                }

                $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $pass->emp_fname . '  ' . $pass->emp_mname . '  ' . $pass->emp_lname . ' (' . $pass->emp_code . ' )</td>


														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
										<td>' . $leave_allocation->in_time . '</td>

														<td>' . $leave_allocation->out_time . '</td>


														  	  <td>' . $leave_allocation->w_hours . ' Hours (  ' . $leave_allocation->w_min . ') Minutes</td>
														  	  <td>' . $leave_allocation->remarks . '</td>
												<td class="icon" style="text-align: center;">
															   ' . $file . '

															   </td>

						</tr>';
                $f++;}
        }

        $data['employee_rs'] = DB::table('employee')
            ->join('users', 'employee.emp_code', '=', 'users.employee_id')->where('employee.emid', '=', $Roledata->reg)->where('users.emid', '=', $Roledata->reg)->get();
        $data['employee_id'] = $request->employee_id;

        return View('appemployee/employer-work-list', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewattendancemonthwise($emp_id, $month_yr)
    {

        try {

            $Employeeus = DB::table('users')->where('id', '=', base64_decode($emp_id))->where('status', '=', 'active')->first();
            $employee_code = '';
            $time_out = '';
            $fetch_date = '';
            $dvalue = array();

            $daliyEmployee = DB::table('attandence')->select(DB::raw('DISTINCT date'))->distinct('date')
                ->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', base64_decode($month_yr))->where('emid', '=', $Employeeus->emid)->orderBy('id', 'asc')->get();
            if (count($daliyEmployee) != 0) {

                foreach ($daliyEmployee as $value) {

                    $attndetails = array('date' => $value->date, 'month' => base64_decode($month_yr));
                    $daliyEmployeedate = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', base64_decode($month_yr))->where('date', '=', $value->date)->where('emid', '=', $Employeeus->emid)->orderBy('id', 'asc')->get();
                    foreach ($daliyEmployeedate as $valuedate) {

                        $attndetails['log'][] = array('timein' => $valuedate->time_in, 'timeout' => $valuedate->time_out,
                            'time_in_location' => $valuedate->time_in_location, 'time_out_location' => $valuedate->time_out_location,
                            'duty_hours' => $valuedate->duty_hours);
                    }
                    $dvalue[] = array_merge($attndetails);
                }

            }
            $data['dailyattandence'] = $dvalue;

            return View('appemployee/employee-attandence', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewdailyattendancemonthwise($employer_id)
    {try {
        $date = date('Y-m-d');
        $daliyEmployee = DB::table('attandence')->select(DB::raw('DISTINCT employee_code'))->distinct('employee_code')->where('emid', '=', $employer_id)
            ->where('date', '=', $date)->orderBy('employee_name', 'asc')->get();
        $attndetails = array();
        $dvalue = array();

        if (count($daliyEmployee) != 0) {
            foreach ($daliyEmployee as $value) {

                $Roledata = DB::table('employee')->join('users', 'employee.emp_code', '=', 'users.employee_id')

                    ->where('employee.emp_code', '=', $value->employee_code)
                    ->where('employee.emid', '=', $employer_id)
                    ->where('users.emid', '=', $employer_id)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('employee.emp_code', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.emp_ps_email', DB::raw('ifnull(employee.emp_ps_phone,"") as emp_ps_phone'))
                    ->first();

                $attndetails = array('date' => $date, 'employee_code' => $value->employee_code
                    , 'emp_fname' => $Roledata->emp_fname, 'emp_mname' => $Roledata->emp_mname, 'emp_lname' => $Roledata->emp_lname);

                $daliyEmployeedate = DB::table('attandence')->where('employee_code', '=', $value->employee_code)
                    ->where('date', '=', $date)->where('emid', '=', $employer_id)->orderBy('id', 'asc')->get();

                foreach ($daliyEmployeedate as $valuedate) {

                    $attndetails['log'][] = array('timein' => $valuedate->time_in, 'timeout' => $valuedate->time_out,
                        'time_in_location' => $valuedate->time_in_location, 'time_out_location' => $valuedate->time_out_location,
                        'duty_hours' => $valuedate->duty_hours);
                }
                $dvalue[] = array_merge($attndetails);

            }
        }

        $data['dailyattandence'] = $dvalue;

        return View('appemployee/daliy-attandence', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewdutyeroster($employer_id)
    {try {
        $date = date('Y-m-d');
        $Roledata = DB::table('duty_roster')
            ->join('employee', 'duty_roster.employee_id', '=', 'employee.emp_code')
            ->join('users', 'employee.emp_code', '=', 'users.employee_id')

            ->where('employee.emid', '=', $employer_id)
            ->whereDate('duty_roster.start_date', '<=', $date)
            ->whereDate('duty_roster.end_date', '>=', $date)

            ->where('users.emid', '=', $employer_id)
            ->where('users.status', '=', 'active')
            ->where('users.user_type', '=', 'employee')
            ->select('duty_roster.*', 'employee.emp_code', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.emp_ps_email', DB::raw('ifnull(employee.emp_ps_phone,"") as emp_ps_phone'))
            ->orderBy('employee.emp_fname', 'ASC')->get();

        $dataduty = array();

        if (count($Roledata) != 0) {

            foreach ($Roledata as $valros) {

                $shift_auth = DB::table('shift_management')
                    ->where('department', '=', $valros->department)
                    ->where('id', '=', $valros->shift_code)
                    ->where('designation', '=', $valros->designation)

                    ->where('emid', '=', $valros->emid)
                    ->orderBy('id', 'DESC')
                    ->first();

                $off_auth = DB::table('offday')
                    ->where('department', '=', $valros->department)
                    ->where('shift_code', '=', $valros->shift_code)
                    ->where('designation', '=', $valros->designation)

                    ->where('emid', '=', $valros->emid)
                    ->orderBy('id', 'DESC')
                    ->first();

                $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                $difference = abs($dateout - $datein) / 60;
                $hours = floor($difference / 60);
                $minutes = ($difference % 60);
                $duty_hours = $hours;
                $offarr = array();
                $off_day = array();
                if (!empty($off_auth)) {
                    if ($off_auth->sun == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Sunday';
                    } else {
                        $offarr[] = $duty_hours;
                    }

                    if ($off_auth->mon == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Monday';
                    } else {
                        $offarr[] = $duty_hours;

                    }

                    if ($off_auth->tue == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Tuesday';
                    } else {
                        $offarr[] = $duty_hours;
                    }

                    if ($off_auth->wed == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'wednesday';
                    } else {
                        $offarr[] = $duty_hours;
                    }

                    if ($off_auth->thu == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Thursday';
                    } else {
                        $offarr[] = $duty_hours;
                    }

                    if ($off_auth->fri == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Friday';
                    } else {
                        $offarr[] = $duty_hours;
                    }
                    if ($off_auth->sat == '1') {
                        $offarr[] = '0';
                        $off_day[] = 'Saturday';
                    } else {
                        $offarr[] = $duty_hours;
                    }
                }
                $of_str = '';
                $of_str = implode(',', $offarr);
                $of_str_val = '';
                $of_str_val = implode(',', $off_day);

                if (isset($of_str) && !empty($of_str)) {
                    $of_str = $of_str;

                } else {
                    $of_str = '';
                }
                if (isset($of_str_val) && !empty($of_str_val)) {
                    $of_str_val = $of_str_val;

                } else {
                    $of_str_val = '';
                }

                if (in_array(date('l', strtotime($date)), $off_day)) {

                } else {
                    $dataduty[] = array(
                        'employee_code' => $valros->employee_id
                        , 'emp_fname' => $valros->emp_fname, 'emp_mname' => $valros->emp_mname, 'emp_lname' => $valros->emp_lname, 'shift_code' => $shift_auth->shift_code, 'shift_des' => $shift_auth->shift_des
                        , 'shift_start_time' => date('h:i a', strtotime($shift_auth->time_in)), 'shift_end_time' => date('h:i a', strtotime($shift_auth->time_out)), 'duty_hours' => $duty_hours);

                }
            }

        }
        $data['dailyattandence'] = $dataduty;

        return View('appemployee/duty-roster-employer', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function viewapprovedleave($employer_id)
    {try {
        $employer_id = base64_decode($employer_id);
        $first_day_this_year = date('Y-01-01');
        $last_day_this_year = date('Y-12-31');

        $Employee1 = DB::table('users')->where('id', '=', $employer_id)->where('status', '=', 'active')->first();

        $leaveApply = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies')
            ->where('leave_apply.employee_id', '=', $Employee1->employee_id)
            ->where('leave_apply.emid', '=', $Employee1->emid)
            ->whereDate('leave_apply.from_date', '>=', $first_day_this_year)
            ->whereDate('leave_apply.to_date', '<=', $last_day_this_year)
            ->orderBy('leave_apply.id', 'DESC')
            ->limit(5)

            ->get();

        $data['leaveApply'] = $leaveApply;

        return View('appemployee/leave-view', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewtaskadd($emp_id)
    {try {

        $Employee1 = DB::table('users')->where('id', '=', base64_decode($emp_id))->where('status', '=', 'active')->first();

        $data['Roledata'] = DB::table('registration')

            ->where('reg', '=', $Employee1->emid)
            ->first();

        $data['employee'] = DB::table('employee')
            ->where('emp_code', '=', $Employee1->employee_id)
            ->where('emid', '=', $Employee1->emid)->first();

        return View('appemployee/work-add', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewtasksave(Request $request)
    {
        try {
            $Employee1 = DB::table('users')
                ->where('employee_id', '=', $request->employee_code)
                ->where('emid', '=', $request->reg)
                ->where('status', '=', 'active')->first();

            $data['Roledata'] = DB::table('registration')

                ->where('reg', '=', $Employee1->emid)
                ->first();

            $data['employee'] = DB::table('employee')
                ->where('emp_code', '=', $request->employee_code)
                ->where('emid', '=', $request->reg)->first();

            $tot = $request->w_min + ($request->w_hours * 60);
            if ($request->has('file')) {

                $file_ps_doc = $request->file('file');
                $extension_ps_doc = $request->file->extension();
                $path_ps_doc = $request->file->store('tasks', 'public');

            } else {

                $path_ps_doc = '';

            }

            $datagg = array(
                'employee_id' => $request->employee_code,
                'emid' => $request->reg,
                'file' => $path_ps_doc,

                'w_hours' => $request->w_hours,
                'w_min' => $request->w_min,
                'in_time' => date('h:i A', strtotime($request->in_time)),
                'out_time' => date('h:i A', strtotime($request->out_time)),
                'min_tol' => $tot,
                'date' => date('Y-m-d', strtotime($request->date)),

                'remarks' => $request->remarks,
                'cr_date' => date('Y-m-d'),

            );

            DB::table('rota_employee')->insert($datagg);

            //Session::flash('message',' Tasks Added Successfully .');

            //return redirect('appemployees/task-add/'.base64_encode($Employee1->id));
            return response()->json(['msg' => 'Task Information Successfully saved.', 'status' => 'true']);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewUserConfig($emp_id)
    {try {

        $emp_id = base64_decode($emp_id);
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['users'] = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->where('employee.emid', '=', $Roledata->reg)
            ->where('users.emid', '=', $Roledata->reg)
            ->select('users.*')->where('users.user_type', '=', 'employee')
            ->orderBy('name', 'ASC')->get();

        return view('appemployee/view-users', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }
    public function viewAddLeaveType($emp_id)
    {try {
        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        return view('appemployee/manage-leave-type', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function getLeaveType($emp_id)
    {try {
        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['leave_type_rs'] = DB::table('leave_type')->where('emid', '=', $Roledata->reg)
            ->orderBy('id', 'desc')->get();
        return view('appemployee/leave-type', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function saveLeaveType(Request $request)
    {try {

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();
        $alias = trim(strtoupper($request->alies));
        if (!empty($request->id)) {
            $leavedata = DB::table('leave_type')
                ->where('emid', '=', $Roledata->reg)
                ->where('id', '!=', $request->id)
                ->where('alies', '=', $alias)
                ->first();
        } else {
            $leavedata = DB::table('leave_type')
                ->where('emid', '=', $Roledata->reg)
                ->where('alies', '=', $alias)
                ->first();
        }

        $leave_type = trim(strtoupper($request->leave_type_name));

        $validate = Validator::make($request->all(), [
            'leave_type_name' => 'required',

            'alies' => 'required',
        ],
            [
                'leave_type_name.required' => 'Leave Type required',

                'alies.required' => 'Alias is required',
            ]);
        if ($validate->fails()) {
            return redirect('applaeve/leave-management/new-leave-type/' . base64_encode($Roledata->reg))
                ->withErrors($validate)
                ->withInput();

        }

        //$data = request()->except(['_token']);
        if (!empty($leavedata)) {
            Session::flash('message', 'It is already exits.');
            return redirect('applaeve/leave-management/leave-type-listing/' . base64_encode($Roledata->reg));
        }

        $data = array(
            'leave_type_name' => trim(strtoupper($request->leave_type_name)),
            'alies' => trim(strtoupper($request->alies)),
            'remarks' => $request->remarks,
            'leave_type_status' => 'active',
            'emid' => $Roledata->reg,

        );
        if (!empty($request->id)) {
            DB::table('leave_type')
                ->where('id', $request->id)
                ->update($data);
            Session::flash('message', 'Leave Type Updated Successfully');
            return redirect('applaeve/leave-management/leave-type-listing/' . base64_encode($Roledata->reg));
        }
        if (!empty($data)) {
            DB::table('leave_type')->insert($data);

            Session::flash('message', 'Leave Type Added Successfully');
            return redirect('applaeve/leave-management/leave-type-listing/' . base64_encode($Roledata->reg));

        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function getLeaveTypeDtl($emp_id, $let_id)
    {try {

        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['holidaydtl'] = DB::Table('leave_type')->where('id', $let_id)->first();

        // dd($data);

        return view('appemployee/manage-leave-type', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }
    public function leaveRules($emp_id)
    {try {

        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['leave_type_rs'] = DB::Table('leave_type')->where('emid', '=', $Roledata->reg)->where('leave_type_status', '=', 'active')->select('id', 'leave_type_name')->get();
        $data['employee_type_rs'] = DB::Table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

        return view('appemployee/add-new-rule', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function getLeaveRules($emp_id)
    {
        try {

            $emp_id = base64_decode($emp_id);
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['leave_rule_rs'] = DB::Table('leave_rule')

                ->join('leave_type', 'leave_rule.leave_type_id', '=', 'leave_type.id')

                ->select('leave_rule.*', 'leave_type.leave_type_name')
                ->where('leave_rule_status', '=', 'active')
                ->where('leave_rule.emid', '=', $Roledata->reg)
                ->orderBy('leave_rule.id', 'desc')
                ->get();

            return view('appemployee/leave-rule', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveAddLeaveRule(Request $request)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $validator = Validator::make($request->all(), [

                'leave_type_id' => 'required|max:255',

                'max_no' => 'required|max:10',
                'employee_type' => 'required',

                'effective_from' => 'required',
                'effective_to' => 'required',
            ],
                [
                    'leave_type_id.required' => 'Leave Type Name Required',
                    'max_no.required' => 'Maximum No. Required',
                    'employee_type.required' => 'Employee Type Required',

                    'effective_from.required' => 'Effective From Required',
                    'effective_to.required' => 'Effective To Required',
                ]);

            if ($validator->fails()) {
                return redirect('applaeve/leave-management/save-leave-rule/' . base64_encode($Roledata->reg))->withErrors($validator)->withInput();

            }

            //$data=request()->except(['_token']);

            $data = $request->all();
            if (!empty($request->id)) {

                DB::table('leave_rule')
                    ->where('id', $request->id)
                    ->update(['leave_type_id' => $request->leave_type_id,
                        'max_no' => $request->max_no, 'employee_type' => $request->employee_type, 'effective_from' => $request->effective_from, 'updated_at' => date('Y-m-d h:i:s'),
                        'created_at' => date('Y-m-d h:i:s'),
                        'leave_rule_status' => 'active', 'effective_to' => $request->effective_to]);
                Session::flash('message', 'Leave Rule Information Successfully Updated.');

            } else {
                $data = array(
                    'leave_type_id' => $request->leave_type_id,
                    'max_no' => $request->max_no,

                    'employee_type' => $request->employee_type,

                    'effective_from' => $request->effective_from,
                    'effective_to' => $request->effective_to,
                    'updated_at' => date('Y-m-d h:i:s'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'leave_rule_status' => 'active',
                    'emid' => $Roledata->reg,

                );

                $check_entry = DB::table('leave_rule')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('employee_type', '=', $request->employee_type)
                    ->where('leave_type_id', '=', $request->leave_type_id)
                    ->where('effective_from', '=', $request->effective_from)
                    ->where('effective_to', '=', $request->effective_to)
                    ->first();
                if (empty($check_entry)) {
                    DB::table('leave_rule')->insert($data);
                    Session::flash('message', 'Leave Rule Information Successfully Saved.');
                } else {
                    Session::flash('message', 'Leave Rule Information alredy Exists.');
                    return redirect('applaeve/leave-management/leave-rule-listing/' . base64_encode($Roledata->reg));

                }
            }

            return redirect('applaeve/leave-management/leave-rule-listing/' . base64_encode($Roledata->reg));

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getLeaveRulesById($emp_id, $leave_rule_id)
    {
        try {

            $emp_id = base64_decode($emp_id);
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['leave_rule_data'] = DB::table('leave_rule')->where('id', $leave_rule_id)->first();

            $data['leave_type_rs'] = DB::Table('leave_type')->where('emid', '=', $Roledata->reg)->where('leave_type_status', '=', 'active')->select('id', 'leave_type_name')->get();
            $data['employee_type_rs'] = DB::Table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            return view('appemployee/add-new-rule', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewAddLeaveAllocation($emp_id)
    {try {
        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $data['result'] = '';
        $data['employees'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('status', '=', 'active')->get();
        $data['employee_type_rs'] = DB::Table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

        return view('appemployee/add-new-allocation', $data);
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function getLeaveAllocation($emp_id)
    {try {
        $emp_id = base64_decode($emp_id);
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emp_id)
            ->first();

        $data['leave_allocation'] = DB::table('leave_allocation')
            ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
            ->select('leave_allocation.*', 'leave_type.leave_type_name')
            ->whereYear('leave_allocation.created_at', '=', date('Y'))
            ->where('leave_allocation.emid', '=', $Roledata->reg)
            ->where('leave_type.emid', '=', $Roledata->reg)
            ->orderBy('leave_allocation.id', 'desc')
            ->get();
        return view('appemployee/leave-allocation', $data);

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function saveAddLeaveAllocation(Request $request)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $allocation_list = $request->all();
            if (isset($allocation_list['leave_rule_id']) && count($allocation_list['leave_rule_id']) != 0) {
                $g = 1;
                foreach ($allocation_list['leave_rule_id'] as $allocationkey => $allocation_value) {

                    $data = array(
                        'leave_type_id' => $allocation_list['leave_type_id' . $g],
                        'leave_rule_id' => $allocation_value,
                        'max_no' => $allocation_list['max_no' . $g],
                        'employee_type' => $allocation_list['employee_type' . $g],
                        'leave_in_hand' => $allocation_list['leave_in_hand' . $g],
                        'month_yr' => date('m/Y', strtotime($allocation_list['month_yr' . $g] . '-01')),
                        'employee_code' => $allocation_list['employee_code' . $g],
                        'updated_at' => date('Y-m-d h:i:s'),
                        'created_at' => date('Y-m-d h:i:s'),
                        'leave_allocation_status' => 'active',
                        'emid' => $Roledata->reg,

                    );

                    $leave_month = $this->getLeaveAllocationByYear($Roledata->reg, $allocation_value, $allocation_list['employee_code' . $g], $allocation_list['month_yr' . $g]);

                    if (empty($leave_month)) {
                        DB::table('leave_allocation')->insert($data);

                    } else {
                        Session::flash('message', 'Leave Allocation Information Already Exits.');
                        return redirect('applaeve/leave-management/leave-allocation-listing/' . base64_encode($Roledata->reg));
                    }

                    $g++;
                }

                Session::flash('message', 'Leave Allocation Information Successfully Saved.');
                return redirect('applaeve/leave-management/leave-allocation-listing/' . base64_encode($Roledata->reg));

            } else {
                Session::flash('message', 'Leave Allocation Not Selected.');
                return redirect('applaeve/leave-management/leave-allocation-listing/' . base64_encode($Roledata->reg));

            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getLeaveAllocationById($emp_id, $leave_allocation_id)
    {
        try {

            $emp_id = base64_decode($emp_id);
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $data['leave_allocation'] = DB::table('leave_allocation')->where('id', $leave_allocation_id)->first();
            $data['leave_type'] = DB::table('leave_type')->where('id', $data['leave_allocation']->leave_type_id)->first();
            return view('appemployee/edit-leave-allocation', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getAddLeaveAllocation(Request $request)
    {try {

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $request->reg)
            ->first();

        $current_year = date('Y');
        $previous_year = $current_year - 1;
        $desig_rs = DB::table('employee_type')

            ->where('employee_type_name', '=', $request->employee_type)
            ->where('emid', '=', $Roledata->reg)
            ->first();
        if ($request->employee_code != '') {
            $employeesy = DB::table('employee')->where('emp_code', '=', $request->employee_code)->where('emid', '=', $Roledata->reg)->get();
        } else {
            $employeesy = DB::table('employee')->where('emp_status', '=', $desig_rs->employee_type_name)->where('emid', '=', $Roledata->reg)->get();
        }

        $leave_allocations = DB::Table('leave_rule')
            ->leftJoin('leave_type', 'leave_rule.leave_type_id', '=', 'leave_type.id')
            ->where('leave_type.emid', '=', $Roledata->reg)
            ->whereYear('effective_from', '<=', $request->year_value . '-01-01')
            ->whereYear('effective_to', '>=', $request->year_value . '-12-31')

            ->where('leave_rule.employee_type', '=', $desig_rs->id)
            ->select('leave_rule.*', 'leave_type.leave_type_name')->get();

        $result = '';
        $i = 1;
        foreach ($employeesy as $employeesyg) {

            foreach ($leave_allocations as $leave_allocationkey => $leave_allocation) {

                //->where('month_yr','=',date('m').'/'.date('Y'))

                $leave_allocationew = DB::Table('leave_allocation')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('month_yr', 'like', '%' . $request->year_value . '%')

                    ->where('leave_rule_id', '=', $leave_allocation->id)
                    ->where('employee_code', '=', $employeesyg->emp_code)
                    ->first();

                if (empty($leave_allocationew)) {

                    $leave_in_hand = $leave_allocation->max_no;

                    $result .= '<tr>
			    <input type="hidden" value="' . $leave_allocation->leave_type_id . '" class="form-control" name="leave_type_id' . $i . '"  id="leave_type_id' . $i . '" readonly>


                <input type="hidden" value="' . $desig_rs->id . '" class="form-check-input" name="employee_type' . $i . '" id="employee_type' . $i . '"  readonly>
				  <input type="hidden" value="' . $employeesyg->emp_code . '" class="form-check-input" name="employee_code' . $i . '" id="employee_code' . $i . '"  readonly>
				<td><div class="form-check"><label class="form-check-label"><input type="checkbox" name="leave_rule_id[]" value="' . $leave_allocation->id . '"  id="leave_rule_id' . $i . '" ><span class="form-check-sign"> </span></label></div></td>
				<td>' . $desig_rs->employee_type_name . '</td>

				<td>' . $employeesyg->emp_code . '</td>
				<td>' . $employeesyg->emp_fname . ' ' . $employeesyg->emp_mname . ' ' . $employeesyg->emp_lname . '</td>
				<td>' . $leave_allocation->leave_type_name . '</td>
				<td><input type="text" value="' . $leave_allocation->max_no . '" name="max_no' . $i . '" class="form-control" id="max_no' . $i . '"  readonly style="height: 35px !important"></td>


				<td><input type="text" id="leave_in_hand' . $i . '" value="' . $leave_in_hand . '" name="leave_in_hand' . $i . '" class="form-control" style="height: 35px !important" required></td>
				<td><input type="month" id="month_yr' . $i . '"  name="month_yr' . $i . '" class="form-control"  style="height: 35px !important"  required>
				</td>

			  </tr>';
                    $i++;}
            }

        }
        $employees = DB::table('employee')
            ->where('status', '=', 'active')
            ->where('emp_status', '!=', 'TEMPORARY')
            ->where('emp_status', '!=', 'EX-EMPLOYEE')
            ->orderBy('emp_fname', 'asc')
            ->where('emp_status', '=', $desig_rs->employee_type_name)
            ->where('emid', '=', $Roledata->reg)
            ->get();

        $employee_type_rs = DB::Table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
        $remp = $request->employee_code;
        $rempty = $request->employee_type;

        return view('appemployee/add-new-allocation', compact('result', 'Roledata', 'employees', 'employee_type_rs', 'remp', 'rempty'));

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function editLeaveAllocation(Request $request)
    {
        try {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $request->reg)
                ->first();

            DB::table('leave_allocation')
                ->where('id', $request->id)
                ->update(['leave_in_hand' => $request->leave_in_hand, 'month_yr' => $request->month_yr]);
            Session::flash('message', 'Leave Allocation Information Successfully Updated.');
            return redirect('applaeve/leave-management/leave-allocation-listing/' . base64_encode($Roledata->reg));

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getLeaveAllocationByYear($reg, $leave_rule_id, $employee_code, $month_yr)
    {try {
        $mon = date('Y', strtotime($month_yr . '-01'));

        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $reg)
            ->first();

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $reg)
            ->first();
        $current_year = date('Y');
        $monthly_leave_allocation = DB::table('leave_allocation')
            ->where('employee_code', '=', $employee_code)
            ->where('leave_rule_id', '=', $leave_rule_id)
            ->where('month_yr', 'like', '%' . $mon . '%')
            ->where('emid', '=', $Roledata->reg)

            ->first();

        return $monthly_leave_allocation;

    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function allleavreqe($employee_id, $emp_id)
    {
        try {
            $employee_id = base64_decode($employee_id);
            $emp_id = base64_decode($emp_id);
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', $emp_id)
                ->first();

            $Employee = DB::table('employee')->where('emp_code', '=', $employee_id)->where('emid', '=', $emp_id)->first();

            $Employer = DB::table('registration')->where('reg', '=', $emp_id)->first();

            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');

            $data['LeaveAllocation'] = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', $employee_id)
                ->where('leave_allocation.emid', '=', $emp_id)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])
            //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies', DB::raw("(select count(*) from `leave_apply` where `leave_apply`.`employee_id` = '" . $employee_id . "' and `leave_apply`.`emid` = '" . $emp_id . "' and `leave_apply`.`status` = 'APPROVED' and `leave_apply`.`from_date` between '2022-01-01' and '2022-12-31' and `leave_apply`.`to_date` between '" . $first_day_this_year . "' and '" . $last_day_this_year . "' and `leave_apply`.`leave_type`=leave_allocation.leave_type_id) as leave_taken"))
                ->orderBy('leave_type.leave_type_name', 'ASC')
                ->get();

            // $data['LeaveTaken'] = DB::table('leave_apply1')
            //     ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            //     ->where('leave_apply.employee_id', '=', $employee_id)
            //     ->where('leave_apply.emid', '=', $emp_id)
            //     ->where('leave_apply.status', '=', 'APPROVED')
            //     ->whereBetween('leave_apply.from_date', [$first_day_this_year, $last_day_this_year])
            //     ->whereBetween('leave_apply.to_date', [$first_day_this_year, $last_day_this_year])

            //     ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies')
            //     ->orderBy('leave_type.leave_type_name', 'ASC')
            //     ->get();

            //dd($data);

            return view('appemployee/leavestatus', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

}
