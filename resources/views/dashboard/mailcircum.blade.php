<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
</head>

<body>
	
	<table width="900px" style="margin:auto;font-family: calibri;margin: auto;
    font-family: calibri;
    border: 5px solid #add5f7;
    padding: 10px;font-size:20px;">
		<tr>
				<td><h3>{{ $job->emp_fname }} {{ $job->emp_mname }} {{ $job->emp_lname }}</h3></td>
			<td>@if($Roledata->logo!='') <img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /> @endif</td>
		</tr>
		<tr>
			<td colspan="2">{{ $job->emp_pr_street_no}} @if( $job->emp_per_village) ,{{ $job->emp_per_village}} @endif @if( $job->emp_pr_state) ,{{ $job->emp_pr_state}} @endif @if( $job->emp_pr_city) ,{{ $job->emp_pr_city}} @endif
  @if( $job->emp_pr_pincode) ,{{ $job->emp_pr_pincode}} @endif  @if( $job->emp_pr_country) ,{{ $job->emp_pr_country}} @endif</h3></td>
			
		</tr>
		<tr>
			<td colspan="2">Date : {{date('d/m/Y',strtotime($date))}}</h3></td>
			
		</tr>

		<tr>
			<tr><td>
				<p><b>Subject: Change of Circumstances - Annual Reminder.</b>
<p>To comply with Home Office guidance, we have an obligation to report changes in sponsored
migrant contact details to the Home Office via the sponsor management system within 10 days of
the change occurring. In this regard please update (in applicable) change of circumstances details
(e.g. change of Passport, BRP card, Immigration Status, Nationality, Residential and/or
Correspondences address, landline telephone number and mobile telephone number, Emergency
contact details, Next of Kin details, Disability Information, Registrations and Memberships status, Job
Title). Please notify us immediately if there is any change in circumstances at your end.
Mentionable, your historic contact details will be retained in the form of hardcopy and/or digital
format. You can also update such information yourself by logging into <a href="https://workpermitcloud.co.uk/hrms/" target="_blank">https://workpermitcloud.co.uk/hrms/</a> with your
employee login credentials.</p>

<p>Please do not hesitate to contact your HR/line manager if you have any concern or would like to
discuss this further.</p>


<p>Yours sincerely</p><p>{{ $Roledata->f_name }} {{ $Roledata->l_name }}</p>
<p>{{ $Roledata->desig }}</p>
			</td></tr>
		</tr>
	</table>
</body>

</html>