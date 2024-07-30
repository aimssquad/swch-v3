<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportBalance implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($reg)
    {
       
		 $this->reg = $reg;
    }
    public function collection()
    {

		
			$leave_allocation_rs= DB::table('leave_allocation')
            ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
            ->join('employee', 'leave_allocation.employee_code', '=', 'employee.emp_code') 
            	->where('employee.emid','=',$this->reg) 
            		->where('leave_allocation.emid','=',$this->reg)
            			->where('leave_type.emid','=',$this->reg) 
            ->select('leave_allocation.*', 'leave_type.leave_type_name','employee.*')
            ->get();
							
		

    	$h=1;
				 foreach($leave_allocation_rs as $leave_balance)
     {
		 
		   
        
      $customer_array[] = array(
       'Sl No'  => $h,
       'Employee Code'   =>$leave_balance->emp_code,
       'Employee Name'    => $leave_balance->emp_fname." ".$leave_balance->emp_mname." ".$leave_balance->emp_lname,
       'Leave Type'  => $leave_balance->leave_type_name,
       'Balance in Hand'   => $leave_balance->leave_in_hand
	   
      );
   

     $h++; }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
          'Sl No'  ,
       'Employee Code'   ,
       'Employee Name'   ,
       'Leave Type' ,
       'Balance in Hand'  
        ];
    }
}