<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Loan\Loan;
use DB;

class ExcelFileExportAdjustAmount implements FromCollection, WithHeadings
{
    private $month_yr;
    private $loan_type;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr,$loan_type)
    {

        $this->month_yr = $month_yr;
        $this->loan_type = $loan_type;

    }
    public function collection()
    {


            //echo 0; die;
            $employee_rs = Loan::join('employee', 'employee.emp_code', '=', 'loans.emp_code')
            ->select('employee.salutation','employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.Designation', 'employee.old_emp_code','employee.emp_pf_no', 'loans.*')
            //->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
            //->where('loan_type', '=', $this->loan_type)
            ->where('deduction', '=', 'Y')
            ->where('loans.loan_amount', '>', 0)
            ->where('loans.adjust_amount', '>', 0)
            ->orderByRaw('cast(employee.emp_code as unsigned)', 'asc')
            ->get();


        $h = 1;
        $customer_array = array();
        $total_loan_amount=0;
        $total_balance=0;
        $total_installment=0;
        $total_pf_interest=0;
        $total_deduction=0;
        $total_loanadjust=0;

        if (count($employee_rs) != 0) {

                foreach ($employee_rs as $record) {
                    $balance=0;
                    if($record->recoveries==null){
                        $balance = $record->loan_amount;
                    }else{
                        $balance = $record->loan_amount-$record->recoveries;
                    }
                    $total_loan_amount=$total_loan_amount+$record->loan_amount;
                    $total_installment=$total_installment+$record->payroll_deduction;
                    $total_pf_interest=$total_pf_interest+$record->pf_iterest;
                    $total_deduction=$total_deduction+$record->payroll_deduction+$record->pf_iterest;
                    $total_balance=$total_balance+$balance;
                    $total_loanadjust=$total_loanadjust+$record->adjust_amount;
                    $pf_interest=$record->pf_iterest;

                    if($record->deduction == 'Y'){ $deduction = "Yes"; }else{ $deduction = "No";  }

                    $customer_array[] = array(
                        'Sl No'=> $h,
                        'Employee Id'=>$record->emp_code,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Designation'=>$record->emp_designation,
                        'Loan start month'=>date('m/Y',strtotime($record->start_month??'N/A')),
                        'Loan Type'=>$record->loan_type??'N/A',
                        'Loan Amount'=>$record->loan_amount??'N/A',
                        'Adjustment Amount'=>$record->adjust_amount??'N/A',
                        'Installment'=>$record->installment_amount??'N/A',
                        'Deduction'=> $deduction,
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
                'Employee Id',
                'Employee Code',
                'Employee Name',
                'Designation',
                'Loan start month',
                'Loan Type',
                'Loan Amount',
                'Loan Adjustment Amount',
                'Installment',
                'Deduction',
            ];

    }
}
