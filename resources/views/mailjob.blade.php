<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SWCH</title>
</head>

<body>
<table style="width:100%;">
  <thead>
    <tr>
	  <td style="color: #29b9ff;font-size: 20px;">{{ $Roledata->com_name }}</td>
	  <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td>
	</tr>
  </thead>
</table>
<table style="width:100%;border: 3px solid #28b0f3;padding: 0 20px;">
  <tr>
    <td>
	  <p>Dear {{ $name }},</p>

	  <p>Thank you for taking the time to apply for {{ $pos }} (Job code: {{ $job_code }}). We appreciate your interest in our company. We are currently in the process of receiving applications for this position and will review your application soon. If you are shortlisted to continue to the interview process, we will be in contact with
	  you.</p>


<p>Thanking you</p>



<h5 style="margin-bottom:0;color: #29b9ff;font-size: 16px;">{{ $Roledata->com_name }} </h5>



	</td>
  </tr>
</table>
</body>
</html>
