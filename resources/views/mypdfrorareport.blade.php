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
    background-color: #ecebfd;
}
.mm {
    background-color: white;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact; ">
<table class="odd_class" style="width:100%;font-family:cambria">
 <thead>
     <tr>
         <th style="width:130px;">
             <div style="border:2px solid #d00eff;"><img src="https://skilledworkerscloud.co.uk/hrms/img/logo.png" alt="" width="130px"></div>
         </th>
         <th style="text-align:right;">
             <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	  <p style="margin:0;font-size:20px">Duty Roster Report</p>
         </th>
     </tr>
  <tr>
  </tr>
 </thead>
</table>

<table style="width:100%;font-family:cambria">
    <tr>
        <th calspan="2" style="width:90%; background-color: #fff!imporant;"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2></th>
    </tr>
</table>    
    

<!--<table style="width:100%;font-family:cambria">-->
<!-- <thead>-->
<!--  <tr>-->
<!--    <th style="text-align: left;width: 10%;"><img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="130"/></th>-->
<!--	<th style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2>-->
<!--	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>-->

<!--	  <p style="margin:0;font-size:20px">Duty Roster Report-->
<!--</p>-->
<!--	</th>-->
<!--  </tr>-->
<!-- </thead>-->
 
 
<!--</table>-->

	 
<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #d00eff;">
  <tr>
    <th style="color:#fff">Sl No.</th>

	 <th style="color:#fff">Department</th>
	 <th style="color:#fff">Designation</th>
	 <th style="color:#fff">Employee Name</th>
	 <th style="color:#fff">Shift Code</th>
	 	<th style="color:#fff">Work In Time</th>
														<th style="color:#fff">Work Out Time</th>
													<th style="color:#fff">Break Time From</th>
													<th style="color:#fff">Break Time  To</th>
													<th style="color:#fff">From Date</th>
														<th style="color:#fff">To Date</th>
													
  </tr>
 </thead>
<tbody>
    <?php
    	if($leave_allocation_rs)
		{$f=1;
			foreach($leave_allocation_rs as $leave_allocation)
			{
			    $employee_shift=DB::table('shift_management')
     ->where('id', '=',  $leave_allocation->shift_code)
   
  ->first();
  $employee_shift_emp=DB::table('employee')
     ->where('emp_code', '=',  $leave_allocation->employee_id)
    ->where('emid', '=', $emid)
  ->first();
?>
  <tr>
    <td>{{ $f }}</td>


	<td>{{$department_name}}</td>
				<td>{{$designation_name }}</td>
													<td>{{$employee_shift_emp->emp_fname}}  {{$employee_shift_emp->emp_mname}}  {{$employee_shift_emp->emp_lname}} ({{$leave_allocation->employee_id}})</td>
														<td>{{$employee_shift->shift_code}} ( {{ $employee_shift->shift_des }}  )</td>
													
													
													<td>{{date('h:i a',strtotime($employee_shift->time_in))}}</td>
													<td>{{date('h:i a',strtotime($employee_shift->time_out))}}</td>
													<td>{{date('h:i a',strtotime($employee_shift->rec_time_in))}}</td>
													<td>{{date('h:i a',strtotime($employee_shift->rec_time_out))}}</td>
														<td>{{date('d/m/Y',strtotime($leave_allocation->start_date))}}</td>
															<td>{{date('d/m/Y',strtotime($leave_allocation->end_date))}}</td>
  </tr>
  <?php
  $f++;}
		}
		?>
 
</tbody>
</table>
</body>
</html>
