<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use PDF;
use Session;
use view;

class OrganisationController extends Controller
{
    public function viewdash()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                return View('status/dashboard', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewbillng()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

               

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('tareq_app')

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('ref_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->get();

                    //dd($data);

                return View('status/status-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function addbillng()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('billing')

                    ->get();
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->get();

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                return View('billing/billing-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewsendbilldetails($send_id)
    {try {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('billing')->where('id', '=', base64_decode($send_id))->first();
            $pass = DB::Table('registration')

                ->where('reg', '=', $job->emid)

                ->first();

            $add = '';
            $add = $pass->address;
            if ($pass->address2 != '') {
                $add .= ' ,' . $pass->address2;
            }
            if ($pass->road != '') {
                $add .= ' ,' . $pass->road;
            }
            if ($pass->city != '') {
                $add .= ' ,' . $pass->city;
            }
            if ($pass->zip != '') {
                $add .= ' ,' . $pass->zip;
            }
            if ($pass->country != '') {
                $add .= ' ,' . $pass->country;
            }
            $path = public_path() . '/billpdf/' . $job->dom_pdf;
            $data = array('name' => $pass->f_name . ' ' . $pass->l_name, 'com_name' => $pass->com_name, 'address' => $add);
            $toemail = $pass->email;

            Mail::send('mailbillsend', $data, function ($message) use ($toemail, $path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Bill Details');
                $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $data = array('name' => $pass->f_name . ' ' . $pass->l_name, 'com_name' => $pass->com_name, 'address' => $add);
            $toemail = $pass->organ_email;

            Mail::send('mailbillsend', $data, function ($message) use ($toemail, $path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Bill Details');
                $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $dataimgedit = array(
                'bill_send' => date('Y-m-d'),
            );
            DB::table('billing')

                ->where('id', '=', base64_decode($send_id))
                ->update($dataimgedit);

            Session::flash('message', 'Bill  send Successfully.');

            return redirect('billing/billinglist');
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function savebillng(Request $request)
    {try {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $lsatdeptnmdb = DB::table('billing')->whereYear('date', '=', date('Y'))->whereMonth('date', '=', date('m'))->orderBy('id', 'DESC')->first();

            if (empty($lsatdeptnmdb)) {
                $pid = date('Y') . '/' . date('m') . '/001';
            } else {
                $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdb->in_id);
                if ($str < 10) {
                    $pid = date('Y') . '/' . date('m') . '/00' . ($str + 1);
                } else if ($str < 99) {
                    $pid = date('Y') . '/' . date('m') . '/0' . ($str + 1);
                } else {
                    $pid = date('Y') . '/' . date('m') . '/' . ($str + 1);
                }

            }
            $pidhh = str_replace("/", "-", $pid);
            $filename = $pidhh . '.pdf';
            $Roledata = DB::Table('registration')
                ->where('status', '=', 'active')
                ->where('reg', '=', $request->emid)
                ->first();
            $datap = ['Roledata' => $Roledata, 'in_id' => $pid, 'des' => $request->des, 'date' => date('Y-m-d'), 'amount' => $request->amount];
            $pdf = PDF::loadView('mybillPDF', $datap);

            $pdf->save(public_path() . '/billpdf/' . $filename);

            $data = array(

                'in_id' => $pid,
                'emid' => $request->emid,
                'status' => 'not paid',
                'amount' => $request->amount,
                'due' => $request->amount,
                'des' => htmlspecialchars($request->des),
                'date' => date('Y-m-d'),
                'dom_pdf' => $filename,
            );

            DB::table('billing')->insert($data);

            Session::flash('message', 'Bill Added Successfully .');

            return redirect('billing/billinglist');
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewAddbillingy($comp_id)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['tareq'] = DB::table('tareq_app')
                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                return View('status/status-edit', $data);

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveAddbillingy(Request $request)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->last_date != '') {
                    $last_date = date('Y-m-d', strtotime($request->last_date));
                } else {
                    $last_date = '';
                }

                if ($request->last_sub != '') {
                    $last_sub = date('Y-m-d', strtotime($request->last_sub));
                } else {
                    $last_sub = '';
                }

                //dd($request->all());
                $existingCompanyInfo = DB::table('registration')->where('status', '=', 'active')->where('reg', $request->emid)->first();
                $datagg = array(
                    'last_date' => $last_date,
                    'last_sub' => $last_sub,
                    'remark_su' => $request->remark_su,
                    'hr_in' => $request->hr_in,
                    'invoice_se' => $request->invoice_se,
                    'need_action' => $request->need_action,
                    'other_action' => $request->other_action,
                    'invoice' => $request->invoice,
                    'update_new_ct' => date('Y-m-d'),
                );
                DB::table('tareq_app')->where('id', $request->id)->update($datagg);

                if ($last_date != '') {
                    $request->licence = 'yes';
                    $datareg = array(
                        'licence' => $request->licence,
                        'license_type' => $request->license_type,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('reg', $request->emid)->update($datareg);

                    if ($existingCompanyInfo->licence != 'yes' && $request->licence == 'yes' && $existingCompanyInfo->license_type=='Internal') {

                       // dd('mail section');
                        //mail to case worker for assignment of organisation
                        $data_email = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the HR File.');

                        //$toemail = 'm.subhasish@gmail.com';
                        $toemail = 'hr@workpermitcloud.co.uk';
                        //$toemail = 'manager@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('New Unassigned HR');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        $data_email = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the Recruitement File.');

                        //$toemail = 'm.subhasish@gmail.com';
                        $toemail = 'recruitment@workpermitcloud.co.uk';
                        //$toemail = 'manager@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('New Recruitment organisation');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        $toemail = 'm.subhasish@gmail.com';
                        // $toemail = 'hr@workpermitcloud.co.uk';
                        //$toemail = 'manager@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('New Unassigned HR');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        $data_email = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the Recruitement File.');

                        $toemail = 'm.subhasish@gmail.com';
                        // $toemail = 'recruitment@workpermitcloud.co.uk';
                        //$toemail = 'manager@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('New Recruitment organisation');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        // $data_email = array('to_name' => '', 'body_content' => 'First license invoice need to be raised for Organisation with name "' . $existingCompanyInfo->com_name . '". Please proceed with the needful.');

                        // $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 1st Invoice.<p> Organisation with name "' . $existingCompanyInfo->com_name . '" .</p><p>Invoice Amount: £750 plus VAT</p>');

                        // $toemail = 'invoice@workpermitcloud.co.uk';
                        // Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        //     $message->to($toemail, 'Workpermitcloud')->subject
                        //         ('First license invoice');
                        //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        // });

                        if($existingCompanyInfo->authemail !=null || trim($existingCompanyInfo->authemail) !=''){
                            
                            $toemail = $existingCompanyInfo->authemail;
                            Mail::send('mailsmsla', $data_email, function ($message) use ($toemail) {
                                $message->to($toemail, 'Workpermitcloud')->subject
                                    ('Need action to prepare HR File');
                                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                            });
                            $toemail = 'm.subhasish@gmail.com';
                            Mail::send('mailsmsla', $data_email, function ($message) use ($toemail) {
                                $message->to($toemail, 'Workpermitcloud')->subject
                                    ('Need action to prepare HR File');
                                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                            });
                        }


                    }

                } else {
                    $datareg = array(
                        'license_type' => $request->license_type,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('reg', $request->emid)->update($datareg);
                }

                Session::flash('message', ' Application Assign Changed Successfully .');

                return redirect('organisation-status/view-application');

            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewreminder()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('reminder')

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->get();

                return View('status/reminder-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddremindery()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('reminder')

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->get();

                return View('status/reminder-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function saveAddremindery(Request $request)
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {$member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data = array(

                    'emid' => $data['Roledata']->reg,
                    'employee_id' => $member,

                    'type' => $request->type,
                    'remarks' => htmlspecialchars($request->remarks),

                    'date' => date('Y-m-d'),
                    'time' => date('h:i:s A'),
                    'date_new' => date('Y-m-d', strtotime($request->date)),
                    'time_new' => date('h:i A', strtotime($request->time)),
                );

                DB::table('reminder')->insert($data);

                Session::flash('message', ' Invoice Reminder Added Successfully .');

                return redirect('organisation-status/view-reminder');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewhr()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('hr_apply')

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->get();

                return View('status/hr-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddhry()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('company_job')

                    ->where('emid', '=', $data['Roledata']->reg)

                    ->orderBy('id', 'asc')
                    ->first();

                return View('status/hr-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddhry(Request $request)
    {

        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {$member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->due_date != '') {
                    $due = date('Y-m-d', strtotime($request->due_date));
                } else {
                    $due = '';
                }

                if ($request->sub_due_date != '') {
                    $su_due = date('Y-m-d', strtotime($request->sub_due_date));
                } else {
                    $su_due = '';
                }

                if ($request->target_date != '') {
                    $tar_due = date('Y-m-d', strtotime($request->target_date));
                } else {
                    $tar_due = '';
                }
                if ($request->visa_date != '') {
                    $vis_due = date('Y-m-d', strtotime($request->visa_date));
                } else {
                    $vis_due = '';
                }

                $datahh = array(

                    'emid' => $data['Roledata']->reg,
                    'employee_id' => $member,
                    'job_date' => date('Y-m-d', strtotime($request->job_date)),
                    'hr_file_date' => date('Y-m-d', strtotime($request->hr_file_date)),

                    'job_ad' => $request->job_ad,
                    'remarks' => $request->remarks,
                    'inpect' => $request->inpect,
                    'due_date' => $due,
                    'sub_due_date' => $su_due,
                    'licence' => $request->licence,
                    'identified' => $request->identified,
                    'preparation' => $request->preparation,
                    'home_off' => $request->home_off,
                    'rect_deatils' => $request->rect_deatils,
                    'date' => date('Y-m-d'),
                    'status' => 'Incomplete',

                    'update_new_ct' => date('Y-m-d'),

                );

                DB::table('hr_apply')->insert($datahh);

                if ($request->licence == 'Granted') {
                    //mail to case worker for assignment of organisation
                    $data_email = array('to_name' => '', 'body_content' => 'License granted for Organisation with name "' . $data['Roledata']->com_name . '" . Please proceed with the needful for recruitment.');

                    //$toemail = 'm.subhasish@gmail.com';
                    $toemail = 'recruitment@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Organisation License Granted');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 2nd Invoice.<p> Organisation with name "' . $data['Roledata']->com_name . '" .</p><p>Invoice Amount: £750 plus VAT</p>');

                    $toemail = 'invoice@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Organisation License Granted');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }

                Session::flash('message', ' HR File Added Successfully .');

                return redirect('organisation-status/view-hr');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddhrnew($comp_id)
    {
        try {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['or_de'] = DB::Table('registration')
                ->where('status', '=', 'active')

                ->get();

            $data['user'] = DB::Table('users_admin_emp')
                ->where('status', '=', 'active')

                ->get();

            $data['ref'] = DB::Table('reffer_mas')
                ->where('status', '=', 'active')

                ->get();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['hr'] = DB::table('hr_apply')

                ->where('id', '=', base64_decode($comp_id))
                ->first();
            return View('status/hr-edit', $data);

        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function saveAddhrgynew(Request $request)
    {
        try { 
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                    //dd($data['Roledata']->license_type);

                $data['hrapply'] = DB::table('hr_apply')->where('id', $request->id)->first();

                if ($request->due_date != '') {
                    $due = date('Y-m-d', strtotime($request->due_date));
                } else {
                    $due = '';
                }

                if ($request->sub_due_date != '') {
                    $su_due = date('Y-m-d', strtotime($request->sub_due_date));
                } else {
                    $su_due = '';
                }

                if ($request->target_date != '') {
                    $tar_due = date('Y-m-d', strtotime($request->target_date));
                } else {
                    $tar_due = '';
                }
                if ($request->visa_date != '') {
                    $vis_due = date('Y-m-d', strtotime($request->visa_date));
                } else {
                    $vis_due = '';
                }
                if ($request->home_visit_date != '') {
                    $home_visit_date = date('Y-m-d', strtotime($request->home_visit_date));
                } else {
                    $home_visit_date = '';
                }
                if ($request->refused_date != '') {
                    $refused_date = date('Y-m-d', strtotime($request->refused_date));
                } else {
                    $refused_date = '';
                }
                if ($request->grant_date != '') {
                    $grant_date = date('Y-m-d', strtotime($request->grant_date));
                } else {
                    $grant_date = '';
                }
                if ($request->reject_date != '') {
                    $reject_date = date('Y-m-d', strtotime($request->reject_date));
                } else {
                    $reject_date = '';
                }
                if ($request->hr_reply_date != '') {
                    $hr_reply_date = date('Y-m-d', strtotime($request->hr_reply_date));
                } else {
                    $hr_reply_date = null;
                }
                $datagg = array(
                    'job_ad' => $request->job_ad,
                    'remarks' => $request->remarks,
                    'inpect' => $request->inpect,
                    'due_date' => $due,
                    'sub_due_date' => $su_due,
                    'home_visit_date' => $home_visit_date,
                    'licence' => $request->licence,
                    'identified' => $request->identified,
                    'preparation' => $request->preparation,
                    'home_off' => $request->home_off,
                    'rect_deatils' => $request->rect_deatils,
                    'need_action' => $request->need_action,
                    'other_action' => $request->other_action,
                    'refused_date' => $refused_date,
                    'grant_date' => $grant_date,
                    'reject_date' => $reject_date,
                    'hr_reply_date' => $hr_reply_date,
                    'status' => $request->status,

                    'update_new_ct' => date('Y-m-d'),

                );
                DB::table('hr_apply')->where('id', $request->id)->update($datagg);

                if ($request->licence == 'Granted' && $data['hrapply']->licence != 'Granted' && $data['Roledata']->license_type=='Internal') {
                    //mail to case worker for assignment of organisation
                    $data_email = array('to_name' => '', 'body_content' => 'License granted for Organisation with name "' . $data['Roledata']->com_name . '" . Please proceed with the needful for recruitment.');

                    //$toemail = 'm.subhasish@gmail.com';
                    $toemail = 'recruitment@workpermitcloud.co.uk';
                    Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Organisation License Granted');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                    // $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 1st Invoice.<p> Organisation with name "' . $data['Roledata']->com_name . '" .</p><p>Invoice Amount: £750 plus VAT</p>');

                    // $toemail = 'invoice@workpermitcloud.co.uk';
                    // Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                    //     $message->to($toemail, 'Workpermitcloud')->subject
                    //         ('Organisation License Granted');
                    //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    // });

                }

                Session::flash('message', ' HR File Changed Successfully .');

                return redirect('organisation-status/view-hr');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewcos()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['cos_apply'] = DB::Table('cos_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                //->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                $data['recruitment'] = DB::Table('recruitment_file_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->first();

                // dd($cos_apply);

                $data['bill_rs'] = DB::Table('cos_apply_emp')
                //->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id as wpc_employee', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id as wpc_employee')
                    ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
                // ->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'right')
                    ->where('cos_apply.emid', '=', $data['Roledata']->reg)
                    ->whereNotNull('cos_apply_emp.employee_id')
                // ->where('cos_apply.employee_id', '=', $member)
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->get();

                // dd($data['bill_rs']);

                // $data['bill_rs'] = DB::Table('cos_apply')

                //     ->where('emid', '=', $data['Roledata']->reg)
                //     ->where('employee_id', '=', $member)
                //     ->orderBy('id', 'desc')
                //     ->get();

                //return View('status/cos-list', $data);
                return View('status/cos-list-new', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewVisaFile()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['visa_file_apply'] = DB::Table('visa_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                // dd($cos_apply);

                $data['bill_rs'] = DB::Table('visa_file_emp')
                //->select('visa_file_emp.*', 'visa_file_apply.id as cosid', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('visa_file_emp.*')
                    //->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //->join('employee', 'employee.id', '=', 'visa_file_emp.com_employee_id', 'right')
                    ->where('visa_file_emp.emid', '=', $data['Roledata']->reg)
                    ->whereNotNull('visa_file_emp.employee_id')
                 ->where('visa_file_emp.employee_id', '=', $member)
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->get();

                //dd($data['bill_rs']);

                return View('status/visa-file-apply-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewRecruitmentFile()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['recruitment_file_apply'] = DB::Table('recruitment_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                // dd($data);

                $data['bill_rs'] = DB::Table('recruitment_file_emp')
                //->select('recruitment_file_emp.*', 'recruitment_file_apply.id as cosid', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('recruitment_file_emp.*', 'recruitment_file_apply.id as cosid', DB::raw("(select stage from stages where id= recruitment_file_emp.stage_id) as stage_name"))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                // ->join('employee', 'employee.id', '=', 'recruitment_file_emp.com_employee_id', 'right')
                    ->where('recruitment_file_apply.emid', '=', $data['Roledata']->reg)
                //->where('recruitment_file_apply.employee_id', '=', $member)
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->get();

                //dd($data['bill_rs']);

                return View('status/recruitment-file-apply-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddcosy()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['cos_apply'] = DB::Table('cos_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                // $data['hr'] = DB::table('cos_apply')
                //     ->where('id', '=', base64_decode($comp_id))
                //     ->first();

                //sm 29-11-2021
                // $data['cos_emp'] = DB::table('cos_apply_emp')
                //     ->where('com_cos_apply_id', '=', base64_decode($comp_id))
                //     ->first();
                //dd($data);
                return View('status/cos-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewAddVisaFile()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['visa_file_apply'] = DB::Table('visa_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                return View('status/visa-file-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewAddRecruitmentFile()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['stages'] = DB::Table('stages')
                    ->where('is_active', '=', 'Y')
                    ->where('module', '=', 'recruitment')
                    ->orderBy('stages.stage', 'asc')
                    ->get();

                $data['recruitment_file_apply'] = DB::Table('recruitment_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                return View('status/recruitment-file-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveAddcosy(Request $request)
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                //dd($request->all());

                $member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['cos_apply'] = DB::Table('cos_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                $data['cos_apply_emp'] = DB::Table('cos_apply_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_name', '=', $request->employee_name)
                    ->orderBy('id', 'desc')
                    ->first();

                //dd(!empty($data['cos_apply_emp']));

                if (!empty($data['cos_apply_emp'])) {
                    Session::flash('message', ' COS File Already Added.');
                    return redirect('organisation-status/view-cos');
                }

                if ($request->target_date != '') {
                    $tar_due = date('Y-m-d', strtotime($request->target_date));
                } else {
                    $tar_due = '';
                }
                if ($request->visa_date != '') {
                    $vis_due = date('Y-m-d', strtotime($request->visa_date));
                } else {
                    $vis_due = '';
                }
                if ($request->additional_info_request_date != '') {
                    $additional_info_request_date = date('Y-m-d', strtotime($request->additional_info_request_date));
                } else {
                    $additional_info_request_date = '';
                }
                if ($request->additional_info_sent_date != '') {
                    $additional_info_sent_date = date('Y-m-d', strtotime($request->additional_info_sent_date));
                } else {
                    $additional_info_sent_date = '';
                }
                if ($request->cos_assigned_date != '') {
                    $cos_assigned_date = date('Y-m-d', strtotime($request->cos_assigned_date));
                } else {
                    $cos_assigned_date = '';
                }

                $datahh = array(
                    'emid' => $data['Roledata']->reg,
                    'com_employee_id' => $request->com_employee_id,
                    'employee_name' => $request->employee_name,
                    'com_cos_apply_id' => $data['cos_apply']->id,
                    'employee_id' => $member,
                    'cos' => $request->cos,
                    'applied_cos_date' => $request->applied_cos_date,
                    'type_of_cos' => $request->type_of_cos,
                    // 'type_of_cos_date' => $request->type_of_cos_date,
                    'additional_info_requested' => $request->additional_info_requested,
                    'additional_info_request_date' => $additional_info_request_date,
                    'additional_info_sent' => $request->additional_info_sent,
                    'additional_info_sent_date' => $additional_info_sent_date,
                    'cos_assigned' => $request->cos_assigned,
                    'cos_assigned_date' => $cos_assigned_date,

                    // 'client' => $request->client,
                    // 'other' => $request->other,
                    'remarks_cos' => $request->remarks_cos,
                    // 'target_date' => $tar_due,
                    // 'identified' => $request->identified,
                    // 'allocation_status' => $request->allocation_status,
                    // 'job_offer_status' => $request->job_offer_status,
                    // 'visa_app' => $request->visa_app,
                    // 'visa_date' => $vis_due,
                    // 'fur_query' => $request->fur_query,
                    // 'visa_stat' => $request->visa_stat,
                    // 'appeal' => $request->appeal,
                    // 'responsible' => $request->responsible,
                    // 'app_stat' => $request->app_stat,
                    // 'app_out' => $request->app_out,
                    // 'cos_aloca' => $request->cos_aloca,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'update_new_ct' => date('Y-m-d'),
                );

                //dd($datahh);

                DB::table('cos_apply_emp')->insert($datahh);
                if ($request->status == 'Granted') {

                    $visa_file_apply = DB::Table('visa_file_apply')
                        ->where('emid', '=', $data['Roledata']->reg)
                        ->orderBy('id', 'desc')
                        ->first();

                    if (!empty($visa_file_apply)) {
                        //visa assigned
                        $visa_file_emp = DB::Table('visa_file_emp')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->get();

                        if (count($visa_file_emp) > 0) {
                            //visa emp already exist
                            // Do nothing
                        } else {
                            //visa emp doesn't exist but visa assigned
                            //Add employee to visa with blank case worker
                            $dataVisaEmp = array(
                                'emid' => $data['Roledata']->reg,
                                'employee_id' => null,
                                'com_employee_id' => null,
                                'employee_name' => $request->employee_name,
                                'com_visa_apply_id' => $visa_file_apply->id,
                                'cos_assigned' => null,
                                'visa_application_started' => null,
                                'visa_application_start_date' => null,
                                'visa_application_submitted' => null,
                                'visa_application_submit_date' => null,
                                'biometric_appo_date' => null,
                                'documents_uploaded' => null,
                                'interview_date_confirm' => null,
                                'interview_date' => null,
                                'mock_interview_confirm' => null,
                                'mock_interview_date' => null,
                                'remarks' => null,
                                'date' => date('Y-m-d'),
                                'status' => null,
                                'update_new_ct' => date('Y-m-d'),
                            );

                            DB::table('visa_file_emp')->insert($dataVisaEmp);

                            if ($request->cos_assigned == 'Yes') {

                                $toemail = 'visa@workpermitcloud.co.uk';

                                $data_email = array('to_name' => '', 'body_content' => 'COS already Issued/Allocate, please go ahead for Visa Application. <p>Organisation name "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '".</p><p>Type of CoS: "' . $request->type_of_cos . '"</p><p>Cos Assigned Date: ' . $cos_assigned_date . '</p> Please proceed with the needful.');

                                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Request for VISA');
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });

                                $toemail = 'invoice@workpermitcloud.co.uk';

                                $data_email = array('to_name' => '', 'body_content' => 'Please issue the 2nd invoice for Cos allocation and Visa processing.<p> Organisation with name "' . $data['Roledata']->com_name . '".</p><p>Candidate Name: "' . $request->employee_name . '".</p><p>CoS Type: "' . $request->type_of_cos . '"</p><p>Invoice Amount: £1050 plus VAT.</p><p>Note: UK Address VAT will be applicable.</p>');

                                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Request for Recruitment Second Bill');
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });

                            }

                        }

                    } else {
                        //visa not assigned
                        //Add visa assign with blank case worker
                        //Add visa emp to visa with blank case worker
                        $dataVisa = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $visaAdd = DB::table('visa_file_apply')->insert($dataVisa);

                        $visa_file_apply = DB::Table('visa_file_apply')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_apply->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                    }

                    if ($request->cos_assigned == 'Yes') {

                        $toemail = 'visa@workpermitcloud.co.uk';

                        $data_email = array('to_name' => '', 'body_content' => 'COS already Issued/Allocate, please go ahead for Visa Application. <p>Organisation name "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '".</p><p>Type of CoS: "' . $request->type_of_cos . '"</p><p>Cos Assigned Date: ' . $cos_assigned_date . '</p> Please proceed with the needful.');

                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Request for VISA');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        $toemail = 'invoice@workpermitcloud.co.uk';

                        $data_email = array('to_name' => '', 'body_content' => 'Please issue the 2nd invoice for Cos allocation and Visa processing.<p> Organisation with name "' . $data['Roledata']->com_name . '".</p><p>Candidate Name: "' . $request->employee_name . '".</p><p>CoS Type: "' . $request->type_of_cos . '"</p><p>Invoice Amount: £1050 plus VAT.</p><p>Note: UK Address VAT will be applicable.</p>');

                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Request for Recruitment Second Bill');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                    }

                }

                Session::flash('message', ' COS File Added Successfully .');

                return redirect('organisation-status/view-cos');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function saveAddVisaFile(Request $request)
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                //dd($request->all());

                $member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['visa_file_apply'] = DB::Table('visa_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                $data['visa_file_emp'] = DB::Table('visa_file_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_name', '=', $request->employee_name)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($data['visa_file_emp'])) {
                    Session::flash('message', ' Visa File Already Added.');
                    return redirect('organisation-status/view-visa-file');
                }

                if ($request->visa_application_start_date != '') {
                    $visa_application_start_date = date('Y-m-d', strtotime($request->visa_application_start_date));
                } else {
                    $visa_application_start_date = null;
                }
                if ($request->visa_application_submit_date != '') {
                    $visa_application_submit_date = date('Y-m-d', strtotime($request->visa_application_submit_date));
                } else {
                    $visa_application_submit_date = null;
                }
                if ($request->biometric_appo_date != '') {
                    $biometric_appo_date = date('Y-m-d', strtotime($request->biometric_appo_date));
                } else {
                    $biometric_appo_date = null;
                }
                if ($request->interview_date != '') {
                    $interview_date = date('Y-m-d', strtotime($request->interview_date));
                } else {
                    $interview_date = null;
                }

                if ($request->mock_interview_date != '') {
                    $mock_interview_date = date('Y-m-d', strtotime($request->mock_interview_date));
                } else {
                    $mock_interview_date = null;
                }
                if ($request->visa_granted_date != '') {
                    $visa_granted_date = date('Y-m-d', strtotime($request->visa_granted_date));
                } else {
                    $visa_granted_date = null;
                }

                $datahh = array(
                    'emid' => $data['Roledata']->reg,
                    'employee_id' => $member,
                    'com_employee_id' => $request->com_employee_id,
                    'employee_name' => $request->employee_name,
                    'com_visa_apply_id' => $data['visa_file_apply']->id,
                    'cos_assigned' => $request->cos_assigned,
                    'candidate_type' => $request->candidate_type,
                    'visa_application_started' => $request->visa_application_started,
                    'visa_application_start_date' => $visa_application_start_date,
                    'visa_application_submitted' => $request->visa_application_submitted,
                    'visa_application_submit_date' => $visa_application_submit_date,
                    'biometric_appo_date' => $biometric_appo_date,
                    'documents_uploaded' => $request->documents_uploaded,
                    'interview_date_confirm' => $request->interview_date_confirm,
                    'interview_date' => $interview_date,
                    'mock_interview_confirm' => $request->mock_interview_confirm,
                    'mock_interview_date' => $mock_interview_date,
                    'visa_granted_date' => $visa_granted_date,

                    'remarks' => $request->remarks,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'update_new_ct' => date('Y-m-d'),
                );

                //dd($datahh);

                DB::table('visa_file_emp')->insert($datahh);

                Session::flash('message', ' Visa File Added Successfully .');

                return redirect('organisation-status/view-visa-file');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddRecruitmentFile(Request $request)
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                //dd($request->all());

                $member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['recruitment_file_apply'] = DB::Table('recruitment_file_apply')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_id', '=', $member)
                    ->orderBy('id', 'desc')
                    ->first();

                $data['recruitment_file_emp'] = DB::Table('recruitment_file_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->where('employee_name', '=', $request->employee_name)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($data['recruitment_file_emp'])) {
                    Session::flash('message', ' Recruitment File Already Added.');
                    return redirect('organisation-status/view-recruitment-file');
                }

                if ($request->advert_start_date != '') {
                    $advert_start_date = date('Y-m-d', strtotime($request->advert_start_date));
                } else {
                    $advert_start_date = null;
                }
                if ($request->advert_end_date != '') {
                    $advert_end_date = date('Y-m-d', strtotime($request->advert_end_date));
                } else {
                    $advert_end_date = null;
                }
                if ($request->date_of_interview != '') {
                    $date_of_interview = date('Y-m-d', strtotime($request->date_of_interview));
                } else {
                    $date_of_interview = null;
                }
                if ($request->candidate_hired_date != '') {
                    $candidate_hired_date = date('Y-m-d', strtotime($request->candidate_hired_date));
                } else {
                    $candidate_hired_date = null;
                }

                $datahh = array(
                    'emid' => $data['Roledata']->reg,
                    'employee_id' => $member,
                    'com_employee_id' => $request->com_employee_id,
                    'employee_name' => $request->employee_name,
                    'employee_email' => $request->employee_email,
                    'employee_address' => $request->employee_address,
                    'employee_phone' => $request->employee_phone,
                    'com_recruitment_apply_id' => $data['recruitment_file_apply']->id,
                    'candidate_identified' => $request->candidate_identified,
                    'advert_posted' => $request->advert_posted,
                    'advert_start_date' => $advert_start_date,
                    'advert_end_date' => $advert_end_date,
                    'candidate_applied' => $request->candidate_applied,
                    'date_of_interview' => $date_of_interview,
                    'candidate_hired' => $request->candidate_hired,
                    'candidate_hired_date' => $candidate_hired_date,

                    'soc' => $request->soc,
                    'position' => $request->position,
                    'candidate_id' => $request->candidate_id,
                    'candidate_type' => $request->candidate_type,
                    'reffered' => $request->reffered,
                    'correspondense_addr' => $request->correspondense_addr,

                    'remarks' => $request->remarks,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'stage_id' => ($request->stage_id == '') ? 0 : $request->stage_id,
                    'update_new_ct' => date('Y-m-d'),
                );

                //dd($datahh);

                DB::table('recruitment_file_emp')->insert($datahh);

                $existingRecEmp = DB::table('recruitment_file_emp')
                    ->where('emid', $data['Roledata']->reg)
                    ->where('employee_id', $member)
                    ->where('employee_name', $request->employee_name)
                    ->first();

                //if ($existingRecEmp->stage_id != $request->stage_id) {
                //Add to history table
                $datahh = array(
                    'emid' => $existingRecEmp->emid,
                    'employee_id' => $existingRecEmp->employee_id,
                    'com_employee_id' => $existingRecEmp->com_employee_id,
                    'employee_name' => $request->employee_name,
                    'com_recruitment_apply_id' => $existingRecEmp->com_recruitment_apply_id,
                    'candidate_identified' => $request->candidate_identified,
                    'advert_posted' => $request->advert_posted,
                    'advert_start_date' => $request->advert_start_date,
                    'advert_end_date' => $request->advert_end_date,
                    'candidate_applied' => $request->candidate_applied,
                    'date_of_interview' => $request->date_of_interview,
                    'candidate_hired' => $request->candidate_hired,
                    'candidate_hired_date' => $request->candidate_hired_date,

                    'remarks' => $request->remarks,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'stage_id' => ($request->stage_id == '') ? 0 : $request->stage_id,
                    'update_new_ct' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                //dd($datahh);

                DB::table('recruitment_file_emp_history')->insert($datahh);

                //}

                $toemail = 'invoice@workpermitcloud.co.uk';

                $data_email = array('to_name' => '', 'body_content' => 'Please issue the 1st invoice for Recruitment. <p>Organisation with name "' . $data['Roledata']->com_name . '".</p><p>Candidate Name: "' . $request->employee_name . '"</p><p>Invoice Amount: £1000 plus VAT</p> Note: UK Address VAT will be applicable.');
                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ('Organisation Generate Recruitment Invoice');
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });


                if ($request->status == 'Hired') {

                    $cos_apply = DB::Table('cos_apply')
                        ->where('emid', '=', $data['Roledata']->reg)
                        ->orderBy('id', 'desc')
                        ->first();

                    if (!empty($cos_apply)) {
                        //cos assigned
                        $cos_apply_emp = DB::Table('cos_apply_emp')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->get();

                        if (count($cos_apply_emp) > 0) {
                            //cos emp already exist
                            // Do nothing
                        } else {
                            //cos emp doesn't exist but cos assigned
                            //Add employee to cos with blank case worker
                            $dataCosEmp = array(
                                'emid' => $data['Roledata']->reg,
                                'com_employee_id' => null,
                                'employee_name' => $request->employee_name,
                                'com_cos_apply_id' => $cos_apply->id,
                                'employee_id' => null,
                                'cos' => null,
                                'applied_cos_date' => null,
                                'type_of_cos' => null,
                                'additional_info_requested' => null,
                                'additional_info_request_date' => null,
                                'additional_info_sent' => null,
                                'additional_info_sent_date' => null,
                                'cos_assigned' => null,
                                'cos_assigned_date' => null,

                                'remarks_cos' => null,
                                'date' => date('Y-m-d'),
                                'status' => null,
                                'update_new_ct' => date('Y-m-d'),
                            );

                            DB::table('cos_apply_emp')->insert($dataCosEmp);

                        }

                    } else {
                        //cos not assigned
                        //Add Cos assign with blank case worker
                        //Add Cos emp to cos with blank case worker
                        $dataCos = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $cosAdd = DB::table('cos_apply')->insert($dataCos);

                        $cos_apply_add = DB::Table('cos_apply')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataCosEmp = array(
                            'emid' => $data['Roledata']->reg,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_cos_apply_id' => $cos_apply_add->id,
                            'employee_id' => null,
                            'cos' => null,
                            'applied_cos_date' => null,
                            'type_of_cos' => null,
                            'additional_info_requested' => null,
                            'additional_info_request_date' => null,
                            'additional_info_sent' => null,
                            'additional_info_sent_date' => null,
                            'cos_assigned' => null,
                            'cos_assigned_date' => null,

                            'remarks_cos' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('cos_apply_emp')->insert($dataCosEmp);

                    }

                    $toemail = 'cos@workpermitcloud.co.uk';

                    if ($toemail != '') {

                        $data_email = array('to_name' => '', 'body_content' => 'The candidate is hired. Go ahead with requesting COS. <p>Organisation Name: "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '"</p> has been requested for COS after hired. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Request For COS');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });
                    }

                }

                Session::flash('message', ' Recruitment File Added Successfully .');

                return redirect('organisation-status/view-recruitment-file');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddcosnew($comp_id)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['recruitment'] = DB::Table('recruitment_file_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->first();

                // $data['hr'] = DB::table('cos_apply')
                //     ->where('id', '=', base64_decode($comp_id))
                //     ->first();

                $data['hr'] = DB::Table('cos_apply_emp')
                //->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('cos_apply_emp.*', 'cos_apply.id as cosid')
                    ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
                //->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'right')
                    ->where('cos_apply_emp.id', '=', base64_decode($comp_id))
                    ->first();

                //echo base64_decode($comp_id);
                // dd($data['hr']);
                //sm 29-11-2021
                $data['cos_emp'] = DB::table('cos_apply_emp')
                    ->where('com_cos_apply_id', '=', base64_decode($comp_id))
                    ->first();

                //dd($data);
                return View('status/cos-edit', $data);

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function editVisaFile($comp_id)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['hr'] = DB::Table('visa_file_emp')
                //->select('visa_file_emp.*', 'visa_file_apply.id as cosid', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('visa_file_emp.*', 'visa_file_apply.id as visaid')
                    ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                // ->join('employee', 'employee.id', '=', 'visa_file_emp.com_employee_id', 'right')
                    ->where('visa_file_emp.id', '=', base64_decode($comp_id))
                    ->first();

                //sm 29-11-2021
                $data['visa_file_emp'] = DB::table('visa_file_emp')
                    ->where('com_visa_apply_id', '=', base64_decode($comp_id))
                    ->first();

                //dd($data);
                return View('status/visa-file-edit', $data);

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function editRecruitmentFile($comp_id)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                //sm 29-11-2021
                $data['employees'] = DB::Table('employee')
                    ->where('status', '=', 'active')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $data['hr'] = DB::Table('recruitment_file_emp')
                //->select('recruitment_file_emp.*', 'recruitment_file_apply.id as cosid', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                    ->select('recruitment_file_emp.*', 'recruitment_file_apply.id as cosid')
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                // ->join('employee', 'employee.id', '=', 'recruitment_file_emp.com_employee_id', 'right')
                    ->where('recruitment_file_emp.id', '=', base64_decode($comp_id))
                    ->first();

                $data['recruitment_file_emp_history'] = DB::table('recruitment_file_emp_history')
                    ->select('recruitment_file_emp_history.*', DB::raw("(select stage from stages where id= recruitment_file_emp_history.stage_id) as stage_name"))
                    ->where('emid', '=', $data['hr']->emid)
                    ->where('employee_id', '=', $data['hr']->employee_id)
                    ->where('employee_name', '=', $data['hr']->employee_name)
                    ->where('com_recruitment_apply_id', '=', $data['hr']->com_recruitment_apply_id)
                    ->get();

                //dd($data['recruitment_file_emp_history']);

                //sm 29-11-2021
                $data['recruitment_file_emp'] = DB::table('recruitment_file_emp')
                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                $data['stages'] = DB::Table('stages')
                    ->where('is_active', '=', 'Y')
                    ->where('module', '=', 'recruitment')
                    ->orderBy('stages.stage', 'asc')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                //dd($data);
                return View('status/recruitment-file-edit', $data);

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveAddcosgynew(Request $request)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $cos = DB::Table('cos_apply_emp')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($request->target_date != '') {
                    $tar_due = date('Y-m-d', strtotime($request->target_date));
                } else {
                    $tar_due = '';
                }
                if ($request->visa_date != '') {
                    $vis_due = date('Y-m-d', strtotime($request->visa_date));
                } else {
                    $vis_due = '';
                }
                if ($request->additional_info_request_date != '') {
                    $additional_info_request_date = date('Y-m-d', strtotime($request->additional_info_request_date));
                } else {
                    $additional_info_request_date = '';
                }
                if ($request->additional_info_sent_date != '') {
                    $additional_info_sent_date = date('Y-m-d', strtotime($request->additional_info_sent_date));
                } else {
                    $additional_info_sent_date = '';
                }
                if ($request->additional_info_sent_date != '') {
                    $additional_info_sent_date = date('Y-m-d', strtotime($request->additional_info_sent_date));
                } else {
                    $additional_info_sent_date = '';
                }
                if ($request->cos_assigned_date != '') {
                    $cos_assigned_date = date('Y-m-d', strtotime($request->cos_assigned_date));
                } else {
                    $cos_assigned_date = '';
                }

                $datagg = array(
                    'cos' => $request->cos,
                    'employee_name' => $request->employee_name,
                    'applied_cos_date' => $request->applied_cos_date,
                    'type_of_cos' => $request->type_of_cos,
                    // 'type_of_cos_date' => $request->type_of_cos_date,
                    'additional_info_requested' => $request->additional_info_requested,
                    'additional_info_request_date' => $additional_info_request_date,
                    'additional_info_sent' => $request->additional_info_sent,
                    'additional_info_sent_date' => $additional_info_sent_date,
                    'cos_assigned' => $request->cos_assigned,
                    'cos_assigned_date' => $cos_assigned_date,

                    'remarks_cos' => $request->remarks_cos,
                    'status' => $request->status,
                    'update_new_ct' => date('Y-m-d'),
                );

                DB::table('cos_apply_emp')->where('id', $request->id)->update($datagg);

                //if (!empty($cos)) {
                if ($request->cos_assigned == 'Yes') {

                    $visa_file_apply = DB::Table('visa_file_apply')
                        ->where('emid', '=', $data['Roledata']->reg)
                        ->orderBy('id', 'desc')
                        ->first();

                    if (!empty($visa_file_apply)) {
                        //visa assigned
                        $visa_file_emp = DB::Table('visa_file_emp')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->get();

                        if (count($visa_file_emp) > 0) {
                            //visa emp already exist
                            // Do nothing
                        } else {
                            //visa emp doesn't exist but visa assigned
                            //Add employee to visa with blank case worker
                            $dataVisaEmp = array(
                                'emid' => $data['Roledata']->reg,
                                'employee_id' => null,
                                'com_employee_id' => null,
                                'employee_name' => $request->employee_name,
                                'com_visa_apply_id' => $visa_file_apply->id,
                                'cos_assigned' => null,
                                'visa_application_started' => null,
                                'visa_application_start_date' => null,
                                'visa_application_submitted' => null,
                                'visa_application_submit_date' => null,
                                'biometric_appo_date' => null,
                                'documents_uploaded' => null,
                                'interview_date_confirm' => null,
                                'interview_date' => null,
                                'mock_interview_confirm' => null,
                                'mock_interview_date' => null,
                                'remarks' => null,
                                'date' => date('Y-m-d'),
                                'status' => null,
                                'update_new_ct' => date('Y-m-d'),
                            );

                            DB::table('visa_file_emp')->insert($dataVisaEmp);
                            if ($request->cos_assigned == 'Yes') {

                                $toemail = 'visa@workpermitcloud.co.uk';

                                $data_email = array('to_name' => '', 'body_content' => 'COS already Issued/Allocate, please go ahead for Visa Application. <p>Organisation name "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '".</p><p>Type of CoS: "' . $request->type_of_cos . '"</p><p>Cos Assigned Date: ' . $cos_assigned_date . '</p> Please proceed with the needful.');

                                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Request for VISA');
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });

                                $toemail = 'invoice@workpermitcloud.co.uk';

                                $data_email = array('to_name' => '', 'body_content' => 'Please issue the 2nd invoice for Cos allocation and Visa processing.<p> Organisation with name "' . $data['Roledata']->com_name . '".</p><p>Candidate Name: "' . $request->employee_name . '".</p><p>CoS Type: "' . $request->type_of_cos . '"</p><p>Invoice Amount: £1050 plus VAT.</p><p>Note: UK Address VAT will be applicable.</p>');

                                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Request for Recruitment Second Bill');
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });

                            }

                        }

                    } else {
                        //visa not assigned
                        //Add visa assign with blank case worker
                        //Add visa emp to visa with blank case worker
                        $dataVisa = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $visaAdd = DB::table('visa_file_apply')->insert($dataVisa);

                        $visa_file_apply = DB::Table('visa_file_apply')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_apply->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                    }

                    if ($request->cos_assigned == 'Yes') {

                        $toemail = 'visa@workpermitcloud.co.uk';

                        $data_email = array('to_name' => '', 'body_content' => 'COS already Issued/Allocate, please go ahead for Visa Application. <p>Organisation name "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '".</p><p>Type of CoS: "' . $request->type_of_cos . '"</p><p>Cos Assigned Date: ' . $cos_assigned_date . '</p> Please proceed with the needful.');

                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Request for VISA');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                        $toemail = 'invoice@workpermitcloud.co.uk';

                        // $data_email = array('to_name' => '', 'body_content' => 'Raise recruitment Second bill Organisation with name "' . $data['Roledata']->com_name . '". Please proceed with the needful.');

                        $data_email = array('to_name' => '', 'body_content' => 'Please issue the 2nd invoice for Cos allocation and Visa processing.<p> Organisation with name "' . $data['Roledata']->com_name . '".</p><p>Candidate Name: "' . $request->employee_name . '".</p><p>CoS Type: "' . $request->type_of_cos . '"</p><p>Invoice Amount: £1050 plus VAT.</p><p>Note: UK Address VAT will be applicable.</p>');

                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'Workpermitcloud')->subject
                                ('Request for Recruitment Second Bill');
                            $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                        });

                    }

                }

                //}

                Session::flash('message', ' Cos File Changed Successfully .');

                return redirect('organisation-status/view-cos');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }
    public function updateVisaFile(Request $request)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->visa_application_start_date != '') {
                    $visa_application_start_date = date('Y-m-d', strtotime($request->visa_application_start_date));
                } else {
                    $visa_application_start_date = null;
                }
                if ($request->visa_application_submit_date != '') {
                    $visa_application_submit_date = date('Y-m-d', strtotime($request->visa_application_submit_date));
                } else {
                    $visa_application_submit_date = null;
                }
                if ($request->biometric_appo_date != '') {
                    $biometric_appo_date = date('Y-m-d', strtotime($request->biometric_appo_date));
                } else {
                    $biometric_appo_date = null;
                }
                if ($request->interview_date != '') {
                    $interview_date = date('Y-m-d', strtotime($request->interview_date));
                } else {
                    $interview_date = null;
                }

                if ($request->mock_interview_date != '') {
                    $mock_interview_date = date('Y-m-d', strtotime($request->mock_interview_date));
                } else {
                    $mock_interview_date = null;
                }
                if ($request->visa_granted_date != '') {
                    $visa_granted_date = date('Y-m-d', strtotime($request->visa_granted_date));
                } else {
                    $visa_granted_date = null;
                }

                $datagg = array(
                    'employee_name' => $request->employee_name,
                    'cos_assigned' => $request->cos_assigned,
                    'candidate_type' => $request->candidate_type,
                    'visa_application_started' => $request->visa_application_started,
                    'visa_application_start_date' => $visa_application_start_date,
                    'visa_application_submitted' => $request->visa_application_submitted,
                    'visa_application_submit_date' => $visa_application_submit_date,
                    'biometric_appo_date' => $biometric_appo_date,
                    'documents_uploaded' => $request->documents_uploaded,
                    'interview_date_confirm' => $request->interview_date_confirm,
                    'interview_date' => $interview_date,
                    'mock_interview_confirm' => $request->mock_interview_confirm,
                    'mock_interview_date' => $mock_interview_date,
                    'visa_granted_date' => $visa_granted_date,

                    'remarks' => $request->remarks,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'update_new_ct' => date('Y-m-d'),
                );

                DB::table('visa_file_emp')->where('id', $request->id)->update($datagg);
                Session::flash('message', ' Visa File Changed Successfully .');

                return redirect('organisation-status/view-visa-file');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function updateRecruitmentFile(Request $request)
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                //dd($request->all());
                $existingRecEmp = DB::table('recruitment_file_emp')->where('id', $request->id)->first();
                //dd($existingRecEmp);
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->advert_start_date != '') {
                    $advert_start_date = date('Y-m-d', strtotime($request->advert_start_date));
                } else {
                    $advert_start_date = null;
                }
                if ($request->advert_end_date != '') {
                    $advert_end_date = date('Y-m-d', strtotime($request->advert_end_date));
                } else {
                    $advert_end_date = null;
                }
                if ($request->date_of_interview != '') {
                    $date_of_interview = date('Y-m-d', strtotime($request->date_of_interview));
                } else {
                    $date_of_interview = null;
                }
                if ($request->candidate_hired_date != '') {
                    $candidate_hired_date = date('Y-m-d', strtotime($request->candidate_hired_date));
                } else {
                    $candidate_hired_date = null;
                }

                $datagg = array(
                    'employee_name' => $request->employee_name,
                    'employee_email' => $request->employee_email,
                    'employee_address' => $request->employee_address,
                    'employee_phone' => $request->employee_phone,
                    'candidate_identified' => $request->candidate_identified,
                    'advert_posted' => $request->advert_posted,
                    'advert_start_date' => $advert_start_date,
                    'advert_end_date' => $advert_end_date,
                    'candidate_applied' => $request->candidate_applied,
                    'date_of_interview' => $date_of_interview,
                    'candidate_hired' => $request->candidate_hired,
                    'candidate_hired_date' => $candidate_hired_date,

                    'soc' => $request->soc,
                    'position' => $request->position,
                    'candidate_id' => $request->candidate_id,
                    'candidate_type' => $request->candidate_type,
                    'reffered' => $request->reffered,
                    'correspondense_addr' => $request->correspondense_addr,

                    'remarks' => $request->remarks,
                    'date' => date('Y-m-d'),
                    'status' => $request->status,
                    'stage_id' => ($request->stage_id == '') ? 0 : $request->stage_id,
                    'update_new_ct' => date('Y-m-d'),
                );

                DB::table('recruitment_file_emp')->where('id', $request->id)->update($datagg);

                if ($existingRecEmp->stage_id != $request->stage_id) {
                    //Add to history table
                    $datahh = array(
                        'emid' => $existingRecEmp->emid,
                        'employee_id' => $existingRecEmp->employee_id,
                        'com_employee_id' => $existingRecEmp->com_employee_id,
                        'employee_name' => $request->employee_name,
                        'com_recruitment_apply_id' => $existingRecEmp->com_recruitment_apply_id,
                        'candidate_identified' => $request->candidate_identified,
                        'advert_posted' => $request->advert_posted,
                        'advert_start_date' => $request->advert_start_date,
                        'advert_end_date' => $request->advert_end_date,
                        'candidate_applied' => $request->candidate_applied,
                        'date_of_interview' => $request->date_of_interview,
                        'candidate_hired' => $request->candidate_hired,
                        'candidate_hired_date' => $request->candidate_hired_date,

                        'soc' => $request->soc,
                        'position' => $request->position,
                        'candidate_id' => $request->candidate_id,
                        'candidate_type' => $request->candidate_type,
                        'reffered' => $request->reffered,
                        'correspondense_addr' => $request->correspondense_addr,
    
                        'remarks' => $request->remarks,
                        'date' => date('Y-m-d'),
                        'status' => $request->status,
                        'stage_id' => ($request->stage_id == '') ? 0 : $request->stage_id,
                        'update_new_ct' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s'),
                    );

                    //dd($datahh);

                    DB::table('recruitment_file_emp_history')->insert($datahh);

                }

                if ($existingRecEmp->status != 'Hired' && $request->status == 'Hired') {

                    $cos_apply = DB::Table('cos_apply')
                        ->where('emid', '=', $data['Roledata']->reg)
                        ->orderBy('id', 'desc')
                        ->first();

                    if (!empty($cos_apply)) {
                        //cos assigned
                        $cos_apply_emp = DB::Table('cos_apply_emp')
                            ->where('emid', '=', $data['Roledata']->reg)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->get();

                        if (count($cos_apply_emp) > 0) {
                            //cos emp already exist
                            // Do nothing
                        } else {
                            //cos emp doesn't exist but cos assigned
                            //Add employee to cos with blank case worker
                            $dataCosEmp = array(
                                'emid' => $data['Roledata']->reg,
                                'com_employee_id' => null,
                                'employee_name' => $request->employee_name,
                                'com_cos_apply_id' => $cos_apply->id,
                                'employee_id' => null,
                                'cos' => null,
                                'applied_cos_date' => null,
                                'type_of_cos' => null,
                                'additional_info_requested' => null,
                                'additional_info_request_date' => null,
                                'additional_info_sent' => null,
                                'additional_info_sent_date' => null,
                                'cos_assigned' => null,
                                'cos_assigned_date' => null,

                                'remarks_cos' => null,
                                'date' => date('Y-m-d'),
                                'status' => null,
                                'update_new_ct' => date('Y-m-d'),
                            );

                            DB::table('cos_apply_emp')->insert($dataCosEmp);

                            $toemail = 'cos@workpermitcloud.co.uk';

                            if ($toemail != '') {

                                $data_email = array('to_name' => '', 'body_content' => 'The candidate is hired. Go ahead with requesting COS. <p>Organisation Name: "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '"</p> has been requested for COS after hired. Please proceed with the needful.');

                                Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Request For COS');
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });
                            }

                        }

                    } else {
                        //cos not assigned
                        //Add Cos assign with blank case worker
                        //Add Cos emp to cos with blank case worker
                        $dataCos = array(
                            'emid' => $data['Roledata']->reg,
                            'employee_id' => null,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $cosAdd = DB::table('cos_apply')->insert($dataCos);

                        $cos_apply_n = DB::Table('cos_apply')
                            ->where('emid', '=', $data['Roledata']->reg)

                            ->first();

                        $dataCosEmp = array(
                            'emid' => $data['Roledata']->reg,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_cos_apply_id' => $cos_apply_n->id,
                            'employee_id' => null,
                            'cos' => null,
                            'applied_cos_date' => null,
                            'type_of_cos' => null,
                            'additional_info_requested' => null,
                            'additional_info_request_date' => null,
                            'additional_info_sent' => null,
                            'additional_info_sent_date' => null,
                            'cos_assigned' => null,
                            'cos_assigned_date' => null,

                            'remarks_cos' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('cos_apply_emp')->insert($dataCosEmp);

                        $toemail = 'cos@workpermitcloud.co.uk';

                        if ($toemail != '') {

                            $data_email = array('to_name' => '', 'body_content' => 'The candidate is hired. Go ahead with requesting COS. <p>Organisation Name: "' . $data['Roledata']->com_name . '"</p> <p>Candidate Name: "' . $request->employee_name . '"</p> has been requested for COS after hired. Please proceed with the needful.');

                            Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                $message->to($toemail, 'Workpermitcloud')->subject
                                    ('Request For COS');
                                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                            });
                        }

                    }

                    // $toemail = 'invoice@workpermitcloud.co.uk';

                    // $data_email = array('to_name' => '', 'body_content' => 'Please issue the 1st invoice for Recruitment. <p>Organisation with name "' . $data['Roledata']->com_name . '"</p><p>Candidate Name: "' . $request->employee_name . '"</p>.<p>Invoice Amount: £1000 plus VAT</p>Note: UK Address VAT will be applicable.');

                    // Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                    //     $message->to($toemail, 'Workpermitcloud')->subject
                    //         ('Generate recruitment first invoice');
                    //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    // });

                }

                Session::flash('message', ' Recruitment File Changed Successfully .');

                return redirect('organisation-status/view-recruitment-file/');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewcahngepass()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $member = Session::get('admin_userpp_member');
                $users = DB::table('users_admin_emp')->where('employee_id', '=', $member)->first();

                return view('status/change-password', compact('users'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function savecahngepass(Request $request)
    {
        try {if (!empty(Session::get('emp_email'))) {
            $member = Session::get('admin_userpp_member');
            $users = DB::table('users_admin_emp')->where('employee_id', '=', $member)->first();

            if ($request->old != $users->password) {
                Session::flash('message', 'Old Password Is Incorrect.');
                return redirect('organisation-status/change-password');
            } else {
                if ($request->new_p != $request->con) {

                    Session::flash('message', 'New Password and Cormfirm Password Are Not Same');
                    return redirect('organisation-status/change-password');

                } else {
                    $dataimgperpa = array(
                        'password' => $request->new_p,
                    );
                    DB::table('users_admin_emp')
                        ->where('employee_id', '=', $member)
                        ->update($dataimgperpa);
                    Session::flash('message', ' Password Changed Successfully.');
                    return redirect('organisation-status/change-password');
                }

            }
        } else {
            return redirect('/');
        }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewvisa()
    {
        try {
            $email = Session::get('emp_email');
            $member = Session::get('admin_userpp_member');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('visa_or_emp_apply')

                    ->where('emid', '=', $data['Roledata']->reg)

                    ->orderBy('id', 'desc')
                    ->get();

                return View('status/visa-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddvisay()
    {
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['employee_rs'] = DB::Table('employee')

                    ->where('emid', '=', $data['Roledata']->reg)

                    ->orderBy('id', 'asc')
                    ->get();
                $data['visa_act_rs'] = DB::Table('visa_activity_config')

                    ->where('status', '=', 'Active')

                    ->orderBy('id', 'asc')
                    ->get();

                return View('status/visa-add', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }
    public function saveAddvisay(Request $request)
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {$member = Session::get('admin_userpp_member');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $ckeck_com = DB::table('visa_or_emp_apply')->where('emid', $data['Roledata']->reg)->where('employee_id', '=', $request->employee_id)->first();
                if (!empty($ckeck_com)) {
                    Session::flash('message', 'Visa File Already Exists.');
                    return redirect('organisation-status/view-visa');
                } else {

                    $datahh = array(

                        'emid' => $data['Roledata']->reg,
                        'employee_id' => $request->employee_id,

                        'cr_date' => date('Y-m-d'),
                        'status' => 'Granted',

                    );

                    DB::table('visa_or_emp_apply')->insert($datahh);

                    $allocation_list = $request->all();
                    foreach ($request['id'] as $valuemenm) {

                        if ($allocation_list['start_date' . $valuemenm] != '') {
                            $start_date = date('Y-m-d', strtotime($allocation_list['start_date' . $valuemenm]));
                        } else {
                            $start_date = '';
                        }
                        if ($allocation_list['end_date' . $valuemenm] != '') {
                            $end_date = date('Y-m-d', strtotime($allocation_list['end_date' . $valuemenm]));
                        } else {
                            $end_date = '';
                        }
                        if ($allocation_list['actual_date' . $valuemenm] != '') {
                            $actual_date = date('Y-m-d', strtotime($allocation_list['actual_date' . $valuemenm]));
                        } else {
                            $actual_date = '';
                        }

                        $datahhnew = array(

                            'emid' => $data['Roledata']->reg,
                            'employee_id' => $request->employee_id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'actual_date' => $actual_date,
                            'id_vis_act' => $valuemenm,
                            'description' => $allocation_list['description' . $valuemenm],
                            'duration' => $allocation_list['duration' . $valuemenm],
                            'remarks' => $allocation_list['remarks' . $valuemenm],
                            'user_employee_id' => $member,

                        );

                        DB::table('visa_or_emp_details_apply')->insert($datahhnew);

                    }
                    Session::flash('message', ' Visa File Added Successfully .');

                    return redirect('organisation-status/view-visa');

                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddvisanew($comp_id)
    {try {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $member = Session::get('admin_userpp_member');
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['employee_rs'] = DB::Table('employee')

                ->where('emid', '=', $data['Roledata']->reg)

                ->orderBy('id', 'asc')
                ->get();
            $data['visa_act_rs'] = DB::Table('visa_activity_config')

                ->where('status', '=', 'Active')

                ->orderBy('id', 'asc')
                ->get();

            $data['hr'] = DB::table('visa_or_emp_apply')

                ->where('id', '=', base64_decode($comp_id))
                ->first();

            return View('status/visa-edit', $data);

        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

    public function saveAddvisagynew(Request $request)
    {try {
        $email = Session::get('emp_email');
        if (!empty($email)) {$member = Session::get('admin_userpp_member');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $ckeck_com = DB::table('visa_or_emp_apply')->where('emid', $data['Roledata']->reg)
                ->where('employee_id', '=', $request->employee_id)
                ->where('id', '!=', $request->newid)->first();
            if (!empty($ckeck_com)) {
                Session::flash('message', 'Visa File Already Exists.');
                return redirect('organisation-status/view-visa');
            } else {

                $datahh = array(

                    'emid' => $data['Roledata']->reg,
                    'employee_id' => $request->employee_id,
                    'up_date' => date('Y-m-d'),

                    'status' => 'Granted',

                );

                DB::table('visa_or_emp_apply')
                    ->where('id', $request->newid)

                    ->update($datahh);

                $allocation_list = $request->all();
                DB::table('visa_or_emp_details_apply')->where('emid', $data['Roledata']->reg)
                    ->where('employee_id', '=', $request->employee_id)->delete();

                foreach ($request['id'] as $valuemenm) {

                    if ($allocation_list['start_date' . $valuemenm] != '') {
                        $start_date = date('Y-m-d', strtotime($allocation_list['start_date' . $valuemenm]));
                    } else {
                        $start_date = '';
                    }
                    if ($allocation_list['end_date' . $valuemenm] != '') {
                        $end_date = date('Y-m-d', strtotime($allocation_list['end_date' . $valuemenm]));
                    } else {
                        $end_date = '';
                    }
                    if ($allocation_list['actual_date' . $valuemenm] != '') {
                        $actual_date = date('Y-m-d', strtotime($allocation_list['actual_date' . $valuemenm]));
                    } else {
                        $actual_date = '';
                    }

                    $datahhnew = array(

                        'emid' => $data['Roledata']->reg,
                        'employee_id' => $request->employee_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'actual_date' => $actual_date,
                        'id_vis_act' => $valuemenm,
                        'description' => $allocation_list['description' . $valuemenm],
                        'duration' => $allocation_list['duration' . $valuemenm],
                        'remarks' => $allocation_list['remarks' . $valuemenm],
                        'user_employee_id' => $member,

                    );

                    DB::table('visa_or_emp_details_apply')->insert($datahhnew);

                }
                Session::flash('message', ' Visa File Updated Successfully .');

                return redirect('organisation-status/view-visa');

            }

        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }

    }

}
