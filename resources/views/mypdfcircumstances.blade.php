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


<table style="width:98%;font-family:cambria">
 <thead>
  <tr>
   <th style="text-align: "><img src="https://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="100"/></th>
		<th style=""><h2 style="font-size: 25px;    margin-bottom: 0;">{{ $com_name }}</h2>
	 <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	   <p style="margin:0;font-size:20px">Change Of Circumstances Report</p>
	</th>
  </tr>
 </thead>


</table>

<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #1572e8;">
  <tr>
      	<th   style="color:#fff ;font-size:11px;">Sl No</th>
      	<th   style="color:#fff ;font-size:11px;">Updated Date</th>
    <th  style="color:#fff ;font-size:11px;">Employment Type</th>
	<th    style="color:#fff ;font-size:11px;">Employee ID</th>
													<th   style="color:#fff ;font-size:11px;">Employee Name</th>

														<th   style="color:#fff ;font-size:11px;">Job Title</th>
													<th   style="color:#fff ;font-size:11px;">Address</th>


													<th   style="color:#fff ;font-size:11px;">Contact Number</th>


														<th   style="color:#fff ;font-size:11px;">BRP  Number</th>
													<th   style="color:#fff ;font-size:11px;">Visa Expiry</th>
														<th    style="color:#fff ;font-size:11px;">Remarks/Restriction to work</th>
													<th   style="color:#fff ;font-size:11px;">Passport No.</th>
													<th style="color:#fff ;font-size:11px;">EUSS Details</th>
													<th style="color:#fff ;font-size:11px;">DBS Details</th>
													<th style="color:#fff ;font-size:11px;">National Id Details</th>
													<th style="color:#fff ;font-size:11px;">Other Documents</th>

															<th  style="color:#fff ;font-size:11px;">Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details? </th>
															<th  style="color:#fff ;font-size:11px;">Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?</th>

											<th  style="color:#fff ;font-size:11px;">Annual  Reminder Date</th>

  </tr>

 </thead>
<tbody>
    <?php

$f = 2;
$nn = '';
$doj = '';
$anual_date = '';
$dojg = '';

$employeet = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $emid)->first();

$date1 = date('Y', strtotime($employeet->emp_doj)) . date('m-d');

$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365 * 60 * 60 * 24));
date('Y', strtotime($date1));
$endtyear = date('Y', strtotime($date1)) + ($years);

$employeetnew = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $emid)->first();
$employeetcircumnew = DB::table('change_circumstances_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $emid)->orderBy('id', 'DESC')->first();

$employeetemployeeother = DB::table('circumemployee_other_doc_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $emid)->orderBy('id', 'DESC')->get();

$dataeotherdoc = '';

if (count($employeetemployeeother) != 0) {

    foreach ($employeetemployeeother as $valother) {
        if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
            $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
        } else {
            $other_exp_date = '';
        }} else {
            $other_exp_date = '';
        }
        $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
    }

}
if (!empty($employeetcircumnew)) {

    $anual_datenew = date('Y-m-d', strtotime($employeetcircumnew->date_change . '  + 1 year'));
    $peradd = '';
    $peradd = $employeetcircumnew->emp_pr_street_no;
    if ($employeetcircumnew->emp_per_village) {$peradd .= ',' . $employeetcircumnew->emp_per_village;}
    if ($employeetcircumnew->emp_pr_state) {$peradd .= ',' . $employeetcircumnew->emp_pr_state
        ;}if ($employeetcircumnew->emp_pr_city) {$peradd .= ',' . $employeetcircumnew->emp_pr_city;}
    if ($employeetcircumnew->emp_pr_pincode) {$peradd .= ',' . $employeetcircumnew->emp_pr_pincode;}
    if ($employeetcircumnew->emp_pr_country) {$peradd .= ',' . $employeetcircumnew->emp_pr_country;}
    ;

    if ($employeetcircumnew->visa_exp_date != '1970-01-01') {if ($employeetcircumnew->visa_exp_date != '') {
        $visa_exp_date = date('jS F Y', strtotime($employeetcircumnew->visa_exp_date));
    } else {
        $visa_exp_date = '';
    }} else {
        $visa_exp_date = '';
    }
    if ($employeetcircumnew->pass_exp_date != '1970-01-01') {if ($employeetcircumnew->pass_exp_date != '') {
        $stfol = 'EXPIRE:  ' . date('jS F Y', strtotime($employeetcircumnew->pass_exp_date));
    } else {
        $stfol = '';
    }} else {
        $stfol = '';

    }

	$euss_exp = '';
	if ($employeetcircumnew->euss_exp_date != '1970-01-01') {
		if ($employeetcircumnew->euss_exp_date != 'null' && $employeetcircumnew->euss_exp_date != NULL) {
			$euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->euss_exp_date));
		}
	}
    $euss_exp = $employeetcircumnew->euss_ref_no . $euss_exp;

	$dbs_exp = '';
	if ($employeetcircumnew->dbs_exp_date != '1970-01-01') {
		if ($employeetcircumnew->dbs_exp_date != 'null' && $employeetcircumnew->dbs_exp_date != NULL) {
			$dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->dbs_exp_date));
		}
	}
    $dbs_exp = $employeetcircumnew->dbs_ref_no . $dbs_exp;

	$nid_exp = '';
	if ($employeetcircumnew->nat_exp_date != '1970-01-01') {
		if ($employeetcircumnew->nat_exp_date != 'null' && $employeetcircumnew->nat_exp_date != NULL) {
			$nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->nat_exp_date));
		}
	}
    $nid_exp = $employeetcircumnew->nat_id_no . $nid_exp;


    $desinf = $employeetcircumnew->emp_designation;
    $newph = $employeetcircumnew->emp_ps_phone;
    $newpnati = $employeetcircumnew->nationality;
    $newpnavia = $employeetcircumnew->visa_doc_no;
    $newpnapasas = $employeetcircumnew->pass_doc_no;
    $date_doj = date('d/m/Y', strtotime($employeetcircumnew->date_change));
} else {

    $anual_datenew = date('Y-m-d', strtotime($employeet->emp_doj . '  + 1 year'));
    $peradd = '';
    $peradd = $employeetnew->emp_pr_street_no;
    if ($employeetnew->emp_per_village) {$peradd .= ',' . $employeetnew->emp_per_village;}
    if ($employeetnew->emp_pr_state) {$peradd .= ',' . $employeetnew->emp_pr_state
        ;}if ($employeetnew->emp_pr_city) {$peradd .= ',' . $employeetnew->emp_pr_city;}
    if ($employeetnew->emp_pr_pincode) {$peradd .= ',' . $employeetnew->emp_pr_pincode;}
    if ($employeetnew->emp_pr_country) {$peradd .= ',' . $employeetnew->emp_pr_country;}
    ;

    if ($employeetnew->visa_exp_date != '1970-01-01') {if ($employeetnew->visa_exp_date != '') {
        $visa_exp_date = ' ' . date('jS F Y', strtotime($employeetnew->visa_exp_date));
    } else {
        $visa_exp_date = ' NA';
    }} else {
        $visa_exp_date = 'NA';
    }
    if ($employeetnew->pass_exp_date != '1970-01-01') {if ($employeetnew->pass_exp_date != '') {
        $stfol = 'EXPIRE:  ' . date('jS F Y', strtotime($employeetnew->pass_exp_date));
    } else {
        $stfol = ' NA';
    }} else {
        $stfol = ' NA';
    }

	$euss_exp = '';
	if ($employeetnew->euss_exp_date != '1970-01-01') {
		if ($employeetnew->euss_exp_date != 'null' && $employeetnew->euss_exp_date != NULL) {
			$euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->euss_exp_date));
		}
	}
    $euss_exp = $employeetnew->euss_ref_no . $euss_exp;

	$dbs_exp = '';
	if ($employeetnew->dbs_exp_date != '1970-01-01') {
		if ($employeetnew->dbs_exp_date != 'null' && $employeetnew->dbs_exp_date != NULL) {
			$dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->dbs_exp_date));
		}
	}
    $dbs_exp = $employeetnew->dbs_ref_no . $dbs_exp;

	$nid_exp = '';
	if ($employeetnew->nat_exp_date != '1970-01-01') {
		if ($employeetnew->nat_exp_date != 'null' && $employeetnew->nat_exp_date != NULL) {
			$nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->nat_exp_date));
		}
	}
    $nid_exp = $employeetnew->nat_id_no . $nid_exp;


    $desinf = $employeetnew->emp_designation;
    $newph = $employeetnew->emp_ps_phone;
    $newpnati = $employeetnew->nationality;
    $newpnavia = $employeetnew->visa_doc_no;
    $newpnapasas = $employeetnew->pass_doc_no;
    $date_doj = date('d/m/Y', strtotime($employeet->emp_doj));
}

$emp_name_history = $employeetnew->emp_fname;
if (isset($employeetcircumnew->emp_mname) && $employeetcircumnew->emp_mname!=null && $employeetcircumnew->emp_mname != '') {
    $emp_name_history = $emp_name_history . ' ' . $employeetcircumnew->emp_mname;
} else {
    $emp_name_history = $emp_name_history . ' ' . $employeetnew->emp_mname;
}
if (isset($employeetcircumnew->emp_lname) && $employeetcircumnew->emp_lname!=null && $employeetcircumnew->emp_lname != '') {
    $emp_name_history = $emp_name_history . ' ' . $employeetcircumnew->emp_lname;
} else {
    $emp_name_history = $emp_name_history . ' ' . $employeetnew->emp_lname;
}

?>

         <tr>
       <td style="font-size:10px;">1</td>
      <td style="font-size:10px;">{{$date_doj}}</td>
    <td style="font-size:10px;"><?php echo $employee_type; ?></td>
	<td style="font-size:10px;">{{ $employeetnew->emp_code}}</td>
<td style="font-size:10px;">{{ $emp_name_history }}</td>

 <td style="font-size:10px;">{{ $desinf}}</td>

<td style="font-size:10px;">{{ $peradd}}</td>


 <td style="font-size:10px;">{{ $newph }}</td>

 <td style="font-size:10px;">{{ $newpnavia }}</td>
 <td style="font-size:10px;">   {{$visa_exp_date}}</td>
  <td style="font-size:10px;">Not Applicable</td>
 <td style="font-size:10px;">{{ $newpnapasas }}  @if( $stfol!='NA') {{$stfol}}  @endif     </td>
 <td style="font-size:10px;"> {{$euss_exp}}</td>
 <td style="font-size:10px;"> {{$dbs_exp}}</td>
 <td style="font-size:10px;"> {{$nid_exp}}</td>
 <td style="font-size:10px;"> {{$dataeotherdoc	}}</td>
         <td style="font-size:10px;"></td>
          <td style="font-size:10px;"></td>
             <td style="font-size:10px;">{{date('d/m/Y',strtotime($anual_datenew))}}</td>

  </tr>


		<?php	for ($m = date('Y', strtotime($employeet->emp_doj)); $m <= $endtyear; $m++) {

    $strartye = date($m . '-01-01');
    $endtye = date($m . '-12-31');

    $leave_allocation_rsdg = DB::table('change_circumstances')
        ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')
        ->where('change_circumstances.emp_code', '=', $employeet->emp_code)
        ->where('change_circumstances.emid', '=', $employeet->emid)
        ->where('employee.emp_code', '=', $employeet->emp_code)
        ->where('employee.emid', '=', $employeet->emid)
        ->where('employee.emp_status', '=', $employeet->emp_status)
        ->whereBetween('date_change', [$strartye, $endtye])
        ->orderBy('date_change', 'ASC')
        ->select('change_circumstances.*')
        ->get();

    if (count($leave_allocation_rsdg) != 0) {

        foreach ($leave_allocation_rsdg as $leave_allocation) {

            $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $leave_allocation->emid)->first();

            $dojg = date('m-d', strtotime($employeet->emp_doj));

            $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));

            $euss_exp = '';
            if ($leave_allocation->euss_exp_date != '1970-01-01') {
                if ($leave_allocation->euss_exp_date != 'null' && $leave_allocation->euss_exp_date != NULL) {
                    $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->euss_exp_date));
                }
            }
            $euss_exp = $leave_allocation->euss_ref_no . $euss_exp;
        
            $dbs_exp = '';
            if ($leave_allocation->dbs_exp_date != '1970-01-01') {
                if ($leave_allocation->dbs_exp_date != 'null' && $leave_allocation->dbs_exp_date != NULL) {
                    $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->dbs_exp_date));
                }
            }
            $dbs_exp = $leave_allocation->dbs_ref_no . $dbs_exp;
        
            $nid_exp = '';
            if ($leave_allocation->nat_exp_date != '1970-01-01') {
                if ($leave_allocation->nat_exp_date != 'null' && $leave_allocation->nat_exp_date != NULL) {
                    $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->nat_exp_date));
                }
            }
            $nid_exp = $leave_allocation->nat_id_no . $nid_exp;
        

            $employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $leave_allocation->emid)
                ->where('cir_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->get();


            $dataeotherdoc = '';

            if (count($employeetemployeeother) != 0) {

                foreach ($employeetemployeeother as $valother) {
                    if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
                        $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
                    } else {
                        $other_exp_date = '';
                    }} else {
                        $other_exp_date = '';
                    }
                    $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
                }

            }

            $emp_name_coc = $employeet->emp_fname;
            if ($leave_allocation->emp_mname != '') {
                $emp_name_coc = $emp_name_coc . ' ' . $leave_allocation->emp_mname;
            } else {
                $emp_name_coc = $emp_name_coc . ' ' . $employeet->emp_mname;
            }

            if ($leave_allocation->emp_lname != '') {
                $emp_name_coc = $emp_name_coc . ' ' . $leave_allocation->emp_lname;
            } else {
                $emp_name_coc = $emp_name_coc . ' ' . $employeet->emp_lname;
            }
            ?>
        <tr>
       <td style="font-size:10px;">{{  $f }}</td>
      <td style="font-size:10px;">{{date('d/m/Y',strtotime($leave_allocation->date_change))}}</td>
    <td style="font-size:10px;"><?php echo $employee_type; ?></td>
	<td style="font-size:10px;">{{ $leave_allocation->emp_code}}</td>
<td style="font-size:10px;">{{ $emp_name_coc }}</td>

 <td style="font-size:10px;">{{ $leave_allocation->emp_designation}}</td>

<td style="font-size:10px;">{{ $leave_allocation->emp_pr_street_no}} @if( $leave_allocation->emp_per_village) ,{{ $leave_allocation->emp_per_village}} @endif @if( $leave_allocation->emp_pr_state) ,{{ $leave_allocation->emp_pr_state}} @endif @if( $leave_allocation->emp_pr_city) ,{{ $leave_allocation->emp_pr_city}} @endif
  @if( $leave_allocation->emp_pr_pincode) ,{{ $leave_allocation->emp_pr_pincode}} @endif  @if( $leave_allocation->emp_pr_country) ,{{ $leave_allocation->emp_pr_country}} @endif</td>


 <td style="font-size:10px;">{{ $leave_allocation->emp_ps_phone }}</td>

 <td style="font-size:10px;">{{ $leave_allocation->visa_doc_no }}</td>
 <td style="font-size:10px;">   @if( $leave_allocation->visa_exp_date!='1970-01-01') @if( $leave_allocation->visa_exp_date!='') {{ date('jS F Y',strtotime($leave_allocation->visa_exp_date)) }} @else NA @endif  @else NA  @endif</td>
  <td style="font-size:10px;">{{ $leave_allocation->res_remark }}</td>
 <td style="font-size:10px;">{{ $leave_allocation->pass_doc_no }}  @if( $leave_allocation->pass_exp_date!='1970-01-01') @if( $leave_allocation->pass_exp_date!='') EXPIRE: {{ date('jS F Y',strtotime($leave_allocation->pass_exp_date)) }} @endif  @endif     </td>

<td style="font-size:10px;"> {{$euss_exp}}</td>
<td style="font-size:10px;"> {{$dbs_exp	}}</td>
<td style="font-size:10px;"> {{$nid_exp	}}</td>
<td style="font-size:10px;"> {{$dataeotherdoc	}}</td>
   <td style="font-size:10px;">{{ $leave_allocation->hr }}</td>
          <td style="font-size:10px;">{{ $leave_allocation->home }}</td>
             <td style="font-size:10px;">{{date('d/m/Y',strtotime($anual_date))}}</td>

  </tr>
      <?php
$f++;}
    } else {

        $dojg = date('m-d', strtotime($employeet->emp_doj));
        $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));
        if (date('Y', strtotime($employeet->emp_doj)) != $m) {
            ?><tr>
				<td style="font-size:10px;">{{$f}}</td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>

													<td style="font-size:10px;"></td>
														<td style="font-size:10px;"></td>

														<td style="font-size:10px;"></td>

															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>

															<td style="font-size:10px;">@if($endtyear!=$m) no change @endif</td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;">{{ date('d/m/Y',strtotime($anual_date)) }}</td>


						</tr>
                <?php

            $f++;}
    }
}

for ($o = ($endtyear + 1); $o <= ($endtyear + 4); $o++) {
    $dojg = date('m-d', strtotime($employeet->emp_doj));
    $anual_date = date('Y-m-d', strtotime($o . '-' . $dojg . '  + 1 year'));

    ?><tr>
				<td style="font-size:10px;">{{$f}}</td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>
													<td style="font-size:10px;"></td>

													<td style="font-size:10px;"></td>
														<td style="font-size:10px;"></td>

														<td style="font-size:10px;"></td>

															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
																<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;"></td>
															<td style="font-size:10px;">{{ date('d/m/Y',strtotime($anual_date)) }}</td>


						</tr>
                <?php

    $f++;

}

?>



</tbody>
</table>
</body>
</html>