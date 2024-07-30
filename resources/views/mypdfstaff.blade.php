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
   @page {size: landscape}
}
tr:nth-child(even) {
    background-color: #d0e5ff;
}

</style>
</head>

<body style="webkit-print-color-adjust: exact; size: landscape;">


<table style="width:100%;font-family:cambria">
 <thead>
  <tr>
   <th style="text-align: "><img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="100"/></th>
		<th style=""><h2 style="font-size: 25px;    margin-bottom: 0;">{{ $com_name }}</h2>
	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	   <p style="margin:0;font-size:20px">Staff Report</p>
	</th>
  </tr>
 </thead>


</table>

<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
    <th  style="color:#fff ;font-size:14px;">Sl No.</th>
	<th    style="color:#fff ;font-size:14px;">Staff Code</th>
													<th   style="color:#fff ;font-size:14px;">Staff Name</th>
														<th   style="color:#fff ;font-size:14px;">Job Title</th>
													<th   style="color:#fff ;font-size:14px;">Address</th>

													<th   style="color:#fff ;font-size:14px;">DOB</th>
													<th   style="color:#fff ;font-size:14px;">Job Start Date</th>
													<th   style="color:#fff ;font-size:14px;">Telephone</th>
													<th   style="color:#fff ;font-size:14px;">Nationality</th>
													<th    style="color:#fff ;font-size:14px;">NI Number</th>
													<th   style="color:#fff ;font-size:14px;">Visa Expiry Date</th>
													<th   style="color:#fff ;font-size:14px;">Passport No.</th>
													<!-- <th   style="color:#fff ;font-size:14px;">Passport Expiry Date</th> -->
													<th   style="color:#fff ;font-size:14px;">EUSS Details</th>
													<th   style="color:#fff ;font-size:14px;">DBS Details</th>
													<th   style="color:#fff ;font-size:14px;">National Id Details</th>


  </tr>

 </thead>
<tbody>
    <?php $i = 0;foreach ($employee_rs as $employee) {

    $employefgf = DB::table('users')->where('emid', '=', $employee->emid)->where('employee_id', '=', $employee->emp_code)->first();
    if ($employefgf->status == 'active') {
      $i++;
      $colorme='';
      if(($employee->visa_doc_no != null && ($employee->visa_exp_date != null && $employee->visa_exp_date!='1970-01-01')) || ($employee->euss_ref_no != null && ($employee->euss_exp_date != null && $employee->euss_exp_date!='1970-01-01'))){
        $colorme='blue';
      }
      $pass_no = '';
      if ($employee->pass_exp_date != '1970-01-01') {
          if ($employee->pass_exp_date != 'null') {
              $pass_no = '  EXPIRE:' . date('jS F Y', strtotime($employee->pass_exp_date));
          }
      }

      $euss_exp = '';
      if ($employee->euss_exp_date != '1970-01-01') {
        if ($employee->euss_exp_date != 'null' && $employee->euss_exp_date != NULL) {
          $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->euss_exp_date));
        }
      }
      $dbs_exp = '';
      if ($employee->dbs_exp_date != '1970-01-01') {
        if ($employee->dbs_exp_date != 'null' && $employee->dbs_exp_date != NULL) {
          //dd($employee);
          $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->dbs_exp_date));
        }
      }
      $nid_exp = '';
      if ($employee->nat_exp_date != '1970-01-01') {
          if ($employee->nat_exp_date != 'null') {
              $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
          }
      }


    ?>
  <tr @if($colorme !='') style="color:{{$colorme}}" @endif>
    <td style="font-size:13px;"><?php echo $i; ?></td>
	<td style="font-size:13px;">{{ $employee->emp_code}}</td>
<td style="font-size:13px;">{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
 <td style="font-size:13px;">{{ $employee->emp_designation}}</td>
<td style="font-size:13px;">{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>

<td style="font-size:13px;">  @if( $employee->emp_dob!='1970-01-01' &&  $employee->emp_dob!=''  &&  $employee->emp_dob!='E11') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @elseif($employee->emp_code=='E11')   {{ date('d/m/Y',strtotime($employee->emp_dob)) }}  @endif
      </td>
<td style="font-size:13px;">  @if( $employee->emp_doj!='1970-01-01' &&  $employee->emp_doj!=''  &&  $employee->emp_doj!='E11') {{ date('d/m/Y',strtotime($employee->emp_doj)) }} @elseif($employee->emp_code=='E11')   {{ date('d/m/Y',strtotime($employee->emp_doj)) }}  @endif
      </td>
 <td style="font-size:13px;">{{ $employee->emp_ps_phone }}</td>
 <td style="font-size:13px;">{{ $employee->nationality }}</td>
 <td style="font-size:13px;">{{ $employee->ni_no }}</td>
 <td style="font-size:13px;">   @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('jS F Y',strtotime($employee->visa_exp_date)) }} @endif  @else NA  @endif</td>
 <td style="font-size:13px;">{{ $employee->pass_doc_no . $pass_no }}   </td>
     <!-- <td style="font-size:13px;">  @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='')  {{ date('jS F Y',strtotime($employee->pass_exp_date)) }} @endif @else NA  @endif     </td> -->

     <td style="font-size:13px;">{{ $employee->euss_ref_no . $euss_exp }}</td>
     <td style="font-size:13px;">{{ $employee->dbs_ref_no . $dbs_exp }}</td>
     <td style="font-size:13px;">{{ $employee->nat_id_no . $nid_exp }}</td>

  </tr>
   <?php }}?>

</tbody>
</table>
</body>
</html>