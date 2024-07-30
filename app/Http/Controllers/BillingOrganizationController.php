<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use PDF;
use Session;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use view;
use App\UntrackedPayment;

class BillingOrganizationController extends Controller
{

    public function viewdash()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                return View('billingorganization/dashboard', $data);
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
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('billing')

                    ->where(function ($query) {
                        $query->where('status', '=', 'not paid')
                            ->orWhere('status', '=', 'partially paid')
                            ->orWhere('status', '=', 'paid');
                    })

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->groupBy('in_id')
                    ->orderBy('in_id', 'desc')
                    ->get();

                return View('billingorganization/billing-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewpayre()
    {

        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['pay_rs'] = DB::Table('payment')
                    ->where(function ($query) {
                        $query->where('status', '=', 'paid')
                            ->orWhere('status', '=', 'partially paid');
                    })
                    ->where('emid', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->get();

                return View('billingorganization/payment-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewpaymentdeta($com_id, $in_id)
    {

        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                $data['bill_rs'] = DB::Table('billing')
                    ->where('in_id', '=', base64_decode($in_id))

                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->first();
                if (!empty($data['bill_rs'])) {
                    $dkata = array(

                        'in_id' => $data['bill_rs']->in_id,
                        'emid' => $data['bill_rs']->emid,
                        'status' => 'In Process',
                        'amount' => $data['bill_rs']->amount,

                        'des' => htmlspecialchars($data['bill_rs']->des),
                        'date' => $data['bill_rs']->date,

                        'dom_pdf' => $data['bill_rs']->dom_pdf,

                    );

                    DB::table('payment')->insert($dkata);

                    $data['payme_new'] = DB::Table('payment')
                        ->where('in_id', '=', $data['bill_rs']->in_id)
                        ->where('status', '=', 'In Process')
                        ->where('emid', '=', $data['Roledata']->reg)
                        ->orderBy('id', 'desc')
                        ->first();
                } else {
                    return redirect('billingorganization/billinglist');
                }

                return View('billingorganization/payment-view', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function tppaymentdeta($in_id,Request $request)
    {

        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['bill_rs'] = DB::Table('billing')
                    ->where('in_id', '=', base64_decode($in_id))
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($data['bill_rs'])) {
                    // $dkata = array(

                    //     'in_id' => $data['bill_rs']->in_id,
                    //     'emid' => $data['bill_rs']->emid,
                    //     'status' => 'In Process',
                    //     'amount' => $data['bill_rs']->amount,

                    //     'des' => htmlspecialchars($data['bill_rs']->des),
                    //     'date' => $data['bill_rs']->date,

                    //     'dom_pdf' => $data['bill_rs']->dom_pdf,

                    // );

                    // DB::table('payment')->insert($dkata);

                    // $data['payme_new'] = DB::Table('payment')
                    //     ->where('in_id', '=', $data['bill_rs']->in_id)
                    //     ->where('status', '=', 'In Process')
                    //     ->where('emid', '=', $data['Roledata']->reg)
                    //     ->orderBy('id', 'desc')
                    //     ->first();
                } else {
                    return redirect('billingorganization/billinglist');
                }

                if(isset($request->due_amount)){
                    $data['mode']='posted';
                    $data['req_amount']=$request->paid_amount*100;
                    $data['paid_amount']=$request->paid_amount;
                    if($request->paid_amount<=0){
                        Session::flash('error', 'Invalid payment amount.');
                        return redirect('billingorganization/billinglist');
                    }
                    
                }
                return View('billingorganization/payment-tp', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddpayment(Request $request)
    {

        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                if ($lsatdeptnmdb->due == $request->re_amount) {
                    $amount = $request->re_amount;

                    $amount = $amount * 100;
                    $currency = 'GBP';

                    if (empty(request()->get('stripeToken'))) {
                        session()->flash('error', 'Some error while making the payment. Please try again');
                        return back()->withInput();
                    }

                    Stripe::setApiKey(env('STRIPE_SECRET'));

                    //Stripe::setApiKey('sk_test_51IudyfDZgDCMdjopaGZ0mbkhvKrDiVy5XTIBNtpIocfkwzAhsY6cm50hmPKHFrLY9sKjqXC9s04HZQO7dflwRqRY00JyRB67aW');

                    try {
                        /** Add customer to stripe, Stripe customer */
                        $customer = Customer::create([
                            'email' => request('email'),
                            'source' => request('stripeToken'),
                        ]);
                    } catch (Exception $e) {
                        $apiError = $e->getMessage();
                        //dd($apiError);
                    }

                    if (empty($apiError) && $customer) {
                        /** Charge a credit or a debit card */
                        try {
                            /** Stripe charge class */
                            $charge = Charge::create(array(
                                'customer' => $customer->id,
                                'amount' => $amount,
                                'currency' => $currency,
                                'description' => 'Some testing description',
                            ));

                        } catch (Exception $e) {
                            $apiError = $e->getMessage();
                        }

                        if (empty($apiError) && $charge) {
                            // Retrieve charge details
                            $paymentDetails = $charge->jsonSerialize();

                            if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {

                                /** You need to create model and other implementations */
                                /*
                                Payment::create([
                                'name'                          => request('name'),
                                'email'                         => request('email'),
                                'amount'                        => $paymentDetails['amount'] / 100,
                                'currency'                      => $paymentDetails['currency'],
                                'transaction_id'                => $paymentDetails['balance_transaction'],
                                'payment_status'                => $paymentDetails['status'],
                                'receipt_url'                   => $paymentDetails['receipt_url'],
                                'transaction_complete_details'  => json_encode($paymentDetails)
                                ]);
                                 */

                                if ($customer->email == $email) {
                                    $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                        ->orderBy('id', 'desc')->first();

                                    $lsatdeptnmdb = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                        ->whereMonth('payment_date', '=', date('m'))
                                        ->orderBy('id', 'DESC')->first();

                                    if (empty($lsatdeptnmdb)) {
                                        $pid = date('Y') . '/' . date('m') . '/001';
                                    } else {
                                        $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdb->pay_recipt);

                                        //Added by sm on 10-11-2021
                                        if ($str == '') {
                                            $str = 0;
                                        }

                                        if ($str <= 8) {
                                            $pid = date('Y') . '/' . date('m') . '/00' . ($str + 1);
                                        } else if ($str < 99) {
                                            $pid = date('Y') . '/' . date('m') . '/0' . ($str + 1);
                                        } else {
                                            $pid = date('Y') . '/' . date('m') . '/' . ($str + 1);
                                        }

                                    }

                                    $pidhh = str_replace("/", "-", $pid);

                                    $filename = $pidhh . '.pdf';

                                    // echo $customer->email . '::' . $email . '***' . $request->in_id . '###' . $filename;
                                    // dd($lsatdeptnmdb);

                                    $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                                    $des_rs = DB::table('billing')
                                        ->where('in_id', '=', $request->in_id)
                                        ->get();

                                    $nameb = array();
                                    if (count($des_rs) != 0) {
                                        foreach ($des_rs as $biname) {
                                            $nameb[] = $biname->des;

                                        }
                                    }
                                    $strbil = implode(',', $nameb);

                                    $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $request->re_amount, 'des' => $strbil, 'date' => date('d/m/Y'), 'billing' => $lsatdeptnmdb, 'method' => 'Online'];

                                    $pdf = PDF::loadView('myinvoicePDF', $datap);

                                    $pdf->save(public_path() . '/paypdf/' . $filename);

                                    $data = array(

                                        'status' => 'paid',

                                        're_amount' => $request->re_amount,
                                        'due_amonut' => $request->due_amonut,
                                        'payable_amount' => $request->due_amonut,
                                        'payment_type' => 'Card',
                                        'payment_date' => date('Y-m-d'),
                                        'bank_payment_id' => $paymentDetails['created'],
                                        'pay_recipt' => $pid,
                                        'pay_recipt_pdf' => $filename,
                                        'remarks' => 'Transaction Success ',
                                    );

                                    DB::table('payment')->where('id', $request->new_id)->update($data);

                                    $dataup = array(
                                        'due' => 0,
                                        'status' => 'paid',
                                    );
                                    DB::table('billing')->where('in_id', $request->in_id)->update($dataup);
                                    $Roledata = DB::table('registration')
                                        ->where('status', '=', 'active')
                                        ->where('reg', '=', $lsatdeptnmdb->emid)
                                        ->first();

                                    $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $request->in_id)->first();
                                    $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                                    $path = public_path() . '/paypdf/' . $filename;
                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = $Roledata->email;

                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        // $message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });
                                    $path = public_path() . '/paypdf/' . $filename;
                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = $Roledata->authemail;
                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        // $message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });

                                    $path = public_path() . '/paypdf/' . $filename;
                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = "info@workpermitcloud.co.uk";
                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        // $message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });

                                }
                                return view('billingorganization/thank-sub', $data);

                            } else {
                                $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                    ->orderBy('id', 'desc')->first();

                                $data = array(
                                    'status' => 'cancel',
                                    'payment_date' => date('Y-m-d'),
                                    'remarks' => 'Transaction failed',
                                );

                                DB::table('payment')->where('id', $request->new_id)->update($data);

                                session()->flash('error', 'Transaction failed');
                                return view('billingorganization/cancel');
                            }
                        } else {
                            session()->flash('error', 'Transaction failed');

                            $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                ->orderBy('id', 'desc')->first();

                            $data = array(
                                'status' => 'cancel',
                                'payment_date' => date('Y-m-d'),
                                'remarks' => 'Error in capturing amount: ' . $apiError,
                            );

                            DB::table('payment')->where('id', $request->new_id)->update($data);

                            session()->flash('error', 'Transaction failed');
                            return view('billingorganization/cancel');
                        }
                    } else {
                        session()->flash('error', 'Transaction failed');

                        $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                            ->orderBy('id', 'desc')->first();

                        $data = array(
                            'status' => 'cancel',
                            'payment_date' => date('Y-m-d'),
                            'remarks' => 'Invalid card details: ' . $apiError,
                        );

                        DB::table('payment')->where('id', $request->new_id)->update($data);

                        session()->flash('error', 'Transaction failed');
                        return view('billingorganization/cancel');
                    }

                } else if ($lsatdeptnmdb->due > $request->re_amount) {
                    $amount = $request->re_amount;

                    $amount = $amount * 100;
                    $currency = 'GBP';

                    if (empty(request()->get('stripeToken'))) {
                        session()->flash('error', 'Some error while making the payment. Please try again');
                        return back()->withInput();
                    }

                    Stripe::setApiKey(env('STRIPE_SECRET'));

                    // Stripe::setApiKey('sk_test_51IudyfDZgDCMdjopaGZ0mbkhvKrDiVy5XTIBNtpIocfkwzAhsY6cm50hmPKHFrLY9sKjqXC9s04HZQO7dflwRqRY00JyRB67aW');

                    try {
                        /** Add customer to stripe, Stripe customer */
                        $customer = Customer::create([
                            'email' => request('email'),
                            'source' => request('stripeToken'),
                        ]);
                    } catch (Exception $e) {
                        $apiError = $e->getMessage();
                    }

                    if (empty($apiError) && $customer) {
                        /** Charge a credit or a debit card */
                        try {
                            /** Stripe charge class */
                            $charge = Charge::create(array(
                                'customer' => $customer->id,
                                'amount' => $amount,
                                'currency' => $currency,
                                'description' => 'Some testing description',
                            ));
                        } catch (Exception $e) {
                            $apiError = $e->getMessage();
                        }

                        if (empty($apiError) && $charge) {
                            // Retrieve charge details
                            $paymentDetails = $charge->jsonSerialize();
                            if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {
                                /** You need to create model and other implementations */
                                /*
                                Payment::create([
                                'name'                          => request('name'),
                                'email'                         => request('email'),
                                'amount'                        => $paymentDetails['amount'] / 100,
                                'currency'                      => $paymentDetails['currency'],
                                'transaction_id'                => $paymentDetails['balance_transaction'],
                                'payment_status'                => $paymentDetails['status'],
                                'receipt_url'                   => $paymentDetails['receipt_url'],
                                'transaction_complete_details'  => json_encode($paymentDetails)
                                ]);
                                 */

                                if ($customer->email == $email) {

                                    $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                        ->orderBy('id', 'desc')->first();

                                    $lsatdeptnmdb = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                        ->whereMonth('payment_date', '=', date('m'))

                                        ->orderBy('id', 'DESC')->first();

                                    if (empty($lsatdeptnmdb)) {
                                        $pid = date('Y') . '/' . date('m') . '/001';
                                    } else {
                                        $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdb->pay_recipt);

                                        //Added by sm on 10-11-2021
                                        if ($str == '') {
                                            $str = 0;
                                        }

                                        if ($str <= 8) {
                                            $pid = date('Y') . '/' . date('m') . '/00' . ($str + 1);
                                        } else if ($str < 99) {
                                            $pid = date('Y') . '/' . date('m') . '/0' . ($str + 1);
                                        } else {
                                            $pid = date('Y') . '/' . date('m') . '/' . ($str + 1);
                                        }

                                    }

                                    $pidhh = str_replace("/", "-", $pid);

                                    $filename = $pidhh . '.pdf';
                                    $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                                    $des_rs = DB::table('billing')

                                        ->where('in_id', '=', $request->in_id)

                                        ->get();
                                    $nameb = array();
                                    if (count($des_rs) != 0) {
                                        foreach ($des_rs as $biname) {
                                            $nameb[] = $biname->des;

                                        }
                                    }
                                    $strbil = implode(',', $nameb);

                                    $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $request->re_amount, 'des' => $strbil, 'date' => date('d/m/Y'), 'billing' => $lsatdeptnmdb, 'method' => 'Online'];

                                    $pdf = PDF::loadView('myinvoicePDF', $datap);

                                    $pdf->save(public_path() . '/paypdf/' . $filename);

                                    $data = array(

                                        'status' => 'partially paid',

                                        're_amount' => $request->re_amount,
                                        'due_amonut' => $request->due_amonut,
                                        'payable_amount' => $request->due_amonut,
                                        'payment_type' => 'Card',
                                        'payment_date' => date('Y-m-d'),
                                        'bank_payment_id' => $paymentDetails['created'],
                                        'pay_recipt' => $pid,
                                        'pay_recipt_pdf' => $filename,
                                        'remarks' => 'Transaction Success ',
                                    );

                                    DB::table('payment')->where('id', $request->new_id)->update($data);

                                    $dataup = array(
                                        'due' => ($request->due_amonut - $request->re_amount),
                                        'status' => 'partially paid',
                                    );
                                    DB::table('billing')->where('in_id', $request->in_id)->update($dataup);

                                    $Roledata = DB::table('registration')
                                        ->where('status', '=', 'active')
                                        ->where('reg', '=', $lsatdeptnmdb->emid)
                                        ->first();

                                    $path = public_path() . '/paypdf/' . $filename;

                                    $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $request->in_id)->first();
                                    $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = $Roledata->email;

                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        //$message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });
                                    $path = public_path() . '/paypdf/' . $filename;
                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = $Roledata->authemail;
                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        // $message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });

                                    $path = public_path() . '/paypdf/' . $filename;
                                    $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                                    $toemail = "info@workpermitcloud.co.uk";
                                    Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                        $message->to($toemail, 'WorkPermitCloud')->subject
                                            ('Payment Receive   Details');
                                        //$message->attach($path);
                                        $message->from('noreply@workpermitcloud.co.uk', 'WorkPermitCloud');
                                    });
                                }
                                return view('billingorganization/thank-sub', $data);

                            } else {
                                $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                    ->orderBy('id', 'desc')->first();

                                $data = array(
                                    'status' => 'cancel',
                                    'payment_date' => date('Y-m-d'),
                                    'remarks' => 'Transaction failed',
                                );

                                DB::table('payment')->where('id', $request->new_id)->update($data);

                                session()->flash('error', 'Transaction failed');
                                return view('billingorganization/cancel');
                            }
                        } else {
                            session()->flash('error', 'Transaction failed');

                            $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                                ->orderBy('id', 'desc')->first();

                            $data = array(
                                'status' => 'cancel',
                                'payment_date' => date('Y-m-d'),
                                'remarks' => 'Error in capturing amount: ' . $apiError,
                            );

                            DB::table('payment')->where('id', $request->new_id)->update($data);

                            session()->flash('error', 'Transaction failed');
                            return view('billingorganization/cancel');
                        }
                    } else {
                        session()->flash('error', 'Transaction failed');

                        $check_subcrip = DB::table('payment')->where('id', $request->new_id)
                            ->orderBy('id', 'desc')->first();

                        $data = array(
                            'status' => 'cancel',
                            'payment_date' => date('Y-m-d'),
                            'remarks' => 'Invalid card details: ' . $apiError,
                        );

                        DB::table('payment')->where('id', $request->new_id)->update($data);

                        session()->flash('error', 'Transaction failed');
                        return view('billingorganization/cancel');
                    }

                } else {
                    Session::flash('message', 'Payable Amount Is Bigger Than Amount.');
                    return redirect('billingorganization/billinglist');
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            //dd($e);
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddpayTp(Request $request)
    {

        try {
            if($request->responseCode==0){
                //echo 'Thank you for making the payment';
                //dd($request->all());
                $invoiceID=$request->orderRef;
                $xref=$request->xref;
                $transactionID=$request->transactionID;
                $gatewayResponse=json_encode($request->all());

                $responseAmount=$request->amount;
                $responseAmount=round($responseAmount/100,2);

                $invInfo=DB::table('billing')->where('in_id', '=', $invoiceID)->orderBy('id', 'DESC')->first();
                //dd($invInfo);

                //for sandbox testing only
                //$responseAmount=$invInfo->due;

                if(!empty($invInfo)){
                    $Roledata = DB::table('registration')
                        ->where('status', '=', 'active')
                        ->where('reg', '=', $invInfo->emid)
                        ->first();

                   //dd($Roledata);

                    $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                        ->whereMonth('payment_date', '=', date('m'))
                        ->orderBy('id', 'DESC')->first();

                    $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                        ->whereMonth('payment_date', '=', date('m'))
                        ->orderBy('id', 'DESC')->get();

                   // dd($lsatdeptnmdbnew);
                    // dd(count($lsatdeptnmdbnew1));

                    $invStr = str_replace("/", "", $invInfo->id);
                    //generating pay_recipt no. below --start
                    if (empty($lsatdeptnmdbnew)) {
                        $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                    } else {
                        // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                        $str = count($lsatdeptnmdbnew1) + 1;

                        if ($str == '') {
                            $str = count($lsatdeptnmdbnew1);
                        }

                        if ($str <= 8) {
                            $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                        } else if ($str < 99) {
                            $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                        } else {
                            $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                        }

                    }
                    //generating pay_recipt no. above --end
                    // dd($pid);
                    $lsatdeptnmdbexit = DB::table('payment')->where('pay_recipt', '=', $pid)
                                            ->orderBy('pay_recipt', 'DESC')
                                            ->first();

                    if (!empty($lsatdeptnmdbexit)) {
                        Session::flash('error', 'Payment Id already Exits. ');
                        return redirect('billingorganization/billinglist');
                    } else {
                        //checking payable amount & received amount
                        //dd($responseAmount);
                        if ($invInfo->due == $responseAmount) {

                            $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                ->whereMonth('payment_date', '=', date('m'))
                                ->orderBy('id', 'DESC')->first();

                            $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                ->whereMonth('payment_date', '=', date('m'))
                                ->orderBy('id', 'DESC')->get();

                            //dd($lsatdeptnmdbnew);
                            //dd(count($lsatdeptnmdbnew1));

                            $invStr = str_replace("/", "", $invInfo->id);
                            //generating pay_recipt no. below --start
                            if (empty($lsatdeptnmdbnew)) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                            } else {
                                // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                                $str = count($lsatdeptnmdbnew1) + 1;

                                if ($str == '') {
                                    $str = count($lsatdeptnmdbnew1);
                                }

                                if ($str <= 8) {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                                } else if ($str < 99) {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                                } else {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                                }

                            }
                            //generating pay_recipt no. above --end
                            //dd($pid);
                            $max_idnew = DB::table('payment')
                                ->orderBy('id', 'DESC')->first();

                            $max_id = ($max_idnew->id + 1);

                            //pdf file name
                            $pidhh = str_replace("/", "-", $max_id . $pid);
                            //dd($pidhh);
                            
                            $filename = $pidhh . '.pdf';
                            $lsatdeptnmdb = DB::table('billing')->where('id', '=', $invInfo->id)->orderBy('id', 'DESC')->first();
                            //dd($lsatdeptnmdb);
                            $Roledata = DB::table('registration')

                                ->where('reg', '=', $lsatdeptnmdb->emid)
                                ->first();

                            $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $responseAmount, 'des' => $invInfo->des, 'date' => date('d/m/Y'), 'billing' => $lsatdeptnmdb, 'method' => 'Online'];

                            $pdf = PDF::loadView('myinvoicePDF', $datap);

                            $pdf->save(public_path() . '/paypdf/' . $filename);

                            $data = array(

                                'in_id' => $lsatdeptnmdb->in_id,
                                'emid' => $lsatdeptnmdb->emid,
                                'status' => 'paid',
                                'amount' => $lsatdeptnmdb->amount,
                                're_amount' => $responseAmount,
                                'due_amonut' => round($invInfo->due-$responseAmount,2),
                                'payable_amount' => $invInfo->due,
                                'payment_type' => 'Bacs',
                                'des' => htmlspecialchars($invInfo->des),
                                'date' => $lsatdeptnmdb->date,
                                'payment_date' => date('Y-m-d'),
                                'dom_pdf' => $lsatdeptnmdb->dom_pdf,

                                'pay_recipt' => $pid,
                                'pay_recipt_pdf' => $filename,
                                'remarks' => 'Transaction Success',
                                'tp_transaction_id' => $transactionID,
                                'tp_xref' => $xref,
                                'tp_response' => $gatewayResponse,

                            );
                            
                            DB::table('payment')->insert($data);

                            $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $lsatdeptnmdb->in_id)->first();

                            $dataup = array(
                                'due' => 0,
                                'status' => 'paid',
                            );
                            DB::table('billing')->where('in_id', $lsatdeptnmdb->in_id)->update($dataup);

                            // dd($lastPayRec->id);

                            $Roledata = DB::table('registration')

                                ->where('reg', '=', $lsatdeptnmdb->emid)
                                ->first();
                            $path = public_path() . '/paypdf/' . $filename;
                            $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                            $toemail = $Roledata->email;

                            if ($toemail != '') {
                                Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Payment Receive Details');
                                    //$message->attach($path);
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });
                            }

                            $path = public_path() . '/paypdf/' . $filename;
                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                            $toemail = $Roledata->authemail;
                            if ($toemail != '') {
                                Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Payment Receive   Details');
                                    // $message->attach($path);
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });
                            }

                            $path = public_path() . '/paypdf/' . $filename;
                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                            $toemail = "accounts@workpermitcloud.co.uk";
                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'Workpermitcloud')->subject
                                    ('Payment Receive   Details');
                                //$message->attach($path);
                                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                            });
                            
                            
                            Session::flash('message', 'Payment Received Successfully .');

                        } else if ($invInfo->due > $responseAmount) {

                            $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                ->whereMonth('payment_date', '=', date('m'))
                                ->orderBy('id', 'DESC')->first();

                            $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                                ->whereMonth('payment_date', '=', date('m'))
                                ->orderBy('id', 'DESC')->get();

                            //dd($lsatdeptnmdbnew);
                            //dd(count($lsatdeptnmdbnew1));

                            $invStr = str_replace("/", "", $invInfo->id);
                            //generating pay_recipt no. below --start
                            if (empty($lsatdeptnmdbnew)) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                            } else {
                                // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                                $str = count($lsatdeptnmdbnew1) + 1;

                                if ($str == '') {
                                    $str = count($lsatdeptnmdbnew1);
                                }

                                if ($str <= 8) {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                                } else if ($str < 99) {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                                } else {
                                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                                }

                            }
                            $max_idnew = DB::table('payment')
                                ->orderBy('id', 'DESC')->first();

                            $max_id = ($max_idnew->id + 1);

                            $pidhh = str_replace("/", "-", $max_id . $pid);

                            $filename = $pidhh . '.pdf';
                            $lsatdeptnmdb = DB::table('billing')->where('id', '=', $invInfo->id)->orderBy('id', 'DESC')->first();

                            $Roledata = DB::table('registration')

                                ->where('reg', '=', $lsatdeptnmdb->emid)
                                ->first();

                            $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $responseAmount, 'des' => $invInfo->des, 'date' => date('d/m/Y'), 'billing' => $lsatdeptnmdb, 'method' => 'Online'];

                            $pdf = PDF::loadView('myinvoicePDF', $datap);

                            $pdf->save(public_path() . '/paypdf/' . $filename);

                            

                            $data = array(

                                'in_id' => $lsatdeptnmdb->in_id,
                                'emid' => $lsatdeptnmdb->emid,
                                'status' => 'partially paid',
                                'amount' => $lsatdeptnmdb->amount,
                                're_amount' => $responseAmount,
                                'due_amonut' => round($invInfo->due-$responseAmount,2),
                                'payable_amount' => $invInfo->due,
                                'payment_type' => 'Bacs',
                                'des' => $invInfo->des,
                                'date' => $lsatdeptnmdb->date,
                                'payment_date' => date('Y-m-d'),
                                'dom_pdf' => $lsatdeptnmdb->dom_pdf,
                                'pay_recipt' => $pid,
                                'pay_recipt_pdf' => $filename,
                                'remarks' => 'Transaction Success ',
                                'tp_transaction_id' => $transactionID,
                                'tp_xref' => $xref,
                                'tp_response' => $gatewayResponse,
                            );

                            DB::table('payment')->insert($data);

                            $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $lsatdeptnmdb->in_id)->first();

                            $dataup = array(
                                'due' => round($invInfo->due-$responseAmount,2),
                                'status' => 'partially paid',
                            );
                            DB::table('billing')->where('in_id', $lsatdeptnmdb->in_id)->update($dataup);

                            $Roledata = DB::table('registration')

                                ->where('reg', '=', $lsatdeptnmdb->emid)
                                ->first();

                            $path = public_path() . '/paypdf/' . $filename;

                            $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                            $toemail = $Roledata->email;
                            // $toemail = 'm.subhasish@gmail.com';

                            if ($toemail != '') {
                                Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Payment Receive   Details');
                                    // $message->attach($path);
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });
                            }
                            $path = public_path() . '/paypdf/' . $filename;
                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);

                            $toemail = $Roledata->authemail;

                            if ($toemail != '') {
                                Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                    $message->to($toemail, 'Workpermitcloud')->subject
                                        ('Payment Receive   Details');
                                    //  $message->attach($path);
                                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                                });
                            }

                            $path = public_path() . '/paypdf/' . $filename;
                            $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $responseAmount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);

                            $toemail = "accounts@workpermitcloud.co.uk";

                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'Workpermitcloud')->subject
                                    ('Payment Receive   Details');
                                // $message->attach($path);
                                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                            });

                            

                            Session::flash('message', 'Payment Received Successfully .');

                        } else {
                            Session::flash('message', 'Payment Amount Is Bigger Than Amount.');
                        }

                        return redirect('billingorganization/billinglist');
                    }

                }else{

                    $model  = new UntrackedPayment;
                    $model->transaction_id    = $transactionID;
                    $model->xref    = $xref;
                    $model->amount    = $responseAmount;
                    $model->pay_date    = date('Y-m-d');
                    $model->save();

                    $toemail = 'accounts@workpermitcloud.co.uk';
                    // $toemail = 'm.subhasish@gmail.com';

                    $data_email = array('to_name' => '', 'body_content' => 'Payment received on invalid Invoice Reference. Please refund the payment received from the customer via TakePayments Merchant Dashboard.
                    <p>Payment Cross Reference # "'.$xref.'"</p>
                    <p>Received Amount: &pound;'.$responseAmount.'</p>
                    <p>Date of the payment received: '.date('Y-m-d').'</p>');

                    Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ('Automatic Refund Request');
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });
    

                    Session::flash('error', 'Invalid invoice response received. Need to be asked for refund, if charged. Copy & Use this referencee no. for future communications Ref#'.$xref);
                    return redirect('billingorganization/billinglist');
   
                }
                
            }else{
                
                Session::flash('error', $request->responseCode.' - '.$request->responseMessage);
                return redirect('billingorganization/billinglist');
            }

        } catch (Exception $e) {
            //dd($e);
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

}