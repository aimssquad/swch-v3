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
td,th{
    padding-top:5px;
    padding-bottom:5px;
    padding-left:5px;
    padding-right:5px;
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
             <p style="margin:0;font-size:15px">{{ $role->address }}<br />{{$role->city}},{{$role->zip}},{{$role->country}}</p>

	  <p style="margin:0;font-size:25px">All Employee Report</p>
         </th>
     </tr>
  <tr>
  </tr>
 </thead>
</table>

<table style="width:100%;font-family:cambria">
    <tr>
        <th calspan="2" style="width:90%; background-color: #fff!imporant;"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $role->com_name }}</h2></th>
    </tr>
</table>





<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #d00eff;">
    
  <tr>
    <th  style="color:#fff;font-size:11px;">Sl No.</th>
	 <th  style="color:#fff;font-size:11px;">Emp Code</th>
	 <th  style="color:#fff;font-size:11px;">Emp Name</th>
	 <th  style="color:#fff;font-size:11px;">DOB</th>
	 <th  style="color:#fff;font-size:11px;">Mobile</th>
	 <th  style="color:#fff;font-size:11px;">Email</th>
	 <th  style="color:#fff;font-size:11px;">Department</th>
	 <th  style="color:#fff;font-size:11px;">Designation</th>
	 <th  style="color:#fff;font-size:11px;">Nationality</th>
	 <th  style="color:#fff;font-size:11px;">NI Number</th>
	 <!--<th  style="color:#fff;font-size:11px;">Visa Expert</th>-->
	 <!--<th  style="color:#fff;font-size:11px;">Password No</th>-->
	 <th  style="color:#fff;font-size:11px;">Address</th>
	 
  </tr>
  
 
 
 </thead>
<tbody>
     <?php
     $h = 1;
    ?>
    @foreach($employee as $file)
      <tr>
        <td style="font-size:10px;">{{ $h++ }}</td>
    	<td style="font-size:10px;">{{ $file->emp_code }}</td>
    	<td style="font-size:10px;">{{ $file->emp_fname.' '.$file->emp_lname }}</td>
    	<td style="font-size:10px;">{{ $file->emp_dob }}</td>
    	<td style="font-size:10px;">{{ $file->emp_ps_phone }}</td>
    	<td style="font-size:10px;">{{ $file->emp_ps_email }}</td>
    	<td style="font-size:10px;">{{ $file->emp_department }}</td>
    	<td style="font-size:10px;">{{ $file->emp_designation }}</td>
    	<td style="font-size:10px;">{{ $file->nationality }}</td>
    	<td style="font-size:10px;">{{ $file->ni_no }}</td>
    	<!--<td style="font-size:10px;">{{ $file->emp_designation }}</td>-->
    	<!--<td style="font-size:10px;">@if( $file->visa_exp_date!='1970-01-01') @if( $file->visa_exp_date!='') {{ date('d/m/Y',strtotime($file->visa_exp_date)) }} @endif  @endif</td>-->
    	<!--<td style="font-size:10px;">{{ $file->pass_doc_no }}</td>-->
        <td style="font-size:10px;">
            {{ $file->emp_pr_street_no }}
            @if($file->emp_per_village), {{ $file->emp_per_village }} @endif
            @if($file->emp_pr_state), {{ $file->emp_pr_state }} @endif
            @if($file->emp_pr_city), {{ $file->emp_pr_city }} @endif
            @if($file->emp_pr_pincode), {{ $file->emp_pr_pincode }} @endif
            @if($file->emp_pr_country), {{ $file->emp_pr_country }} @endif
        </td>
      </tr>
    @endforeach
 
  
</tbody>
</table>
</body>
</html>
