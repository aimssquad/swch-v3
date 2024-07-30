<?php
$employee='';
$name='';
$num='';
$email='';
$desig='';
if(!empty($offer->reportauthor)){
   
    $employee=DB::table('employee')->where('emid', '=',$Roledata->reg )->where('emp_code', '=',$offer->reportauthor)->first();
    $name=$employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname;
    $num=$employee->emp_ps_phone;
    $email=$employee->emp_ps_email;
    $desig=$employee->emp_designation;
}else{
   $name=$job_d->author;
    $num=$job_d->con_num;
    $email=$job_d->email;
    $desig=$job_d->desig; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>

<title>SWCH</title>
</head>

<body>
<table style="width:100%;">
  <thead>
    <tr>
         <td>Date :{{date('d/m/Y', strtotime($offer->cr_date))}}
       </td>
	  <td style="color: #29b9ff;font-size: 20px;">{{ $Roledata->com_name }}</td>
	  <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td>
	</tr>
  </thead>
</table>
<table style="width:100%;border: 3px solid #28b0f3;padding: 0 20px;">
  <tr>
     
    <td>
	  <p style="text-align: right;"> {{ $name_main }}</p>
	   <p style="text-align: right;"> {{ $offer->location }} @if(!empty($offer->zip)),{{ $offer->zip }} @endif</p>
	  <p>{{ date('d/m/Y', strtotime($offer->cr_date))}}</p>
	   <p>{{ $Roledata->com_name }} </p>
	   <p>{{ $Roledata->address.','.$Roledata->address2.','.$Roledata->road.','.$Roledata->city.','.$Roledata->zip.','.$Roledata->country}} </p>
	  <p>Dear  {{ $name_main }},</p>
	  
	<p>  Following your recent interview, I am writing to offer you the post of {{ $job_title }}  at the salary of {{ $offer->offered_sal }} per {{ $offer->payment_type}}, starting on {{ date('d/m/Y',strtotime($offer->date_jo))}}.
	
 </p>
 <p>Full details of the post’s terms and conditions of employment are in your attached Employment Contract.</p>
	  <p>As explained during the interview, this job offer is made subject to satisfactory results from necessary pre-employment checks.  There will also be a probationary period of three months which will have to be completed satisfactorily.<p>
	  
	 
	  <p> This is a  {{ $job_d->job_type }} .On starting, you will report to {{$name}}.</p>
	  
<p>If you have any queries on the contents of this letter, the attached Employment Contractor the pre-employment checks, please do not hesitate to contact me on 0{{$num}}.</p>

<p>To accept this offer, please sign and date the attached copy of this letter in the spaces indicated, scan it in legible format and send it back to us by replying to  {{$email}}.</p>
<p>We are delighted to offer you this opportunity and look forward to you joining the organisation and working with you.</p>
<p>This letter is part of your contract of employment.</p>

<p>Yours sincerely,</p>

<h5 style="margin-bottom:0;color: #29b9ff;font-size: 16px;">{{$name}}</h5>
<p style="margin-top:0;margin-bottom:0;">{{$desig}}</p>
<p><b>I am very pleased to accept the job offer on the terms and conditions detailed in this letter and the Written Statement of Terms and Conditions of Employment</b></p>
<p><b>Signed and date ………………………………………………………………………………………………</b><p>
   <p><b> [Successful candidate to write their signature with date]</b><p>



 <p><b>Name ……………………………………………………………………………………………………………….</b> </p>

 <p><b>[Successful candidate to print their full name in capital letters]</b><p>


	</td>
  </tr>
</table>
</body>
</html>


 


