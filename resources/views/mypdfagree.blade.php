<?php $laeve_arr = array();
$laeve_srt = '';
$laeve_arr1 = array();
$laeve_srt1 = '';

if (count($LeaveAllocation) != 0) {
    foreach ($LeaveAllocation as $value) {
        $laeve_arr[] = $value->leave_in_hand . '  days  ' . strtolower($value->leave_type_name);
        $laeve_arr1[] = $value->max_no . '  days  ' . strtolower($value->leave_type_name);
    }

    $laeve_srt = implode(',', $laeve_arr);
    $laeve_srt1 = implode(',', $laeve_arr1);

} else {
    $laeve_srt = '';
    $laeve_srt1 = '';
}
$job_r = DB::table('company_job_list')

    ->where('title', '=', $emp_de->emp_designation)

    ->where('emid', '=', $Roledata->reg)
    ->orderBy('id', 'DESC')
    ->first();

if (!empty($emp_de->emp_payment_type)) {
    $emp_payment_type = DB::table('payment_type_master')

        ->where('id', '=', $emp_de->emp_payment_type)

        ->orderBy('id', 'DESC')
        ->first();
}
$perr = '';
if (!empty($emp_de->emp_payment_type)) {
    if (strpos($emp_payment_type->pay_type, 'Weekly') !== false) {
        $perr = 'Weekly';
    } else {
        $perr = $emp_payment_type->pay_type;
    }
}
$perwd = '';

if (!empty($emp_de->wedges_paymode)) {
    $emp_wedgpayment_type = DB::table('payment_type_wedes')

        ->where('id', '=', $emp_de->wedges_paymode)

        ->orderBy('id', 'DESC')
        ->first();
    $perwd = $emp_wedgpayment_type->pay_type;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SWCH</title>
</head>


  <body>
  <table width="100%" style="text-align: left;">
    <tbody>
      <tr>

        <th style="text-align: left;"> @if($com_logo!='')<img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}"  alt="" width="100"> @endif</th>

      </tr>
      <tr><th><h2 style="margin: 0;text-align: left;">{{ $com_name }}</h2></th></tr>

      <tr><th><h1 style="text-align:left;"><span style="border-bottom: 1px solid">Contract of Employment</span></h1></th></tr>


      <tr>
        <td><p style="margin: 0;font-weight:600;">Between the Employer, {{ $com_name }}</p>
          <p style="margin: 0;font-weight:600;">{{ $Roledata->address}} @if( $Roledata->address2) ,{{ $Roledata->address2}} @endif @if( $Roledata->road) ,{{ $Roledata->road}} @endif @if( $Roledata->city) ,{{ $Roledata->city}} @endif @if( $Roledata->zip) ,{{ $Roledata->zip}} @endif @if( $Roledata->country) ,{{ $Roledata->country}} @endif</p>
          <p style="margin: 0;font-weight:600;">and the Employee, {{ $em_name }}</p>
          <p style="margin: 0;font-weight:600;">{{ $emp_de->emp_pr_street_no}} @if( $emp_de->emp_per_village) ,{{ $emp_de->emp_per_village}} @endif @if( $emp_de->emp_pr_state) ,{{ $emp_de->emp_pr_state}} @endif @if( $emp_de->emp_pr_city) ,{{ $emp_de->emp_pr_city}} @endif
  @if( $emp_de->emp_pr_pincode) ,{{ $emp_de->emp_pr_pincode}} @endif  @if( $emp_de->emp_pr_country) ,{{ $emp_de->emp_pr_country}} @endif</p>
        </td>
      </tr>
      <tr><td><h3 style="font-weight: 600">Start of Employment and Duration of Contract</h3>
        <p>The employment will start on  @if( $emp_de->start_date!='1970-01-01') @if( $emp_de->start_date!='') {{ date('d/m/Y',strtotime($emp_de->start_date)) }} @endif  @endif and the Initial duration of work is a 3 year period. This contract may be
		extended in future subject to your performance and subject to
		immigration control if it is required for your visa condition.</p></td></tr>
<!--<tr><td>-->
<!--        <h3 style="font-weight: 600;">Probationary Period</h3>-->
<!--        <p>The employment is subject to the completion of a 3months probationary period.</p>-->

<!--<p>If, at the end of the probationary period, the Employee's performance is considered to be of a satisfactory standard, the appointment will be made permanent.</p>-->

<!--<p>During the probationary period, one-week's notice may be given by either party to terminate this contract.</p>-->
<!--<p>In lieu of notice during the probationary period, the Employer may pay the Employee the salary that he would have earned till the end of probationary period.</p></td>-->
<!--      </tr>-->
      <tr><td>

<h3 style="font-weight: 600;">Job Description</h3>
<p>The Employee is engaged initially to perform the duties of {{  $emp_de->emp_designation }}</p>
@if(!empty($job_r))
 {!! $job_r->des_job !!}

@endif
<p>The Employee will, however, be expected to carry out any other reasonable duties in line with his responsibilities to assist in the smooth operation of the business.</p>
</td>
      </tr>
      <!-- <tr><td>
<h3 style="font-weight: 600;">Medical Fitness</h3>
<p>It is a condition of the employment that the Employer is satisfied on the Employee's medical fitness to carry out duties.</p>

<p>This appointment is conditional on a satisfactory Occupational Health Service/Employer's Doctor assessment.</p>

<p>Should it be deemed necessary during the employment, the Employee may be required to attend for a medical examination from the Employer's Doctor/Occupational Health Service.</p>
</td>
      </tr> -->
      <tr><td>
<h3 style="font-weight: 600;">Qualifications</h3>
<p>If the Employee's employment with the Employer is dependent upon the possession of particular qualifications or registration with a statutory Body or other Authority, then evidence of this must be produced on request.</p>

<p>Failure to produce such evidence may lead to the termination of the employment.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Place of Work</h3>
<p>The normal place of work will be at the Employer's address shown above.</p>

<p>Following reasonable notice and consultation, however, the Employee would be expected to work at any other premises if required.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Working Hours</h3>
<p>The working hours are @if(!empty($emp_de->emp_payment_type))   {{ $emp_de->min_work}} @endif  per week.</p>

<p>The Employer may require the Employee to vary the pattern of his working hours to meet the needs of the service.</p>

<p>The Employee's entitlement to have paid refreshment breaks.</p>
<p><b>Remuneration</b></p>
<p>You are entitled to be paid GBP  @if(!empty($emp_de->emp_payment_type))   {{ $emp_de->min_rate}} @endif  @if(!empty($emp_de->emp_payment_type)) per {{ $perr}} @endif. Your salary will be paid @if(!empty($emp_de->wedges_paymode))  {{ $perwd}} @endif by    @if(!empty($emp_de->emp_pay_type) && $emp_de->emp_pay_type=='Bank')
                       BACS @elseif($emp_de->emp_pay_type=='Cash') cash @else
                        BACS @endif .</p>

<p>Your rate of pay will be reviewed in every six months. Your rate of pay will not necessarily increase as a result of the review.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Overtime payments</h3>
<p>Additional payments will be made for overtime worked as per company policy.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Holidays</h3>
<p>The Management's holiday year runs from 1st January to 31st December inclusive. If you work part time your pro-rata entitlement will be based on the number of hours you work. If you work as a full time employee you will be entitled to have 28 days paid holiday in each year, in addition to statutory holidays.You are allowed to take an unpaid holiday subject to special circumstances, but it must be prior approved by the management.</p>

<p>You must obtain authorization from the Management before making any holiday arrangements. The date
of holidays must be agreed with the Employer and a Holiday Request must be completed and authorized by the Employer at least 14 days prior to your proposed holiday dates. <b>Any unauthorized absence for more than 10 days will be notified to the Home Office UKVI if it is required for your visa condition.</b>
Furthermore, disciplinary action may be taken against you. You must inform the management immediately if there is any change of circumstance,such as change of contact details, change of your immigration status etc.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Sickness</h3>
<p>Subject to you complying with the above notification and certification requirements, plus any additional rules introduced from time to time, you will, if eligible, be paid Statutory Sick Pay in accordance with the legislation applying from time to time.</p>

<p>For the purpose of Statutory Sick Pay, your qualifying days are Monday to Friday.</p>

<p>The Employer does not operate a sick pay scheme other than Statutory Sick Pay.</p>
</td>
      </tr>
      <tr><td>

<h3 style="font-weight: 600;">Pension Scheme</h3>
<p>
The Company will comply with its employer pension duties in accordance with relevant legislation (if applicable). Details in this respect will be furnished to you separately.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Notice of Termination</h3>
<p>Where there is just cause for termination, the Employer may terminate the Employee's employment without notice, as permitted by law.</p>

<p>The Employee and the Employer agree that reasonable and sufficient notice of termination of employment by the Employer is the greater of four (4) weeks or any minimum notice required by law..</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Redundancy</h3>
<p>If the Employer decides to reduce manning levels, suitable volunteers will be asked for.</p>

<p>In addition, the Employer may select other employees for redundancy on the basis of an assessment of relative capabilities, performance, service length, conduct, reliability, attendance record and suitability for the remaining work.</p>

<p>In the event of redundancy, statutory redundancy terms will apply.</p>

</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Rules of Conduct</h3>
<p>The Employee must:</p>
<ul>
<li>not endanger the health or safety of any employee whilst at work;;</li>
<li>at all times use as instructed any protective clothing or equipment which has been issued;</li>
<li>immediately report accidents, no matter how slight;</li>
<li>observe all rules concerning smoking and fire hazards;</li>
<li>act wholeheartedly in the interests of the Employer at all times;</li>
<li>acquaint (himself/herself) with all authorised notices displayed at his place of work;</li>
<li>inform the Employer if he contracts a contagious illness;</li>
<li>not remove any material or equipment from his place of work without prior permission;</li>
<li>not use the Employer's time, material or equipment for unauthorised work;</li>
<li>at all times follow Employer's working and operation procedures.</li>

</ul>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Misconduct Leading to Summary Dismissal Without Notice</h3>
<ul>
<li>theft of the Employer's property;</li>
<li>fighting, physical assault or dangerous horseplay;</li>
<li>failure to carry out a direct instruction from a superior during working hours;</li>
<li>use of bad language or aggressive behavior on the Employer's premises or in front of customers;</li>
<li>wilful and/or deliberate damage of the Employer's property;</li>
<li>incapability through alcohol or illegal drugs;</li>
<li>loss of driving licence where driving is an essential part of the job;</li>
<li>endangering the health or safety of another person at the place of work;</li>
<li>deliberately falsifying the Employer's records;</li>
<li>receiving bribes to affect the placing of business with a supplier of goods or services;</li>
<li>falsely claiming to be sick in order to defraud the Employer;</li>
<li>immoral conduct.</li>
</ul>
</td>
      </tr>
      <tr><td>


<h3 style="font-weight: 600;">Disciplinary Action</h3>
<p>Should the need for disciplinary action be deemed necessary, this will be taken in accordance with the Employer's Policy and Procedure on Disciplinary Action.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Grievances</h3>
<p>Where the Employee has a grievance relating to any aspect of their employment,they should contact their immediate manager and give full details of his grievance, in confidence.</p>

<p>The Employee should allow reasonable time for consideration of all the facts before remedial action can be taken.</p>
</td>
      </tr>
      <tr><td>
<p>Where the Employee's immediate manager is not able satisfactorily to resolve the grievance, the Employee should refer the matter in writing to the most senior manager available.</p>

<p>The Employee has the right to be accompanied by a work colleague or by another person as in accordance with the current legislation throughout the grievance procedure.</p>


<p style="font-weight: 600;">If you agree with the above terms and conditions please sign both copies of this Contract, retain one and return the other to me.</p>

      </td>
    </tr>
<tr>
  <td>
    <p style="font-weight: 600;">Signed ______________________________<br>for {{ $com_name }}, <span style="float:right;">Date:   _______________</span></p>
<br>
    <p style="font-weight: 600;">Signed ______________________________<br>for  {{ $em_name }}, <span style="float:right;">Date:  _______________</span></p>
  </td>
</tr>
    </tbody>
  </table>





  </body>
</html>
