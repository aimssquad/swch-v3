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
.mm {
    background-color: white;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact; ">

<table style="width:100%;font-family:cambria">
 <thead>
  <tr>
    <th style="text-align: left;width: 10%;">
        @if($Roledata->logo!='')  <img src="https://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" width="130"/>@endif 
        
      </th>
	<th style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $Roledata->com_name }}</h2>
	 <p style="margin:0;font-size:15px"> @if($Roledata->address!=''){{ $Roledata->address }}@if($Roledata->address2!='null'), {{ $Roledata->address2 }}@endif @if($Roledata->road!='null') ,{{ $Roledata->road }} @endif <br />{{ $Roledata->city }},{{ $Roledata->zip }},{{ $Roledata->country }}@endif</p>

	  <p style="margin:0;font-size:20px">Organisation  Report
</p>
	</th>
  </tr>
 </thead>
 
 
</table>

	 
<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #d27eff;">
  <tr>
    <th style="color:#000; text-align:center; padding-top:5px; padding-bottom:5px;"><b>Sl No.</b></th>

	 <th style="color:#000;text-align:center;"><b>Type</b></th>
	 <th style="color:#000; text-align:center;"><b>Particulars</b></th>
	 
  </tr>
 </thead>
<tbody>
    <tr>
    <td style="text-align:center;">1</td>
     <td>Organisation Name</td>
      <td>{{ $Roledata->com_name }} </td>
       </tr>
        <tr>
       <td style="text-align:center;">2</td>
     <td>Type of Organisation</td>
      <td>{{ $Roledata->com_type }} @if($Roledata->com_type=='others-type') {{ $Roledata->others_type }} @endif</td>
       </tr>
        <tr>
       <td style="text-align:center;">3</td>
     <td>Registration Number.</td>
      <td> @if($Roledata->com_reg!='null'){{ $Roledata->com_reg }}@endif  </td>
       </tr>
        <tr style="text-align:center;">
       <td>4</td>
       
     <td style="text-align:left;">Contact Number.</td>
      <td style="text-align:left;">{{ $Roledata->p_no }} </td>
       </tr>
        <tr>
        <td style="text-align:center;">5</td>
     <td>Organisation Email ID.</td>
      <td>{{ $Roledata->email }} </td>
       </tr>
        <tr style="text-align:center;">
       <td>6</td>
     <td style="text-align:left;">Website</td>
      <td> @if($Roledata->website!='null'){{ $Roledata->website }}@endif </td>
       </tr>
        <tr>
       <td style="text-align:center;">7</td>
     <td>Trading Name</td>
      <td>{{ $Roledata->trad_name }} </td>
       </tr>
        <tr>
       <td style="text-align:center;">8</td>
     <td>Trading Period</td>
      <td>{{ $Roledata->com_year }} </td>
       </tr>
        <tr style="text-align:center;">
      <td>9</td>
     <td style="text-align:left;">Name Of Sector</td>
      <td>{{ $Roledata->com_nat }} </td>
       </tr>
        <tr>
      <td style="text-align:center;">10</td>
     <td>Number of Settled Employee</td>
      <td>{{ $Roledata->no_em }} </td>
       </tr>
        <tr>
       <td style="text-align:center;">11</td>
     <td>Number of Non- Settled Employee</td>
      <td>{{ $Roledata->no_em_work }} </td>
       </tr>
        <tr>
        <td style="text-align:center;">12</td>
     <td>Total Number Of Employee</td>
      <td>{{ $Roledata->work_per }} </td>
       </tr>
        <tr>
       <td style="text-align:center;">13</td>
     <td>How Many Directors</td>
      <td>{{ $Roledata->no_dire }} </td>
       </tr>
        <tr>
        <td style="text-align:center;">14</td>
     <td>Logo</td>
     
      <td>
          @if($Roledata->logo!='')<img src="https://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" height="50px" width="50px"/>@endif </td>
           </tr>
            <tr>
       <td style="text-align:center;">15</td>
     <td>Authorised Person Name</td>
      <td>{{ $Roledata->f_name }} {{ $Roledata->l_name }} </td>
       </tr>
        <tr>
       <td style="text-align:center;">16</td>
     <td>Authorised Person Designation</td>
      <td>{{ $Roledata->desig }}  </td>
       </tr>
        <tr>
         <td style="text-align:center;">17</td>
     <td>Authorised Person Email</td>
      <td>{{ $Roledata->authemail }}  </td>
       </tr>
        <tr>
         <td style="text-align:center;">18</td>
     <td>Authorised Person Proof Of Id </td>
      <td>  @if($Roledata->proof!='') Uploaded @else Not Uploaded @endif  </td>
       </tr>
       <tr>
         <td style="text-align:center;">19</td>
     <td>Organisation Address</td>
      <td>@if($Roledata->address!=''){{ $Roledata->address }}@if($Roledata->address2!='null'), {{ $Roledata->address2 }}@endif @if($Roledata->road!='null') ,{{ $Roledata->road }} @endif {{ $Roledata->city }},{{ $Roledata->zip }},{{ $Roledata->country }}@endif  </td>
       </tr>
        <tr>
         <td style="text-align:center;">20</td>
     <td>Organisation  Bank Name</td>
      <td> @if($Roledata->bank_name!='null'){{ $Roledata->bank_name }}@endif  </td>
       </tr>
        <tr>
         <td style="text-align:center;">21</td>
     <td>Organisation  Account No</td>
      <td>@if($Roledata->acconut_name!='null'){{ $Roledata->acconut_name }}@endif  </td>
       </tr>
        <tr>
         <td style="text-align:center;">22</td>
     <td>Organisation  Sort Code</td>
      <td>@if($Roledata->sort_code!='null'){{ $Roledata->acconut_name }}@endif </td>
       </tr>
       
        <?php
         $leave_allocation_rs = DB::table('company_upload')
                      ->where('emid','=',$Roledata->reg)
                 ->get();
    	if($leave_allocation_rs)
		{$f=23;
			foreach($leave_allocation_rs as $leave_allocation)
			{
			    
?>
 @if($leave_allocation->docu_nat!='')
<tr>
         <td>{{ $f}}</td>
     <td>{{ $leave_allocation->type_doc }}   @if($leave_allocation->type_doc=='Others Document') {{ $leave_allocation->other_txt }} @endif </td>
      <td> @if($leave_allocation->docu_nat!='') Uploaded @else Not Uploaded @endif  </td>
       </tr>
	@endif
 <?php
  $f++;}
		}
		?>
</tbody>
</table>
</body>
</html>
