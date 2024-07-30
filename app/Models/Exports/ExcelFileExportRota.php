<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportRota implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date,$department_name,$designation_name,$new_emp,$reg)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
		 $this->department_name = $department_name;
		 	 $this->designation_name = $designation_name;
		 	  $this->new_emp = $new_emp;
		 $this->reg = $reg;
    }
    public function collection()
    {

		if($this->new_emp != 'all')
		
		{
		

			
                   $leave_allocation_rs=DB::table('duty_roster')
				      ->join('employee','duty_roster.employee_id','=','employee.emp_code')
                           ->where('duty_roster.employee_id','=',$this->new_emp)
                             ->where('employee.emp_code','=',$this->new_emp)
						   ->where('duty_roster.emid', '=', $this->reg )
						      ->where('employee.emid', '=',$this->reg )
						  ->where('employee.emp_designation', '=',$this->designation_name )
						   ->where('employee.emp_department', '=',$this->department_name  )
									 ->where('duty_roster.start_date', '>=',  $this->start_date)
							 ->where('duty_roster.end_date', '<=', $this->end_date )
							->select('duty_roster.*')
                            ->get();
		}else{
			$leave_allocation_rs=DB::table('duty_roster')
				      ->join('employee','duty_roster.employee_id','=','employee.emp_code')
                             ->where('employee.emid', '=',$this->reg )
						  ->where('duty_roster.emid', '=', $this->reg )
						  ->where('employee.emp_designation', '=',$this->designation_name )
						   ->where('employee.emp_department', '=',$this->department_name  )
								 ->where('duty_roster.start_date', '>=',  $this->start_date)
							 ->where('duty_roster.end_date', '<=', $this->end_date )
							->select('duty_roster.*')
                            ->get();
							
		}


    	$h=1;
				 foreach($leave_allocation_rs as $leave_allocation)
     {
		 $employee_shift_emp=DB::table('employee')
     ->where('emp_code', '=',  $leave_allocation->employee_id)
    ->where('emid', '=', $this->reg)
  ->first();
    $employee_shift=DB::table('shift_management')
     ->where('id', '=',  $leave_allocation->shift_code)
   
  ->first();

      $customer_array[] = array(
       'Sl No'  => $h,
       'Department'   => $this->department_name ,
       'Designation'    => $this->designation_name,
       'Employee Name'  => $employee_shift_emp->emp_fname.' '.$employee_shift_emp->emp_mname.' '.$employee_shift_emp->emp_lname.' ('.$leave_allocation->employee_id.' )',
       'Shift Code'   => $employee_shift->shift_code.' ( '. $employee_shift->shift_des.'  )',
	   'Work In Time'   => date('h:i a',strtotime($employee_shift->time_in)),
	   'Work Out Time'   => date('h:i a',strtotime($employee_shift->time_out)),
	   'Break Time From'   => date('h:i a',strtotime($employee_shift->rec_time_in)),
	    'Break Time  To'   => date('h:i a',strtotime($employee_shift->rec_time_out)),
	     'From Date'   =>date('d/m/Y',strtotime($leave_allocation->start_date)),
	     'To Date'   => date('d/m/Y',strtotime($leave_allocation->end_date))
      );
$h++;
     }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
             'Sl No',
       'Department' ,
       'Designation' ,
       'Employee Name',
       'Shift Code' ,
	   'Work In Time' ,
	   'Work Out Time',
	   'Break Time From',
	    'Break Time  To',
	     'From Date',
	     'To Date'  ,
        ];
    }
}