<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SWCH</title>
<style>
@media print {
   body {
      -webkit-print-color-adjust: exact;
   }
}
tr:nth-child(even) {
    background-color: #d0e5ff;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact; ">

<table style="width:100%;font-family:cambria">
 <thead>
  <tr>
    <th style="text-align: left;width: 10%;"><img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="130"/></th>
	<th style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2>
	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	  <p style="margin:0;font-size:20px">Details of Status Search</p>
	</th>
  </tr>
 </thead>
 
 
</table>

<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
    <th style="color:#fff">Job Code</th>
	 <th style="color:#fff">Job Title</th>
	 <th style="color:#fff">Candidate</th>
	 <th style="color:#fff">Email</th>
	 <th style="color:#fff">Contact No.</th>
	 <th style="color:#fff">Status</th>
	 <th style="color:#fff">Date</th>
	 <th style="color:#fff">Remarks</th>
  </tr>
 </thead>
<tbody>
    <?php
    	if($candidate_rs)
		{$f=1;
			foreach($candidate_rs as $leave_allocation)
			{$job_details=DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id )->orderBy('id', 'DESC')->first();
  			
if(!empty($job_details)){ 
     $job_ff=DB::table('candidate_history')
     ->join('company_job', 'candidate_history.job_id', '=', 'company_job.id')
     
    ->where('candidate_history.user_id', '=', $leave_allocation->id )
    ->where('company_job.emid','=',$reg) 
				  
			   	
		        ->select('candidate_history.*', 'company_job.job_code')
    ->orderBy('candidate_history.id', 'ASC')
    ->get();
      $o=1;
   $end=  date('d/m/Y',strtotime($leave_allocation->date));
	 $dte_end= $leave_allocation->date;
    
    ?>
  <tr>
    <td>{{ $leave_allocation->job_code }}</td>
	<td>{{ $leave_allocation->job_title }}</td>
	<td>{{ $leave_allocation->name }}</td>
	<td>{{ $leave_allocation->email }}</td>
	<td>{{ $leave_allocation->phone }}</td>
	<td>Application Received</td>
	<td>{{ $end }}</td>
	<td></td>
  </tr>
  <?php
  foreach($job_ff as $leave_allocationjj)
			{
			   
 $end= date('d/m/Y',strtotime($leave_allocationjj->date));
   $dte_end= $leave_allocationjj->date;
    ?>
  <tr>
    <td>{{ $leave_allocationjj->job_code }}</td>
	<td>{{ $leave_allocationjj->job_title }}</td>
	<td>{{ $leave_allocationjj->name }}</td>
	<td>{{ $leave_allocationjj->email }}</td>
	<td>{{ $leave_allocationjj->phone }}</td>
	<td>{{ $leave_allocationjj->status }}</td>
	<td>{{ $end }}</td>
	<td>{{ $leave_allocationjj->remarks }}</td>
  </tr>
  <?php
		$o++;	}
   
    
}
else{
	$end=  date('d/m/Y',strtotime($leave_allocation->date));
	 $dte_end= $leave_allocation->date;
	 
	 
	 ?>
  <tr>
    <td>{{ $leave_allocation->job_code }}</td>
	<td>{{ $leave_allocation->job_title }}</td>
	<td>{{ $leave_allocation->name }}</td>
	<td>{{ $leave_allocation->email }}</td>
	<td>{{ $leave_allocation->phone }}</td>
	<td>{{ $leave_allocation->status }}</td>
	<td>{{ $end }}</td>
	<td>{{ $leave_allocation->remarks }}</td>
  </tr>
  <?php
}


  $f++;
			}
		}
		?>
 
</tbody>
</table>
</body>
</html>
