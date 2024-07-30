<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;

class LandingApiController extends Controller
{

    public function getregis(Request $request)
    {

        $Employee = DB::table('registration')->where('email', '=', $request->email)->first();

        if (empty($Employee)) {
            $employee_pid = DB::table('registration')

                ->orderBy('id', 'DESC')

                ->first();
            if (empty($employee_pid)) {
                $pid = 'EM1';
            } else {
                $pid = 'EM' . ($employee_pid->id + 1);
            }

            $data = array(
                'com_name' => $request->com_name,
                'f_name' => $request->f_name,

                'l_name' => $request->l_name,
                'reg' => $pid,
                'email' => $request->email,
                'organ_email' => $request->email,
                'p_no' => $request->p_no,
                'pass' => $request->pass,
                'status' => 'active',
                'verify' => 'not approved',
                'licence' => 'no',
                'created_at' => date('Y-m-d'),

            );

            DB::table('registration')->insert($data);
            $datauser = array(
                'name' => $request->com_name,
                'user_type' => 'employer',

                'status' => 'active',
                'employee_id' => $pid,
                'email' => $request->email,

                'updated_at' => date('Y-m-d h:i:s'),
                'created_at' => date('Y-m-d h:i:s'),
                'password' => $request->pass,

            );
            DB::table('users')->insert($datauser);

            $le_type = DB::table('le_type')->get();

            foreach ($le_type as $value_le) {
                $datauserleave = array(
                    'leave_type_name' => $value_le->leave_type_name,
                    'alies' => $value_le->alies,

                    'remarks' => $value_le->remarks,
                    'emid' => $pid,
                    'leave_type_status' => 'active',

                );
                DB::table('leave_type')->insert($datauserleave);
            }

            $em_type = DB::table('em_type')->get();

            foreach ($em_type as $value_em) {
                $datauseremployty = array(
                    'employee_type_name' => $value_em->name,

                    'emid' => $pid,
                    'employee_type_status' => 'Active',

                );
                DB::table('employee_type')->insert($datauseremployty);
            }

            $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email, 'desig' => $request->desig);
            $toemail = 'habibmehadi@gmail.com';
            Mail::send('mailre', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Organisation   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $datamail = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email, 'desig' => $request->desig);
            $toemail = 'admin@workpermitcloud.co.uk';
            Mail::send('mailre', $datamail, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Organisation   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email, 'pass' => $request->pass);
            $toemail = $request->email;
            Mail::send('mailor', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Welcome to Work Permit Cloud HR Management System');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $Employee = DB::table('registration')->where('reg', '=', $pid)->first();
            return response()->json(['msg' => 'Thank you for Registration', 'status' => 'true', 'email' => $request->email, 'company name' => $request->com_name
                , 'First name' => $request->f_name, 'Last name' => $request->l_name, 'Registration Id' => $pid, 'Phone No' => $request->p_no, 'address' => $Employee->address, 'website' => $Employee->website]);

        } else {
            return response()->json(['msg' => 'Email id already exits.', 'status' => 'false']);

        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function getlogin(Request $request)
    {

        $Employee1 = DB::table('users')->where('email', '=', $request->email)->where('password', '=', $request->psw)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employee = DB::table('employee')->where('emp_code', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->first();

                $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->where('status', '=', 'active')->first();
                if (!empty($Employer)) {

                    $Roles_auth = DB::table('role_authorization')
                        ->where('emid', '=', $Employee->emid)
                        ->where('member_id', '=', $request->email)
                        ->get()->toArray();
                    $arrrole = array();
                    foreach ($Roles_auth as $valrol) {
                        $arrrole[] = $valrol->menu;
                    }
                    $laeve_ap = '';

                    if (in_array('50', $arrrole)) {
                        $laeve_ap = 'yes';
                    } else {
                        $laeve_ap = 'No';
                    }
                    $contact = '';

                    if ($Employee->emp_status == 'CONTRACTUAL' || $Employee->emp_status == 'FULL TIME' || $Employee->emp_status == 'PART TIME') {
                        $contact = 'yes';
                    } else {
                        $contact = 'No';
                    }

                    return response()->json(['msg' => 'Login successfully', 'status' => 'true', 'Company Name' => $Employer->com_name, 'user_type' => 'employee', 'Company Logo' => $Employer->logo, $Employee, 'user_id' => $Employee1->id, 'Leave_approver' => $laeve_ap, 'Contract_agrrement' => $contact]);

                } else {
                    return response()->json(['msg' => 'You are not active!', 'status' => 'false']);
                }

            } else if ($Employee1->user_type == 'employer') {
                $Employee = DB::table('registration')->where('email', '=', $request->email)->where('pass', '=', $request->psw)->first();

                $employee_active = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employee->reg)
                    ->where('users.emid', '=', $Employee->reg)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('users.*')->get();
                $employee_migarnt = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employee->reg)
                    ->where('users.emid', '=', $Employee->reg)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('employee.*')->get();
                $t = 0;
                if (count($employee_migarnt) != 0) {

                    foreach ($employee_migarnt as $mirga) {

                        if ($mirga->visa_exp_date != '1970-01-01') {

                            if ($mirga->visa_exp_date != 'null') {
                                if ($mirga->visa_exp_date != '') {
                                    $t++;
                                }
                            }

                        }

                    }
                }

                return response()->json(['status' => 'true', $Employee, 'user_type' => 'employer', 'employer_user_id' => $Employee1->id]);

            } else {

                return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
            }
        } else {

            return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function getloginemployer(Request $request)
    {

        $Employee1 = DB::table('users')->where('email', '=', $request->email)->where('password', '=', $request->psw)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employer') {
                $Employee = DB::table('registration')->where('email', '=', $request->email)->where('pass', '=', $request->psw)->first();

                return response()->json(['status' => 'true', $Employee]);

            } else {
                return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);

            }
        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function getviewemployer(Request $request)
    {
        if ($request->reg != '') {

            $Roledata = DB::table('registration')

                ->where('reg', '=', $request->reg)
                ->first();
            $cuurenci_master = DB::table('currencies')->get();
            $nat_or_master = DB::table('nat_or')->get();
            $type_or_master = DB::table('type_or')->get();
            $employee_upload_rs = DB::table('company_upload')
                ->where('emid', '=', $Roledata->reg)
                ->get();
            $traid_pre = array('0 to 6 months', 'Over 6 to 12 months', 'Over 12 to 18 months', 'Over 18 to 36 months', 'Over 36 months+');
            $other_pre = array('Tier 1', 'Tier 2 (General)', 'Tier 2 (ICT)', 'Tier 2 (Other)', 'Tier 5', 'International Job Permit', 'others-permit');
            $type_doc = array('Registered Business License or Certificate', 'Business Bank statement for 3 Month', 'Proof of Business Premises (Tenancy Agreement)', 'Franchise Agreement', 'Copy Of Lease Or Freehold Property', 'Employer Liability Insurance Certificate', 'PAYEE And Account Reference Letter From HMRC', 'Governing Body Registration', 'Copy Of Health & Safety Star Rating', 'VAT Certificate (if you have', 'Audited Annual Account (if you have)', 'Others Document');

            return response()->json(['status' => 'true', $Roledata, $type_or_master, $traid_pre, $nat_or_master, $other_pre, $cuurenci_master, $type_doc, $employee_upload_rs]);

        } else {
            return response()->json(['msg' => 'Registration id not found!', 'status' => 'false']);

        }

    }

    public function getviewemployeemployelinkr(Request $request)
    {
        if ($request->reg != '') {

            $Roledata = DB::table('registration')

                ->where('reg', '=', $request->reg)
                ->first();

            return response()->json(['status' => 'true', $Roledata]);

        } else {
            return response()->json(['msg' => 'Registration id not found!', 'status' => 'false']);

        }

    }

    public function getimageemployer(Request $request)
    {

        $content = $request->json()->all();
        if ($content['reg'] != '') {

            $Roledata = DB::table('registration')

                ->where('reg', '=', $content['reg'])
                ->first();

            if (!empty($content['logo'])) {

                $folderPath1 = "employee/";

                $image_base64_1 = base64_decode($content['logo']);
                $file1 = $folderPath1 . uniqid() . '.' . 'jpeg';

                Storage::disk('public')->put($file1, $image_base64_1);
                $dataimg = array(
                    'logo' => $file1,
                );
                DB::table('registration')
                    ->where('reg', '=', $content['reg'])
                    ->update($dataimg);
                $Employee1 = DB::table('registration')

                    ->where('reg', '=', $content['reg'])
                    ->first();

                return response()->json(['msg' => 'Successfullly Updated', 'resultstatus' => 'true', 'logo' => $Employee1->logo]);

            } else {
                $Employee2 = DB::table('registration')

                    ->where('reg', '=', $content['reg'])
                    ->first();
                return response()->json(['msg' => 'not updated', 'resultstatus' => 'false', 'logo' => $Employee2->logo]);

            }

        }

    }

    public function updateemployerpro(Request $request)
    {

        $content = $request->json()->all();
        if ($content['reg'] != '') {

            $dataup = array(
                'com_name' => $content['com_name'],
                'f_name' => $content['f_name'],

                'l_name' => $content['l_name'],

                'p_no' => $content['p_no'],
                'pan' => $content['pan'],
                'address' => $content['address'],
                'website' => $content['website'],
                'fax' => $content['fax'],

                'com_reg' => $content['com_reg'],
                'com_type' => $content['com_type'],
                'com_year' => $content['com_year'],
                'com_nat' => $content['com_nat'],
                'no_em' => $content['no_em'],
                'work_per' => $content['work_per'],
                'no_dire' => $content['no_dire'],

                'bank_name' => $content['bank_name'],
                'acconut_name' => $content['acconut_name'],

                'sort_code' => $content['sort_code'],
                'others_type' => $content['others_type'],

                'nature_type' => $content['nature_type'],
                'no_em_work' => $content['no_em_work'],

                'country' => $content['country'],
                'currency' => $content['currency'],
                'desig' => $content['desig'],
                'trad_name' => $content['trad_name'],
                'con_num' => $content['con_num'],
                'authemail' => $content['authemail'],

                'address2' => $content['address2'],
                'road' => $content['road'],
                'city' => $content['city'],
                'zip' => $content['zip'],
                'updated_at' => date('Y-m-d'),
            );

            if (array_key_exists('type_of_doc', $content['company_up_det'])) {
                $totalimmgdet = count($content['company_up_det']['type_of_doc']);

                // print_r($totalimmgdet);die;

                for ($j = 0; $j < $totalimmgdet; $j++) {
                    if ($content['company_up_det']['type_of_doc'][$j]['id'] != '') {

                        if ($content['company_up_det']['type_of_doc'][$j]['docu_nat'] != '') {

                            $folderPath10 = "company_upload_doc/";

                            $image_base64_10 = base64_decode($content['company_up_det']['type_of_doc'][$j]['docu_nat']);
                            $file10 = $folderPath10 . uniqid() . '.' . 'jpeg';

                            Storage::disk('public')->put($file10, $image_base64_10);

                            $dataimgeditup = array(

                                'type_doc' => $content['company_up_det']['type_of_doc'][$j]['type_doc'],
                                'other_txt' => $content['company_up_det']['type_of_doc'][$j]['other_txt'],

                                'docu_nat' => $file10,
                            );

                            DB::table('company_upload')
                                ->where('id', $content['company_up_det']['type_of_doc'][$j]['id'])
                                ->where('emid', '=', $content['reg'])

                                ->update($dataimgeditup);
                        } else {
                            $dataimgeditup = array(

                                'type_doc' => $content['company_up_det']['type_of_doc'][$j]['type_doc'],
                                'other_txt' => $content['company_up_det']['type_of_doc'][$j]['other_txt'],
                            );

                            DB::table('company_upload')
                                ->where('id', $content['company_up_det']['type_of_doc'][$j]['id'])
                                ->where('emid', '=', $content['reg'])

                                ->update($dataimgeditup);

                        }
                    } else {

                        if ($content['company_up_det']['type_of_doc'][$j]['docu_nat'] != '') {
                            $folderPath11 = "company_upload_doc/";

                            $image_base64_11 = base64_decode($content['company_up_det']['type_of_doc'][$j]['docu_nat']);
                            $file11 = $folderPath11 . uniqid() . '.' . 'jpeg';

                            Storage::disk('public')->put($file11, $image_base64_11);
                        } else {
                            $file11 = '';
                        }

                        $dataupload = array(

                            'type_doc' => $content['company_up_det']['type_of_doc'][$j]['type_doc'],
                            'other_txt' => $content['company_up_det']['type_of_doc'][$j]['other_txt'],
                            'emid' => $content['reg'],
                            'docu_nat' => $file11,
                        );
                        DB::table('company_upload')->insert($dataupload);

                    }
                }
            }

            $Roledatauseer = DB::table('registration')

                ->where('reg', '=', $content['reg'])
                ->first();

            if ($Roledatauseer->created_at != '' && $Roledatauseer->updated_at == '') {

                $data = array('f_name' => $content['f_name'], 'l_name' => $content['l_name'], 'com_name' => $content['com_name'], 'p_no' => $content['p_no'], 'email' => $Roledatauseer['email']);

                $toemail = 'habibmehadi@gmail.com';
                Mail::send('mailorupnew', $data, function ($message) use ($toemail) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ('Organisation   Update');
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });
            }
            DB::table('registration')->where('reg', '=', $content['reg'])->update($dataup);

            return response()->json(['msg' => 'Successfullly Updated', 'resultstatus' => 'true']);

        } else {

            return response()->json(['msg' => 'not updated', 'resultstatus' => 'false']);

        }

    }

    public function getimage(Request $request)
    {

        $content = $request->json()->all();

        $Employee = DB::table('users')->where('id', '=', $content['user_id'])->where('status', '=', 'active')->where('user_type', '!=', 'admin')->first();

        if ($Employee->user_type == 'employee') {

            if (!empty($content['emp_image'])) {

                $folderPath1 = "employee_logo/";

                $image_base64_1 = base64_decode($content['emp_image']);
                $file1 = $folderPath1 . uniqid() . '.' . 'jpeg';

                Storage::disk('public')->put($file1, $image_base64_1);
                $dataimg = array(
                    'emp_image' => $file1,
                );
                DB::table('employee')
                    ->where('emp_code', $Employee->employee_id)
                    ->where('emid', '=', $Employee->emid)
                    ->update($dataimg);
                $Employee1 = DB::table('employee')->where('emp_code', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->first();

                return response()->json(['msg' => 'Successfullly Updated', 'resultstatus' => 'true', 'emp_image' => $Employee1->emp_image]);

            } else {
                $Employee2 = DB::table('employee')->where('emp_code', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->first();
                return response()->json(['msg' => 'not updated', 'resultstatus' => 'false', 'emp_image' => $Employee2->emp_image]);

            }

        }

    }

    public function getemplyerprofile(Request $request)
    {

        $content = $request->json()->all();
        $Employee = DB::table('users')->where('email', '=', $content['email'])->where('status', '=', 'active')->first();
        if (empty($Employee)) {

            $employee_pid = DB::table('registration')

                ->orderBy('id', 'DESC')

                ->first();
            if (empty($employee_pid)) {
                $pid = 'EM1';
            } else {
                $pid = 'EM' . ($employee_pid->id + 1);
            }

            $datareg = array(
                'com_name' => $content['com_name'],
                'f_name' => $content['f_name'],

                'l_name' => $content['l_name'],
                'reg' => $pid,
                'email' => $content['email'],
                'organ_email' => $content['email'],
                'status' => 'active',
                'verify' => 'not approved',
                'licence' => 'no',

                'p_no' => $content['p_no'],
                'pass' => $content['pass'],
                'created_at' => date('Y-m-d'),

            );
            DB::table('registration')->insert($datareg);
            $datauser = array(
                'name' => $content['com_name'],
                'user_type' => 'employer',

                'status' => 'active',
                'employee_id' => $pid,
                'email' => $content['email'],

                'updated_at' => date('Y-m-d h:i:s'),
                'created_at' => date('Y-m-d h:i:s'),
                'password' => $content['pass'],

            );
            DB::table('users')->insert($datauser);

            $le_type = DB::table('le_type')->get();

            foreach ($le_type as $value_le) {
                $datauserleave = array(
                    'leave_type_name' => $value_le->leave_type_name,
                    'alies' => $value_le->alies,

                    'remarks' => $value_le->remarks,
                    'emid' => $pid,
                    'leave_type_status' => 'active',

                );
                DB::table('leave_type')->insert($datauserleave);
            }

            $em_type = DB::table('em_type')->get();

            foreach ($em_type as $value_em) {
                $datauseremployty = array(
                    'employee_type_name' => $value_em->name,

                    'emid' => $pid,
                    'employee_type_status' => 'Active',

                );
                DB::table('employee_type')->insert($datauseremployty);
            }

            $data = array('f_name' => $content['f_name'], 'l_name' => $content['l_name'], 'com_name' => $content['com_name'], 'p_no' => $content['p_no'], 'email' => $content['email'], 'desig' => $content['desig']);
            $toemail = 'habibmehadi@gmail.com';
            Mail::send('mailre', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Organisation   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $datamail = array('f_name' => $content['f_name'], 'l_name' => $content['l_name'], 'com_name' => $content['com_name'], 'p_no' => $content['p_no'], 'email' => $content['email'], 'desig' => $content['desig']);
            $toemail = 'admin@workpermitcloud.co.uk';
            Mail::send('mailre', $datamail, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Organisation   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $datam = array('f_name' => $content['f_name'], 'l_name' => $content['l_name'], 'com_name' => $content['com_name'], 'p_no' => $content['p_no'], 'email' => $content['email'], 'password' => $content['pass']);
            $toemail = $content['email'];
            Mail::send('mailor', $datam, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Login   Details');
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            return response()->json(['msg' => 'Thank you for Registration.', 'resultstatus' => 'true']);

        } else {
            return response()->json(['msg' => 'Email id already exits.', 'resultstatus' => 'false']);

        }

    }

    public function saveemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->user_id)->where('status', '=', 'active')->first();

        if ($Employee1->user_type == 'employer') {$Employee = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

            return response()->json(['status' => 'true', 'email' => $Employee->email, 'company name' => $Employee->com_name
                , 'First name' => $Employee->f_name, 'Last name' => $Employee->l_name, 'Registration Id' => $Employee->reg, 'Phone No' => $Employee->p_no, 'user type' => $Employee1->user_type, 'Company Name' => $Employee->com_name, 'Company Logo' => $Employee->logo]);

        } else if ($Employee1->user_type == 'employee') {
            $Employee = DB::table('employee')->where('emp_code', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->first();

            $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();

            $employeelists = DB::table('employee')->where('emid', '=', $Employer->reg)->where('emp_code', '!=', $Employee1->employee_id)->select('employee.emp_code', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')->get();
            $grade = DB::table('grade')->where('emid', '=', $Employer->reg)->where('grade_status', '=', 'active')->get();
            $tax_master = DB::table('tax_master')->where('emid', '=', $Employer->reg)->get();
            $payment_type_master = DB::table('payment_type_master')->where('emid', '=', $Employer->reg)->get();
            $bank = DB::table('bank_masters')->get();
            $Employee_employee_job = DB::table('employee_job')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employer->reg)->get()->toArray();

            $Employee_employee_pay_structure = DB::table('employee_pay_structure')->where('employee_code', '=', $Employee1->employee_id)->where('emid', '=', $Employer->reg)->get()->toArray();

            $Employee_employee_nation = DB::table('nationality_master')->where('emid', '=', $Employer->reg)->get();
            $Employee_employee_qualification = DB::table('employee_qualification')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employer->reg)->get()->toArray();

            $Employee_employee_training = DB::table('employee_training')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employer->reg)->get()->toArray();

            $Employee_employee_upload = DB::table('employee_upload')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employer->reg)->get()->toArray();

            return response()->json(['status' => 'true', 'Company Name' => $Employer->com_name, 'Company Logo' => $Employer->logo, $Employee, $Employee_employee_job, $Employee_employee_pay_structure, $Employee_employee_qualification, $Employee_employee_training, $Employee_employee_upload, $employeelists, $grade, $payment_type_master, $tax_master, $bank, $Employee_employee_nation]);

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function saveCompany(Request $request)
    {

        if (is_numeric($request->com_name) == 1) {

            return response()->json(['msg' => 'Company Name Should not be numeric.', 'status' => 'false']);
        }

        $Employee = DB::table('registration')->where('reg', $request->reg)->first();

        if (!empty($Employee)) {

            $data = array(
                'com_name' => $request->com_name,
                'f_name' => $request->f_name,

                'l_name' => $request->l_name,

                'p_no' => $request->p_no,
                'pan' => $request->pan,
                'address' => $request->address,
                'website' => $request->website,
                'fax' => $request->fax,
            );

            DB::table('registration')->where('reg', $request->reg)->update($data);

            return response()->json(['msg' => 'Updated successfully', 'status' => 'true', 'email' => $Employee->email, 'company name' => $Employee->com_name
                , 'First name' => $Employee->f_name, 'Last name' => $Employee->l_name, 'Registration Id' => $Employee->reg, 'Phone No' => $Employee->p_no, 'pan' => $Employee->pan
                , 'address' => $Employee->address, 'website' => $Employee->website, 'fax' => $Employee->fax]);

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'status' => 'false']);
        }

    }

    public function editemployee(Request $request)
    {

        $result = $request->json()->all();

        $Employee = DB::table('users')->where('id', '=', $result['user_id'])->where('status', '=', 'active')->first();

        if ($Employee->user_type == 'employee') {

            $data = array(

                'emp_blood_grp' => $result['emp_blood_grp'],
                'emp_eye_sight_left' => $result['emp_eye_sight_left'],
                'emp_eye_sight_right' => $result['emp_eye_sight_right'],
                'emp_weight' => $result['emp_weight'],
                'emp_height' => $result['emp_height'],
                'emp_identification_mark_one' => $result['emp_identification_mark_one'],
                'emp_identification_mark_two' => $result['emp_identification_mark_two'],
                'emp_physical_status' => $result['emp_physical_status'],

                'em_name' => $result['em_name'],
                'em_relation' => $result['em_relation'],
                'em_email' => $result['em_email'],
                'em_phone' => $result['em_phone'],
                'em_address' => $result['em_address'],

                'emp_pr_street_no' => $result['emp_pr_street_no'],
                'emp_per_village' => $result['emp_per_village'],
                'emp_pr_city' => $result['emp_pr_city'],
                'emp_pr_country' => $result['emp_pr_country'],
                'emp_pr_pincode' => $result['emp_pr_pincode'],
                'emp_pr_state' => $result['emp_pr_state'],

                'emp_ps_street_no' => $result['emp_ps_street_no'],
                'emp_ps_village' => $result['emp_ps_village'],
                'emp_ps_city' => $result['emp_ps_city'],
                'emp_ps_country' => $result['emp_ps_country'],
                'emp_ps_pincode' => $result['emp_ps_pincode'],
                'emp_ps_state' => $result['emp_ps_state'],

                'nat_id' => $result['nat_id'],
                'place_iss' => $result['place_iss'],
                'iss_date' => $result['iss_date'],
                'exp_date' => date('Y-m-d', strtotime($result['exp_date'])),
                'pass_nation' => $result['pass_nation'],
                'country_residence' => $result['country_residence'],
                'country_birth' => $result['country_birth'],
                'place_birth' => $result['place_birth'],

                'pass_doc_no' => $result['pass_doc_no'],
                'pass_nat' => $result['pass_nat'],
                'issue_by' => $result['issue_by'],
                'pas_iss_date' => date('Y-m-d', strtotime($result['pas_iss_date'])),
                'pass_exp_date' => date('Y-m-d', strtotime($result['pass_exp_date'])),
                'pass_review_date' => date('Y-m-d', strtotime($result['pass_review_date'])),
                'eli_status' => $result['eli_status'],

                'cur_pass' => $result['cur_pass'],
                'remarks' => $result['remarks'],

                'visa_doc_no' => $result['visa_doc_no'],
                'visa_nat' => $result['visa_nat'],
                'visa_issue' => $result['visa_issue'],
                'visa_issue_date' => date('Y-m-d', strtotime($result['visa_issue_date'])),
                'visa_exp_date' => date('Y-m-d', strtotime($result['visa_exp_date'])),
                'visa_review_date' => date('Y-m-d', strtotime($result['visa_review_date'])),
                'visa_eli_status' => $result['visa_eli_status'],

                'visa_cur' => $result['visa_cur'],
                'visa_remarks' => $result['visa_remarks'],

                'drive_doc' => $result['drive_doc'],
                'licen_num' => $result['licen_num'],
                'lin_exp_date' => $result['lin_exp_date'],

            );

            DB::table('employee')->where('emp_code', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->update($data);

            $tot_train_item = count($result['tarin_name']);
            DB::table('employee_training')->where('emp_id', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->delete();

            for ($i = 0; $i < $tot_train_item; $i++) {
                if ($result['tarin_name'][$i] != '') {
                    $datatrain = array(
                        'emp_id' => $Employee->employee_id,
                        'train_des' => $result['train_des'][$i],
                        'tarin_start_date' => date('Y-m-d', strtotime($result['tarin_start_date'][$i])),
                        'tarin_end_date' => date('Y-m-d', strtotime($result['tarin_end_date'][$i])),
                        'tarin_name' => $result['tarin_name'][$i],

                        'emid' => $Employee->emid,

                    );
                    DB::table('employee_training')->insert($datatrain);
                }
            }

            $tot_job_item = count($result['job_name']);
            DB::table('employee_job')->where('emp_id', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->delete();
            for ($i = 0; $i < $tot_job_item; $i++) {
                if ($result['job_name'][$i] != '') {
                    $datajob = array(
                        'emp_id' => $Employee->employee_id,
                        'job_name' => $result['job_name'][$i],
                        'job_start_date' => date('Y-m-d', strtotime($result['job_start_date'][$i])),
                        'job_end_date' => date('Y-m-d', strtotime($result['job_end_date'][$i])),
                        'des' => $result['des'][$i],
                        'emid' => $Employee->emid,
                        'exp' => $result['exp'][$i],

                    );
                    DB::table('employee_job')->insert($datajob);
                }
            }

            $Employee1 = DB::table('employee')->where('emp_code', '=', $Employee->employee_id)->where('emid', '=', $Employee->emid)->first();

            return response()->json(['msg' => 'Updated successfully', 'status' => 'true', $Employee1]);

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'status' => 'false']);
        }

    }

    public function holidayemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employee = DB::table('employee')->where('emp_code', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->first();

                $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                $holidayEmployer = DB::table('holiday')->where('emid', '=', $Employer->reg)->where('from_date', '>=', date('Y-m-d'))->orderBy('id', 'ASC')
                    ->limit(2)->get();

                $first_day_this_year = date('Y-01-01');
                $last_day_this_year = date('Y-12-31');

                $LeaveAllocation = DB::table('leave_allocation')
                    ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                    ->where('leave_allocation.employee_code', '=', $Employee1->employee_id)
                    ->where('leave_allocation.emid', '=', $Employee1->emid)
                    ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])
                //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                    ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                    ->get();

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

                $Roles_auth = DB::table('role_authorization')
                    ->where('emid', '=', $Employee1->emid)
                    ->where('member_id', '=', $Employee1->email)
                    ->get()->toArray();
                $arrrole = array();
                foreach ($Roles_auth as $valrol) {
                    $arrrole[] = $valrol->menu;
                }
                $laeve_ap = '';

                if (in_array('50', $arrrole)) {
                    $laeve_ap = 'yes';
                } else {
                    $laeve_ap = 'No';
                }

                return response()->json(['status' => 'true', $holidayEmployer, $LeaveAllocation, $leaveApply, 'Leave_approver' => $laeve_ap, 'img' => $Employee->emp_image, $Employee]);

            }if ($Employee1->user_type == 'employer') {

                $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_active = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })
                    ->where('users.emid', '=', $Employer->reg)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('users.*')->get();
                $employee_migarnt = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('users.emid', '=', $Employer->reg)
                    ->where(function ($query) {
                        $query->orWhereNotNull('employee.visa_doc_no')
                            // ->orWhereNotNull('employee.visa_exp_date')
                            // ->orWhereNotNull('employee.euss_exp_date')
                            
                            ->orWhereNotNull('employee.euss_ref_no')
                            ;
                    })
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('employee.*')->get();
                $employees = array();
                $t = 0;
                if (count($employee_migarnt) != 0) {

                    foreach ($employee_migarnt as $mirga) {

                        $dob = '';
                        $address_emp = '';

                        if ($mirga->emp_dob != '1970-01-01') {
                            if ($mirga->emp_dob != '') {
                                $dob = date('d/m/Y', strtotime($mirga->emp_dob));
                            }
                        }

                        $address_emp .= $mirga->emp_pr_street_no;
                        if ($mirga->emp_per_village) {$address_emp .= ', ' . $mirga->emp_per_village;}
                        if ($mirga->emp_pr_state) {$address_emp .= ', ' . $mirga->emp_pr_state;}if ($mirga->emp_pr_city) {$address_emp .= ', ' . $mirga->emp_pr_city;}
                        if ($mirga->emp_pr_pincode) {$address_emp .= ', ' . $mirga->emp_pr_pincode;}if ($mirga->emp_pr_country) {$address_emp .= ', ' . $mirga->emp_pr_country;}

                        $employees[] = array("emp_code" => $mirga->emp_code, "emp_fname" => $mirga->emp_fname, "emp_mname" => $mirga->emp_mname, "emp_lname" => $mirga->emp_lname
                            , 'emp_dob' => $dob, 'emp_ps_phone' => $mirga->emp_ps_phone, 'nationality' => $mirga->nationality, 'ni_no' => $mirga->ni_no
                            , 'visa_exp_date' => date('d/m/Y', strtotime($mirga->visa_exp_date))
                            , 'visa_exp_date_90' => date('d/m/Y', strtotime($mirga->visa_exp_date . '  - 90  days'))
                            , 'visa_exp_date_60' => date('d/m/Y', strtotime($mirga->visa_exp_date . '  - 60  days'))
                            , 'visa_exp_date_30' => date('d/m/Y', strtotime($mirga->visa_exp_date . '  - 30  days'))
                            , 'pass_doc_no' => $mirga->pass_doc_no, 'address' => $address_emp);

                        $t++;


                    }
                } else {
                    $employees[] = (object) array();
                }

                return response()->json(['status' => 'true', 'user_type' => 'employer', 'total_employee' => count($employee_active), 'total_migrant' => count($employee_migarnt), 'monitoring' => $employees, 'img' => $Employer->logo]);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function timeinemployee(Request $request)
    {

        $Employeeus = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        $employee_code = '';
        $time_out = '';
        $fetch_date = '';
        $add = '';
        if ($Employeeus->user_type == 'employee') {

            $daliyEmployee = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->where('emid', '=', $Employeeus->emid)->orderBy('id', 'desc')->first();

            //dd($Employeeus);

            if (!empty($daliyEmployee)) {
                $time_out = $daliyEmployee->time_out;
                $employee_code = $daliyEmployee->employee_code;
                $fetch_date = $daliyEmployee->date;

                $Roledata = DB::table('duty_roster')

                    ->whereDate('start_date', '<=', $request->date)
                    ->whereDate('end_date', '>=', $request->date)

                    ->where('duty_roster.employee_id', '=', $Employeeus->employee_id)
                    ->where('duty_roster.emid', '=', $Employeeus->emid)
                    ->first();

                if (!empty($Roledata)) {
                    $add = 'yes';
                } else {
                    $add = '';
                }

            } else {
                // $time_out = $daliyEmployee->time_out;
                // $employee_code = $daliyEmployee->employee_code;
                // $fetch_date = $daliyEmployee->date;

                $Roledata = DB::table('duty_roster')

                    ->whereDate('start_date', '<=', $request->date)
                    ->whereDate('end_date', '>=', $request->date)

                    ->where('duty_roster.employee_id', '=', $Employeeus->employee_id)
                    ->where('duty_roster.emid', '=', $Employeeus->emid)
                    ->first();

                if (!empty($Roledata)) {
                    $add = 'yes';
                } else {
                    $add = '';
                }
                //dd($Roledata);

            }

            if ($employee_code != '' && $time_out != '' && !empty($add)) {
                $Employee = DB::table('employee')->where('emp_code', '=', $Employeeus->employee_id)->where('emid', '=', $Employeeus->emid)->first();
                $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;
                $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                $data = array(
                    'employee_code' => $Employee->emp_code,
                    'employee_name' => $employee_name,

                    'emid' => $Employee->emid,
                    'date' => $request->date,
                    'time_in' => $request->time_in,
                    'month' => $request->month,
                    'time_in_location' => $request->time_in_location,

                );

                DB::table('attandence')->insert($data);
                return response()->json(['msg' => 'data is saved', 'resultstatus' => 'true', 'status' => 'active']);
            } else if ($employee_code == '' && $time_out == '' && !empty($add)) {
                $Employee = DB::table('employee')->where('emp_code', '=', $Employeeus->employee_id)->where('emid', '=', $Employeeus->emid)->first();
                $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;
                $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                $data = array(
                    'employee_code' => $Employee->emp_code,
                    'employee_name' => $employee_name,

                    'emid' => $Employee->emid,
                    'date' => $request->date,
                    'time_in' => $request->time_in,
                    'month' => $request->month,
                    'time_in_location' => $request->time_in_location,

                );

                DB::table('attandence')->insert($data);
                return response()->json(['msg' => 'Attendance Time In Saved', 'resultstatus' => 'true', 'status' => 'active']);
            } else if (empty($add)) {
                return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

            } else {
                return response()->json(['msg' => 'You have not Clocked Out last time. Clock Out first', 'resultstatus' => 'false', 'status' => 'active']);

            }

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function timeoutemployee(Request $request)
    {

        $Employeeus = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        $employee_code = '';
        $time_in = '';
        $fetch_time_out = '';
        $last_attendence_id = '';
        $date_arr1 = '';
        $d2 = '';
        $m2 = '';
        $y2 = '';
        $new_date2 = '';
        $datein = '';
        $dateout = '';
        $difference = '';
        $hours = '';
        $minutes = '';
        $duty_hours = '';
        $add = '';
        $Roledata = DB::table('duty_roster')

            ->whereDate('start_date', '<=', $request->date)
            ->whereDate('end_date', '>=', $request->date)

            ->where('duty_roster.employee_id', '=', $Employeeus->employee_id)
            ->where('duty_roster.emid', '=', $Employeeus->emid)
            ->first();
        if (!empty($Roledata)) {
            $add = 'yes';
        } else {
            $add = '';
        }
        if ($Employeeus->user_type == 'employee' && !empty($add)) {
            $date_arr = explode('-', $request->date);
            $d1 = $date_arr[0];
            $m1 = $date_arr[1];
            $y1 = $date_arr[2];
            $new_date1 = $y1 . '-' . $m1 . '-' . $d1;
            $daliyEmployee = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->where('emid', '=', $Employeeus->emid)->orderBy('id', 'desc')->first();

            if (!empty($daliyEmployee) && !empty($add)) {
                if ($request->time_out != '' && !empty($add)) {

                    if (!empty($daliyEmployee)) {

                        $employee_code = $daliyEmployee->employee_code;

                        $dt = $daliyEmployee->date;
                        $time_in = $daliyEmployee->time_in;
                        $fetch_time_out = $daliyEmployee->time_out;
                        $last_attendence_id = $daliyEmployee->id;
                        $date_arr1 = explode('-', $dt);
                        $d2 = $date_arr1[0];
                        $m2 = $date_arr1[1];
                        $y2 = $date_arr1[2];
                        $new_date2 = $y2 . '-' . $m2 . '-' . $d2;
                        $datein = strtotime(date("Y-m-d " . $time_in));
                        $dateout = strtotime(date("Y-m-d " . $request->time_out));
                        $difference = abs($dateout - $datein) / 60;
                        $hours = floor($difference / 60);
                        $minutes = ($difference % 60);
                        $duty_hours = $hours . ":" . $minutes;
                        $days = $d1 - $d2;
                    }

                    if ($fetch_time_out == "" && !empty($add)) {
                        $Employee = DB::table('employee')->where('emp_code', '=', $Employeeus->employee_id)->where('emid', '=', $Employeeus->emid)->first();
                        $employee_name = $Employee->emp_fname . $Employee->emp_mname . $Employee->emp_lname;
                        $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();
                        $data = array(
                            'duty_hours' => $duty_hours,

                            'date' => $dt,
                            'time_out' => $request->time_out,
                            'month' => $request->month,
                            'time_out_location' => $request->time_out_location,

                        );
                        DB::table('attandence')->where('employee_code', $Employee->emp_code)->where('id', $last_attendence_id)->where('emid', '=', $Employeeus->emid)->update($data);

                        return response()->json(['msg' => 'Attendance Time Out Saved', 'resultstatus' => 'true', 'status' => 'active']);
                    } else if (empty($add)) {
                        return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

                    } else {
                        return response()->json(['msg' => 'You have not Clocked In last time. Clock In first', 'resultstatus' => 'false', 'status' => 'active']);

                    }} else if (empty($add)) {
                    return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

                } else {
                    return response()->json(['msg' => 'Time In not completed', 'resultstatus' => 'false', 'status' => 'active']);

                }
            } else if (empty($add)) {
                return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

            } else {
                return response()->json(['msg' => 'You have not Clocked In last time. Clock In first', 'resultstatus' => 'false', 'status' => 'active']);

            }
        } else if (empty($add)) {
            return response()->json(['msg' => 'Duty Roster is not found for today ', 'resultstatus' => 'false', 'status' => 'active']);

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function allholdaymployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        if ($Employee1->user_type == 'employee') {
            $Employee = DB::table('employee')->where('emp_code', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->first();

            $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();

            $holidayEmployer = DB::table('holiday')->where('emid', '=', $Employer->reg)->where('from_date', '>=', date('Y-01-01'))->where('from_date', '<=', date('Y-12-31'))->orderBy('from_date', 'ASC')
                ->get();

            if (!empty($holidayEmployer)) {
                return response()->json(['status' => 'true', $holidayEmployer]);
            } else {
                return response()->json(['msg' => 'No holiday found!', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'No holiday found!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function aleavemployee(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        if ($users->user_type == 'employee') {

            $employee = DB::table('employee')->where('emp_code', '=', $users->employee_id)->where('emid', '=', $users->emid)->first();
            $leave_type_rs =
            DB::table('leave_type')
                ->join('leave_allocation', 'leave_type.id', '=', 'leave_allocation.leave_type_id')

                ->select('leave_type.*')
                ->where('leave_type.emid', '=', $users->emid)
                ->where('leave_allocation.employee_code', '=', $users->employee_id)
                ->where('leave_allocation.emid', '=', $users->emid)
                ->where('leave_allocation.month_yr', 'like', '%' . date('Y') . '%')
                ->where('leave_allocation.leave_in_hand', '!=', 0)
                ->get();

            $holiday_rs = DB::Table('holiday')->where('emid', '=', $users->emid)->select('from_date', 'to_date', 'day', 'holiday_type')->get();
            // dd($holiday_rs);

            $holidays = array();
            $holiday_type = array();

            foreach ($holiday_rs as $holiday) {

                if ($holiday->day > '1') {
                    $from_date = $holiday->from_date;
                    $to_date = $holiday->to_date;

                    $date1 = date("d-m-Y", strtotime($from_date));
                    $date2 = date("d-m-Y", strtotime($to_date));
                    // dd($date1);
                    // Declare an empty array
                    // $holiday_array = array();

                    // Use strtotime function
                    $variable1 = strtotime($date1);
                    $variable2 = strtotime($date2);

                    // Use for loop to store dates into array
                    // 86400 sec = 24 hrs = 60*60*24 = 1 day
                    for ($currentDate = $variable1; $currentDate <= $variable2; $currentDate += (86400)) {

                        $Store = date('Y-m-d', $currentDate);

                        $holidays[] = $Store;
                        $holiday_type[] = $holiday->holiday_type;

                    }

                    // Display the dates in array format

                } elseif ($holiday->day == '1') {
                    $Store = $holiday->from_date;
                    $holidays[] = $Store;
                    $holiday_type[] = $holiday->holiday_type;
                }

                $holiday_array = array("holidays" => $holidays, "holiday_type" => $holiday_type);

            }

            return response()->json(['msg' => 'data  found!', 'status' => 'true', $leave_type_rs, $employee]);
        } else {

            return response()->json(['msg' => 'No rule  found!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function aleaveget(Request $request)
    {
        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if ($users->user_type == 'employee') {
            $leaveinhand = DB::table('leave_allocation')
                ->where('leave_type_id', '=', $request->leave_type)
                ->where('employee_code', '=', $users->employee_id)
                ->where('emid', '=', $users->emid)
                ->where('month_yr', 'like', '%' . date('Y') . '%')
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($leaveinhand)) {
                if ($leaveinhand->leave_in_hand > 0) {

                    $leave_type_rs = $leaveinhand->leave_in_hand;

                } else {
                    $leave_type_rs = '0';
                }
            } else {
                $leave_type_rs = '0';

            }
            return response()->json(['msg' => 'data  found!', 'status' => 'true', 'leave_inhand' => $leave_type_rs]);
        } else {

            return response()->json(['msg' => 'No rule  found!', 'status' => 'false']);
        }

    }

    public function saveleaveget(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        $report_auth = DB::table('employee')->where('emp_code', '=', $users->employee_id)->where('emid', '=', $users->emid)->first();
        if (!empty($report_auth)) {
            $report_auth_name = $report_auth->emp_reporting_auth;

        } else {
            $report_auth_name = '';

        }

        $diff = abs(strtotime($request->to_date) - strtotime($request->from_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;

        if ($request->days != 0) {
            if ($request->leave_inhand >= $request->days) {
                $data['employee_id'] = $users->employee_id;
                $data['employee_name'] = $request->employee_name;
                $data['emp_reporting_auth'] = $report_auth_name;
                $data['emp_lv_sanc_auth'] = '';
                $data['date_of_apply'] = $request->date_of_apply;
                $data['leave_type'] = $request->leave_type;

                $data['from_date'] = date('Y-m-d', strtotime($request->from_date));
                $data['to_date'] = date('Y-m-d', strtotime($request->to_date));
                $data['no_of_leave'] = $request->days;
                $data['status'] = "NOT APPROVED";
                $data['emid'] = $users->emid;
                $leave_apply = DB::table('leave_apply')->insert($data);

                $firebaseToken = DB::table('users')->where('employee_id', $users->emid)->whereNotNull('device_token')->pluck('device_token')->all();

                $userdata = DB::table('users')->where('employee_id', $users->emid)
                    ->first();
                if ($userdata->device_token != '') {

                    $notification_details[] = array("user_id" => $userdata->id);
                }
                $notification_approver = array();

                if (count($firebaseToken) != 0) {
                    $LeaveApply = DB::table('leave_type')

                        ->where('id', $request->leave_type)

                        ->orderBy('id', 'DESC')
                        ->first();
                    $content = $request->employee_name . ' applied ' . $LeaveApply->leave_type_name . ' from ' . date('d/m/Y', strtotime($request->from_date)) . ' to ' . date('d/m/Y', strtotime($request->to_date));

                    if (!empty($report_auth)) {

                        $firebaseToken_report = DB::table('users')
                            ->where('employee_id', $report_auth->emp_reporting_auth)
                            ->where('emid', $users->emid)->first();

                        if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                            $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                            $bodyapprove = '
		{
"from":"employee",
"to":"approver",
"navigate":"leave",
"message":"' . $content . '"
}';
                            $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave Applied');

                            $server_output = '';
                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                            $server_output = curl_exec($ch);

                            $outputFrom = json_decode($server_output);

                        }

                    }

                    $body = '
		{
"from":"employee",
"to":"employer",
"navigate":"leave",
"message":"' . $content . '"
}';
                    $data = array('notification_details' => $notification_details, 'body' => $body, 'title' => 'Leave Applied');

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Applied Successfully', 'status' => 'true']);
            } else {

                return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'Sorry, No of days does not have any  zero', 'status' => 'false']);
        }
        //  $request->leave_inhand;

    }

    public function leaveapprivere(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        $emp_code = $users->employee_id;

        $LeaveApply = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')
            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')

            ->where('leave_apply.emid', '=', $users->emid)
            ->where('employee.emid', '=', $users->emid)
            ->where('leave_type.emid', '=', $users->emid)
            ->where(function ($result) use ($emp_code) {
                if ($emp_code) {
                    $result->where('leave_apply.emp_reporting_auth', $emp_code)
                        ->orWhere('leave_apply.emp_lv_sanc_auth', $emp_code);
                }
            })

            ->orderBy('date_of_apply', 'DESC')
            ->get();
        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }
    public function leaveapprivereedit(Request $request)
    {

        $users = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();

        $id = $request->id;

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
            ->where('leave_apply.employee_id', '=', $lv_aply)
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

        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply, $Prev_leave, $totleave]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }

    public function SaveLeavePermission(Request $request)
    {
        // dd($request);
        $users = DB::table('users')->where('id', '=', $request->user_id)->where('status', '=', 'active')->first();

        $leaveApply = DB::table('leave_apply')

            ->where('id', '=', $request->apply_id)

            ->first();

        $Allocation = DB::table('leave_allocation')
            ->where('employee_code', '=', $request->employee_id)
            ->where('leave_type_id', '=', $request->leave_type)
            ->where('emid', '=', $users->emid)

            ->where('month_yr', 'like', '%' . date('Y', strtotime($leaveApply->from_date)) . '%')
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
        $laevetay = DB::table('leave_apply')->where('id', '=', $request->apply_id)->first();

        if ($request->leave_check == 'APPROVED') {

            $lv_inhand = $inhand - ($request->no_of_leave);

            if ($lv_inhand < 0) {
                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocation')
                    ->where('leave_type_id', '=', $request->leave_type)
                    ->where('employee_code', '=', $request->employee_id)
                    ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    ->update(['leave_in_hand' => $lv_inhand]);

                $LeaveApply = DB::table('leave_type')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', $users->emid)->first();

                if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '
		{
"from":"approver",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave  APPROVED successfully. ', 'status' => 'true']);

            }
        } else if ($request->leave_check == 'REJECTED') {
            DB::table('leave_apply')
                ->where('id', $request->apply_id)
                ->where('employee_id', $request->employee_id)
                ->where('emid', '=', $users->emid)
                ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

            $LeaveApply = DB::table('leave_type')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
                ->where('emid', $users->emid)->first();

            if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '
		{
"from":"approver",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Rejected Successfully ', 'status' => 'true']);

        } else if ($request->leave_check == 'RECOMMENDED') {

            $lv_inhand = $inhand - $request->no_of_leave;
            // dd($lv_inhand);
            if ($lv_inhand < 0) {

                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                $emp_code = $request->employee_id;

                $sanc_auth = DB::table('employee')->where('emp_code', $request->employee_id)->where('emid', '=', $users->emid)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $users->emid)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                $LeaveApply = DB::table('leave_type')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', $users->emid)->first();

                if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '
		{
"from":"approver",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Recommended Successfully! ', 'status' => 'true']);

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

            $LeaveApply = DB::table('leave_type')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
                ->where('emid', $users->emid)->first();

            if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '
		{
"from":"approver",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Cancel Successfully! ', 'status' => 'true']);

        }

    }

    public function allleavreqe(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employee = DB::table('employee')->where('emp_code', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->first();

                $Employer = DB::table('registration')->where('reg', '=', $Employee->emid)->first();

                $first_day_this_year = date('Y-01-01');
                $last_day_this_year = date('Y-12-31');

                $LeaveAllocation = DB::table('leave_allocation')
                    ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                    ->where('leave_allocation.employee_code', '=', $Employee1->employee_id)
                    ->where('leave_allocation.emid', '=', $Employee1->emid)
                    ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])
                //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                    ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                    ->orderBy('leave_type.leave_type_name', 'ASC')
                    ->get();

                return response()->json(['status' => 'true', $LeaveAllocation]);

            }

        } else {

            return response()->json(['msg' => 'Your email or password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function dailytimeemployee(Request $request)
    {

        $Employeeus = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        $employee_code = '';
        $time_out = '';
        $fetch_date = '';
        if ($Employeeus->user_type == 'employee') {

            $daliyEmployee = DB::table('attandence')->select(DB::raw('DISTINCT date'))->distinct('date')->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', $request->month)->where('emid', '=', $Employeeus->emid)->orderBy('id', 'asc')->get();
            if (count($daliyEmployee) != 0) {

                foreach ($daliyEmployee as $value) {

                    $attndetails = array('date' => $value->date, 'month' => $request->month);
                    $daliyEmployeedate = DB::table('attandence')->where('employee_code', '=', $Employeeus->employee_id)->where('month', '=', $request->month)->where('date', '=', $value->date)->where('emid', '=', $Employeeus->emid)->orderBy('id', 'asc')->get();
                    foreach ($daliyEmployeedate as $valuedate) {

                        $attndetails['log'][] = array('timein' => $valuedate->time_in, 'timeout' => $valuedate->time_out,
                            'time_in_location' => $valuedate->time_in_location, 'time_out_location' => $valuedate->time_out_location,
                            'duty_hours' => $valuedate->duty_hours);
                    }
                    $dvalue[] = array_merge($attndetails);
                }
                return response()->json(['msg' => 'Data is found ', 'resultstatus' => 'true', 'status' => 'active', $dvalue]);
            } else {
                return response()->json(['msg' => 'Data is  not found', 'resultstatus' => 'false', 'status' => 'active']);
            }

        } else {
            return response()->json(['msg' => 'Employer Does not exits', 'resultstatus' => 'false', 'status' => 'inactive']);
        }

    }

    public function updateemployee(Request $request)
    {

        $content = $request->json()->all();

// print_r($content['personal_details']);

        $Employee1 = DB::table('users')->where('id', '=', $content['user_id'])->where('status', '=', 'active')->first();
        if ($Employee1->user_type == 'employee') {

            if (array_key_exists('personal_details', $content)) {

                $personaldetailsupdate = array(

                    'emp_fname' => strtoupper($content['personal_details']['emp_fname']),
                    'emp_mname' => strtoupper($content['personal_details']['emp_mid_name']),
                    'emp_lname' => strtoupper($content['personal_details']['emp_lname']),
                    'emp_ps_email' => $content['personal_details']['emp_ps_email'],
                    'emp_dob' => date('Y-m-d', strtotime($content['personal_details']['emp_dob'])),
                    'emp_ps_phone' => $content['personal_details']['emp_ps_phone'],
                    'em_contact' => $content['personal_details']['em_contact'],
                    'emp_gender' => $content['personal_details']['emp_gender'],
                    'marital_status' => $content['personal_details']['marital_status'],
                    'nationality' => $content['personal_details']['nationality'],
                    'ni_no' => $content['personal_details']['ni_no'],
                );

                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($personaldetailsupdate);

            }

            if (array_key_exists('service_details', $content)) {

                $serviceupdate = array(

                    'emp_department' => $content['service_details']['emp_department'],
                    'emp_designation' => $content['service_details']['emp_designation'],
                    'emp_doj' => date('Y-m-d', strtotime($content['service_details']['emp_doj'])),
                    'emp_status' => $content['service_details']['emp_status'],
                    'date_confirm' => $content['service_details']['date_confirm'],
                    'start_date' => $content['service_details']['start_date'],
                    'end_date' => $content['service_details']['end_date'],
                    'job_loc' => $content['service_details']['job_loc'],
                    'emp_reporting_auth' => $content['service_details']['emp_reporting_auth'],
                    'emp_lv_sanc_auth' => $content['service_details']['emp_lv_sanc_auth'],

                );

                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($serviceupdate);

                if (!empty($content['service_details']['emp_image'])) {

                    // $file = $content['emp_image'];
                    // $extension = $request->emp_image->extension();
                    // $path = $request->emp_image->store('employee_logo','public');

                    $folderPath1 = "employee_logo/";

                    $image_base64_1 = base64_decode($content['service_details']['emp_image']);
                    $file1 = $folderPath1 . uniqid() . '.' . 'jpeg';
                    // $savepath  = $image_parts[1]->store('img','public');
                    // file_put_contents($file, $image_base64);
                    Storage::disk('public')->put($file1, $image_base64_1);
                    $dataimg = array(
                        'emp_image' => $file1,
                    );
                    DB::table('employee')
                        ->where('emp_code', $Employee1->employee_id)
                        ->where('emid', '=', $Employee1->emid)
                        ->update($dataimg);

                }

            }

            if (array_key_exists('educational_details', $content)) {

                $totaled = count($content['educational_details']);

                for ($i = 0; $i < $totaled; $i++) {

                    if ($content['educational_details'][$i]['id'] != '') {

                        if ($content['educational_details'][$i]['doc'] != '') {

                            $folderPath2 = "employee_quli_doc/";

                            $image_base64_2 = base64_decode($content['educational_details'][$i]['doc']);
                            $file2 = $folderPath2 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file2, $image_base64_2);

                            $dataimgedit = array(
                                'doc' => $file2,
                            );
                            DB::table('employee_qualification')
                                ->where('emid', '=', $Employee1->emid)
                                ->where('id', $content['educational_details'][$i]['id'])
                                ->where('emp_id', '=', $Employee1->employee_id)
                                ->update($dataimgedit);
                        }

                        if ($content['educational_details'][$i]['doc2'] != '') {
                            $folderPath3 = "employee_quli_doc2/";

                            $image_base64_3 = base64_decode($content['educational_details'][$i]['doc2']);
                            $file3 = $folderPath3 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file3, $image_base64_3);

                            $dataimgedit = array(
                                'doc2' => $file3,
                            );
                            DB::table('employee_qualification')
                                ->where('id', $content['educational_details'][$i]['id'])
                                ->where('emid', '=', $Employee1->emid)
                                ->where('emp_id', '=', $Employee1->employee_id)
                                ->update($dataimgedit);
                        }

                        $dataquli_edit = array(
                            'emp_id' => $Employee1->employee_id,
                            'quli' => $content['educational_details'][$i]['quli'],
                            'dis' => $content['educational_details'][$i]['dis'],
                            'ins_nmae' => $content['educational_details'][$i]['ins_nmae'],
                            'board' => $content['educational_details'][$i]['board'],
                            'year_passing' => $content['educational_details'][$i]['year_passing'],
                            'perce' => $content['educational_details'][$i]['perce'],
                            'grade' => $content['educational_details'][$i]['grade'],

                        );

                        DB::table('employee_qualification')
                            ->where('id', $content['educational_details'][$i]['id'])
                            ->where('emid', '=', $Employee1->emid)
                            ->where('emp_id', '=', $Employee1->employee_id)
                            ->update($dataquli_edit);
                    } else {

                        if ($content['educational_details'][$i]['doc'] != '') {

                            $folderPath4 = "employee_quli_doc/";

                            $image_base64_4 = base64_decode($content['educational_details'][$i]['doc']);
                            $file4 = $folderPath4 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file4, $image_base64_4);

                        } else {
                            $file4 = "";
                        }
                        if ($content['educational_details'][$i]['doc2'] != '') {

                            $folderPath5 = "employee_quli_doc2/";

                            $image_base64_5 = base64_decode($content['educational_details'][$i]['doc2']);
                            $file5 = $folderPath5 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file5, $image_base64_5);
                        } else {
                            $file5 = "";
                        }

                        $dataquli_insert = array(
                            'emp_id' => $Employee1->employee_id,
                            'quli' => $content['educational_details'][$i]['quli'],
                            'dis' => $content['educational_details'][$i]['dis'],
                            'ins_nmae' => $content['educational_details'][$i]['ins_nmae'],
                            'board' => $content['educational_details'][$i]['board'],
                            'year_passing' => $content['educational_details'][$i]['year_passing'],
                            'perce' => $content['educational_details'][$i]['perce'],
                            'grade' => $content['educational_details'][$i]['grade'],
                            'doc' => $file4,
                            'doc2' => $file5,
                            'emid' => $Employee1->emid,

                        );

                        DB::table('employee_qualification')->insert($dataquli_insert);
                    }

                }

            }

            $tot_job_item = count($content['job_details']);
            DB::table('employee_job')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->delete();
            for ($i = 0; $i < $tot_job_item; $i++) {
                if ($content['job_details'][$i]['job_name'] != '') {
                    $datajob = array(
                        'emp_id' => $Employee1->employee_id,
                        'job_name' => $content['job_details'][$i]['job_name'],
                        'job_start_date' => $content['job_details'][$i]['job_start_date'],
                        'job_end_date' => $content['job_details'][$i]['job_end_date'],
                        'des' => $content['job_details'][$i]['des'],
                        'emid' => $Employee1->emid,
                        'exp' => $content['job_details'][$i]['exp'],

                    );
                    DB::table('employee_job')->insert($datajob);
                }
            }

            $tot_train_item = count($content['training_details']);
            DB::table('employee_training')->where('emp_id', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->delete();

            for ($i = 0; $i < $tot_train_item; $i++) {
                if ($content['training_details'][$i]['tarin_name'] != '') {
                    $datatrain = array(
                        'emp_id' => $Employee1->employee_id,
                        'train_des' => $content['training_details'][$i]['train_des'],
                        'tarin_start_date' => $content['training_details'][$i]['tarin_start_date'],
                        'tarin_end_date' => $content['training_details'][$i]['tarin_end_date'],
                        'tarin_name' => $content['training_details'][$i]['tarin_name'],

                        'emid' => $Employee1->emid,

                    );
                    DB::table('employee_training')->insert($datatrain);
                }
            }

            $dataupdatearray = array(

                'criminal' => $content['additional_details']['criminal'],
                'emp_blood_grp' => $content['additional_details']['emp_blood_grp'],
                'emp_weight' => $content['additional_details']['emp_weight'],
                'emp_height' => $content['additional_details']['emp_height'],
                'emp_identification_mark_one' => $content['additional_details']['emp_identification_mark_one'],
                'emp_identification_mark_two' => $content['additional_details']['emp_identification_mark_two'],
                'emp_physical_status' => $content['additional_details']['emp_physical_status'],

                'em_name' => $content['emg_details']['em_name'],
                'em_relation' => $content['emg_details']['em_relation'],
                'em_email' => $content['emg_details']['em_email'],
                'em_phone' => $content['emg_details']['em_phone'],
                'em_address' => $content['emg_details']['em_address'],

                'titleof_license' => $content['cer_membership']['titleof_license'],
                'cf_license_number' => $content['cer_membership']['cf_license_number'],
                'cf_start_date' => date('Y-m-d', strtotime($content['cer_membership']['cf_start_date'])),
                'cf_end_date' => date('Y-m-d', strtotime($content['cer_membership']['cf_end_date'])),

                'emp_pr_street_no' => $content['permanent_add']['emp_pr_address1'],
                'emp_per_village' => $content['permanent_add']['emp_pr_address2'],
                'emp_pr_city' => $content['permanent_add']['emp_pr_city'],
                'emp_pr_country' => $content['permanent_add']['emp_pr_country'],
                'emp_pr_pincode' => $content['permanent_add']['emp_pr_pincode'],
                'emp_pr_state' => $content['permanent_add']['emp_pr_roadname'],

                'emp_ps_street_no' => $content['present_add']['emp_ps_address1'],
                'emp_ps_village' => $content['present_add']['emp_ps_address2'],
                'emp_ps_city' => $content['present_add']['emp_ps_city'],
                'emp_ps_country' => $content['present_add']['emp_ps_country'],
                'emp_ps_pincode' => $content['present_add']['emp_ps_pincode'],
                'emp_ps_state' => $content['present_add']['emp_ps_roadname'],

                'place_birth' => $content['passport_details']['place_birth'],
                'pass_doc_no' => $content['passport_details']['pass_doc_no'],
                'pass_nat' => $content['passport_details']['pass_nat'],
                'issue_by' => $content['passport_details']['issue_by'],
                'pas_iss_date' => date('Y-m-d', strtotime($content['passport_details']['pas_iss_date'])),
                'pass_exp_date' => date('Y-m-d', strtotime($content['passport_details']['pass_exp_date'])),
                'pass_review_date' => date('Y-m-d', strtotime($content['passport_details']['pass_review_date'])),
                'eli_status' => $content['passport_details']['eli_status'],
                'cur_pass' => $content['passport_details']['cur_pass'],
                'remarks' => $content['passport_details']['remarks'],

                'visa_doc_no' => $content['visa_details']['visa_doc_no'],
                'visa_nat' => $content['visa_details']['visa_nat'],
                'visa_issue' => $content['visa_details']['visa_issue'],
                'visa_issue_date' => date('Y-m-d', strtotime($content['visa_details']['visa_issue_date'])),
                'visa_exp_date' => date('Y-m-d', strtotime($content['visa_details']['visa_exp_date'])),
                'visa_review_date' => date('Y-m-d', strtotime($content['visa_details']['visa_review_date'])),
                'visa_eli_status' => $content['visa_details']['visa_eli_status'],
                'visa_cur' => $content['visa_details']['visa_cur'],
                'visa_remarks' => $content['visa_details']['visa_remarks'],
                'country_residence' => $content['visa_details']['country_residence'],

                'nat_id' => $content['immigration_det']['nat_id'],
                'place_iss' => $content['immigration_det']['place_iss'],
                'iss_date' => $content['immigration_det']['iss_date'],
                'exp_date' => date('Y-m-d', strtotime($content['immigration_det']['exp_date'])),
                'pass_nation' => $content['immigration_det']['pass_nation'],
                'country_birth' => $content['immigration_det']['country_birth'],

                'drive_doc' => $content['driving_details']['drive_doc'],
                'licen_num' => $content['driving_details']['licen_num'],
                'lin_exp_date' => $content['driving_details']['lin_exp_date'],

            );

            $updateemployee = DB::table('employee')
                ->where('emp_code', $Employee1->employee_id)
                ->where('emid', '=', $Employee1->emid)
                ->update($dataupdatearray);

            if ($content['permanent_add']['pr_add_proof'] != '') {

                $folderPath6 = "employee_per_add/";

                $image_base64_6 = base64_decode($content['permanent_add']['pr_add_proof']);
                $file6 = $folderPath6 . uniqid() . '.' . 'jpeg';
                // $savepath  = $image_parts[1]->store('img','public');
                // file_put_contents($file, $image_base64);
                Storage::disk('public')->put($file6, $image_base64_6);

                $dataimgper = array(
                    'pr_add_proof' => $file6,
                );
                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($dataimgper);
            }

            if ($content['present_add']['ps_add_proof'] != '') {

                $folderPath7 = "employee_ps_add/";

                $image_base64_7 = base64_decode($content['present_add']['ps_add_proof']);
                $file7 = $folderPath7 . uniqid() . '.' . 'jpeg';
                // $savepath  = $image_parts[1]->store('img','public');
                // file_put_contents($file, $image_base64);
                Storage::disk('public')->put($file7, $image_base64_7);

                $dataimgps = array(
                    'ps_add_proof' => $file7,
                );
                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($dataimgps);
            }

            if ($content['passport_details']['pass_docu'] != '') {

                $folderPath8 = "employee_doc/";

                $image_base64_8 = base64_decode($content['passport_details']['pass_docu']);
                $file8 = $folderPath8 . uniqid() . '.' . 'jpeg';
                // $savepath  = $image_parts[1]->store('img','public');
                // file_put_contents($file, $image_base64);
                Storage::disk('public')->put($file8, $image_base64_8);

                $dataimgdoc = array(
                    'pass_docu' => $file8,
                );
                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($dataimgdoc);
            }

            if ($content['visa_details']['visa_upload_doc'] != '') {

                $folderPath9 = "employee_vis_doc/";

                $image_base64_9 = base64_decode($content['visa_details']['visa_upload_doc']);
                $file9 = $folderPath9 . uniqid() . '.' . 'jpeg';
                // $savepath  = $image_parts[1]->store('img','public');
                // file_put_contents($file, $image_base64);
                Storage::disk('public')->put($file9, $image_base64_9);

                $dataimgvis = array(
                    'visa_upload_doc' => $file9,
                );
                DB::table('employee')
                    ->where('emp_code', $Employee1->employee_id)
                    ->where('emid', '=', $Employee1->emid)
                    ->update($dataimgvis);
            }

            if (array_key_exists('type_of_doc', $content['immigration_det'])) {
                $totalimmgdet = count($content['immigration_det']['type_of_doc']);

                // print_r($totalimmgdet);die;

                for ($j = 0; $j < $totalimmgdet; $j++) {
                    if ($content['immigration_det']['type_of_doc'][$j]['id'] != '') {

                        if ($content['immigration_det']['type_of_doc'][$j]['docu_nat'] != '') {

                            $folderPath10 = "employee_upload_doc/";

                            $image_base64_10 = base64_decode($content['immigration_det']['type_of_doc'][$j]['docu_nat']);
                            $file10 = $folderPath10 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file10, $image_base64_10);

                            $dataimgeditup = array(
                                'emp_id' => $Employee1->employee_id,
                                'type_doc' => $content['immigration_det']['type_of_doc'][$j]['type_doc'],
                                'emid' => $Employee1->emid,
                                'docu_nat' => $file10,
                            );

                            DB::table('employee_upload')
                                ->where('id', $content['immigration_det']['type_of_doc'][$j]['id'])
                                ->where('emid', '=', $Employee1->emid)
                                ->where('emp_id', '=', $Employee1->employee_id)
                                ->update($dataimgeditup);
                        }
                    } else {

                        if ($content['immigration_det']['type_of_doc'][$j]['docu_nat'] != '') {
                            $folderPath11 = "employee_upload_doc/";

                            $image_base64_11 = base64_decode($content['immigration_det']['type_of_doc'][$j]['docu_nat']);
                            $file11 = $folderPath11 . uniqid() . '.' . 'jpeg';
                            // $savepath  = $image_parts[1]->store('img','public');
                            // file_put_contents($file, $image_base64);
                            Storage::disk('public')->put($file11, $image_base64_11);
                        } else {
                            $file11 = '';
                        }

                        $dataupload = array(
                            'emp_id' => $Employee1->employee_id,
                            'type_doc' => $content['immigration_det']['type_of_doc'][$j]['type_doc'],
                            'emid' => $Employee1->emid,
                            'docu_nat' => $file11,
                        );
                        DB::table('employee_upload')->insert($dataupload);

                    }
                }
            }

            return response()->json(['msg' => 'Successfullly Updated', 'resultstatus' => 'true']);
        } else {
            return response()->json(['msg' => 'Not an employee', 'resultstatus' => 'false']);
        }

    }

    public function getallemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {

            }if ($Employee1->user_type == 'employer') {

                $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_active = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                    ->where(function ($query) {

                        $query->whereNull('employee.emp_status')
                            ->orWhere('employee.emp_status', '!=', 'LEFT');
                    })
                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('users.emid', '=', $Employer->reg)
                    ->where('users.status', '=', 'active')
                    ->where('users.user_type', '=', 'employee')
                    ->select('employee.*')->get();

                return response()->json(['status' => 'true', 'user_type' => 'employer', 'employee' => $employee_active]);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function adnotemployee(Request $request)
    {

        $content = $request->json()->all();
        $notification_details = array();
        if ($content['employee_id'] != '') {
            $firebaseToken = DB::table('users')->where('emid', $content['emid'])->whereIn('employee_id', $content['employee_id'])->whereNotNull('device_token')->pluck('device_token')->all();

            foreach ($content['employee_id'] as $value) {
                $userdata = DB::table('users')->where('emid', $content['emid'])->where('employee_id', $value['emp'])
                    ->first();
                if ($userdata->device_token != '') {
                    $notification_details[] = array("user_id" => $userdata->id);

                }
                $data = array(

                    'employee_id' => $value['emp'],
                    'emid' => $content['emid'],

                    'sub' => $content['sub'],

                    'content' => htmlspecialchars($content['content']),
                    'cr_date' => date('Y-m-d  h:i A'),
                    'read_fu' => '0',
                    'path' => 'employer',
                );

                DB::table('notification_em')->insert($data);

            }

            if (count($firebaseToken) != 0) {
                $body =
                    '{
"from":"employer",
"to":"employee",
"navigate":"notification",
"message":"' . $content['sub'] . '"
}';

                $regisdata = DB::table('registration')->where('reg', $content['emid'])
                    ->first();
                $data = array('notification_details' => $notification_details, 'body' => $body, 'title' => 'From ' . $regisdata->com_name);

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }
            return response()->json(['msg' => 'Notification is sent!', 'status' => 'true']);

        }

    }

    public function allnotiemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employer = DB::table('registration')->where('reg', '=', $Employee1->emid)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('notification_em.emid', '=', $Employer->reg)
                    ->where('employee.emp_code', '=', $Employee1->employee_id)
                    ->where('notification_em.employee_id', '=', $Employee1->employee_id)
                    ->where('notification_em.path', '=', 'employer')
                    ->orderBy('notification_em.id', 'DESC')
                    ->select('notification_em.*')->get();
                return response()->json(['status' => 'true', 'user_type' => 'employee', 'notification' => $employee_notification]);
            }if ($Employee1->user_type == 'employer') {

                $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('notification_em.emid', '=', $Employer->reg)

                    ->where('notification_em.path', '=', 'employee')
                    ->orderBy('notification_em.id', 'DESC')
                    ->select('notification_em.*', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.emp_image')->get();

                return response()->json(['status' => 'true', 'user_type' => 'employer', 'notification' => $employee_notification]);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function allnotcountiemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employer = DB::table('registration')->where('reg', '=', $Employee1->emid)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)

                    ->where('notification_em.emid', '=', $Employer->reg)
                    ->where('employee.emp_code', '=', $Employee1->employee_id)
                    ->where('notification_em.employee_id', '=', $Employee1->employee_id)
                    ->where('notification_em.read_fu', '=', '0')
                    ->where('notification_em.path', '=', 'employer')
                    ->orderBy('notification_em.id', 'DESC')
                    ->select('notification_em.*')->get();

                return response()->json(['status' => 'true', 'user_type' => 'employee', 'countnotification' => count($employee_notification)]);
            }if ($Employee1->user_type == 'employer') {

                $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('notification_em.emid', '=', $Employer->reg)
                    ->where('notification_em.read_fu', '=', '0')
                    ->where('notification_em.path', '=', 'employee')
                    ->orderBy('notification_em.id', 'DESC')
                    ->select('notification_em.*', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')->get();

                return response()->json(['status' => 'true', 'user_type' => 'employer', 'countnotification' => count($employee_notification)]);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function viewnotcountiemployee(Request $request)
    {

        $Employee1 = DB::table('users')->where('id', '=', $request->employee_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employer = DB::table('registration')->where('reg', '=', $Employee1->emid)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('notification_em.emid', '=', $Employer->reg)
                    ->where('employee.emp_code', '=', $Employee1->employee_id)
                    ->where('notification_em.employee_id', '=', $Employee1->employee_id)
                    ->where('notification_em.path', '=', 'employer')
                    ->where('notification_em.id', '=', $request->not_id)

                    ->select('notification_em.*', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')->first();
                $dataup = array(

                    'read_fu' => '1',
                );
                DB::table('notification_em')->where('id', $request->not_id)->update($dataup);
                return response()->json(['status' => 'true', 'user_type' => 'employee', 'notification' => $employee_notification]);
            }if ($Employee1->user_type == 'employer') {

                $Employer = DB::table('registration')->where('reg', '=', $Employee1->employee_id)->first();

                $employee_notification = DB::table('notification_em')->join('employee', 'notification_em.employee_id', '=', 'employee.emp_code')

                    ->where('employee.emid', '=', $Employer->reg)
                    ->where('notification_em.emid', '=', $Employer->reg)

                    ->where('notification_em.path', '=', 'employee')
                    ->where('notification_em.id', '=', $request->not_id)
                    ->select('notification_em.*', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')->first();
                $dataup = array(

                    'read_fu' => '1',
                );
                DB::table('notification_em')->where('id', $request->not_id)->update($dataup);
                return response()->json(['status' => 'true', 'user_type' => 'employer', 'countnotification' => $employee_notification]);

            }

        } else {

            return response()->json(['msg' => 'Your email and password was wrong!', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }
    public function adnotemployeeall(Request $request)
    {

        $content = $request->json()->all();

        $firebaseToken = DB::table('users')->where('employee_id', $content['emid'])->whereNotNull('device_token')->pluck('device_token')->all();

        $userdata = DB::table('users')->where('employee_id', $content['emid'])
            ->first();
        if ($userdata->device_token != '') {

            $notification_details[] = array("user_id" => $userdata->id);
        }
        $data = array(

            'employee_id' => $content['employee_id'],
            'emid' => $content['emid'],

            'sub' => $content['sub'],

            'content' => htmlspecialchars($content['content']),
            'cr_date' => date('Y-m-d  h:i A'),
            'read_fu' => '0',
            'path' => 'employee',
        );

        DB::table('notification_em')->insert($data);
        if (count($firebaseToken) != 0) {

            $body = '
		{
"from":"employee",
"to":"employer",
"navigate":"notification",
"message":"' . $content['sub'] . '"
}';
            $regisdata = DB::table('employee')->where('emid', $content['emid'])
                ->where('emp_code', $content['employee_id'])
                ->first();
            $data = array('notification_details' => $notification_details, 'body' => $body, 'title' => 'From ' . $regisdata->emp_fname . ' ' . $regisdata->emp_mname . ' ' . $regisdata->emp_lname);

            $server_output = '';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            $server_output = curl_exec($ch);

            $outputFrom = json_decode($server_output);

        }
        return response()->json(['msg' => 'Notification is sent!', 'status' => 'true']);

    }

    public function getversion()
    {

        $Roledata = DB::table('version')

            ->first();

        return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'version' => $Roledata]);

    }

    public function getpackage()
    {

        $Roledata = DB::Table('package')
            ->where('status', 'active')
            ->get();

        if (count($Roledata) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'package' => $Roledata]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'package' => $Roledata]);

        }

    }

    public function viewallblogs()
    {

        $data['blog_rs'] = DB::Table('blog')

            ->where('status', '=', 'active')
            ->limit(8)
            ->orderBy('id', 'desc')
            ->get();
        $data['total_blog_rs'] = DB::Table('blog')
            ->where('status', '=', 'active')
            ->orderBy('id', 'desc')
            ->get();
        $data['blog_cat_rs'] = DB::Table('blog_cat')
            ->where('status', '=', 'active')
            ->orderBy('id', 'desc')
            ->get();
        $data['blog_cat'] = 'all';
        if (count($data['total_blog_rs']) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'blog_rs' => $data['blog_rs'], 'total_blog_rs' => $data['total_blog_rs'], 'blog_cat_rs' => $data['blog_cat_rs']]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'blog_rs' => $data['blog_rs'], 'total_blog_rs' => $data['total_blog_rs'], 'blog_cat_rs' => $data['blog_cat_rs']]);

        }

    }

    public function viewablogsemployernat($nat_id)
    {

        $data['blog_rs'] = DB::Table('blog')
            ->where('status', '=', 'active')
            ->where('cat', '=', base64_decode($nat_id))
            ->limit(8)
            ->orderBy('id', 'desc')
            ->get();
        $data['total_blog_rs'] = DB::Table('blog')
            ->where('status', '=', 'active')
            ->where('cat', '=', base64_decode($nat_id))
            ->orderBy('id', 'desc')
            ->get();
        $data['blog_cat_rs'] = DB::Table('blog_cat')
            ->where('status', '=', 'active')
            ->orderBy('id', 'desc')
            ->get();
        $data['blog_cat'] = base64_decode($nat_id);
        if (count($data['blog_rs']) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'blog_rs' => $data['blog_rs'], 'total_blog_rs' => $data['total_blog_rs'], 'blog_cat_rs' => $data['blog_cat_rs'], 'blog_cat' => $data['blog_cat']]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'blog_rs' => $data['blog_rs'], 'total_blog_rs' => $data['total_blog_rs'], 'blog_cat_rs' => $data['blog_cat_rs'], 'blog_cat' => $data['blog_cat']]);

        }

    }
    public function viewallblogsid($career_id)
    {

        $data['blog_rs'] = DB::Table('blog')
            ->where('slug', '=', $career_id)

            ->first();
        $data['blog_cat'] = DB::Table('blog_cat')
            ->where('id', '=', $data['blog_rs']->cat)

            ->first();

        $blog_comment_rs = DB::Table('blog_comment')
            ->where('blog_id', '=', $data['blog_rs']->id)
            ->where('status', '=', 'Approved')
            ->orderBy('id', 'desc')
            ->get();
        if (!empty($data['blog_rs'])) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'blog_rs' => $data['blog_rs'], 'blog_cat' => $data['blog_cat'], 'blog_comment_rs' => $blog_comment_rs]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'blog_rs' => $data['blog_rs'], 'blog_cat' => $data['blog_cat'], 'blog_comment_rs' => $blog_comment_rs]);

        }

    }
    public function saveblogcommdd(Request $request)
    {

        $datareg = array(

            'blog_id' => $request->blog_id,

            'email' => $request->email,
            'comment' => $request->comment,
            'status' => 'Not Approved',
            'name' => $request->name,

            'cr_date' => date('Y-m-d H:i:s'),

        );
        DB::table('blog_comment')->insert($datareg);

        $bl = base64_encode($request->blog_id);

        return response()->json(['msg' => 'Comment Send Successfully', 'resultstatus' => 'true']);

    }

    public function vewallalllimit($last_video_id, $limit, $blog_cat)
    {

        $limit = $limit + 8;
        $result_status1 = '';

        if ($blog_cat == 'all') {

            $blog_rs = DB::Table('blog')

                ->where('status', '=', 'active')
                ->limit($limit)
                ->orderBy('blog.id', 'desc')
                ->get();
            $total_blog_rs = DB::Table('blog')
                ->where('status', '=', 'active')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $blog_rs = DB::Table('blog')
                ->where('status', '=', 'active')
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $total_blog_rs = DB::Table('blog')
                ->where('status', '=', 'active')
                ->orderBy('id', 'desc')
                ->get();
        }

        if (!empty($data['blog_rs'])) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'blog_rs' => $blog_rs, 'total_blog_rs' => $total_blog_rs]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'blog_rs' => $blog_rs, 'total_blog_rs' => $total_blog_rs]);

        }

    }

    public function viewallblogblogcatsid($career_id)
    {

        $data['blog_cat'] = DB::Table('blog_cat')
            ->where('id', '=', $career_id)

            ->first();

        if (!empty($data['blog_cat'])) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'name' => $data['blog_cat']->name]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'name' => '']);

        }

    }

    public function saveenquiryd(Request $request)
    {

        $datareg = array(

            'title' => $request->title,

            'f_name' => $request->f_name,
            'l_name' => $request->l_name,

            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'comment' => $request->comment,
            'job_title' => $request->job_title,

            'cr_date' => date('Y-m-d H:i:s'),

        );
        DB::table('enquiry')->insert($datareg);

        return response()->json(['msg' => 'Enquiry Send Successfully', 'resultstatus' => 'true']);

    }

    public function getcommunication($employer_id)
    {

        $Roledata = DB::table('employee')->join('users', 'employee.emp_code', '=', 'users.employee_id')

            ->where('employee.emid', '=', $employer_id)
            ->where('users.emid', '=', $employer_id)
            ->where('users.status', '=', 'active')
            ->where('users.user_type', '=', 'employee')
            ->select('employee.emp_code', 'employee.emp_fname', DB::raw('ifnull(employee.emp_mname,"") as emp_mname'), 'employee.emp_lname', 'employee.emp_ps_email', DB::raw('ifnull(employee.emp_ps_phone,"") as emp_ps_phone'))
            ->orderBy('employee.emp_fname', 'ASC')->get();

        if (count($Roledata) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'employees' => $Roledata]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'employees' => $Roledata]);

        }

    }

    public function dailyattandanceshow($employer_id)
    {
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
                    ->select('employee.emp_code', 'employee.emp_fname', DB::raw('ifnull(employee.emp_mname,"") as emp_mname'), 'employee.emp_lname', 'employee.emp_ps_email', DB::raw('ifnull(employee.emp_ps_phone,"") as emp_ps_phone'))
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

            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'attandence' => $dvalue]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'attandence' => $dvalue]);

        }

    }

    public function dailydutyrostershow($employer_id)
    {

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
            ->orderBy('employee.emp_fname', 'ASC')
            ->get();

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

            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'dutyroster' => $dataduty, 'date' => $date]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'dutyroster' => $dataduty]);

        }

    }

    public function employerleaveapprivere($employer_id)
    {

        $LeaveApply = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')
            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')

            ->where('employee.emid', '=', $employer_id)
            ->where('leave_type.emid', '=', $employer_id)
            ->where('leave_apply.emid', '=', $employer_id)

            ->orderBy('date_of_apply', 'DESC')
            ->get();

        if (count($LeaveApply) != 0) {
            return response()->json(['msg' => 'data found', 'resultstatus' => 'true', 'laevelist' => $LeaveApply]);

        } else {
            return response()->json(['msg' => 'data not found', 'resultstatus' => 'false', 'laevelist' => $LeaveApply]);

        }

    }

    public function employerleaveapprivereedit(Request $request)
    {

        $id = $request->id;

        $LeaveApply = DB::table('leave_apply')
            ->join('leave_type', 'leave_apply.leave_type', '=', 'leave_type.id')
            ->join('employee', 'leave_apply.employee_id', '=', 'employee.emp_code')

            ->select('leave_apply.*', 'leave_type.leave_type_name', 'leave_type.alies', 'employee.emp_status')
            ->where('leave_apply.id', '=', $id)
            ->where('leave_apply.emid', '=', $request->employer_id)
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
            ->where('leave_apply.employee_id', '=', $lv_aply)
            ->where('leave_apply.emid', '=', $request->employer_id)
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
            ->where('emid', '=', $request->employer_id)
            ->whereBetween('from_date', [$from, $to])
            ->whereBetween('to_date', [$from, $to])
            ->orderBy('date_of_apply', 'desc')
            ->first();

        if (!empty($LeaveApply)) {

            return response()->json(['msg' => 'Leave data found', 'status' => 'true', $LeaveApply, $Prev_leave, $totleave]);
        } else {

            return response()->json(['msg' => 'Sorry, No Leave Available', 'status' => 'false']);
        }

    }

    public function employerSaveLeavePermission(Request $request)
    {

        $leaveApply = DB::table('leave_apply')

            ->where('id', '=', $request->apply_id)

            ->first();

        $Allocation = DB::table('leave_allocation')
            ->where('employee_code', '=', $request->employee_id)
            ->where('leave_type_id', '=', $request->leave_type)
            ->where('emid', '=', $request->employer_id)

            ->where('month_yr', 'like', '%' . date('Y', strtotime($leaveApply->from_date)) . '%')
            ->get();

        $inhand = $Allocation[0]->leave_in_hand;

        $lv_sanc_auth = DB::table('employee')
            ->where('emp_code', '=', $request->employee_id)
            ->where('emid', '=', $request->employer_id)

            ->first();

        if (!empty($lv_sanc_auth)) {
            $lv_sanc_auth_name = $lv_sanc_auth->emp_lv_sanc_auth;
        } else {
            $lv_sanc_auth_name = '';
        }
        $laevetay = DB::table('leave_apply')->where('id', '=', $request->apply_id)->first();

        if ($request->leave_check == 'APPROVED') {

            $lv_inhand = $inhand - ($request->no_of_leave);

            if ($lv_inhand < 0) {
                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocation')
                    ->where('leave_type_id', '=', $request->leave_type)
                    ->where('employee_code', '=', $request->employee_id)
                    ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    ->update(['leave_in_hand' => $lv_inhand]);

                $LeaveApply = DB::table('leave_type')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', $request->employer_id)->first();

                if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '
		{
"from":"employer",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave  APPROVED successfully. ', 'status' => 'true']);
            }
        } else if ($request->leave_check == 'REJECTED') {
            DB::table('leave_apply')
                ->where('id', $request->apply_id)
                ->where('employee_id', $request->employee_id)
                ->where('emid', '=', $request->employer_id)
                ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

            $LeaveApply = DB::table('leave_type')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
                ->where('emid', $request->employer_id)->first();

            if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '
		{
"from":"employer",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Rejected Successfully ', 'status' => 'true']);

        } else if ($request->leave_check == 'RECOMMENDED') {

            $lv_inhand = $inhand - $request->no_of_leave;
            // dd($lv_inhand);
            if ($lv_inhand < 0) {

                return response()->json(['msg' => 'Insufficient Leave Balance ', 'status' => 'false']);

            } else {

                $emp_code = $request->employee_id;

                $sanc_auth = DB::table('employee')->where('emp_code', $request->employee_id)->where('emid', '=', $request->employer_id)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                $LeaveApply = DB::table('leave_type')

                    ->where('id', $request->leave_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

                $firebaseToken_report = DB::table('users')
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', $request->employer_id)->first();

                if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                    $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                    $bodyapprove = '
		{
"from":"employer",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                    $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                    $server_output = '';
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                    $server_output = curl_exec($ch);

                    $outputFrom = json_decode($server_output);

                }

                return response()->json(['msg' => 'Leave Recommended Successfully! ', 'status' => 'true']);

            }

        } else {

            $current_status = DB::table('leave_apply')->where('id', $request->apply_id)->first();
            if ($current_status->status == 'APPROVED' && $request->leave_check == 'CANCEL') {

                $lv_inhand = $inhand + $request->no_of_leave;
                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                DB::table('leave_allocation')
                    ->where('leave_type_id', $request->leave_type)
                    ->where('emid', '=', $request->employer_id)
                    ->where('employee_code', $request->employee_id)
                    ->update(['leave_in_hand' => $lv_inhand]);

            } else {
                DB::table('leave_apply')
                    ->where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->where('emid', '=', $request->employer_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
            }

            $LeaveApply = DB::table('leave_type')

                ->where('id', $request->leave_type)

                ->orderBy('id', 'DESC')
                ->first();
            $content = 'Your leave from ' . date('d/m/Y', strtotime($laevetay->from_date)) . ' to ' . date('d/m/Y', strtotime($laevetay->to_date)) . ' has been ' . strtolower($request->leave_check);

            $firebaseToken_report = DB::table('users')
                ->where('employee_id', $request->employee_id)
                ->where('emid', $request->employer_id)->first();

            if (!empty($firebaseToken_report) && $firebaseToken_report->device_token != '') {

                $notification_approver[] = array("user_id" => $firebaseToken_report->id);

                $bodyapprove = '
		{
"from":"employer",
"to":"employee",
"navigate":"dashboard",
"message":"' . $content . '"
}';
                $data = array('notification_details' => $notification_approver, 'body' => $bodyapprove, 'title' => 'Leave  ' . strtolower($request->leave_check));

                $server_output = '';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env("BASE_URL") . "api/send-notification");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $server_output = curl_exec($ch);

                $outputFrom = json_decode($server_output);

            }

            return response()->json(['msg' => 'Leave Cancel Successfully! ', 'status' => 'true']);

        }

    }

    public function update_device_token(Request $request)
    {

        $content = $request->json()->all();
        //dd($content['device_type']);
        $user_list = DB::table('users')->where('id', '=', $content['id'])->first();
        if (!empty($user_list)) {
            if (isset($content['device_type'])) {
                $content['device_type'] = $content['device_type'];
            } else {
                $content['device_type'] = 'A';
            }

            if (isset($content['device_token'])) {
                $content['device_token'] = $content['device_token'];
            } else {
                $content['device_token'] = '';
            }

            $datauser = array(
                'device_token' => $content['device_token'],
                'device_type' => $content['device_type'],

                'updated_at' => date('Y-m-d h:i:s'),

            );
            DB::table('users')
                ->where('id', '=', $content['id'])
                ->update($datauser);
            $response = ['status' => 'true', 'response' => array('message' => 'Token updated'), 'error' => ''];
        } else {
            $response = ['status' => 'true', 'response' => array('message' => 'No data found'), 'error' => ''];
        }

        return json_encode($response);

    }

    public function sendNotification(Request $request)
    {
        $content = $request->json()->all();
        $firebaseToken = DB::table('users')->whereIn('id', $content['notification_details'])->whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAm9WD-ew:APA91bGgSrpKEmFcUzc7uZcgA1yY1q3Ke5uAtCiYnAmg0GC5dok3eYmgZ1q9eNWf3PtxlHEHPT8jKML-7pezBLSyeRGu06Yn57DmtKUS0apDUzE3_MNUxtfayDMI1qr4QTrQ-Q32QnDY';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $content['title'],
                "body" => $content['body'],
            ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        $outputFrom = json_decode($response);

        if ($outputFrom->success = 1) {
            $response = ['status' => 'true', 'response' => array('message' => ' send'), 'error' => ''];

        } else {
            $response = ['status' => 'false', 'response' => array('message' => 'not send'), 'error' => ''];
            return json_encode($response);
        }

        return json_encode($response);

    }

    public function evidencework($user_id)
    {

        $Employee1 = DB::table('users')->where('id', '=', $user_id)->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $Employer = DB::table('registration')->where('reg', '=', $Employee1->emid)->first();

                $employee_work = DB::table('rota_employee')->where('employee_id', '=', $Employee1->employee_id)->where('emid', '=', $Employee1->emid)->orderBy('id', 'DESC')
                    ->paginate(10);

                $date = date('Y-m-d');
                $Roledata = DB::table('duty_roster')

                    ->whereDate('start_date', '<=', $date)
                    ->whereDate('end_date', '>=', $date)

                    ->where('duty_roster.employee_id', '=', $Employee1->employee_id)
                    ->where('duty_roster.emid', '=', $Employee1->emid)
                    ->first();

                if (!empty($Roledata)) {
                    $add = 'yes';
                } else {
                    $add = 'no';
                }
                return response()->json(['status' => 'true', 'user_type' => 'employee', 'add_button' => $add, 'evidencework' => $employee_work]);
            } else {

                return response()->json(['msg' => 'No data found', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'No data found', 'status' => 'false']);
        }

        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function evidenceworkadd(Request $request)
    {$content = $request->json()->all();

        $Employee1 = DB::table('users')->where('employee_id', '=', $content['employee_id'])->where('emid', '=', $content['emid'])->where('status', '=', 'active')->first();
        if (!empty($Employee1)) {
            if ($Employee1->user_type == 'employee') {
                $datein = strtotime(date("Y-m-d " . $content['in_time']));
                $dateout = strtotime(date("Y-m-d " . $content['out_time']));
                $difference = abs($dateout - $datein) / 60;
                $hours = floor($difference / 60);
                $minutes = ($difference % 60);
                $duty_hours = $hours . ":" . $minutes;

                $tot = $minutes + ($hours * 60);

                if (isset($content['file']) && !empty($content['file'])) {
                    $folderPath1 = "tasks/";

                    $image_base64_1 = base64_decode($content['file']);

                    $mime_type = finfo_buffer(finfo_open(), $image_base64_1, FILEINFO_MIME_TYPE);

                    $extension = $this->mime2ext($mime_type); // extract extension from mime type
                    $file = uniqid() . '.' . $extension; // rename file as a unique name
                    $file_dir = $folderPath1 . uniqid() . '.' . $extension;

                    Storage::disk('public')->put($file_dir, $image_base64_1);

                    $path_doc = $file_dir;

                } else {
                    $path_doc = '';
                }

                $datagg = array(
                    'employee_id' => $content['employee_id'],
                    'emid' => $content['emid'],
                    'file' => $path_doc,
                    'w_hours' => $hours,
                    'w_min' => $minutes,
                    'in_time' => date('h:i A', strtotime($content['in_time'])),
                    'out_time' => date('h:i A', strtotime($content['out_time'])),
                    'min_tol' => $tot,
                    'date' => date('Y-m-d', strtotime($content['date'])),

                    'remarks' => $content['remarks'],
                    'cr_date' => date('Y-m-d'),

                );
                DB::table('rota_employee')->insert($datagg);

                return response()->json(['status' => 'true', 'msg' => 'tasks saved']);
            } else {

                return response()->json(['msg' => 'tasks not saved', 'status' => 'false']);
            }

        } else {

            return response()->json(['msg' => 'tasks not saved', 'status' => 'false']);
        }

    }

    /*
    to take mime type as a parameter and return the equivalent extension
     */
    public function mime2ext($mime)
    {
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
    "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
    "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
    "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
    "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
    "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
    "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
    "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
    "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
    "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
    "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
    "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
    "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
    "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
    "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
    "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
    "pdf":["application\/pdf","application\/octet-stream"],
    "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
    "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
    "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
    "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
    "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
    "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
    "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
    "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
    "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
    "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
    "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
    "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
    "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
    "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
    "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
    "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
    "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
    "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
    "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
    "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
    "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
    "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
    "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
    "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
    "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
    "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
    "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
    "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes, true);
        foreach ($all_mimes as $key => $value) {
            if (array_search($mime, $value) !== false) {
                return $key;
            }

        }
        return false;
    }

    public function LeaveCountdate($employee_id, $from_date, $to_date, $leave_type)
    {
        $users = DB::table('users')->where('id', '=', $employee_id)->first();
        $satnew = 'Saturday';
        $sunnew = 'Sunday';
        $total_wk_days = 0;
        $date1_ts = strtotime($from_date);
        $date2_ts = strtotime($to_date);
        $diff = $date2_ts - $date1_ts;
        $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_type)->first();

        $Date1 = date('d-m-Y', strtotime($from_date));
        $Date2 = date('d-m-Y', strtotime($to_date));

        //dd($leave_tyepenew);

// Declare an empty arraya
        $array = array();

// Use strtotime function
        $Variable1 = strtotime($Date1);
        $Variable2 = strtotime($Date2);

// Use for loop to store dates into array
        // 86400 sec = 24 hrs = 60*60*24 = 1 day
        for ($currentDate = $Variable1; $currentDate <= $Variable2;
            $currentDate += (86400)) {

            $Store = date('Y-m-d', $currentDate);
            $array[] = $Store;
        }

        if (trim($leave_tyepenew->alies) == 'HOLIDAY' || trim($leave_tyepenew->alies) == 'H') {
            $total_wk_days = (round($diff / 86400) + 1);

            //dd($total_wk_days);

            $daysnew = 0;
            if (date('d', strtotime($from_date)) > $total_wk_days) {
                $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);
            } else if (date('d', strtotime($from_date)) != 1) {
                $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);
            } else {
                $total_wk_days = $total_wk_days;
            }
            if (date('d', strtotime($from_date)) == date('d', strtotime($to_date))) {
                $total_wk_days = date('d', strtotime($from_date));
            }
            foreach ($array as $valueogf) {

                $new_f = $valueogf;
                $duty_auth = DB::table('duty_roster')

                    ->where('employee_id', '=', $users->employee_id)
                    ->where('emid', '=', $users->emid)

                    ->orderBy('id', 'DESC')
                    ->first();

                $holidays = DB::table('holiday')
                    ->whereDate('from_date', '<=', $new_f)
                    ->whereDate('to_date', '>=', $new_f)

                    ->where('emid', '=', $users->emid)
                    ->first();

                $offg = array();
                if (!empty($duty_auth)) {

                    $shift_auth = DB::table('shift_management')

                        ->where('id', '=', $duty_auth->shift_code)

                        ->where('emid', '=', $users->emid)
                        ->orderBy('id', 'DESC')
                        ->first();
                    $off_auth = DB::table('offday')

                        ->where('shift_code', '=', $duty_auth->shift_code)

                        ->where('emid', '=', $users->emid)
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
                if (in_array(date('l', strtotime($new_f)), $offg)) {

                } else {
                    $daysnew++;
                }

            }

        } else {
            $diff = abs(strtotime($to_date) - strtotime($from_date));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;
            $daysnew = $days;
        }

        //echo $daysnew;

        return response()->json(['msg' => 'data  found!', 'status' => 'true', 'days' => $daysnew]);

    }

    public function getCompanyStatus(Request $request)
    {
        //dd($request->all());
        try {

            $response = array();
            if ($request->reg_email != '') {

                $password = $request->password;
                $reg_email = $request->reg_email;

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $reg_email)
                    ->where('pass', '=', $password)
                    ->first();

                $data['hr_apply'] = DB::Table('hr_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->get();

                $data['application_status'] = DB::Table('tareq_app')

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->get();

                $data['cos_status'] = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
                    ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
                    ->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
                    ->where('cos_apply.emid', '=', $data['Roledata']->reg)
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->get();

                $data['recruitement_status'] = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    
                    ->join('tareq_app', 'recruitment_file_emp.emid', '=', 'tareq_app.emid')
                    ->join('employee', 'employee.id', '=', 'recruitment_file_emp.com_employee_id', 'left')
                    ->where('recruitment_file_emp.emid', '=', $data['Roledata']->reg)
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->get();

                //dd($data);
                $response['status'] = 'success';
                $response['response'] = $data;
                $response['message'] = 'success';
            } else {
                $response['status'] = 'failure';
                $response['response'] = array();
                $response['message'] = 'No records found.';
            }
        } catch (Exception $e) {
            $response['status'] = 'failure';
            $response['response'] = array();
            $response['message'] = $e->getMessage();
        }

        return json_encode($response);
    }
}
