<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportApplicationStatus implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;

		 
    }
    public function collection()
    {
        
        
        	if($this->start_date =='all' && $this->end_date=='all'  ){
        	    
        	    	$or_lince=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 
		        
				->get();
        	}
         
         
         	if($this->start_date!='all' && $this->end_date!='all'  ){
         	    
         	  		$or_lince=DB::Table('registration')
		        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 ->whereBetween('tareq_app.assign_date', [$this->start_date, $this->end_date])
		        
		        
				->get();

				
				
         	}
         	
         	

    	$f=1;
				 foreach($or_lince as $company)
     {
		  			$peradd='';
if($company->address!=''){ $peradd=$company->address;} 
if($company->address2!=''){ $peradd .=','.$company->address2; }
if($company->road!=''){ $peradd .=','. $company->road; } if($company->city!=''){  $peradd .=','.$company->city; }
  if($company->zip!=''){  $peradd .=','.$company->zip; }  if($company->country!=''){  $peradd .=','.$company->country; }
  
								$pass=DB::Table('tareq_app')
		        
				 ->where('emid','=',$company->reg) 
				  ->where('ref_id','=',$company->ref_id) 
		         
				->first();
				$passname=DB::Table('users_admin_emp')
		        
			
				  ->where('employee_id','=',$company->ref_id) 
		         
				->first(); 
				if(!empty($pass)){
				    $ss=$pass->asign_name ;
				    if($pass->last_date!='1970-01-01' && $pass->last_date!=''){
				     $sa_date=date('d/m/Y',strtotime($pass->last_date)) ;
				    }else{
				      $sa_date='';   
				    }
				}else{
				  $ss='';  
				
				  $sa_date='';
				   
				}
						$passhr=DB::Table('hr_apply')
		        
				 ->where('emid','=',$company->reg) 
				 
				->first();
				$hr_sts='';
					if(!empty($passhr)){
					     $hr_sts=$passhr->licence ;  
					    
					}else{
					 $hr_sts='Work In Progress' ;  
					}
					
      $customer_array[] = array(
       'Sl No'  => $f,
       'Organisation Name'   =>$company->com_name  ,
       'Organisation Address'    => $peradd,
       'Authorising Officer Name'  => $company->f_name.' '.$company->l_name,
       'Authorising Officer Contact Number'   =>$company->con_num ,
	   'Application Submission Date'   => $sa_date,
	   'Organisation Status'   => $hr_sts,
	   'Employee Name'=>$passname->name,
	   
      );

   $f++;}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Organisation Name', 'Organisation Address', 'Authorising Officer Name', 'Authorising Officer Contact Number', 'Application Submission Date', 'Organisation Status','Employee Name', 
        ];
    }
}$f=1;