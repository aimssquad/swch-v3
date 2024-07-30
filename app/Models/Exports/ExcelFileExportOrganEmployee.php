<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportOrganEmployee implements FromCollection,WithHeadings
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

		
			$leave_allocation_rs= DB::table('company_employee')
				      
						   ->where('emid', '=', $this->reg )
						  
                            ->get();
							
		

    	$h=1;
				 foreach($leave_allocation_rs as $leave_allocation)
     {
		 
		   
        
      $customer_array[] = array(
       'Sl No'  => $h,
       'Employee Name'   =>$leave_allocation->name,
       'Department'    => $leave_allocation->department,
       'Job Type'  => $leave_allocation->job_type,
       'Job Title'   => $leave_allocation->designation,
        'Immigration Status'   => $leave_allocation->immigration 
	   
      );
   

     $h++; }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
          'Sl No'  ,
       'Employee Name'  ,
       'Department'    ,
       'Job Type'  ,
       'Job Title'  ,
        'Immigration Status'  
        ];
    }
}