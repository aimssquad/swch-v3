<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Loan\Loan;
use DB;

class ExcelFileExportLoanList implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
		 
    }
    public function collection()
    {
        $employee_rs = Loan::join('employee', 'employee.emp_code', '=', 'loans.emp_code')
        ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.Designation', 'employee.old_emp_code', 'loans.*',DB::raw('(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id) as balance'))
        ->orderBy('loans.id', 'desc')
            ->get();

        $h = 1;
        $customer_array = array();
        


        if (count($employee_rs) != 0) {

            foreach ($employee_rs as $record) {
                $balance=0;
                if($record->balance==null){
                    $balance = $record->loan_amount;
                }else{
                    $balance = $record->loan_amount-$record->balance;
                }
                
                
                $loan_type='';
                if($record->loan_type=='SA'){
                    $loan_type='Salary Advance';
                }
                                            
                
                if($record->loan_type=='PF'){
                    $loan_type='PF Loan';
                }

                $adjust_text='';

                if($record->adjust_date==null || $record->adjust_date=='0000-00-00'){
                }else{
                    $adjust_text=$record->adjust_amount.' || '.date('d/m/Y',strtotime($record->adjust_date));
                }               
                                      

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee ID'=>$record->emp_code,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Designation'=>$record->emp_designation,
                    'Loan ID'=>$record->loan_id,
                    'Loan Start Month'=>date('m/Y',strtotime($record->start_month)),
                    'Loan Type'=>$loan_type,
                    'Loan Amount'=>number_format($record->loan_amount,2),
                    'Installment Amount'=>number_format($record->installment_amount,2),
                    'Balance Amount'=>number_format($balance,2),
                    'Deduction'=>($record->deduction=='Y')?'Yes':'No',
                    'Adjust'=>$adjust_text,
                       
                );
                $h++;
            }
        }
        return collect($customer_array);
    }


    public function headings(): array
    {
        return [
            'Sl No',
            'Employee ID',
            'Employee Code',
            'Employee Name',
            'Designation',
            'Loan ID',
            'Loan Start Month',
            'Loan Type',
            'Loan Amount',
            'Installment Amount',
            'Balance Amount',
            'Deduction',
            'Adjust',
            
        ];
    }
}