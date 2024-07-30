<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
use Session;
use view;

class AppcomanyController extends Controller
{
    public function viewdash()
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['employee'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'approved')
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();
            $data['employee_incomplete'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'not approved')
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            $data['employee_constuct'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'CONTRACTUAL')
                ->get();
            $data['employee_regular'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'REGULAR')
                ->get();
            $data['employee_parttime'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'PART TIME')
                ->get();
            $data['employee_ex_empoyee'] = DB::table('employee')

                ->where('emid', '=', $data['Roledata']->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'LEFT')
                ->get();
            return View('company/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddCompanyreport($comp_id)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $Roledata = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('reg', '=', base64_decode($comp_id))
                ->first();

            $datap = ['Roledata' => $Roledata];

            $pdf = PDF::loadView('mypdforganization', $datap);
            return $pdf->download('organisationeport.pdf');
        } else {
            return redirect('/');
        }

    }

    public function getCompanies()
    {
        $email = Session::get('emp_email');
        $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data['Roledata'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        return view('company/company', $data);
    }

    public function getCompanieslink($comapny_id)
    {

        $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', base64_decode($comapny_id))
            ->first();
        $data['Roledata'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', base64_decode($comapny_id))
            ->first();

        return view('appcompany/employee-cretion-link', $data);
    }

    public function viewthank()
    {
        return view('appcompany/thank-you');

    }
    public function viewAddCompany($comapny_id)
    {

        $data['Roledata'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', base64_decode($comapny_id))
            ->first();
        $data['cuurenci_master'] = DB::table('currencies')->get();
        $data['nat_or_master'] = DB::table('nat_or')->get();
        $data['type_or_master'] = DB::table('type_or')->get();
        $data['employee_upload_rs'] = DB::table('company_upload')
            ->where('emid', '=', $data['Roledata']->reg)
            ->get();
        $data['employee_or_rs'] = DB::table('company_employee')
            ->where('emid', '=', $data['Roledata']->reg)
            ->get();
        return View('appcompany/edit-company', $data);

    }

    public function saveCompany(Request $request)
    {

        // dd($request->all());
        $role = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', $request->reg)
            ->first();

        $email = $role->email;
        if (!empty($request->imagedata)) {
            $image = $request->imagedata;
            $folderPath1 = "employee/";
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $image_name = 'thumb_' . strtotime(date('Y-m-d H:i:s')) . '.png';

            $image_base64_1 = base64_decode($request->imagedata);
            $file1 = $folderPath1 . $image_name;

            Storage::disk('public')->put($file1, $image);

            $dataimg = array(
                'logo' => $file1,
            );

            DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
        }
        if (!empty($request->imagedataproof)) {
            $image = $request->imagedataproof;
            $folderPath1 = "proof/";
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            $image_name = 'thumb_' . strtotime(date('Y-m-d H:i:s')) . '.png';

            $image_base64_1 = base64_decode($request->imagedataproof);
            $file1 = $folderPath1 . $image_name;

            Storage::disk('public')->put($file1, $image);

            $dataimg = array(
                'proof' => $file1,
            );
            DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
        }

        if ($request->has('key_proof')) {

            $file1 = $request->file('key_proof');
            $extension1 = $request->key_proof->extension();
            $path1 = $request->key_proof->store('key_proof', 'public');
            $dataimgh = array(
                'key_proof' => $path1,
            );
            DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimgh);
        }

        if ($request->has('level_proof')) {

            $file1 = $request->file('level_proof');
            $extension1 = $request->level_proof->extension();
            $path1 = $request->level_proof->store('level_proof', 'public');
            $dataimgf = array(
                'level_proof' => $path1,
            );
            DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimgf);
        }

        $dataup = array(
            'com_name' => $request->com_name,
            'f_name' => $request->f_name,
            'key_person' => $request->key_person,
            'level_person' => $request->level_person,
            'organ_email' => $request->organ_email,
            'l_name' => $request->l_name,

            'p_no' => $request->p_no,
            'pan' => $request->pan,
            'address' => $request->address,
            'website' => $request->website,
            'land' => $request->land,
            'fax' => $request->fax,

            'com_reg' => $request->com_reg,
            'com_type' => $request->com_type,
            'com_year' => $request->com_year,
            'com_nat' => $request->com_nat,
            'no_em' => $request->no_em,
            'work_per' => $request->work_per,
            'no_dire' => $request->no_dire,

            'bank_name' => $request->bank_name,
            'acconut_name' => $request->acconut_name,
            'trad_status' => $request->trad_status,
            'trad_other' => $request->trad_other,
            'penlty_status' => $request->penlty_status,
            'penlty_other' => $request->penlty_other,
            'bank_status' => $request->bank_status,
            'bank_other' => $request->bank_other,
            'sort_code' => $request->sort_code,
            'others_type' => $request->others_type,

            'nature_type' => $request->nature_type,
            'no_em_work' => $request->no_em_work,

            'country' => $request->country,
            'currency' => $request->currency,
            'desig' => $request->desig,
            'trad_name' => $request->trad_name,
            'con_num' => $request->con_num,
            'authemail' => $request->authemail,

            'address2' => $request->address2,
            'road' => $request->road,
            'city' => $request->city,
            'zip' => $request->zip,
            'updated_at' => date('Y-m-d'),

            'key_f_name' => $request->key_f_name,
            'key_f_lname' => $request->key_f_lname,
            'key_designation' => $request->key_designation,
            'key_phone' => $request->key_phone,
            'key_email' => $request->key_email,
            'key_bank_status' => $request->key_bank_status,
            'key_bank_other' => $request->key_bank_other,

            'level_f_name' => $request->level_f_name,
            'level_f_lname' => $request->level_f_lname,
            'level_designation' => $request->level_designation,
            'level_phone' => $request->level_phone,
            'level_email' => $request->level_email,
            'level_bank_status' => $request->level_bank_status,
            'level_bank_other' => $request->level_bank_other,

            'sun_status' => $request->sun_status,
            'sun_time' => $request->sun_time,
            'sun_close' => $request->sun_close,

            'mon_status' => $request->mon_status,
            'mon_time' => $request->mon_time,
            'mon_close' => $request->mon_close,

            'tue_status' => $request->tue_status,
            'tue_time' => $request->tue_time,
            'tue_close' => $request->tue_close,

            'wed_status' => $request->wed_status,
            'wed_time' => $request->wed_time,
            'wed_close' => $request->wed_close,

            'thu_status' => $request->thu_status,
            'thu_time' => $request->thu_time,
            'thu_close' => $request->thu_close,

            'fri_status' => $request->fri_status,
            'fri_time' => $request->fri_time,
            'fri_close' => $request->fri_close,

            'sat_status' => $request->sat_status,
            'sat_time' => $request->sat_time,
            'sat_close' => $request->sat_close,

        );

        $Roledatauseer = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', $request->reg)
            ->first();

        if (!empty($request->id_up_doc)) {

            $tot_item_nat_edit = count($request->id_up_doc);

            foreach ($request->id_up_doc as $valuee) {

                if ($request->input('type_doc_' . $valuee) != '') {

                    if ($request->has('docu_nat_' . $valuee)) {

                        $extension_doc_edit_up = $request->file('docu_nat_' . $valuee)->extension();

                        $path_quli_doc_edit_up = $request->file('docu_nat_' . $valuee)->store('company_upload_doc', 'public');
                        $dataimgeditup = array(
                            'docu_nat' => $path_quli_doc_edit_up,
                        );

                        DB::table('company_upload')
                            ->where('id', $valuee)
                            ->update($dataimgeditup);

                    }

                    $datauploadedit = array(
                        'emid' => $request->reg,
                        'type_doc' => $request->input('type_doc_' . $valuee),
                        'other_txt' => $request->input('other_doc_' . $valuee),

                    );
                    DB::table('company_upload')
                        ->where('id', $valuee)
                        ->update($datauploadedit);

                }
            }

        }

        if (!empty($request->type_doc)) {
            $tot_item_nat = count($request->type_doc);

            for ($i = 0; $i < $tot_item_nat; $i++) {
                if ($request->type_doc[$i] != '') {
                    if (!empty($request->docu_nat[$i])) {

                        $extension_upload_doc = $request->docu_nat[$i]->extension();
                        $path_upload_doc = $request->docu_nat[$i]->store('company_upload_doc', 'public');

                    } else {
                        $path_upload_doc = '';
                    }
                    $dataupload = array(
                        'emid' => $request->reg,
                        'type_doc' => $request->type_doc[$i],
                        'other_txt' => $request->other_doc[$i],

                        'docu_nat' => $path_upload_doc,
                    );
                    DB::table('company_upload')->insert($dataupload);
                }
            }
        }

        if ($request->licence == 'no') {

            DB::table('company_employee')->where('emid', '=', $request->reg)->delete();

            $tot_title = count($request->name);

            for ($i = 0; $i < $tot_title; $i++) {
                if ($request->name[$i] != '') {
                    $datapaywmo = array(
                        'emid' => $request->reg,

                        'name' => $request->name[$i],
                        'department' => strtoupper($request->department[$i]),
                        'designation' => strtoupper($request->designation[$i]),
                        'job_type' => strtoupper($request->job_type[$i]),
                        'immigration' => $request->immigration[$i],

                    );

                    $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
                    if (empty($lsatdeptnmdb)) {
                        $pid = 'D1';
                    } else {
                        $pid = 'D' . ($lsatdeptnmdb->id + 1);
                    }

                    $datadeprt = array(
                        'department_name' => strtoupper($request->department[$i]),
                        'emid' => $request->reg,
                        'department_code' => $pid,
                    );

                    $deptnmdb = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                    if (empty($deptnmdb)) {
                        DB::table('department')->insert($datadeprt);

                    }
                    $deptnmdbname = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                    $lsatdeptnmdgb = DB::table('designation')->orderBy('id', 'DESC')->first();
                    if (empty($lsatdeptnmdgb)) {
                        $pidf = 'DE1';
                    } else {
                        $pidf = 'DE' . ($lsatdeptnmdgb->id + 1);
                    }

                    $datadesig = array(
                        'department_code' => $deptnmdbname->id,
                        'designation_code' => $pidf,
                        'designation_name' => strtoupper($request->designation[$i]),
                        'emid' => $request->reg,
                        'designation_status' => 'active',
                    );

                    $check_designation = DB::table('designation')->where('department_code', $deptnmdbname->id)->where('designation_name', strtoupper($request->designation[$i]))->where('emid', '=', $request->reg)->first();

                    if (empty($check_designation)) {
                        DB::table('designation')->insert($datadesig);

                    }

                    $employee_type = DB::table('employee_type')->where('employee_type_name', strtoupper(trim($request->job_type[$i])))->where('emid', '=', $request->reg)->first();

                    if (empty($employee_type)) {

                        DB::table('employee_type')->insert(
                            ['employee_type_name' => strtoupper(trim($request->job_type[$i])), 'employee_type_status' => 'Active', 'emid' => $request->reg]
                        );
                    }

                    DB::table('company_employee')->insert($datapaywmo);
                }
            }
        } else {
            $or_rs = DB::table('company_employee')
                ->where('emid', '=', $request->reg)
                ->get();
            if (count($or_rs) == 0) {

                DB::table('company_employee')->where('emid', '=', $request->reg)->delete();

                $tot_title = count($request->name);

                for ($i = 0; $i < $tot_title; $i++) {
                    if ($request->name[$i] != '') {
                        $datapaywmo = array(
                            'emid' => $request->reg,

                            'name' => $request->name[$i],
                            'department' => strtoupper($request->department[$i]),
                            'designation' => strtoupper($request->designation[$i]),
                            'job_type' => strtoupper($request->job_type[$i]),
                            'immigration' => $request->immigration[$i],

                        );

                        $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
                        if (empty($lsatdeptnmdb)) {
                            $pid = 'D1';
                        } else {
                            $pid = 'D' . ($lsatdeptnmdb->id + 1);
                        }

                        $datadeprt = array(
                            'department_name' => strtoupper($request->department[$i]),
                            'emid' => $request->reg,
                            'department_code' => $pid,
                        );

                        $deptnmdb = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                        if (empty($deptnmdb)) {
                            DB::table('department')->insert($datadeprt);

                        }
                        $deptnmdbname = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                        $lsatdeptnmdgb = DB::table('designation')->orderBy('id', 'DESC')->first();
                        if (empty($lsatdeptnmdgb)) {
                            $pidf = 'DE1';
                        } else {
                            $pidf = 'DE' . ($lsatdeptnmdgb->id + 1);
                        }

                        $datadesig = array(
                            'department_code' => $deptnmdbname->id,
                            'designation_code' => $pidf,
                            'designation_name' => strtoupper($request->designation[$i]),
                            'emid' => $request->reg,
                            'designation_status' => 'active',
                        );

                        $check_designation = DB::table('designation')->where('department_code', $deptnmdbname->id)->where('designation_name', strtoupper($request->designation[$i]))->where('emid', '=', $request->reg)->first();

                        if (empty($check_designation)) {
                            DB::table('designation')->insert($datadesig);

                        }

                        $employee_type = DB::table('employee_type')->where('employee_type_name', strtoupper(trim($request->job_type[$i])))->where('emid', '=', $request->reg)->first();

                        if (empty($employee_type)) {

                            DB::table('employee_type')->insert(
                                ['employee_type_name' => strtoupper(trim($request->job_type[$i])), 'employee_type_status' => 'Active', 'emid' => $request->reg]
                            );
                        }

                        DB::table('company_employee')->insert($datapaywmo);
                    }
                }

            }

        }
        if ($Roledatauseer->created_at != '' && $Roledatauseer->updated_at == '') {

            $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email);
            $toemail = 'habibmehadi@gmail.com';
            Mail::send('mailorupnew', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'HRMSPLUS')->subject
                    ('Organisation   Update');
                $message->from('noreply@hrmplus.co.uk', 'HRMSPLUS');
            });
        }

        DB::table('registration')->where('status', '=', 'active')->where('reg', $request->reg)->update($dataup);

        //     Session::flash('message','Organisation Information Successfully saved.');

        //return response()->json(['msg'=>'Organisation Information Successfully saved.','status'=>'true']);

    }

}
