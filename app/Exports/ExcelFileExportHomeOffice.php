<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportHomeOffice implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date,$employee_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
	 $this->employee_id = $employee_id;
		 
    }
    public function collection()
    {
        
        
        	if($this->start_date =='all' && $this->end_date=='all' && $this->employee_id=='all' ){
        	    
        	    	$hr_home_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.home_off','=','Yes') 
				->get();
        	}
         if($this->start_date =='all' && $this->end_date=='all' && $this->employee_id!='all' ){
             
				
				$hr_home_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$this->employee_id) 
      ->where('hr_apply.home_off','=','Yes')
   ->orderBy('hr_apply.id', 'desc')
				->get();
             
         }
         
         	if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id=='all' ){
         	    
         	  	
				
					$hr_home_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$this->start_date, $this->end_date])
      ->where('hr_apply.home_off','=','Yes') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
         	}
         	
         	 if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id!='all'){
         	     
         	   	
					$hr_home_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$this->start_date, $this->end_date])
  ->where('tareq_app.ref_id','=',$this->employee_id) 
     ->where('hr_apply.home_off','=','Yes')
   ->orderBy('hr_apply.id', 'desc')
				->get();
         	 }

    	$f=1;
				 foreach($hr_home_rs as $company)
     {
		  				$pass=DB::Table('registration')
		        
				 ->where('reg','=',$company->emid) 
				 
				->first();
					$terf=DB::Table('tareq_app')
		        
			
				  ->where('emid','=',$company->emid) 
		         
				->first(); 
				$passname=DB::Table('users_admin_emp')
		        
			
				  ->where('employee_id','=',$terf->ref_id) 
		         
				->first(); 
				if(!empty($company->job_date)){
				  
				     $sa_date=date('d/m/Y',strtotime($company->job_date)) ;
				       $app_date=date('d/m/Y',strtotime($company->hr_file_date)) ;
				    
				}else{
				 
				  $app_date='';
				  $sa_date='';
				    $re='';
				}
				  if($company->home_visit_date!=''){
				      
				       $ghg=date('d/m/Y',strtotime($company->home_visit_date)) ;}else{
				           
    $ghg='';
				       }
      $customer_array[] = array(
       'Sl No'  => $f,
       'Organisation Name'   =>$pass->com_name ,
       'Employee Name'    => $passname->name,
       'Start Date for HR File Preparation'  => $sa_date,
       'HR File Prearation Deadline'   =>$app_date,
	   'Home Office Client Visit'   => $ghg,
	   'Remarks'   => $company->remarks,
	   
	   
      );

   $f++;}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Organisation Name', 'Employee Name', 'Start Date for HR File Preparation', 'HR File Prearation Deadline', 'Home Office Client Visit', 'Remarks', 
        ];
    }
}$f=1;