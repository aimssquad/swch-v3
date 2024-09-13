<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Mail;
use Exception;
use PDF;
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
             //dd($data['companies_rs']);
            //dd($data); 
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
            //dd($email);
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            return view($this->_routePrefix . '.employee-rti-link',$data);
        }else{
            return redirect('/');
        }
    }
    public function authorizingOfficer(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            // dd($email);
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                //dd($data);
            return view($this->_routePrefix . '.authorizing-officer',$data);
        }else{
            return redirect('/');
        }  
    }

    public function keyContact(Request $request) {
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
            return view($this->_routePrefix . '.key-contect',$data);
            //return view('company/employee-key-link', $data);
        }else{
            return redirect('/');
        }  
    }
    public function level1User(Request $request) {
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
            return view($this->_routePrefix . '.first-level-user',$data);
        }else{
            return redirect('/');
        } 
    }
    public function level2User(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            //dd($email);
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            return view($this->_routePrefix . '.second-level-user',$data);
        }else{
            return redirect('/');
        } 
    }

    public function pdf(){
        $email = Session::get('emp_email');
        $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data['Roledata'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
         //dd($data['companies_rs']);
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('my-profile-pdf', $data);
         return $pdf->download('profile.pdf');
        //return view($this->_routePrefix . '.profile',$data);
    }

    public function viewAddCompany()
    {
        try {
            $email = Session::get('emp_email');
            //dd(Session()->all());
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['application_status_tareq'] = DB::table('tareq_app')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->first();

                $data['cuurenci_master'] = DB::table('location_countries')->get();
                $data['nat_or_master'] = DB::table('nat_or')->get();
                $data['type_or_master'] = DB::table('type_or')->get();
                $data['employee_upload_rs'] = DB::table('company_upload')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['employee_or_rs'] = DB::table('company_employee')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                return view($this->_routePrefix . '.edit-company',$data);
                //return View('company/edit-company', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function saveCompany(Request $request)
    {
        //dd($request->all());
        try {
            if (!empty(Session::get('emp_email'))) {

                //dd($request->all());
                $email = Session::get('emp_email');

                $existingCompanyInfo = DB::table('registration')->where('status', '=', 'active')->where('email', $email)->first();
                //dd($existingCompanyInfo->licence);

                if ($request->has('image')) {

                    $file = $request->file('image');
                    $extension = $request->image->extension();
                    $path = $request->image->store('employee', 'public');
                    $dataimg = array(
                        'logo' => $path,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
                }
                if ($request->has('proof')) {

                    $file1 = $request->file('proof');
                    $extension1 = $request->proof->extension();
                    $path1 = $request->proof->store('proof', 'public');
                    $dataimg = array(
                        'proof' => $path1,
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

                if ($request->hasFile('level_proof')) {
                    $file1 = $request->file('level_proof');
                    $filename = time() . '.' . $file1->getClientOriginalExtension();
                    $path1 = $file1->storeAs('level_proof', $filename, 'public');
                    $dataimgf = [
                        'level_proof' => $path1,  // Store the relative path
                    ];
                    DB::table('registration')
                        ->where('status', '=', 'active')
                        ->where('email', $email)
                        ->update($dataimgf);
                }
                

                if ($request->hasFile('level2_proof')) {
                    $file2 = $request->file('level2_proof');
                    $filename2 = time() . '.' . $file2->getClientOriginalExtension();
                    $path2 = $file2->storeAs('level2_proof', $filename2, 'public');
                    $dataimgf2 = [
                        'level2_proof' => $path2,  // Store the relative path
                    ];
                    DB::table('registration')
                        ->where('status', '=', 'active')
                        ->where('email', $email)
                        ->update($dataimgf2);
                }

                $dataup = array(
                    'com_name' => $request->com_name,
                    'f_name' => $request->f_name,

                    'l_name' => $request->l_name,

                    'p_no' => $request->p_no,
                    'pan' => $request->pan,
                    'address' => $request->address,
                    'website' => $request->website,
                    'land' => $request->land,
                    'fax' => $request->fax,

                    'key_person' => $request->key_person,
                    'level_person' => $request->level_person,

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

                    'level2_f_name' => $request->level2_f_name,
                    'level2_f_lname' => $request->level2_f_lname,
                    'level2_designation' => $request->level2_designation,
                    'level2_phone' => $request->level2_phone,
                    'level2_email' => $request->level2_email,
                    'level2_bank_status' => $request->level2_bank_status,
                    'level2_bank_other' => $request->level2_bank_other,

                    'trad_status' => $request->trad_status,
                    'trad_other' => $request->trad_other,
                    'penlty_status' => $request->penlty_status,
                    'penlty_other' => $request->penlty_other,
                    'bank_status' => $request->bank_status,
                    'bank_other' => $request->bank_other,

                    'com_reg' => $request->com_reg,
                    'com_type' => $request->com_type,
                    'com_year' => $request->com_year,
                    'com_nat' => $request->com_nat,
                    'no_em' => $request->no_em,
                    'work_per' => $request->work_per,
                    'no_dire' => $request->no_dire,

                    'bank_name' => $request->bank_name,
                    'acconut_name' => $request->acconut_name,
                    'organ_email' => $request->organ_email,
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

                    'licence' => $request->licence,
                    'verify' => $request->verify,
                    'verified_on' => $request->verified_on,
                    //'status' => $request->status,
                    'license_type' => $request->license_type,

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
                                $size = $request->file('docu_nat_' . $valuee)->getSize();

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

                if ($existingCompanyInfo->verify == 'not approved' && $request->verify == 'approved') {
                    //     //mail to case worker for assignment of organisation
                    //     $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been verified for license apply. Please proceed with the needful.');

                    //     //$toemail = 'm.subhasish@gmail.com';
                    //     $toemail = 'hr@workpermitcloud.co.uk';
                    //     Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                    //         $message->to($toemail, 'Workpermitcloud')->subject
                    //             ('Organisation License Applied');
                    //         $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    //     });
                    //     // $toemail = 'invoice@workpermitcloud.co.uk';
                    //     // Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                    //     //     $message->to($toemail, 'Workpermitcloud')->subject
                    //     //         ('Organisation License Applied');
                    //     //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    //     // });
                
                    $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 1st Invoice.<p> Organisation with name "' . $existingCompanyInfo->com_name . '" .</p><p>Invoice Amount: £1500 plus VAT</p>');

                    $toemail = 'invoice@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License invoice');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    if($existingCompanyInfo->authemail !=null || trim($existingCompanyInfo->authemail) !=''){
                            
                        $toemail = $existingCompanyInfo->authemail;
                        Mail::send('mailsmslaprior', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Need your action to complete sponsorship licence application');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });
                        $toemail = "m.subhasish@gmail.com";
                        Mail::send('mailsmslaprior', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Need your action to complete sponsorship licence application');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });
                    }                    

                }

                if ($existingCompanyInfo->licence != 'yes' && $request->licence == 'yes' ) {
                    //mail to case worker for assignment of organisation
                    $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the HR File.');

                    //$toemail = 'm.subhasish@gmail.com';
                    $toemail = 'hr@workpermitcloud.co.uk';
                    //$toemail = 'manager@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('New Unassigned HR');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the Recruitement File.');

                    //$toemail = 'm.subhasish@gmail.com';
                    $toemail = 'recruitment@workpermitcloud.co.uk';
                    //$toemail = 'manager@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('New Recruitment organisation');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    $toemail = 'm.subhasish@gmail.com';
                    // $toemail = 'hr@workpermitcloud.co.uk';
                    //$toemail = 'manager@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('New Unassigned HR');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the Recruitement File.');

                    $toemail = 'm.subhasish@gmail.com';
                    // $toemail = 'recruitment@workpermitcloud.co.uk';
                    //$toemail = 'manager@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('New Recruitment organisation');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                     //$data = array('to_name' => '', 'body_content' => 'First license invoice need to be raised for Organisation with name "' . $existingCompanyInfo->com_name . '". Please proceed with the needful.');
                    if($existingCompanyInfo->authemail !=null || trim($existingCompanyInfo->authemail) !=''){
                            
                        $toemail = $existingCompanyInfo->authemail;
                        Mail::send('mailsmsla', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Need action to prepare HR File');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });
                    }        
                    $toemail = 'm.subhasish@gmail.com';
                        Mail::send('mailsmsla', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Need action to prepare HR File');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });            


                }

                if ($Roledatauseer->created_at != '' && $Roledatauseer->updated_at == '') {

                    $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email);
                    $toemail = 'admin@workpermitcloud.co.uk';
                    Mail::send('mailorupnew', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Organisation Update');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                }

                DB::table('registration')->where('status', '=', 'active')->where('reg', $request->reg)->update($dataup);
                //DB::table('registration')->where('reg', $request->reg)->update($dataup);

                Session::flash('message', 'Organisation Information Successfully saved.');
                return redirect('organization/profile');
            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


}
