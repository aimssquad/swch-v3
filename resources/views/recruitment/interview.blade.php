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
        @if($can_d->date_up!='')
        <td>Date :{{date('d/m/Y ',strtotime($can_d->date_up))}}
	    @if($can_d->date_up>='2021-02-22')
          {{' '.date('h:i A ',strtotime($can_d->date_up))}}
         @endif
       </td>
       @else
       <td>Date :{{date('d/m/Y ',strtotime($date . ' -2 days'))}}
	  
       </td>
       
        @endif
	  <td style="color: #29b9ff;font-size: 20px;">{{ $Roledata->com_name }}</td>
	  <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td>
	</tr>
  </thead>
</table>
<table style="width:100%;border: 3px solid #28b0f3;padding: 0 20px;">
  <tr>
    <td>
	  <p>Dear {{ $name }},</p>
	    <p>Thank you for your interest for the position of {{ $pos }} (job code: {{ $job_code }}). We would like to invite you for a telephone interview. The interview / assessment details are as follows:</p>
 
 <p>Date : {{ date('d/m/Y', strtotime($date))}}</p>
	  <p>Time: {{ date('h:i A', strtotime($from_time))}}  To  {{ date('h:i A', strtotime($to_time))}}</p>
	   @if($place!='')
 <p>Interview Place : {{ $place }}</p>
	@endif
	  @if($panel!='')
 <p>Interview Panel : {{ $panel }}</p>
	@endif
	  <p>Interviewer : {{ $job_d->author }}</p>
	   
	<p>  If you no longer wish to be considered for this post please reply to us at {{ $job_d->email }} within next three (03) working days with the subject title “withdrawn”. Doing this promptly may then allow us to allocate your interview slot to another applicant.</p>

<p> If you have any special requirements that should be taken into account during the assessment and selection process, please highlight these to us by calling 0{{ $Roledata->p_no }}.</p>
<p>
You will be notified if your interview was successful.Should you be successful following the interview process, your referees will be contacted to confirm your employment history. If you
have not done so already it is advisable that you check your referees availability and ensure that you have provided us with contact information such as their work email address. When references are taken up, it is your responsibility to chase your referees in order that an unconditional offer of employment can be made. Please be aware we require the last 3 years of references including any gaps.</p>
<p>If you have any queries about the interview, please do not hesitate to contact  {{ $job_d->email }} and  0{{ $job_d->con_num }} directly. We look forward to hearing from you directly via reply email.</p>

<p>Yours sincerely,</p>

<h5 style="margin-bottom:0;color: #29b9ff;font-size: 16px;">{{ $Roledata->com_name }} </h5>



	</td>
  </tr>
</table>
</body>
</html>
