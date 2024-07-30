<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
</head>

<body>
	
	<table style="max-width:900px;width:100%;margin:auto;font-family: calibri;margin: auto;
    font-family: calibri;
    border: 5px solid #add5f7;
    padding: 10px;">
		<tr>
			<td><h3>{{ $offer->emp_fname }} {{ $offer->emp_mname }} {{ $offer->emp_lname }}</h3></td>
			<td>@if($Roledata->logo!='') <img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /> @endif</td>
		</tr>
		<tr>
			<td colspan="2">{{ $offer->emp_pr_street_no}} @if( $offer->emp_per_village) ,{{ $offer->emp_per_village}} @endif @if( $offer->emp_pr_state) ,{{ $offer->emp_pr_state}} @endif @if( $offer->emp_pr_city) ,{{ $offer->emp_pr_city}} @endif
  @if( $offer->emp_pr_pincode) ,{{ $offer->emp_pr_pincode}} @endif  @if( $offer->emp_pr_country) ,{{ $offer->emp_pr_country}} @endif</h3></td>
			
		</tr>
		<tr>
			<td colspan="2">Date : {{date('d/m/Y',strtotime($offer->pass_exp_date.'  - 30  days'))}}</h3></td>
			
		</tr>

		<tr>
			<tr><td colspan="2">
				<p><b>Subject: Right to Work Documentation – Temporary Passport 30-day Reminder.</b></p>
<p>Further to your employment on a temporary passport, I am writing to remind you that this passport is due to
expire on {{date('d/m/Y',strtotime($offer->pass_exp_date))}}. You are therefore requested to make arrangements to renew your right to
work documentation in order for you to remain in employment.</p>
<p>Examples of the documents we require are as follows:</p>
<ul>
<li> A copy of your completed application; and</li>
<li> Proof of postage; and/or</li>
<li> An acknowledgement letter from the Home Office confirming receipt of your application</li>
<li> Where a Certificate of Application provides you with the right to work it is your responsibility
to ensure your certificate of application is always dated within 6 months</li>
</ul>
<p>{{ $Roledata->com_name }}  will complete a check with the Home Office Employer Checking Service to
obtain confirmation of any application at the time of your passport expiring or at 5 monthly intervals
dependent on the checking requirements for the right to work documents you provide to us. Where
a negative verification notice is received, we cannot continue to employ you, unless you are able to
provide alternative evidence to satisfy us that you have the right to work.</p>

<p>As previously advised, the immigration, Asylum and the Nationality Act 2006 requires all employers
to make documentation checks at the start of every new colleague’s employment. This legislation
also requires employers to carry out follow-up checks where the documents provided only give a
colleague the temporary right to work in the UK. This also forms part of the employment with
{{ $Roledata->com_name }}</p>
<p>Please bring your original documents into the HR team without delay or no later than & 15 days of
issuance of letter;. Otherwise, we will have no option but to review your ongoing right to work
when your current passport expires. A failure to provide sufficient document evidencing your ongoing
right to work in the UK could result {{ $Roledata->com_name }} taking action, which may include
considering the summary termination of your employment.
Please do not hesitate to contact me if you have any concern or would like to discuss this further.	</p>

<p>Please do not hesitate to contact me if you have any concern or would like to discuss this further.</p>

<p>Yours sincerely</p><p>{{ $Roledata->f_name }} {{ $Roledata->l_name }}</p>
<p>{{ $Roledata->desig }}</p>
			</td></tr>
		</tr>
		
	<tr><td colspan="2"><input type="button" style="background: #2196f3;
    color: #fff;box-shadow: none;" value="Print this page" onClick="window.print()"></td></tr>
		</tr>
	</table>
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
</body>




</html>