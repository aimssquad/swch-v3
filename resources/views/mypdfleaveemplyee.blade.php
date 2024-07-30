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
<?php
$job_details=DB::table('employee')->where('emp_code', '=', $leaveApply[0]->employee_id)->where('emid', '=', $emid )->orderBy('id', 'DESC')->first();
  
  ?>
<body style="webkit-print-color-adjust: exact; ">

<table style="width:100%;font-family:cambria">
 <thead>
  <tr>
   <th style="text-align: left;width: 10%;">@if($com_logo!='') <img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="100"/> @endif</th>
		<th style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2>
	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	  <p style="margin:0;font-size:20px">Leave Details Of {{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}} ({{ $year_value }})</p>
	</th>
  </tr>
 </thead>
 
 
</table>
 
<table style="width:100%;margin-top: 50px;">
<tr>
<td>Employee Code: {{$leaveApply[0]->employee_id}}</td>

<td style="text-align:right">Employee Name:  {{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}}	</td>
</tr>
</table>
<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
    <th  style="color:#fff">Sl No.</th>
    	<th style="color:#fff">Leave Type</th>
													<th style="color:#fff">Date Of Application	</th>
													<th style="color:#fff">Duration</th>
													<th style="color:#fff">No. Of Days</th>
													
													

	 
  </tr>
 </thead>
<tbody>
    <?php
    $y=1;
    ?>
     
   @foreach($leaveApply as $lvapply)
                                                <tr>
                                                    <td>{{$y}}</td>
                                                    
                                                   
                                                    <td>{{$lvapply->leave_type_name}}</td>
                                                    <td ><?php $date=date_create($lvapply->date_of_apply);
                                                        echo date_format($date,"d/m/Y");  ?></td>

						

                        <td s><?php $fromdate=date_create($lvapply->from_date);
                                                        echo date_format($fromdate,"d/m/Y");  ?> To <?php $todate=date_create($lvapply->to_date);
                                                        echo date_format($todate,"d/m/Y");  ?></td>
                                                
<td>{{$lvapply->no_of_leave}}</td>
                                                
                                                   
                                                </tr>
                                                <?php
    $y++;
    ?>
                                             @endforeach
                                            </tbody>
										</table>
                                   			
                                   		</div>
                                 </div>
                                

  
</tbody>
</table>




</body>
</html>
