<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportAwardgrant implements FromCollection,WithHeadings
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
        	    
        	    	$hr_granted_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.licence','=','Granted') 
      ->select('hr_apply.*')
				->get();
        	}
         if($this->start_date =='all' && $this->end_date=='all' && $this->employee_id!='all' ){
             	$hr_granted_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$this->employee_id) 
     ->where('hr_apply.licence','=','Granted') 
     
   ->orderBy('hr_apply.id', 'desc')
     ->select('hr_apply.*')
				->get();
             
         }
         
         	if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id=='all' ){
         	    
         	  	$hr_granted_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$this->start_date, $this->end_date])
     ->where('hr_apply.licence','=','Granted') 
       
   ->orderBy('hr_apply.id', 'desc')
   ->select('hr_apply.*')
				->get();  
         	}
         	
         	 if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id!='all'){
         	     
         	   	$hr_granted_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$this->start_date, $this->end_date])
  ->where('tareq_app.ref_id','=',$this->employee_id) 
    ->where('hr_apply.licence','=','Granted') 
   ->orderBy('hr_apply.id', 'desc')
     ->select('hr_apply.*')
				->get();  
         	 }

    	$f=1;
				 foreach($hr_granted_rs as $company)
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
				
				if(!empty($company->update_new_ct)){
				  
				     $up_date=date('d/m/Y',strtotime($company->update_new_ct)) ;
				      
				    
				}else{
				 
				 $up_date=date('d/m/Y',strtotime($company->date.' + 2 days')) ;
				  if($up_date>date('d/m/Y')){
				    $up_date= date('d/m/Y');
				 }else{
				    $up_date=$up_date; 
				 }        
				}
					$pabillsts=DB::Table('billing')
			
				  ->where('emid','=',$company->emid) 
		         
				->get(); 
				$grb='';
				if(count($pabillsts)!=0){
                          $grb='Generated';
                            }else{
                            $grb='Not Generated';
											
}
      $customer_array[] = array(
       'Sl No'  => $f,
       'Organisation Name'   =>$pass->com_name ,
        'Authorising officers first name'   =>$pass->f_name ,
         'Authorising officers last name'   =>$pass->l_name ,
          'Authorising officers contact number'   =>$pass->con_num ,
           'Authorising officers email address'   =>$pass->authemail ,
       'Employee Name'    => $passname->name,
       'Start Date for HR File Preparation'  => $sa_date,
       'HR File Prearation Deadline'   =>$app_date,
	   'Licence Award Decision'   => $company->licence,
	   'License Award Date' =>$up_date,
	   'Remarks'   => $company->remarks,
	   'Billing Status'   => $grb
	   
      );

   $f++;}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Organisation Name','Authorising officers first name','Authorising officers last name','Authorising officers contact number','Authorising officers email address', 'Employee Name', 'Start Date for HR File Preparation', 'HR File Prearation Deadline', 'Licence Award Decision','License Award Date', 'Remarks', 'Billing Status ', 
        ];
    }
}$f=1;