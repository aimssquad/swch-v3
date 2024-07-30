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
.even_class tr:nth-child(even) {
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
         <th width="130px;">
             <div style="border:2px solid #d897f0; margin-top:20px; width:130px;">
        @if($Roledata->logo!='null')  <img src="https://skilledworkerscloud.co.uk/img/swch_logo.png" alt="" width="130"/>@endif 
        </div>
         </th>
          <th style="text-align:right;">
          <p style="margin:0;font-size:15px"> @if($Roledata->address!='null'){{ $Roledata->address }}@if($Roledata->address2!='null'), {{ $Roledata->address2 }}@endif,{{ $Roledata->road }}<br />{{ $Roledata->city }},{{ $Roledata->zip }},{{ $Roledata->country }}@endif</p>

	  <p style="margin:0;font-size:20px">Employee  Report
</p>
      </th>
     </tr>
  <tr style="background-color:none;">
	 <th colspan="2" style="width:90%"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $Roledata->com_name }}</h2>
	</th>
  </tr>
 </thead>
 
 
</table>

<table style="width:100%;margin-top: 20px;">
    <tr style="background-color: #fff;">
    <td>
          @if($employeedata->emp_image!='')<img src="https://workpermitcloud.co.uk/hrms/public/{{ $employeedata->emp_image }}" style="height:100px;width:100px;border-radius:50%;"/>
          @else
          <img src="https://workpermitcloud.co.uk/hrms/public/assets/img/user.png" style="height:80px;width:80px;border-radius:50%;"/> 
          @endif</td>
          <td style="line-height:22px;">
              Employee Name: {{  $employeedata->emp_fname}} {{  $employeedata->emp_mname}} {{  $employeedata->emp_lname}}	
              <br/>
              Employee Code:{{ $employeedata->emp_code }}
              <br/>
              Department:{{  $employeedata->emp_department}}
              <br/>
              Designation: {{  $employeedata->emp_designation}}	
          </td>
</tr>
</table>
	 
<table class="even_class" border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #D00EFF;">
  <tr>
    <th style="color:#fff; text-align:center; padding-top:5px; padding-bottom:5px;">Sl No.</th>

	 <th style="color:#fff; padding-bottom:5px;">Type</th>
	 <th style="color:#fff; padding-bottom:5px;">Particulars</th>
	 
  </tr>
 </thead>
<tbody>
    <tr>
         <td tyle="text-align:center!important;">1</td>
     <td>Employee Code</td>
      <td>@if($employeedata->emp_code!='null'){{ $employeedata->emp_code }}@endif 
      </td>
       </tr> 
       
        <tr>
         <td tyle="text-align:center;">2</td>
     <td>Employee Name</td>
      <td>@if($employeedata->emp_fname!='null'){{  $employeedata->emp_fname}} {{  $employeedata->emp_mname}} {{  $employeedata->emp_lname}}@endif 
      </td>
       </tr> 
        <tr>
         <td tyle="text-align:center;">3</td>
     <td>Gender</td>
      <td>@if($employeedata->emp_gender!='null'){{  $employeedata->emp_gender}} @endif 
      </td>
       </tr>
       
       
        <tr>
         <td tyle="text-align:center;">4</td>
     <td>NI Number</td>
      <td>@if($employeedata->ni_no!='null'){{  $employeedata->ni_no}} @endif 
      </td>
       </tr> 
       <tr>
         <td tyle="text-align:center;">5</td>
     <td>Date of Birth</td>
      <td> @if( $employeedata->emp_dob!='1970-01-01' &&  $employeedata->emp_dob!=''  &&  $employeedata->emp_dob!='E11') {{ date('d/m/Y',strtotime($employeedata->emp_dob)) }} @elseif($employeedata->emp_code=='E11')   {{ date('d/m/Y',strtotime($employeedata->emp_dob)) }}  @endif
      </td>
       </tr> 
       
       
        <tr>
         <td tyle="text-align:center;">6</td>
     <td>Marital Status</td>
      <td>@if($employeedata->marital_status!='null'){{  $employeedata->marital_status}} @endif 
      </td>
       </tr>
        <tr>
         <td tyle="text-align:center;">7</td>
     <td>Nationality</td>
      <td>@if($employeedata->nationality!='null'){{  $employeedata->nationality}} @endif 
      </td>
       </tr>
       <tr>
         <td tyle="text-align:center;">8</td>
     <td>Email</td>
      <td>@if($employeedata->emp_ps_email!='null'){{  $employeedata->emp_ps_email}} @endif 
      </td>
       </tr> 
        <tr>
         <td tyle="text-align:center;">9</td>
     <td>Contact Number</td>
      <td>@if($employeedata->emp_ps_phone!='null'){{  $employeedata->emp_ps_phone}} @endif 
      </td>
       </tr> 
        <tr>
         <td tyle="text-align:center;">10</td>
     <td>Alternative Number</td>
      <td>@if($employeedata->em_contact!='null'){{  $employeedata->em_contact}} @endif 
      </td>
       </tr> 
        <tr>
         <td tyle="text-align:center;">11</td>
     <td>Department</td>
      <td>@if($employeedata->emp_department!='null'){{  $employeedata->emp_department}} @endif 
      </td>
       </tr> 
       <tr>
         <td tyle="text-align:center;">12</td>
     <td>Designation</td>
     <td>@if($employeedata->emp_designation!='null'){{  $employeedata->emp_designation}} @endif 
      </td>
     
       </tr> 
       <tr>
         <td tyle="text-align:center;">13</td>
     <td>Date of Joining</td>
       <td>@if($employeedata->emp_doj!='1970-01-01' && $employeedata->emp_doj!='' ){{  date('d/m/Y',strtotime($employeedata->emp_doj))}} @endif 
      </td>
       </tr> 
       <tr>
         <td tyle="text-align:center;">14</td>
     <td>Employment  Type </td>
      <td>@if($employeedata->emp_status!='null'){{  $employeedata->emp_status}} @endif 
      </td>
       </tr> 
       <tr>
         <td tyle="text-align:center;">15</td>
     <td>Date of Confirmation </td>
        <td>@if($employeedata->date_confirm!='1970-01-01' && $employeedata->date_confirm!='' ){{  date('d/m/Y',strtotime($employeedata->date_confirm))}} @endif 
      </td>
       </tr> 
        <tr>
       <td>16</td>
     <td>Contract Start Date </td>
        <td>@if($employeedata->start_date!='1970-01-01'  && $employeedata->start_date!=''){{  date('d/m/Y',strtotime($employeedata->start_date))}} @endif 
      </td>
       </tr> 
        <tr>
       <td tyle="text-align:center;">17</td>
     <td>Contract End Date </td>
        <td>@if($employeedata->end_date!='1970-01-01'  && $employeedata->end_date!='' ){{  date('d/m/Y',strtotime($employeedata->end_date))}} @endif 
      </td>
       </tr> 
       <tr>
         <td tyle="text-align:center;">18</td>
     <td>Job Location </td>
      <td>@if($employeedata->job_loc!='null'){{  $employeedata->job_loc}} @endif 
      </td>
       </tr>
       
      
       
        <?php
         $leave_allocation_rs = DB::table('employee_qualification')
                      ->where('emid','=',$Roledata->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
             $f=19;    
    	if($leave_allocation_rs)
		{
			foreach($leave_allocation_rs as $leave_allocation)
			{
?>
<tr>
         <td>{{ $f}}</td>
     <td>Qualification </td>
     <td>@if($leave_allocation->quli!='null'){{  $leave_allocation->quli}} @endif </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Subject </td>
     <td>@if($leave_allocation->dis!='null'){{  $leave_allocation->dis}} @endif </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Institution Name </td>
     <td>@if($leave_allocation->ins_nmae!='null'){{  $leave_allocation->ins_nmae}} @endif </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Awarding Body/ University </td>
     <td>@if($leave_allocation->board!='null'){{  $leave_allocation->board}} @endif </td>
      
       </tr>
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Year of Passing </td>
     <td>@if($leave_allocation->year_passing!='null'){{  $leave_allocation->year_passing}} @endif </td>
      
       </tr>
         <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Percentage </td>
     <td>@if($leave_allocation->perce!='null'){{  $leave_allocation->perce}} @endif </td>
      
       </tr>
         <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Grade/Division </td>
     <td>@if($leave_allocation->grade!='null'){{  $leave_allocation->grade}} @endif </td>
      
       </tr>
         <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Transcript Document</td>
     <td>@if($leave_allocation->doc!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
         <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Certificate Document</td>
     <td>@if($leave_allocation->doc2!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
        <?php $f++;?>

 <?php
  }
		}
		?>
		
		
		
		
		 <?php
         $tran_allocation_rs = DB::table('employee_job')
                      ->where('emid','=',$Roledata->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
    	if($tran_allocation_rs)
		{
			foreach($tran_allocation_rs as $tran_allocation)
			{
?>
<tr>
         <td>{{ $f}}</td>
     <td>Job Title </td>
     <td>@if($tran_allocation->job_name!='null'){{  $tran_allocation->job_name}} @endif </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Start Date </td>
     <td>
         @if($tran_allocation->job_start_date!='1970-01-01'   && $tran_allocation->job_start_date!=''){{  date('d/m/Y',strtotime($tran_allocation->job_start_date))}} @endif 
        </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>End Date </td>
     <td>  @if($tran_allocation->job_end_date!='1970-01-01' && $tran_allocation->job_end_date!=''){{  date('d/m/Y',strtotime($tran_allocation->job_end_date))}} @endif  </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Year of Experience </td>
     <td>@if($tran_allocation->exp!='null'){{  $tran_allocation->exp}} @endif </td>
      
       </tr>
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Job Description </td>
     <td>@if($tran_allocation->des!='null'){{  $tran_allocation->des}} @endif  </td>
      
       </tr>
       
        <?php $f++;?>

 <?php
  }
		}
		?>
		
		
		 <?php
         $traning_allocation_rs = DB::table('employee_training')
                      ->where('emid','=',$Roledata->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
    	if($traning_allocation_rs)
		{
			foreach($traning_allocation_rs as $traning_allocation)
			{
?>
<tr>
         <td>{{ $f}}</td>
     <td>Training  Title </td>
     <td>@if($traning_allocation->tarin_name!='null'){{  $traning_allocation->tarin_name}} @endif </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Training  Start Date </td>
     <td>
         @if($traning_allocation->tarin_start_date!='1970-01-01'  && $traning_allocation->tarin_start_date!=''){{  date('d/m/Y',strtotime($traning_allocation->tarin_start_date))}} @endif 
        </td>
      
       </tr>
       <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Training End Date </td>
     <td>  @if($traning_allocation->tarin_end_date!='1970-01-01'  && $traning_allocation->tarin_end_date!=''){{  date('d/m/Y',strtotime($traning_allocation->tarin_end_date))}} @endif  </td>
      
       </tr>
      
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Training  Description </td>
     <td>@if($traning_allocation->train_des!='null'){{  $traning_allocation->train_des}} @endif  </td>
      
       </tr>
       
        <?php $f++;?>

 <?php
  }
		}
		?>
		
		
	
       
        
       	<tr>
         <td>{{ $f}}</td>
     <td>Next of Kin Contact Name</td>
    <td>@if($employeedata->em_name!='null'){{  $employeedata->em_name}} @endif 
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Next of Kin Contact Relationship</td>
    <td>@if($employeedata->em_relation!='null'){{  $employeedata->em_relation}} @endif 
    @if($employeedata->em_relation=='Others')  ( {{  $employeedata->relation_others}} ) @endif 
      </td>
       </tr>
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Next of Kin Contact Email</td>
    <td>@if($employeedata->em_email!='null'){{  $employeedata->em_email}} @endif 
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Next of Kin Contact Number</td>
    <td>@if($employeedata->em_phone!='null'){{  $employeedata->em_phone}} @endif 
      </td>
       </tr>
       
       
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Next of Kin Contact Address</td>
    <td>@if($employeedata->em_address!='null'){{  $employeedata->em_address}} @endif 
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>COS  Number</td>
    <td>@if($employeedata->cf_license_number!='null'){{  $employeedata->cf_license_number}} @endif 
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>COS Number Start Date</td>
    <td>
      @if($employeedata->cf_start_date!='1970-01-01'   && $employeedata->cf_start_date!=''){{  date('d/m/Y',strtotime($employeedata->cf_start_date))}} @endif   
        
      </td>
       </tr>
          <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>COS Number End Date</td>
    <td>
      @if($employeedata->cf_end_date!='1970-01-01'   && $employeedata->cf_end_date!=''){{  date('d/m/Y',strtotime($employeedata->cf_end_date))}} @endif   
        
      </td>
       </tr>
       
       
       
         <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Present Address</td>
      <td>{{ $employeedata->emp_pr_street_no}} @if( $employeedata->emp_per_village) ,{{ $employeedata->emp_per_village}} @endif @if( $employeedata->emp_pr_state) ,{{ $employeedata->emp_pr_state}} @endif @if( $employeedata->emp_pr_city) ,{{ $employeedata->emp_pr_city}} @endif
  @if( $employeedata->emp_pr_pincode) ,{{ $employeedata->emp_pr_pincode}} @endif  @if( $employeedata->emp_pr_country) ,{{ $employeedata->emp_pr_country}} @endif </td>
       
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td> Proof Of Present Address</td>
      <td>@if( $employeedata->pr_add_proof!='') Uploaded @else Not Uploaded @endif  </td>
       
      </td>
       </tr>
      
       </tr>
     <!--   
       	<tr>
         <td>{{ $f}}</td>
     <td>Country of Birth</td>
    <td>
     @if($employeedata->country_birth!='null'){{  $employeedata->country_birth}} @endif
        
      </td>
       </tr>-->
       <?php $f++;?>
       
       
       	
		
		
			<tr>
         <td>{{ $f}}</td>
     <td>Passport No.</td>
    <td>@if($employeedata->pass_doc_no!='null'){{  $employeedata->pass_doc_no}} @endif 
      </td>
       </tr>
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Nationality</td>
    <td>@if($employeedata->pass_nat!='null'){{  $employeedata->pass_nat}} @endif 
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Place of Birth</td>
    <td>@if($employeedata->place_birth!='null'){{  $employeedata->place_birth}} @endif 
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Passport Issued By</td>
    <td>@if($employeedata->issue_by!='null'){{  $employeedata->issue_by}} @endif 
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Passport Issued Date</td>
    <td>  @if($employeedata->pas_iss_date!='1970-01-01'  && $employeedata->pas_iss_date!=''){{  date('d/m/Y',strtotime($employeedata->pas_iss_date))}} @endif   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Passport Expiry Date</td>
    <td>  @if($employeedata->pass_exp_date!='1970-01-01'  && $employeedata->pass_exp_date!=''){{  date('d/m/Y',strtotime($employeedata->pass_exp_date))}} @endif   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Passport Eligible Review Date</td>
    <td>  @if($employeedata->pass_review_date!='1970-01-01'  && $employeedata->pass_review_date!=''){{  date('d/m/Y',strtotime($employeedata->pass_review_date))}} @endif   
      </td>
       </tr>
       
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Passport Document</td>
     <td>@if($employeedata->pass_docu!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Is this your current passport?</td>
    <td> @if($employeedata->cur_pass!='null'){{  $employeedata->cur_pass}} @endif
   
      </td>
       </tr>
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Passport Remarks</td>
    <td> @if($employeedata->remarks!='null'){{  $employeedata->remarks}} @endif
   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>BRP/Visa Number</td>
    <td> @if($employeedata->visa_doc_no!='null'){{  $employeedata->visa_doc_no}} @endif
   
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Nationality</td>
    <td> @if($employeedata->visa_nat!='null'){{  $employeedata->visa_nat}} @endif
   
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Country of Residence</td>
    <td> @if($employeedata->country_residence!='null'){{  $employeedata->country_residence}} @endif
   
      </td>
       </tr>
       
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td> Visa Issued By</td>
    <td> @if($employeedata->visa_issue!='null'){{  $employeedata->visa_issue}} @endif
   
      </td>
       </tr>
       
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Visa Issued Date</td>
    <td>  @if($employeedata->visa_issue_date!='1970-01-01' && $employeedata->visa_issue_date!=''){{  date('d/m/Y',strtotime($employeedata->visa_issue_date))}} @endif   
      </td>
       </tr>
         <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Visa Expiry Date</td>
    <td>  @if($employeedata->visa_exp_date!='1970-01-01' && $employeedata->visa_exp_date!=''){{  date('d/m/Y',strtotime($employeedata->visa_exp_date))}} @endif   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Visa Eligible Review Date</td>
    <td>  @if($employeedata->visa_review_date!='1970-01-01' && $employeedata->visa_review_date!=''){{  date('d/m/Y',strtotime($employeedata->visa_review_date))}} @endif   
      </td>
       </tr>

       
       
       
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>Visa Document</td>
     <td>@if($employeedata->visa_upload_doc!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Visa Remarks</td>
    <td> @if($employeedata->visa_remarks!='null'){{  $employeedata->visa_remarks}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Ref. No.</td>
    <td> @if($employeedata->euss_ref_no!='null'){{  $employeedata->euss_ref_no}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Nationality</td>
    <td> @if($employeedata->euss_nation!='null'){{  $employeedata->euss_nation}} @endif
   
      </td>
       </tr>
       
  
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Issued Date</td>
    <td>  @if($employeedata->euss_issue_date!='1970-01-01' && $employeedata->euss_issue_date!=''){{  date('d/m/Y',strtotime($employeedata->euss_issue_date))}} @endif   
      </td>
       </tr>
         <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Expiry Date</td>
    <td>  @if($employeedata->euss_exp_date!='1970-01-01' && $employeedata->euss_exp_date!=''){{  date('d/m/Y',strtotime($employeedata->euss_exp_date))}} @endif   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Eligible Review Date</td>
    <td>  @if($employeedata->euss_review_date!='1970-01-01' && $employeedata->euss_review_date!=''){{  date('d/m/Y',strtotime($employeedata->euss_review_date))}} @endif   
      </td>
       </tr>

       
       
       
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>EUSS/Time limit Document</td>
     <td>@if($employeedata->euss_upload_doc!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>EUSS/Time limit Remarks</td>
    <td> @if($employeedata->euss_remarks!='null'){{  $employeedata->euss_remarks}} @endif
   
      </td>
       </tr>
             
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Type</td>
    <td> @if($employeedata->dbs_type!='null'){{  $employeedata->dbs_type}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Ref. No.</td>
    <td> @if($employeedata->dbs_ref_no!='null'){{  $employeedata->dbs_ref_no}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Nationality</td>
    <td> @if($employeedata->dbs_nation!='null'){{  $employeedata->dbs_nation}} @endif
   
      </td>
       </tr>
       
  
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Issued Date</td>
    <td>  @if($employeedata->dbs_issue_date!='1970-01-01' && $employeedata->dbs_issue_date!=''){{  date('d/m/Y',strtotime($employeedata->dbs_issue_date))}} @endif   
      </td>
       </tr>
         <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Expiry Date</td>
    <td>  @if($employeedata->dbs_exp_date!='1970-01-01' && $employeedata->dbs_exp_date!=''){{  date('d/m/Y',strtotime($employeedata->dbs_exp_date))}} @endif   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Eligible Review Date</td>
    <td>  @if($employeedata->dbs_review_date!='1970-01-01' && $employeedata->dbs_review_date!=''){{  date('d/m/Y',strtotime($employeedata->dbs_review_date))}} @endif   
      </td>
       </tr>

       
       
       
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>DBS Document</td>
     <td>@if($employeedata->dbs_upload_doc!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>DBS Remarks</td>
    <td> @if($employeedata->dbs_remarks!='null'){{  $employeedata->dbs_remarks}} @endif
   
      </td>
       </tr>
             
       
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id No.</td>
    <td> @if($employeedata->nat_id_no!='null'){{  $employeedata->nat_id_no}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Nationality</td>
    <td> @if($employeedata->nat_nation!='null'){{  $employeedata->nat_nation}} @endif
   
      </td>
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Country of Residence</td>
    <td> @if($employeedata->nat_country_res!='null'){{  $employeedata->nat_country_res}} @endif
   
      </td>
       </tr>

       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Issued Date</td>
    <td>  @if($employeedata->nat_issue_date!='1970-01-01' && $employeedata->nat_issue_date!=''){{  date('d/m/Y',strtotime($employeedata->nat_issue_date))}} @endif   
      </td>
       </tr>
         <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Expiry Date</td>
    <td>  @if($employeedata->nat_exp_date!='1970-01-01' && $employeedata->nat_exp_date!=''){{  date('d/m/Y',strtotime($employeedata->nat_exp_date))}} @endif   
      </td>
       </tr>
        <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Eligible Review Date</td>
    <td>  @if($employeedata->nat_review_date!='1970-01-01' && $employeedata->nat_review_date!=''){{  date('d/m/Y',strtotime($employeedata->nat_review_date))}} @endif   
      </td>
       </tr>

       
       
       
        <?php $f++;?>
       <tr>
        <td>{{ $f}}</td>
     <td>National Id Document</td>
     <td>@if($employeedata->nat_upload_doc!='') Uploaded @else Not Uploaded @endif  </td>
      
       </tr>
       
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>National Id Remarks</td>
    <td> @if($employeedata->nat_remarks!='null'){{  $employeedata->nat_remarks}} @endif
   
      </td>
       </tr>
             
       
       
      <?php   $employee_bank=DB::table('bank_masters')->where('id','=',$employeedata->emp_bank_name)->first();
      
     
      ?>
      
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Bank Name </td>
    <td>  @if(!empty($employee_bank)){{$employee_bank->master_bank_name }} @endif 
    
      </td>	</tr> 
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Branch  Name </td>
    <td>  @if($employeedata->bank_branch_id!='null' ){{$employeedata->bank_branch_id }} @endif   
      </td>
       </tr>
     <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Sort Code </td>
    <td>  @if($employeedata->emp_sort_code!='null' ){{$employeedata->emp_sort_code }} @endif   
      </td>
       </tr>  
       <?php $f++;?>
       	<tr>
         <td>{{ $f}}</td>
     <td>Account Number </td>
    <td>  @if($employeedata->emp_account_no!='null' ){{$employeedata->emp_account_no }} @endif   
      </td>
       </tr> 
</tbody>
</table>

</body>
</html> 
