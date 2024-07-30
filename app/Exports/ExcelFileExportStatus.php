<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportStatus implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date,$reg,$job_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
	
		 $this->reg = $reg;
		 	 $this->job_id = $job_id;
		 
    }
    public function collection()
    {
         if($this->job_id!=''){
             	$candidate_rs=DB::Table('candidate')
		        ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
		    
		     
				 ->where('company_job.emid','=',$this->reg) 
				 
			    ->where('company_job.id','=',$this->job_id) 
			    	->whereBetween('candidate.date', [$this->start_date, $this->end_date])
		        ->select('candidate.*', 'company_job.job_code')
				->get();
         }else{
          	$candidate_rs=DB::Table('candidate')
		        ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
		    
		     
				 ->where('company_job.emid','=',$this->reg) 
				
			  	->whereBetween('candidate.date', [$this->start_date, $this->end_date])
		        ->select('candidate.*', 'company_job.job_code')
				->get();   
         }

    	
				 foreach($candidate_rs as $leave_allocation)
     {
		 $job_details=DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id )->orderBy('id', 'DESC')->first();
  			
     
if(!empty($job_details)){ 
 $end= date('d/m/Y',strtotime($leave_allocation->date));
   $dte_end= $leave_allocation->date;
   
   $customer_array[] = array(
       'Job Code'  => $leave_allocation->job_code,
       'Job Title'   => $leave_allocation->job_title,
       'Candidate'    => $leave_allocation->name,
       'Email'  => $leave_allocation->email,
       'Contact No.'   => $leave_allocation->phone ,
	   'Status'   => 'Application Received',
	   'Date'   => $end,
	   'Remarks'   => ''
      );
      $job_ff=DB::table('candidate_history')
     ->join('company_job', 'candidate_history.job_id', '=', 'company_job.id')
     
    ->where('candidate_history.user_id', '=', $leave_allocation->id )
    ->where('company_job.emid','=',$this->reg) 
				  
			   	
		        ->select('candidate_history.*', 'company_job.job_code')
    ->orderBy('candidate_history.id', 'ASC')
    ->get();
    
       foreach($job_ff as $leave_allocationjj)
			{
			  $end= date('d/m/Y',strtotime($leave_allocationjj->date));
   $dte_end= $leave_allocationjj->date;  
 $customer_array[] = array(
       'Job Code'  => $leave_allocationjj->job_code,
       'Job Title'   => $leave_allocationjj->job_title,
       'Candidate'    => $leave_allocationjj->name,
       'Email'  => $leave_allocationjj->email,
       'Contact No.'   => $leave_allocationjj->phone ,
	   'Status'   => $leave_allocationjj->status,
	   'Date'   => $end,
	   'Remarks'   => $leave_allocationjj->remarks
      );
			    
			}
   
		    
    
}
else{
	$end=  date('d/m/Y',strtotime($leave_allocation->date));
	 $dte_end= $leave_allocation->date;
	 
	 
	 $customer_array[] = array(
       'Job Code'  => $leave_allocation->job_code,
       'Job Title'   => $leave_allocation->job_title,
       'Candidate'    => $leave_allocation->name,
       'Email'  => $leave_allocation->email,
       'Contact No.'   => $leave_allocation->phone ,
	   'Status'   => $leave_allocation->status,
	   'Date'   => $end,
	   'Remarks'   => $leave_allocation->remarks
      );
}

      

     }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Job Code', 'Job Title', 'Candidate', 'Email', 'Contact No.', 'Status', 'Date', 'Remarks',
        ];
    }
}