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

	  <p style="margin:0;font-size:20px">Attendance Report
</p>
	</th>
  </tr>
 </thead>
 
 
</table>

<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
    <th style="color:#fff">Sl No.</th>
	 <th style="color:#fff">Department</th>
	 <th style="color:#fff">Designation</th>
	 <th style="color:#fff">Employee Code</th>
	 <th style="color:#fff">Employee Name</th>
	 <th style="color:#fff">No.of Working Days</th>
	 <th style="color:#fff">No.of Present Days</th>
	 <th style="color:#fff">No.of Absent Days</th>
	 <th style="color:#fff">No.of Leave Taken</th>
	
	 
  </tr>
 </thead>
<tbody>
    <?php
    
    $per_day_salary=$late_salary_deducted=$no_of_days_salary_deducted=$no_of_days_salary=0;
                
		$working_day=30;
		    $totday=0;
	
        foreach($holidays as $holiday) 
        {
          $totday=$totday+$holiday->day;
        }     
        $total_wk_days=0;
		$date1_ts = strtotime($start_date);
	  $date2_ts = strtotime($end_date);
	  $diff = $date2_ts - $date1_ts;
		 
	 
      $total_wk_days=(round($diff / 86400)+1);
	   
    	if($employee_rs)
		{$f=1;
		 $increment=0;
	  
	  
	  
	  
	  
	  
	  $at=1;
			foreach($employee_rs as $emp)
    {
        $tour_leave_count=0;
        $number_of_days_leave=0;
        $leave_apply_rs =  DB::select(DB::raw("SELECT SUM(no_of_leave) as number_of_days ,SUM(status),SUM(to_date) FROM `leave_apply` WHERE employee_id='$emp->emp_code' and emid='$emid' AND status='APPROVED' AND to_date  between '$start_date' and '$end_date'"));      
      	
        //dd(count($tour_leave));

      $number_of_days_leave= $leave_apply_rs[0]->number_of_days;
       
      if($number_of_days_leave==null)$number_of_days_leave=0;
                    
      $no_of_present=0;     $mon_y=date('m/Y', strtotime($start_date));
                  
       $upload_attendence=DB::select(DB::raw("SELECT count(*) as no_of_present,employee_code FROM `attandence` where employee_code='$emp->emp_code' and emid='$emid' and month='$mon_y'  group by employee_code,date"));     
      
       if(!empty($upload_attendence)){
           $no_of_present=$upload_attendence[0]->no_of_present;
       }else{
           $no_of_present=0;
       }
        
		
       $absent_days=0;
       $totleave_present=$no_of_present+$number_of_days_leave+$tour_leave_count;
        $absent_days=$total_wk_days-$totleave_present;
        
        $totsal=$no_of_present+$number_of_days_leave;
        $total_salary_deduction=$total_wk_days-$totsal;
        
       $no_of_days_salary= $no_of_present+$number_of_days_leave;
        if(!empty($no_of_present)){
?>
  <tr>
    <td>{{ $f }}</td>
	<td>{{ $department_name }}</td>
	<td>{{ $designation_name }}</td>
	<td>{{ $emp->emp_code }}</td>
		<td>{{ $emp->emp_fname.' '.$emp->emp_mname.' '.$emp->emp_lname }}</td>
	<td>{{ $total_wk_days }}</td>
	<td>{{ $no_of_present }}</td>
	<td>{{$absent_days }}</td>
	<td>{{ $number_of_days_leave }}</td>


  </tr>
  <?php
  $f++;
              $increment++;
		 $at++;
        }
    }
		}
		?>
 
</tbody>
</table>
</body>
</html>
