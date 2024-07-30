<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExport implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date,$status,$reg,$job_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
		 $this->status = $status;
		 $this->reg = $reg;
		 	 $this->job_id = $job_id;
		 
    }
    public function collection()
    {
         if($this->job_id!=''){
             	$candidate_rs=DB::Table('candidate')
		        ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
		    
		     
				 ->where('company_job.emid','=',$this->reg) 
				  ->where('candidate.status','=',$this->status)
			    ->where('company_job.id','=',$this->job_id) 
			    	->whereBetween('candidate.date', [$this->start_date, $this->end_date])
		        ->select('candidate.*', 'company_job.job_code')
				->get();
         }else{
          	$candidate_rs=DB::Table('candidate')
		        ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
		    
		     
				 ->where('company_job.emid','=',$this->reg) 
				  ->where('candidate.status','=',$this->status)
			  	->whereBetween('candidate.date', [$this->start_date, $this->end_date])
		        ->select('candidate.*', 'company_job.job_code')
				->get();   
         }

    	
				 foreach($candidate_rs as $leave_allocation)
     {
		 $job_details=DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id )->orderBy('id', 'DESC')->first();
  			
     
if(!empty($job_details)){ 
 $end= date('d/m/Y',strtotime($job_details->date));
   $dte_end= $job_details->date;
    
}
else{
	$end=  date('d/m/Y',strtotime($leave_allocation->date));
	 $dte_end= $leave_allocation->date;
}

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
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Job Code', 'Job Title', 'Candidate', 'Email', 'Contact No.', 'Status', 'Date', 'Remarks',
        ];
    }
}