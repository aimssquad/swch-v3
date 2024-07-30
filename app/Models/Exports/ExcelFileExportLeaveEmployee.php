<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportLeaveEmployee implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($year_value,$new_emp,$reg)
    {
      
		 	 $this->year_value = $year_value;
		 	  $this->new_emp = $new_emp;
		 $this->reg = $reg;
    }
    public function collection()
    {

$first_day_this_year =$this->year_value.'-01-01' ; 
        $last_day_this_year  =$this->year_value.'-12-31';
	
			$leave_allocation_rs=DB::table('leave_apply')
              ->join('leave_type','leave_apply.leave_type','=','leave_type.id') 
              ->select('leave_apply.*','leave_type.leave_type_name','leave_type.alies')
              ->where('leave_apply.employee_id','=',$this->new_emp)
			  ->where('leave_apply.emid','=',$this->reg)
			    ->where('leave_apply.status','=','APPROVED')
              ->whereDate('leave_apply.from_date','>=',$first_day_this_year)
              ->whereDate('leave_apply.to_date','<=',$last_day_this_year)
              ->get(); 
		   
		


    	$h=1;
				 foreach($leave_allocation_rs as $leave_allocation)
     {
		 
      $customer_array[] = array(
       'Sl No'  => $h,
       'Employee Code'   => $leave_allocation->employee_id ,
       'Employee Name'    => $leave_allocation->employee_name,
       'Leave Type'  => $leave_allocation->leave_type_name,
       'Date Of Application'   => date("d/m/Y",strtotime($leave_allocation->date_of_apply)) ,
	   'Duration'   => date('d/m/Y',strtotime($leave_allocation->from_date)).' To  '.date('d/m/Y',strtotime($leave_allocation->to_date)),
	   
	   'No. Of Days'   =>$leave_allocation->no_of_leave,
	    
      );
$h++;
     }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
             'Sl No',
       'Employee Code' ,
       'Employee Name' ,
       'Leave Type',
       'Date Of Application' ,
	   'Duration' ,
	   'No. Of Days',
	  
        ];
    }
}