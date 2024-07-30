<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportHrReply implements FromCollection,WithHeadings
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
        	    
                $hr_reply_rs = DB::Table('hr_apply')
                    ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                    ->whereNotNull('hr_apply.hr_reply_date')
                    ->orderBy('hr_apply.id', 'desc')
                    ->get();
        	}
            if($this->start_date =='all' && $this->end_date=='all' && $this->employee_id!='all' ){
                
                        // $hr_lag_time_rs=DB::Table('hr_apply')
                        //     ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                        //     ->where('tareq_app.ref_id','=',$this->employee_id) 
                        //     ->where('hr_apply.status','=','Incomplete') 
                        //     ->orderBy('hr_apply.id', 'desc')
                        //     ->get();

                        $hr_reply_rs = DB::Table('hr_apply')
                            ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                            ->where('tareq_app.ref_id','=',$this->employee_id) 
                            ->whereNotNull('hr_apply.hr_reply_date')
                            ->orderBy('hr_apply.id', 'desc')
                            ->get();
                        
            }
         
         	if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id=='all' ){
         	    
         	  	
					// $hr_lag_time_rs=DB::Table('hr_apply')
					// 	->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                    //     ->whereBetween('hr_apply.sub_due_date', [$this->start_date, $this->end_date])
                    //     ->where('hr_apply.status','=','Incomplete') 
                    //     ->orderBy('hr_apply.id', 'desc')
				    //     ->get();

                    $hr_reply_rs = DB::Table('hr_apply')
                        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                        ->whereBetween('hr_apply.hr_reply_date', [$this->start_date, $this->end_date]) 
                        ->orderBy('hr_apply.id', 'desc')
                        ->get();
                        
         	}
         	
         	 if($this->start_date!='all' && $this->end_date!='all' && $this->employee_id!='all'){
         	     
         	   	
					// $hr_lag_time_rs=DB::Table('hr_apply')
					// 	->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                    //     ->whereBetween('hr_apply.sub_due_date', [$this->start_date, $this->end_date])
                    //     ->where('tareq_app.ref_id','=',$this->employee_id) 
                    //     ->where('hr_apply.status','=','Incomplete') 
                    //     ->orderBy('hr_apply.id', 'desc')
				    //     ->get();

                    $hr_reply_rs = DB::Table('hr_apply')
                        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
                        ->whereBetween('hr_apply.hr_reply_date', [$this->start_date, $this->end_date]) 
                        ->where('tareq_app.ref_id','=',$this->employee_id)
                        ->orderBy('hr_apply.id', 'desc')
                        ->get();

         	}

    	    $f=1;
				 foreach($hr_reply_rs as $company)
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
				       $sub_due_date=date('d/m/Y',strtotime($company->sub_due_date)) ;
				       $hr_reply_date=date('d/m/Y',strtotime($company->hr_reply_date)) ;
				}else{
				 
				  $app_date='';
				  $sa_date='';
				    $re='';
				    $sub_due_date='';
				    $hr_reply_date='';
				}
      $customer_array[] = array(
       'Sl No'  => $f,
       'Organisation Name'   =>$pass->com_name ,
       'Employee Name'    => $passname->name,
       'Start Date for HR File Preparation'  => $sa_date,
       'HR File Prearation Deadline'   =>$app_date,
	   'Lag Time After Submission'   => $sub_due_date,
	   'HR Reply Date'   => $hr_reply_date,
	   'Remarks'   => $company->remarks,
	   
	   
      );

   $f++;}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Organisation Name', 'Employee Name', 'Start Date for HR File Preparation', 'HR File Prearation Deadline', 'Lag Time After Submission','HR Reply Date', 'Remarks', 
        ];
    }
}$f=1;