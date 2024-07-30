<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportAttandance implements FromCollection,WithHeadings
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
		

			
                   $leave_allocation_rs=DB::table('attandence')
				      ->join('employee','attandence.employee_code','=','employee.emp_code')
                           ->where('attandence.employee_code','=',$this->new_emp)
						   ->where('attandence.emid', '=', $this->reg )
					 ->where('employee.emp_designation', '=',$this->designation_name )
						   ->where('employee.emp_department', '=',$this->department_name )
							->whereBetween('attandence.date', [$this->start_date, $this->end_date])
							->select('attandence.*')
                            ->get();
		}else{
			$leave_allocation_rs=DB::table('attandence')
				      ->join('employee','attandence.employee_code','=','employee.emp_code')
                          
						  
						   ->where('attandence.emid', '=', $this->reg )
					 ->where('employee.emp_designation', '=',$this->designation_name )
						   ->where('employee.emp_department', '=',$this->department_name )
							->whereBetween('attandence.date', [$this->start_date, $this->end_date])
							->select('attandence.*')
                            ->get();
							
		}


    	$h=1;
		$customer_array=array();
		if(count($leave_allocation_rs)!=0){
				 foreach($leave_allocation_rs as $leave_allocation)
     {
	
    $time_in='';
			 if($leave_allocation->time_in!=''){
				 
				$time_in=date('h:i a',strtotime($leave_allocation->time_in)); 
			 }
			 $time_out='';
			 if($leave_allocation->time_out!=''){
				 
				$time_out=date('h:i a',strtotime($leave_allocation->time_out)); 
			 }

      $customer_array[] = array(
       'Sl No'  => $h,
       'Department'   => $this->department_name ,
       'Designation'    => $this->designation_name,
       'Employee Name'  => $leave_allocation->employee_name,
       'Date'   => date('d/m/Y',strtotime($leave_allocation->date)) ,
	   'Clock In'   => $time_in,
	   'Clock In Location'   =>  $leave_allocation->time_in_location ,
	   'Clock Out'   => $time_out,
	    'Clock Out Location'   => $leave_allocation->time_out_location,
	     'Duty Hours'   =>$leave_allocation->duty_hours,
	     
      );
$h++;
     }
		}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No'  ,
       'Department' ,
       'Designation'  ,
       'Employee Name' ,
       'Date'   ,
	   'Clock In'   ,
	   'Clock In Location'  ,
	   'Clock Out'  ,
	    'Clock Out Location'   ,
	     'Duty Hours'  ,
        ];
    }
}