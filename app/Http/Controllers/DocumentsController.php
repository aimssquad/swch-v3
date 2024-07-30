<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportStaff;
use DB;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;
use view;

class DocumentsController extends Controller
{
    public function viewdash()
    {try {
        if (!empty(Session::get('emp_email'))) {

            return view('document/dashboard');
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function getEmployeesstaff()
    {
        try {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
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

            //dd( $data['employee_rs']);

            return view('document/employee', $data);
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function getorganisantionrepo()
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $date['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $data['company_rs'] = DB::table('company_upload')->where('emid', '=', $Roledata->reg)->get();

                return view('document/company-up', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getemployeerepo()
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $date['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
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

                return view('document/employee-up', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getemployeearchiverepo()
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $date['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
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

                return view('document/employee-up-archive', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function downorganisantionrepoemployee(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $date['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $company_rs = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $request->em_code)->orderBy('id', 'DESC')
                    ->first();

                if ($request->em_gan == 'pr_add_proof') {

                    if ($company_rs->pr_add_proof != '') {
                        $path = public_path() . '/' . $company_rs->pr_add_proof;
                        $text = str_replace('employee_per_add/', '', $company_rs->pr_add_proof);

                        $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                        $data['path'] = $company_rs->pr_add_proof;

                        return view('document/employee-up', $data);

                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
                    }
                }

                if ($request->em_gan == 'pass_docu') {

                    if ($company_rs->pass_docu != '') {
                        $path = public_path() . '/' . $company_rs->pass_docu;
                        $text = str_replace('employee_doc/', '', $company_rs->pass_docu);

                        $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                        $data['path'] = $company_rs->pass_docu;

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
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

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
                    }
                }

                if ($request->em_gan == 'euss_upload_doc') {

                    if ($company_rs->euss_upload_doc != '') {

                        $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                        $data['path'] = $company_rs->euss_upload_doc;

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
                    }
                }
                $employee_otherd_doc_rs = DB::table('employee_other_doc')
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_code', '=', $request->em_code)
                    ->get();

                //dd($employee_otherd_doc_rs);

                // $data['employee_otherd_doc_rs'] = DB::table('employee_other_doc')
                // ->where('emid', '=', $Roledata->reg)
                // ->where('emp_code', '=', $decrypted_id)
                // ->get();

                foreach ($employee_otherd_doc_rs as $bankjjnew) {
                    if ($bankjjnew->doc_upload_doc != '' && $bankjjnew->doc_name == $request->em_gan) {

                        $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                        $data['path'] = $bankjjnew->doc_upload_doc;
                        return view('document/employee-up', $data);
                    }

                }

                if ($request->em_gan == 'nat_upload_doc') {

                    if ($company_rs->nat_upload_doc != '') {

                        $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                        $data['path'] = $company_rs->nat_upload_doc;

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
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

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
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

                        return view('document/employee-up', $data);
                    } else {
                        Session::flash('message', 'File Not Uploaded.');

                        return redirect('document/employee-report');
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

                            return view('document/employee-up', $data);

                        }

                    }
                }

            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function downorganisantionrepoemployee_archive(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $date['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['paths'] = array();
                $data['em_code'] = $request->em_code;
                $data['em_gan'] = $request->em_gan;

                $company_rs = DB::table('change_circumstances_history')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $request->em_code)->orderBy('id', 'DESC')
                    ->get();

               // dd($company_rs);

                foreach ($company_rs as $cp_rs) {

                    if ($request->em_gan == 'pass_docu') {
                        //dd($cp_rs);

                        if ($cp_rs->pass_docu != '') {
                            $path = public_path() . '/' . $cp_rs->pass_docu;
                            $text = str_replace('employee_doc/', '', $cp_rs->pass_docu);

                            $data['paths'][] = $cp_rs->pass_docu;
                            $data['infos'][] = $cp_rs;
                        }
                    }

                    if ($request->em_gan == 'pr_add_proof') {

                        if ($cp_rs->pr_add_proof != '') {
                            $path = public_path() . '/' . $cp_rs->pr_add_proof;
                            $text = str_replace('employee_per_add/', '', $cp_rs->pr_add_proof);

                            $data['paths'][] = $cp_rs->pr_add_proof;
                            $data['infos'][] = $cp_rs;

                        }
                    }

                    if ($request->em_gan == 'visa_upload_doc') {

                        if ($cp_rs->visa_upload_doc != '') {
                            // dd($cp_rs);
                            $path = public_path() . '/' . $cp_rs->visa_upload_doc;
                            $text = str_replace('employee_vis_doc/', '', $cp_rs->visa_upload_doc);

                            $strVisaDocs = $cp_rs->visa_upload_doc;

                            if ($cp_rs->visaback_doc != '') {
                                $strVisaDocs .= ',' . $cp_rs->visaback_doc;
                            }
                            $data['paths'][] = $strVisaDocs;
                            $data['infos'][] = $cp_rs;

                        }
                    }

                    if ($request->em_gan == 'dbs_upload_doc') {

                        if ($cp_rs->dbs_upload_doc != '') {
                            $path = public_path() . '/' . $cp_rs->dbs_upload_doc;
                            $text = str_replace('emp_dbs/', '', $cp_rs->dbs_upload_doc);

                            $data['paths'][] = $cp_rs->dbs_upload_doc;
                            $data['infos'][] = $cp_rs;

                        }
                    }

                    // if ($request->em_gan == 'euss_upload_doc') {

                    //     if ($cp_rs->euss_upload_doc != '') {

                    //         $data['paths'][] = $cp_rs->euss_upload_doc;

                    //     }
                    // }

                    $employee_otherd_doc_rs = DB::table('circumemployee_other_doc')
                        ->where('emid', '=', $Roledata->reg)
                        ->where('emp_code', '=', $request->em_code)
                        ->get();

                    //dd($employee_otherd_doc_rs);

                    foreach ($employee_otherd_doc_rs as $bankjjnew) {
                        if ($bankjjnew->doc_upload_doc != '' && $bankjjnew->doc_name == $request->em_gan) {

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $bankjjnew->doc_upload_doc;
                            $data['infos'][] = $bankjjnew;

                        }

                    }

                    if ($request->em_gan == 'nat_upload_doc') {

                        if ($cp_rs->nat_upload_doc != '') {

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $cp_rs->nat_upload_doc;
                            $data['infos'][] = $cp_rs;

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

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $company_uprs->doc;
                            $data['infos'][] = $company_uprs;

                            //return view('document/employee-up', $data);
                        }

                    } else if (strpos($request->em_gan, $word1) !== false) {

                        $newstr = explode("Certificate Document", $request->em_gan);
                        $new_gan = trim($newstr[0]);

                        $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)->where('emp_id', '=', $request->em_code)->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
                            ->first();

                        if (!empty($company_uprs) && $company_uprs->doc2 != '') {
                            $path = public_path() . '/' . $company_uprs->doc2;
                            $text = str_replace('employee_quli_doc2/', '', $company_uprs->doc2);

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $company_uprs->doc2;
                            $data['infos'][] = $company_uprs;

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
                                //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                                $data['paths'][] = $bankjj->docu_nat;
                                $data['infos'][] = $bankjj;

                                //return view('document/employee-up', $data);

                            }

                        }
                    }

                }

                $company_rs = DB::table('change_circumstances')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $request->em_code)->orderBy('id', 'DESC')
                    ->get();

                //dd($company_rs);

                foreach ($company_rs as $cp_rs) {

                    if ($request->em_gan == 'pass_docu') {
                        //dd($cp_rs);

                        if ($cp_rs->pass_docu != '') {
                            $path = public_path() . '/' . $cp_rs->pass_docu;
                            $text = str_replace('employee_doc/', '', $cp_rs->pass_docu);

                            $data['paths'][] = $cp_rs->pass_docu;
                            $data['infos'][] = $cp_rs;
                        }
                    }

                    if ($request->em_gan == 'pr_add_proof') {

                        if ($cp_rs->pr_add_proof != '') {
                            $path = public_path() . '/' . $cp_rs->pr_add_proof;
                            $text = str_replace('employee_per_add/', '', $cp_rs->pr_add_proof);

                            $data['paths'][] = $cp_rs->pr_add_proof;
                            $data['infos'][] = $cp_rs;

                        }
                    }

                    if ($request->em_gan == 'visa_upload_doc') {

                        if ($cp_rs->visa_upload_doc != '') {
                            // dd($cp_rs);
                            $path = public_path() . '/' . $cp_rs->visa_upload_doc;
                            $text = str_replace('employee_vis_doc/', '', $cp_rs->visa_upload_doc);

                            $strVisaDocs = $cp_rs->visa_upload_doc;

                            if ($cp_rs->visaback_doc != '') {
                                $strVisaDocs .= ',' . $cp_rs->visaback_doc;
                            }
                            $data['paths'][] = $strVisaDocs;
                            $data['infos'][] = $cp_rs;

                        }
                    }
                    
                    if ($request->em_gan == 'dbs_upload_doc') {

                        if ($cp_rs->dbs_upload_doc != '') {
                            $path = public_path() . '/' . $cp_rs->dbs_upload_doc;
                            $text = str_replace('emp_dbs/', '', $cp_rs->dbs_upload_doc);

                            $data['paths'][] = $cp_rs->dbs_upload_doc;
                            $data['infos'][] = $cp_rs;

                        }
                    }

                    // if ($request->em_gan == 'euss_upload_doc') {

                    //     if ($cp_rs->euss_upload_doc != '') {

                    //         $data['paths'][] = $cp_rs->euss_upload_doc;

                    //     }
                    // }

                    $employee_otherd_doc_rs = DB::table('circumemployee_other_doc')
                        ->where('emid', '=', $Roledata->reg)
                        ->where('emp_code', '=', $request->em_code)
                        ->get();

                    //dd($employee_otherd_doc_rs);

                    foreach ($employee_otherd_doc_rs as $bankjjnew) {
                        if ($bankjjnew->doc_upload_doc != '' && $bankjjnew->doc_name == $request->em_gan) {

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $bankjjnew->doc_upload_doc;
                            $data['infos'][] = $bankjjnew;

                        }

                    }

                    if ($request->em_gan == 'nat_upload_doc') {

                        if ($cp_rs->nat_upload_doc != '') {

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $cp_rs->nat_upload_doc;
                            $data['infos'][] = $cp_rs;

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

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $company_uprs->doc;
                            $data['infos'][] = $company_uprs;

                            //return view('document/employee-up', $data);
                        }

                    } else if (strpos($request->em_gan, $word1) !== false) {

                        $newstr = explode("Certificate Document", $request->em_gan);
                        $new_gan = trim($newstr[0]);

                        $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)->where('emp_id', '=', $request->em_code)->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
                            ->first();

                        if (!empty($company_uprs) && $company_uprs->doc2 != '') {
                            $path = public_path() . '/' . $company_uprs->doc2;
                            $text = str_replace('employee_quli_doc2/', '', $company_uprs->doc2);

                            //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                            $data['paths'][] = $company_uprs->doc2;
                            $data['infos'][] = $company_uprs;

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
                                //$data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                                $data['paths'][] = $bankjj->docu_nat;
                                $data['infos'][] = $bankjj;

                                //return view('document/employee-up', $data);

                            }

                        }
                    }

                }
                // dd($data);
                return view('document/employee-up-archive', $data);

            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function downorganisantionrepo(Request $request)
    {try {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $date['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            if ($request->or_gan != 'proof') {
                $company_rs = DB::table('company_upload')->where('emid', '=', $Roledata->reg)->where('type_doc', '=', $request->or_gan)->orderBy('id', 'DESC')
                    ->first();

                $path = public_path() . '/' . $company_rs->docu_nat;
                $text = str_replace('company_upload_doc/', '', $company_rs->docu_nat);

                $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                $data['path'] = $company_rs->docu_nat;
                $data['company_rs'] = DB::table('company_upload')->where('emid', '=', $Roledata->reg)->get();

                return view('document/company-up', $data);
            } else {
                if ($Roledata->proof != 'null') {
                    $path = public_path() . '/' . $Roledata->proof;
                    $text = str_replace('proof/', '', $Roledata->proof);

                    $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
                    $data['path'] = $Roledata->proof;
                    $data['company_rs'] = DB::table('company_upload')->where('emid', '=', $Roledata->reg)->get();

                    return view('document/company-up', $data);
                } else {
                    Session::flash('message', 'File Not Uploaded.');

                    return redirect('document/organisation-report');
                }

            }
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function reportEmployeesstaff(Request $request)
    {

        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $employee_rs = DB::table('employee')
                    ->join('users', 'employee.emp_code', '=', 'users.employee_id')
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('users.emid', '=', $Roledata->reg)
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })
                    ->get();

                $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'employee_rs' => $employee_rs, 'emid' => $Roledata->reg];

                $pdf = PDF::loadView('mypdfstaff', $datap);
                $pdf->setPaper('A4', 'landscape');
                return $pdf->download('staffreport.pdf');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function reportEmployeesexcelstaff(Request $request)
    {try {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $employee_rs = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

            return Excel::download(new ExcelFileExportStaff($Roledata->reg), 'staff.xlsx');

        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function getEmployeesLeft()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_status', '=', 'LEFT')->get();

            return view('document/employee-left', $data);
        } else {
            return redirect('/');
        }
    }

}
