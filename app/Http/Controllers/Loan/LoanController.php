<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Employee;
use App\Models\Loan\Loan;
use App\Models\Loan\LoanRecovery;
use App\Models\Payroll\Payroll_detail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelFileExportLoanList;
use App\Exports\ExcelFileExportAdjustAmount;
class LoanController extends Controller
{
    public function viewLoan(Request $request)
    {
       // dd("abbas");
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['ClassName'] = 'view-loans';
            $email = Session::get('adminusernmae');
             $data['employee_rs'] = Loan::join('employee', 'employee.emp_code', '=', 'loans.emp_code')
                ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname','employee.Designation','loans.*',DB::raw('(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id) as balance'))
                ->orderBy('loans.id', 'desc')
                ->get();
               // dd($data);

            return View('loan.index', $data);
        } else {
            return redirect('/');
        }
    }
    public function addLoan(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();

            $maxid=Loan::max('id');
            if($maxid==null){
                $maxid=1;
            }else{
                $maxid=$maxid+1;
            }

            $data['loan_id']='L'.str_pad($maxid,'3','0',STR_PAD_LEFT);

            return View('loan.add', $data);
        }
        else {
            return redirect('/');
        }

    }
    public function saveLoan(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $start_month=date('m/Y',strtotime($request->start_month));
            $employee_code=$request->emp_code;

            $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $start_month)->first();

            if (!empty($payroll)) {
                Session::flash('error', 'Payroll already generated for said period.');
                return redirect('/loans/add-loan')->withInput();
            }
            $prid=Payroll_detail::max('month_yr');
            if(!empty($prid)){
                $pridArr=explode('/',$prid);
                $prid_dt='01-'.$pridArr[0].'-'.$pridArr[1];
                if(strtotime($prid_dt)>strtotime($request->start_month)){
                    Session::flash('error', 'Payroll already generated for months after the said period.');
                    return redirect('/loans/add-loan')->withInput();
                }

            }
            //dd($request->all());

            $maxid=Loan::max('id');
            if($maxid==null){
                $maxid=1;
            }else{
                $maxid=$maxid+1;
            }

            $loan_id='L'.str_pad($maxid,'3','0',STR_PAD_LEFT);

            $loan = new Loan;
            $loan->loan_id = $loan_id;
            $loan->emp_code = $request->emp_code;
            $loan->loan_type = $request->loan_type;
            $loan->start_month = $request->start_month;
            $loan->loan_amount = $request->loan_amount;
            $loan->installment_amount = $request->installment_amount;
            $loan->deduction = $request->deduction;
            //dd($loan);
            $loan->save();
            Session::flash('message', 'Loan details saved successfully.');
            return redirect('/loans/view-loans');


        }else {
            return redirect('/');
        }

    }
    public function editLoan($id)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();
            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();
            return View('loan/edit', $data);
        }else {
            return redirect('/');
        }
    }
    public function updateLoan(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $loanInfo=Loan::find($request->id);

            //dd($loanInfo);
            $old_loan_start_month=date('m/Y',strtotime($loanInfo->start_month));

            $start_month=date('m/Y',strtotime($request->start_month));
            $employee_code=$request->emp_code;

            if($old_loan_start_month==$start_month){
                //No start date change

            }else{
                //start date changed
                $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $old_loan_start_month)->first();

                if (!empty($payroll)) {
                    Session::flash('error', 'As deduction against the loan already started. You cannot change the Loan Start Date.');
                    return redirect('/loans/edit-loan/'.$request->id)->withInput();
                }
                $payroll = Payroll_detail::where('employee_id', '=', $employee_code)->where('month_yr', '=', $start_month)->first();

                if (!empty($payroll)) {
                    Session::flash('error', 'Payroll already generated for said period.');
                    return redirect('/loans/edit-loan/'.$request->id)->withInput();
                }
                $prid=Payroll_detail::max('month_yr');
                if(!empty($prid)){
                    $pridArr=explode('/',$prid);
                    $prid_dt='01-'.$pridArr[0].'-'.$pridArr[1];
                    if(strtotime($prid_dt)>strtotime($request->start_month)){
                        Session::flash('error', 'Payroll already generated for months after the said period.');
                        return redirect('/loans/edit-loan/'.$request->id)->withInput();
                    }

                }
            }

            //dd($request->all());

            $loan = Loan::find($request->id);
            //$loan->loan_id = $loan_id;
            $loan->emp_code = $request->emp_code;
            $loan->loan_type = $request->loan_type;
            $loan->start_month = $request->start_month;
            $loan->loan_amount = $request->loan_amount;
            $loan->installment_amount = $request->installment_amount;
            $loan->deduction = $request->deduction;
            //dd($loan);
            $loan->save();
            Session::flash('message', 'Loan details updated successfully.');
            return redirect('/loans/view-loans');
        }
        else {
            return redirect('/');
        }
    }
    public function loan_list_xlsexport(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            return Excel::download(new ExcelFileExportLoanList(), 'LoanList.xlsx');
        }
        else {
            return redirect('/');
        }
    }
    public function adjustLoan($id)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();


            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$id)->sum('amount');
            $data['loan_balance']=$data['loan_details']->loan_amount-$loanRecoveries;
            return View('loan/adjust', $data);

        } else {
            return redirect('/');
        }
    }
    public function updateLoanAdjustment(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $loanDetails=Loan::where('id', '=', $request->id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$request->id)->sum('amount');
            $loan_balance=$loanDetails->loan_amount-$loanRecoveries;
            $payroll_month=date('m/Y');

            if($loan_balance>0 && $loanDetails->adjust_date==null){
                $loan = Loan::find($request->id);
                $loan->adjust_amount = $loan_balance;
                $loan->adjust_date = date('Y-m-d');
               // $loan->deduction = 'N';
                $loan->adjust_remarks = $request->adjust_remarks;
                //dd($loan);
                $loan->save();

                $loanRecovery = new LoanRecovery;
                $loanRecovery->loan_id = $request->id;
                $loanRecovery->amount = $loan_balance;
                $loanRecovery->payout_month = $payroll_month;
                $loanRecovery->adjusted = 'Y';
                $loanRecovery->save();

                Session::flash('message', 'Loan details adjusted successfully.');
                return redirect('/loans/view-loans');

            }else{
                Session::flash('error', 'Nothing to adjust. Loan already settled.');
                return redirect('/loans/view-loans');
            }

        } else {
            return redirect('/');
        }
    }

    public function viewAdjustLoan($id)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();


            $data['id']=$id;
            $data['loan_details'] = Loan::where('id', '=', $id)->first();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$id)->sum('amount');
            $data['loan_balance']=$data['loan_details']->loan_amount-$loanRecoveries;
            //dd($loan_id);

            return View('loan/adjust-view', $data);

        } else {
            return redirect('/');
        }
    }
    public function loanAdjustmentReport(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

               $data['ClassName'] = 'adjustment-report';

               $employee_rs = Loan::join('employee', 'employee.emp_code', '=', 'loans.emp_code')
               ->select('employee.salutation', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.Designation', 'employee.old_emp_code', 'employee.emp_pf_no', 'loans.*')
               ->where('deduction', '=', 'Y')
               ->where('loans.loan_amount', '>', 0)
               ->where('loans.adjust_amount', '>', 0)
               ->orderBy('employee.emp_code', 'asc')
               ->get();


            $data['result'] = $employee_rs;

            return view('loan.adjustment-report', $data);
        } else {
            return redirect('/');
        }
    }
    public function adjustment_report_xlsexport(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $loan_type = '';
            if (isset($request->loan_type)) {
                $loan_type = $request->loan_type;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportAdjustAmount($month_yr,$loan_type), 'Adjustment-report.xlsx');
        }
        else {
            return redirect('/');
        }
    }

}
