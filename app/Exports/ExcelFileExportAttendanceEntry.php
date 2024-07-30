<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Attendance\Process_attendance;
use DB;

class ExcelFileExportAttendanceEntry implements FromCollection, WithHeadings
{
    private $month_yr;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr)
    {
        
        $this->month_yr = $month_yr;
        
    }
    public function collection()
    {
        
        $employee_rs = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
            ->where('process_attendances.month_yr', '=', $this->month_yr)
            ->where('process_attendances.status', '=', 'A')
            ->where('employee.emp_status', '!=', 'TEMPORARY')
            ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            ->orderByRaw('cast(employee.emp_code as unsigned)', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_itax_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                
//dd($record);
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Id' => $record->emp_code,
                    'Employee Name'=>$record->emp_fname . ' ' . $record->emp_mname . ' ' . $record->emp_lname,
                    'Month'=>$record->month_yr,
                    'Days In Month'=>$record->no_of_working_days,
                    'No. of Present Days'=>$record->no_of_present,
                    'No. of Leave Taken'=>$record->no_of_days_leave_taken,
                    'No. of Absent Days'=>$record->no_of_days_absent,
                    'No. of Salary Days'=>$record->no_of_days_salary,
                    'No. of Salary Adjustment Days'=>$record->no_sal_adjust_days."",
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
            'Employee Name',
            'Month',
            'Days In Month',
            'No. of Present Days',
            'No. of Leave Taken',
            'No. of Absent Days',
            'No. of Salary Days',
            'No. of Salary Adjustment Days',
        ];
    }
}
