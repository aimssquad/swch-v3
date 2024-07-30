<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use URL;
use view;

class MyCronController extends Controller
{

    //90days html visa
    public function viewofferdownsendcandidatedetails($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/firstmail', $data);

    }

    //60days html visa
    public function viewofferdownsendcandidatedetailssecond($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/secondmail', $data);

    }

    //30days html visa
    public function viewofferdownsendcandidatedetailsthired($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/thirdmail', $data);

    }

    //90days email visa
    public function viewsendcandidatedetailssendnew($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        //$toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {
            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

        }

        $toemail = $Roledata->authemail;
        //$toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        //$toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }

    //60days email visa
    public function viewsendcandidatedetailssecondsendnew($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        //$toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->authemail;
        //$toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        //$toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }

    //30days email visa
    public function viewsendcandidatedetailsthirdsendnew($send_id, $emid)
    {
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        //$toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->authemail;
        //$toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        //$toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }

    //visa cron job
    public function visaReminderNotification()
    {

        $url = URL::to("/");

        $dataQuery = DB::table('employee')
            ->select('id', 'emp_code', 'emp_fname', 'emp_lname', 'emp_ps_email', 'visa_exp_date', 'emid', DB::raw('(DATE_SUB(CAST(visa_exp_date as Date), INTERVAL 90 DAY)) as remind_90'), DB::raw('(DATE_SUB(CAST(visa_exp_date as Date), INTERVAL 60 DAY)) as remind_60'), DB::raw('(DATE_SUB(CAST(visa_exp_date as Date), INTERVAL 30 DAY)) as remind_30'), DB::raw('(DATE_SUB(CAST(CURDATE() as Date), INTERVAL 0 DAY)) as today'), DB::raw('(TO_BASE64(emp_code)) as base64_emp_code'), DB::raw('("' . $url . '") as url'))
            ->whereNotNull('employee.visa_doc_no')
            ->whereNotNull('employee.visa_exp_date')
        //->where('emid', '=', 'EM733')
        //->where('emp_code', '=', 'WOR55')
            ->get();

        foreach ($dataQuery as $record) {
            //dd($record);
            $urlView90 = $record->url . '/cron/migrant-dash-firstletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail90 = $record->url . '/cron/migrant-firstletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject90 = 'Right to Work Documentation – Temporary Visa 90-day Reminder.';

            $urlView60 = $record->url . '/cron/migrant-dash-secondletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail60 = $record->url . '/cron/migrant-secondletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject60 = 'Right to Work Documentation – Temporary Visa 60-day Reminder.';

            $urlView30 = $record->url . '/cron/migrant-dash-thiredletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail30 = $record->url . '/cron/migrant-thirdletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject30 = 'Right to Work Documentation – Temporary Visa 30-day Reminder.';

            if ($record->remind_90 == $record->today) {
                $html90 = file_get_contents($urlView90);

                echo 'send 90 remind<br>';
                echo file_get_contents($urlEmail90);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject90,
                    'msg' => $html90,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject90,
                    'msg' => $html90,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            if ($record->remind_60 == $record->today) {
                $html60 = file_get_contents($urlView60);

                echo 'send 60 remind<br>';
                echo file_get_contents($urlEmail60);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject60,
                    'msg' => $html60,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject60,
                    'msg' => $html60,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            if ($record->remind_30 == $record->today) {
                $html30 = file_get_contents($urlView30);

                echo 'send 30 remind<br>';
                echo file_get_contents($urlEmail30);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject30,
                    'msg' => $html30,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject30,
                    'msg' => $html30,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            //dd($record);
        }

    }

    //90days html euss
    public function viewofferdowneuss($send_id, $emid)
    {
        //dd($emid);

        $Roledata = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();
       

        $pdf = '';
        $fo = '';
        $job = DB::table('employee')
            ->where('emp_code', '=', base64_decode($send_id))
            ->where('emid', '=', $Roledata->reg)
            ->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/eussfirstmail', $data);

    }

    //60days html euss
    public function viewofferdownsendeusssecond($send_id, $emid)
    {

        $Roledata = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();

        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/eusssecondmail', $data);

    }

    //30days html euss
    public function viewofferdownsendeussthired($send_id, $emid)
    {

        $Roledata = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('reg', '=', $emid)
            ->first();

        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

        return View('dashboard/eussthirdmail', $data);

    }

    //90days email euss
    public function viewsendeusssendnew($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        // $toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {
            Mail::send('eussmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

        }

        $toemail = $Roledata->authemail;
        // $toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('eussmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        // $toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('eussmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }

    //60days email euss
    public function viewsendeusssecondsendnew($send_id, $emid)
    {

        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        // $toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('eussmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->authemail;
        // $toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('eussmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        // $toemail = 'm.subhasish@gmail.com';

        if ($toemail != '') {

            Mail::send('eussmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }

    //30days email euss
    public function viewsendeussthirdsendnew($send_id, $emid)
    {
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('reg', '=', $emid)
            ->first();
        $pdf = '';
        $fo = '';
        $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

        $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

        $toemail = $job->emp_ps_email;
        // $toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('eussmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->authemail;
        // $toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('eussmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        $toemail = $Roledata->email;
        // $toemail = 'm.subhasish@gmail.com';
        if ($toemail != '') {

            Mail::send('eussmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
        }

        return 'sent successfully';

    }


    
    //EUSS cron job
    public function eussReminderNotification()
    {

        $url = URL::to("/");

        $dataQuery = DB::table('employee')
            ->select('id', 'emp_code', 'emp_fname', 'emp_lname', 'emp_ps_email', 'euss_exp_date', 'emid', DB::raw('(DATE_SUB(CAST(euss_exp_date as Date), INTERVAL 90 DAY)) as remind_90'), DB::raw('(DATE_SUB(CAST(euss_exp_date as Date), INTERVAL 60 DAY)) as remind_60'), DB::raw('(DATE_SUB(CAST(euss_exp_date as Date), INTERVAL 30 DAY)) as remind_30'), DB::raw('(DATE_SUB(CAST(CURDATE() as Date), INTERVAL 0 DAY)) as today'), DB::raw('(TO_BASE64(emp_code)) as base64_emp_code'), DB::raw('("' . $url . '") as url'))
            ->whereNotNull('employee.euss_exp_date')
            ->whereNotNull('employee.euss_ref_no')
            // ->where('emid', '=', 'EM733')
        //->where('emp_code', '=', 'WOR55')
            ->get();

            //dd($dataQuery);

        foreach ($dataQuery as $record) {
            //dd($record);
            $urlView90 = $record->url . '/cron/migrant-euss-firstletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail90 = $record->url . '/cron/migrant-eussfirstletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject90 = 'Right to Work Documentation – Temporary EUSS 90-day Reminder.';

            

            $urlView60 = $record->url . '/cron/migrant-euss-secondletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail60 = $record->url . '/cron/migrant-eusssecondletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject60 = 'Right to Work Documentation – Temporary EUSS 60-day Reminder.';

            $urlView30 = $record->url . '/cron/migrant-euss-thiredletter/' . $record->base64_emp_code . '/' . $record->emid;
            $urlEmail30 = $record->url . '/cron/migrant-eussthirdletter-sendnew/' . $record->base64_emp_code . '/' . $record->emid;
            $subject30 = 'Right to Work Documentation – Temporary EUSS 30-day Reminder.';

        //   dd($record->remind_30);

            if ($record->remind_90 == $record->today) {
                $html90 = file_get_contents($urlView90);

                echo 'send 90 remind<br>';
                echo file_get_contents($urlEmail90);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject90,
                    'msg' => $html90,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject90,
                    'msg' => $html90,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            if ($record->remind_60 == $record->today) {
                $html60 = file_get_contents($urlView60);

                echo 'send 60 remind<br>';
                echo file_get_contents($urlEmail60);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject60,
                    'msg' => $html60,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject60,
                    'msg' => $html60,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            if ($record->remind_30 == $record->today) {
                $html30 = file_get_contents($urlView30);

                echo 'send 30 remind<br>';
                echo file_get_contents($urlEmail30);

                $mc_data = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject30,
                    'msg' => $html30,
                    'email' => $record->emp_ps_email,
                );
                $mc_data1 = array(
                    'emid' => $record->emid,
                    'date' => $record->today,
                    'subject' => $subject30,
                    'msg' => $html30,
                    'email' => $record->emp_ps_email,
                    'employee_id' => $record->emp_code,
                );

                DB::table('employee_messaage_center')->insert($mc_data1);
                DB::table('messaage_center')->insert($mc_data);
                echo '<br>data saved';
            }

            //dd($record);
        }

    }

    public function subscription_reminder(){
        $url = URL::to("/");
        $dataQuery = DB::table('subscriptions')
            ->select('subscriptions.*','registration.com_name','registration.email','plans.plan_name',  DB::raw('(DATE_SUB(CAST(expiry_date as Date), INTERVAL 30 DAY)) as remind_30'), DB::raw('(DATE_SUB(CAST(expiry_date as Date), INTERVAL 15 DAY)) as remind_15'), DB::raw('(DATE_SUB(CAST(CURDATE() as Date), INTERVAL 0 DAY)) as today'),  DB::raw('("' . $url . '") as url'))
            ->join('registration', 'registration.reg', '=', 'subscriptions.emid', 'inner')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id', 'inner')
            ->get();

        foreach ($dataQuery as $record) {

            if ($record->remind_15 == $record->today) {

                $data = array('com_name' => $record->com_name,'email' => $record->email, 'plan_name' => $record->plan_name, 'expiry_date' => $record->expiry_date );
                //dd($data);
                $toemail = $record->email;
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsubscription', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Subscription Renewal 15-day Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    echo 'mail sent remind15';
                    // $file = fopen("public/subscription15.txt","a");
                    // fwrite($file,json_encode($data));
                    // fclose($file);
                }
    
            }
            if ($record->remind_30 == $record->today) {

                $data = array('com_name' => $record->com_name,'email' => $record->email, 'plan_name' => $record->plan_name, 'expiry_date' => $record->expiry_date );
                //dd($data);
                $toemail = $record->email;
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsubscription', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Subscription Renewal 30-day Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    echo 'mail sent remind30';
                    // $file = fopen("public/subscription30.txt","a");
                    // echo fwrite($file,json_encode($data));
                    // fclose($file);

                }
    
            }

    

        }

    }

    public function spl_reminder(){

        $allLicHr = DB::Table('hr_apply')
        ->where(function ($query) {
            $query->where('hr_apply.licence', '=', 'Refused')
                ->orWhere('hr_apply.licence', '=', 'Granted')
                ->orWhere('hr_apply.licence', '=', 'Rejected');

        })
        ->distinct()
        ->pluck('hr_apply.emid');

        $url = URL::to("/");

        $dataQuery =DB::Table('registration')
            ->select('registration.*','tareq_app.last_date',  DB::raw('(DATE_ADD(CAST(tareq_app.last_date as Date), INTERVAL 30 DAY)) as remind_30'), DB::raw('(DATE_ADD(CAST(tareq_app.last_date as Date), INTERVAL 60 DAY)) as remind_60'), DB::raw('(DATE_ADD(CAST(tareq_app.last_date as Date), INTERVAL 90 DAY)) as remind_90'), DB::raw('(DATE_ADD(CAST(CURDATE() as Date), INTERVAL 0 DAY)) as today'),  DB::raw('("' . $url . '") as url'),'users_admin_emp.name as cw_name','users_admin_emp.notification_email as cw_noti_email' )
            ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid', 'left')
            ->join('users_admin_emp', 'users_admin_emp.employee_id', '=', 'tareq_app.ref_id', 'left')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->whereNotIn('registration.reg', $allLicHr)
            ->whereNotNull('tareq_app.last_date')
            ->distinct()
            ->orderBy('registration.id', 'desc')
            
            ->get();

        //dd($dataQuery);

        foreach ($dataQuery as $record) {
            echo $record->today.'<br>';
            echo $record->remind_30.'<br>';
            if ($record->remind_30 == $record->today) {

                $data = array('com_name' => $record->com_name,'days' => '30', 'application_date' => date('d/m/Y',strtotime($record->last_date)));
                //dd($data);
                $toemail = $record->cw_noti_email;
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 30-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    
                }
                $toemail = 'hr@workpermitcloud.co.uk';
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 30-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    echo 'mail sent remind30';
                }

                // $toemail = 'm.subhasish@gmail.com';
                // Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                //     $message->to($toemail, 'Workpermitcloud')->subject
                //         ('License Decision Pending 30-days Reminder');
    
                //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                // });

                echo 'mail sent remind30';

                // $file = fopen("public/splremind30.txt","a");
                // fwrite($file,json_encode($data));
                // fclose($file);
    
            }

            if ($record->remind_60 == $record->today) {

                $data = array('com_name' => $record->com_name,'days' => '60', 'application_date' => date('d/m/Y',strtotime($record->last_date)));
                //dd($data);
                $toemail = $record->cw_noti_email;
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 60-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    
                }
                $toemail = 'hr@workpermitcloud.co.uk';
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 60-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    echo 'mail sent remind60';
                }

                // $toemail = 'm.subhasish@gmail.com';
                // Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                //     $message->to($toemail, 'Workpermitcloud')->subject
                //         ('License Decision Pending 60-days Reminder');
    
                //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                // });
                echo 'mail sent remind60';

                // $file = fopen("public/splremind60.txt","a");
                // fwrite($file,json_encode($data));
                // fclose($file);
    
            }

            if ($record->remind_90 == $record->today) {

                $data = array('com_name' => $record->com_name,'days' => '90', 'application_date' => date('d/m/Y',strtotime($record->last_date)));
                //dd($data);
                $toemail = $record->cw_noti_email;
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 90-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    
                }

                $toemail = 'hr@workpermitcloud.co.uk';
                //$toemail = 'm.subhasish@gmail.com';
                if ($toemail != '') {
        
                    Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('License Decision Pending 90-days Reminder');
        
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
                    echo 'mail sent remind90';
                }

                // $toemail = 'm.subhasish@gmail.com';
                // Mail::send('mailsendsplreminder', $data, function ($message) use ($toemail) {
                //     $message->to($toemail, 'Workpermitcloud')->subject
                //         ('License Decision Pending 90-days Reminder');
    
                //     $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                // });
                echo 'mail sent remind90';

                // $file = fopen("public/splremind90.txt","a");
                // fwrite($file,json_encode($data));
                // fclose($file);
    
            }

    

        }

    }

}
