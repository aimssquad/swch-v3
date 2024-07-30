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
.mm {
    background-color: white;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact; ">

<table style="width:100%;font-family:cambria">
 <thead>
  <tr>
   
	<th style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2>
	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	  <p style="margin:0;font-size:20px">Employee List Report
</p>
	</th>
  </tr>
 </thead>
 
 
</table>

	 
<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
    <th style="color:#fff">Sl No.</th>

	 	<th style="color:#fff">Employee Name</th>
														<th style="color:#fff">Department</th>
														<th style="color:#fff">Job Type</th>
													<th style="color:#fff">Job Title</th>
														<th style="color:#fff">Immigration Status</th>
												
														
													
  </tr>
 </thead>
<tbody>
    <?php
    	if($leave_allocation_rs)
		{$f=1;
			foreach($leave_allocation_rs as $leave_allocation)
			{
	
?>
  <tr>
    <td>{{ $f }}</td>


	<td> {{$leave_allocation->name}}</td>
				<td>{{$leave_allocation->department }}</td>
					<td>{{$leave_allocation->job_type }}</td>
				<td>{{$leave_allocation->designation }}</td>
					<td>{{$leave_allocation->immigration }}</td>
													
  </tr>
  <?php
  $f++;}
		}
		?>
 
</tbody>
</table>
</body>
</html>
