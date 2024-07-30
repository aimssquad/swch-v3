	<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<style type="text/css">
			.form-check-label{position: relative;padding-left: 29px;}.form-radio-label {position: relative;padding-left: 0;}input.form-check-input{position: absolute !important;top: 1px;left: 0;}
		.scan-hd {background: #e3c9ff;padding: 10px 0;border: 1px solid #999;}.scan-hd h3{margin-bottom: 0;}.scan-hd p{margin-bottom: 0;}.scan-body{border: 1px solid #999;border-top:none;}
    .rtw-form-view tr td img{position: absolute;width: 15px;top:3px;left:0;}.scan-body{text-align:center;}.rtw-form-view h3{margin-bottom:0;font-size:25px}
    .rtw-form-view div{position: relative;padding-left: 28px;}.rtw-form-view td {font-size: 13.5px;padding: 4px 6px !important;}.rtw-form-view h4{margin-top:0;}
    @print{
    @page :footer {color: #fff }
    @page :header {color: #fff}
}
	</style>
</head>

<body>
	<table class="rtw-form-view"  style="border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;">
		<tr><th style="text-align: center;"><h3>Right to Work Checklist (RTW)</h3><h4>({{$Roledata->com_name}})</h4></th></tr>
	</table>
	<table border="1"  class="rtw-form-view"  style="border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;margin-bottom:10px;border: 1px solid #a863ed;">
		<tbody>
			
			<tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Name of person:</td>
				<td style="background: #f4e9f7;padding: 8px;">{{ $employee_rs->emp_fname }} {{ $employee_rs->emp_mname }} {{ $employee_rs->emp_lname }}</td>
			</tr>
      <tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Work start date:</td>
				<td style="background: #f4e9f7;padding: 8px;">@if($work_rs->start_date!='') {{ date('d/m/Y',strtotime($work_rs->start_date))}} @endif</td>
			</tr>      
			<tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Date & Time of Check:</td>
				<td style="background: #f4e9f7;padding: 8px;">{{date('d/m/Y',strtotime($work_rs->date))}} {{ $work_rs->start_time }}</td>
			</tr>
			 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->type);
		 
		 
	
	?>
			<tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Type of check:</td>
				<td style="background: #f4e9f7;padding: 8px;">
			 <div>
             <?php if(in_array("Initial check for new employee/applicant - required before employment", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Initial check for new employee/applicant - required before employment
  </label>

</div>		
  
   
 <div>
             <?php  if(in_array("Follow-up check on an existing employee - required before permission to work    expires (under List B - Group 1 or 2)", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Follow-up check on an existing employee - required before permission to work expires (under List B - Group 1 or 2)
  </label>

</div>		
  

  

</td>
			</tr>
	 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->medium);
	
	?>
			<tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Medium of check:</td>
				<td style="background: #f4e9f7;padding: 8px;">

 <div>
             <?php  if(in_array("In-person manual check with original documents", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>In-person manual check with original documents
  </label>

</div>

 <div>
             <?php  if(in_array("Online right to work check", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Online right to work check
  </label>

</div>

		

</td>
			</tr>
	<?php
$desig_rs=DB::table('employee')
 
  ->where('emp_code', '=',  $work_rs->employee_id)
   ->where('emid', '=',  $work_rs->emid)
  ->first();
    $employee_rs=DB::table('employee_qualification')
 
  ->where('emp_id', '=',  $work_rs->employee_id)
   ->where('emid', '=',  $work_rs->emid)
  ->get();
  $employee_otherd_doc_rs = DB::table('employee_other_doc')
  ->where('emid','=',$work_rs->emid )
                      ->where('emp_code','=',  $work_rs->employee_id)
                 ->get();
$result_status1='';
  
  
?>
			<tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Evidence Presented:</td>
				<td style="background: #f4e9f7;padding: 8px;"><?php
				     $kl=0;
     foreach($employee_rs as $bank)
    {
        if($work_rs->evidence==$bank->quli.' Transcript Document'){
                echo $bank->quli.' Transcript Document';
        $kl++;
            }else{
                $se='';
            }
       
        if($work_rs->evidence==$bank->quli.' Certificate Document'){
           echo $bank->quli.' Certificate Document';
          $kl++;
            }else{
                $se='';
            }
         if($bank->doc2!=''){
       
        }
    }
     if($work_rs->evidence=='pr_add_proof'){
          echo 'Proof Of Correspondence   Address'; 
            $kl++;
            }else{
                $se='';
            }
     if($desig_rs->pr_add_proof!=''){
        
      }
       if($work_rs->evidence=='pass_docu'){
              echo 'Passport    Document'; 
           $kl++; 
            }else{
                $se='';
            }
      if($desig_rs->pass_docu!=''){
     
      }
        if($work_rs->evidence=='visa_upload_doc'){
           echo 'Visa    Document '; 
            }else{
                $se='';
            }
       if($desig_rs->visa_upload_doc!=''){
        
           $kl++; 
      }
	   if($work_rs->evidence=='euss_upload_doc'){
          echo 'EUSS    Document'; 
            $kl++;
            }else{
                $se='';
            }
			
			
			  if($work_rs->evidence=='nat_upload_doc'){
          echo 'National Id    Document'; 
            $kl++;
            }else{
                $se='';
            }
	   foreach($employee_otherd_doc_rs as $banknew)
    {
        if($work_rs->evidence==$banknew->doc_name){
            echo $banknew->doc_name; 
			 $kl++;
            }else{
                $se='';
            }
			
      
    }
      if($kl==0){
        echo $work_rs->evidence;
      }
      ?></td>
			</tr>
			<!-- <tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Work start time:</td>
				<td style="background: #f4e9f7;padding: 8px;">@if($work_rs->start_date!='') {{ date('d/m/Y',strtotime($work_rs->start_date))}} @endif</td>
			</tr> -->
			<!-- <tr>
				<td style="width: 200px; padding: 8px; background: #cc99ff;font-weight: 600;">Time of check:</td>
				<td style="background: #f4e9f7;padding: 8px;">{{ $work_rs->start_time }}</td>
			</tr> -->
		</tbody>
	</table>


	 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_ap);
	
	?>
	<table  class="rtw-form-view"  border="1" style="margin-bottom:10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;border: 1px solid #c0504d;background: #f1dbdb;">
		
      <tr>
      	<td colspan="2" style="background: #c0504d;text-align: center;color: #fff;padding: 3px;">
      		Step 1 for physical check
      	</td>
      	
      </tr>
      <tr>
      	<td style="padding: 5px;">You must obtain original documents from either List A or List B of acceptable documents for manual right to work check</td>
      </tr>
      <tr>
      	<td colspan="2" style="background: #c0504d;text-align: center;color: #fff;padding: 3px;">
      		List A
      	</td>
      	
      </tr>
      <tr>
      	<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
          <div>
             <?php  if(in_array("A passport", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   A passport showing the holder, 
         or a person named in the passport as the child of the holder, 
         is a British citizen or a citizen of the UK and Colonies having the right of abode in the UK
  </label>

</div>
      	
</td>
</tr>
<tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A passport or national", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.    A passport or national identity card showing the holder, or a person named in the passport as the child of the holder, is a national of a European Economic Area country or Switzerland.
  
  </label>

</div>

      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A Registration Certificate", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.       A Registration Certificate or Document Certifying Permanent Residence issued by the Home Office, to a national of a European Economic Area country or Switzerland.
  
  </label>

</div>
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A Registration Certificate or Document", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 4.       A Permanent Residence Card issued by the Home Office, to the family member of a national of a European Economic Area country or Switzerland.
 
  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A current Biometric Immigration", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 5.       A current Biometric Immigration Document (Biometric Residence Permit) issued by the Home Office to the holder indicating that the person named is allowed to stay indefinitely in the UK or has no time limit on their stay in the UK.
  
  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A current passport endorsed", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 6.       A current passport endorsed to show that the holder is exempt from immigration control, is allowed to stay indefinitely in the UK, has the right of abode in the UK, or has no time limit on their stay in the UK.
  
  </label>

</div>
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A current Immigration Status", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 7.      A current Immigration Status Document issued by the Home Office to the holder with an endorsement indicating that the named person is allowed to stay indefinitely in the UK or has no time limit on their stay in the UK, together with an official document giving the person’s permanent National Insurance number and their name issued by a Government agency or a previous employer.
  
  </label>

</div>
      		
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A birth (short or long) or adoption", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 8.       A birth (short or long) or adoption certificate issued in the UK, together with an official document giving the person’s permanent National Insurance number and their name issued by a Government agency or a previous employer.
  
  </label>

</div>
      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php  if(in_array("A birth (short or long) or adoption certificate", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 9.      A birth (short or long) or adoption certificate issued in the Channel Islands, the Isle of Man or Ireland, together with an official document giving the person’s permanent National Insurance number and their name issued by a Government agency or a previous employer.

  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("A certificate of registration or naturalisation as a British", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 10.    A certificate of registration or naturalisation as a British citizen, together with an official document giving the person’s permanent National Insurance number and their name issued by a Government agency or a previous employer.

  </label>

</div>
      	
      		
</td>
      </tr>
	 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_bp);
	
	?>
      <tr>
      	<td colspan="2" style="background: #c0504d;text-align: center;color: #fff;padding: 3px;">
      		List B Group 1
      	</td>
      	
      </tr>
       <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php     if(in_array("A current passport endorsed to show that the holder", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   A current passport endorsed to show that the holder is allowed to stay in the UK and is currently allowed to do the type of work in question.


  </label>

</div>
      
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php     if(in_array("A current Biometric Immigration Document", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.   A current Biometric Immigration Document (Biometric Residence Permit) issued by the Home Office to the holder which indicates that the named person can currently stay in the UK and is allowed to do the work in question.


  </label>

</div>
      
      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
      		
              <div>
             <?php    if(in_array("A current Residence Card", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.    A current Residence Card (including an Accession Residence Card or a Derivative Residence Card) issued by the Home Office to a non-European Economic Area national who is a family member of a national of a European Economic Area country or Switzerland or who has a derivative right of residence.


  </label>

</div>
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
  <div>
             <?php   if(in_array("A current Immigration Status Document containing a", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 4.   A current Immigration Status Document containing a photograph issued by the Home Office to the holder with a valid endorsement indicating that the named person may stay in the UK, and is allowed to do the type of work in question, together with an official document giving the person’s permanent National Insurance number and their name issued by a Government agency or a previous employer.


  </label>

</div>
      	
</td>
      </tr>

   <tr>
      	<td colspan="2" style="background: #c0504d;text-align: center;color: #fff;padding: 3px;">
      		List B Group 2
      	</td>
      	
      </tr>
<?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_bpc);
	
	?>
  <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php    if(in_array("A Certificate of Application issued", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   A Certificate of Application issued by the Home Office under regulation 17(3) or 18A (2) of the Immigration (European Economic Area) Regulations 2006, to a family member of a national of a European Economic Area country or Switzerland stating that the holder is permitted to take employment which is less than 6 months old together with a Positive Verification Notice from the Home Office Employer Checking Service.

  </label>

</div>
      	
      		
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php   if(in_array("An Application Registration Card issued", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.    An Application Registration Card issued by the Home Office stating that the holder is permitted to take the employment in question, together 	with a Positive Verification Notice from the Home Office Employer Checking Service.

  </label>

</div>
      	
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #c0504d;">
<div>
             <?php  if(in_array("A Positive Verification Notice", $timearray)){  ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.    A Positive Verification Notice issued by the Home Office Employer Checking Service to the employer or prospective employer, which indicates that the named person may stay in the UK and is permitted to do the work in question.

  </label>

</div>
      	
</td>
      </tr>
	</table>


<table border="1" class="rtw-form-view"  style="margin-bottom:10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;border: 1px solid #9bba58;background: #eaf0dd;">
	

	<tr>
      	<td colspan="2" style="background: #9bba58;text-align: center;color: #fff;padding: 3px;">
      		Step 2 Check
      	</td>
      	
      </tr>
     <tr>
     	<td colspan="2" style="padding: 5px;">You must check that the documents are genuine and that the person presenting them is the prospective employee or employee, the rightful holder and allowed to do the type of work you are offering.</td>
     </tr>

     <tr>
     	<td style="padding: 5px;width: 650px;">
     		1. Are photographs consistent across documents and with the person’s appearance?
     	</td>



     	<td style="padding: 5px;">
         <div>
             <?php if($work_rs->photographs=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div>		
    <div>
             <?php if($work_rs->photographs=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div>	
 <div>
             <?php if($work_rs->photographs=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div>		


     	</td>
     </tr>


     <tr>
     	<td style="padding: 5px;width: 650px;">
     		2. Are dates of birth consistent across documents and with the person’s appearance?
     	</td>
     	<td style="padding: 5px;">
   <div>
             <?php if($work_rs->dates=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div>	
 <div>
             <?php if($work_rs->dates=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div>	
<div>
             <?php if($work_rs->dates=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div>

     	</td>
     </tr>

      <tr>
     	<td style="padding: 5px;width: 650px;">
     		3. Are expiry dates for time-limited permission to be in the UK in the future i.e. they have not passed (if applicable)?
     	</td>
     	<td style="padding: 5px;">
         <div>
             <?php if($work_rs->expiry=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div>
       <div>
             <?php if($work_rs->expiry=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div>
<div>
             <?php if($work_rs->expiry=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div>


     	</td>
     </tr>

     <tr>
     	<td style="padding: 5px;width: 650px;">
     		4. Have you checked work restrictions to determine if the person is able to work for you and do the type of work you are offering? (for students who have limited permission to work during term-times, you must also obtain, copy and retain details of their academic term and vacation times covering the duration of their period of study in the UK for which they will be employed)
     	</td>
     	<td style="padding: 5px;">
         <div>
             <?php if($work_rs->checked=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div>
  <div>
             <?php if($work_rs->checked=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div>
<div>
             <?php if($work_rs->checked=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div>
</td>
     </tr>

     <tr>
     	<td style="padding: 5px;width: 650px;">
     		5. Are you satisfied the document is genuine, has not been tampered with and belongs to the holder?
     	</td>
     	<td style="padding: 5px;">
         <div>
             <?php if($work_rs->satisfied=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div>
  <div>
             <?php if($work_rs->satisfied=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div>
     <div>
             <?php if($work_rs->satisfied=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div> 

     	</td>
     </tr>

     <tr>
     	<td style="padding: 5px;width: 650px;">
     		6. Have you checked the reasons for any different names across documents (e.g. marriage certificate, divorce decree, deed poll)?
(Supporting documents should also be photocopied and a copy retained.)
     	</td>
     	<td style="padding: 5px;">
          <div>
             <?php if($work_rs->reasons=='Yes'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Yes
  </label>

</div> 
<div>
             <?php if($work_rs->reasons=='No'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>No
  </label>

</div> 
   <div>
             <?php if($work_rs->reasons=='N/A'){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>N/A
  </label>

</div>  


     	</td>
     </tr>
</table>

<?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->passports);
	
	?>
<table border="1" class="rtw-form-view" style="margin-bottom: :10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;border: 1px solid #8063a1;background: #e4dfeb;">


<tr>
	<td style="padding: 5px;text-align: center;background:#8063a1;color: #fff">
		Step 3 Copy
	</td>
</tr>

<tr>
	<td style="padding: 5px;">You must make a clear copy of each document in a format which cannot later be altered, and retain the copy securely: electronically or in hardcopy. You must copy and retain:</td>
</tr>

<tr>
	<td style="padding: 5px;">
    <div>
             <?php     if(in_array("any page with the document", $timearray)){   ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   Passports: any page with the document expiry date, nationality, date of birth, signature, leave expiry date, biometric details and photograph, and any page containing information indicating the holder has an entitlement to enter or remain in the UK and undertake the work in question.</label>

  </label>

</div>
		
	</td>
</tr>

<tr>
	<td style="padding: 5px;">
    <div>
             <?php        if(in_array("All other documents", $timearray)){  ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.     All other documents:the document in full,both sides of a Biometric Residence Permit.You must also record and retain the date on which the check was made.s</label>

  </label>

</div>
	
	</td>
</tr>
</table>
<br>

<table border="1" style="margin-bottom: :10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:auto;overflow-x:scroll;font-family: calibri;border: 1px solid #8063a1;">

<tr>
	<th style="background:#cbc0d9;padding: 8px;">Type of RTW evidence</th>
	<th style="background:#cbc0d9;padding: 8px;">Right to work permission validity</th>
	<th style="background:#cbc0d9;padding: 8px;">Follow up RTW check requirement</th>
	<th style="background:#cbc0d9;padding: 8px;">Date followup required</th>
</tr>

<tr>
	<td style="background: #cbc0d9;">List A</td>
	<td>{{ $work_rs->list_right }}</td>
	<td>{{ $work_rs->list_right_follow }}</td>
	<td>@if($work_rs->list_right_date!='')  @if($work_rs->list_right_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_right_date))}} @endif   @endif</td>
</tr>
<tr>
	<td style="background: #cbc0d9;">List B: (Group 1)</td>
	<td>{{ $work_rs->list_rightb }}</td>
	<td>{{ $work_rs->list_rightb_follow }}</td>
	<td>@if($work_rs->list_rightb_date!='') @if($work_rs->list_rightb_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_rightb_date))}} @endif @endif</td>
</tr>
<tr>
	<td style="background: #cbc0d9;">Tier 4 Student Visa term and holiday date evidence</td>
	<td>{{ $work_rs->list_rightti }}</td>
	<td>{{ $work_rs->list_rightti_follow }}</td>
	<td>@if($work_rs->list_rightti_date!='') @if($work_rs->list_rightti_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_rightti_date))}} @endif  @endif</td>
</tr>
<tr>
	<td style="background: #cbc0d9;">List B: (Group 2)</td>
		<td>{{ $work_rs->list_rightbs }}</td>
	<td>{{ $work_rs->list_rightbs_follow }}</td>
	<td>@if($work_rs->list_rightbs_date!='') @if($work_rs->list_rightbs_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_rightbs_date))}} @endif @endif</td>
</tr>



</table>

<table style="max-width: 900px;width:100%;margin:10px auto;">
  @if($work_rs->scan_f_img!='')
	<tr>
		<td>
		<div class="text-center rtw-scan" style="font-family: calibri;padding-left: 0;">
                <div class="scan-hd">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Evidence Scans-1</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste an image of your scanned RTW documents into the grey form field below.</p>
              </div>

              <div class="scan-body" style="background: #edecec;padding-left: 0;">
                 
                 
                  <?php
             $secod=array();
             if($work_rs->scan_f=='visa_upload_doc'){
                 
                  $secod=explode(",",$work_rs->scan_f_img);
          ?>
          <embed src="<?=env("BASE_URL");?>public/{{$secod[0]}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                     
          <?php
            }else{
               ?>
               <embed src="<?=env("BASE_URL");?>public/{{$work_rs->scan_f_img}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                 
               <?php
            }
            ?>
              
                 
              
               
             
                   <div id="scan_nse_id"   @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block;margin-top:20px;padding-left:0;" @else style="display:none;margin-top:20px;padding-left:0;" @endif   >
                   <embed  @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}"  @else  @endif  frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
              
                   </div>    
                
              </div>
              </div>
          </td>
	</tr>
  @endif
  @if($work_rs->scan_s_img!='')
	<tr>
	    
		<td><div class="text-center rtw-scan" style="font-family: calibri;">
                <div class="scan-hd">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Evidence Scans-2 (If applicable)</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste an image of your scanned RTW documents into the blue form field below.</p>
              </div>

              <div class="scan-body" style="background: #e0f6ff;">
                 
                 <?php
             $secod=array();
             if($work_rs->scan_s=='visa_upload_doc'){
                
                  $secod=explode(",",$work_rs->scan_s_img);
                  
                 
          ?>
          <embed src="<?=env("BASE_URL");?>public/{{$secod[0]}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                     
          <?php
            }else{
               ?>
               <embed src="<?=env("BASE_URL");?>public/{{$work_rs->scan_s_img}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                 
               <?php
            }
            ?>
              
                 
              
                
                  <div id="scan_nrse_id"   @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  style="display:block; margin-top:20px;padding-left:0;" @else style="display:none; margin-top:20px;padding-left:0;" @endif    >
                  <embed  @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}"  @else  @endif  frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
              
                   </div>
              </div>
              </div>
          </td>
	</tr>
   @endif
        @if($work_rs->scan_r_img!='')
	<tr>
		<td>
			<div class="text-center rtw-scan" style="font-family: calibri;">
                <div class="scan-hd">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Report</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste a clear copy/image of RTW check result in the orange form below.</p>
              </div>

              <div class="scan-body" style="background: #ffedcb;">
             
                 <?php
             $secod=array();
             if($work_rs->scan_r=='visa_upload_doc'){ 
                 
                  $secod=explode(",",$work_rs->scan_r_img);
          ?>
          <embed src="<?=env("BASE_URL");?>public/{{$secod[0]}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                     
          <?php
            }else{
               ?>
               <embed src="<?=env("BASE_URL");?>public/{{$work_rs->scan_r_img}}" frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
                 
               <?php
            }
            ?>
              
                 
               <div id="scan_nrse_id"   @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block; margin-top:20px;padding-left:0;" @else style="display:none; margin-top:20px;padding-left:0;" @endif    >
                  <embed  @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}"  @else  @endif  frameborder="0" width="50%" height="auto" style="text-align:center;"></embed>
              
                   </div>
                
                  
              </div>
              <p>Note: For all RTW checks: please complete form, attach the scanned RTW evidence document photos/scans and <u>save as one PDF</u></p>
              </div>
		</td>
	</tr>
	   @endif
</table>

<table border="1" style="margin-top:10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:10px auto;">
	

<table border="1" style="margin-top:10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:10px auto;">
	<tr>
		<td style="background: yellow;padding:10px;width:250px">
    RTW check result</td>
		<td style="width:250px">{{$work_rs->result}}</td>
		<td style="background: yellow;padding:10px;width:250px">Remarks</td>
		<td>{{$work_rs->remarks}}</td>
	</tr>
	
<!-- </table>

<table border="1" style="margin-top:10px !important;border-collapse:collapse;max-width: 900px;width:100%;margin:10px auto;"> -->
	<tr>
		<td style="width:250px;padding:10px;background: #cbc0d9;">Checker's Name</td>
		<td width="250">{{$work_rs->checker}}</td>
		<td style="width:250px;background: #cbc0d9;padding:10px;">Contact No.</td>
		<td>{{$work_rs->contact}}</td>
	</tr>


	<tr>
		<td style="width:250px;background: #cbc0d9;padding:10px;background: #cbc0d9">Designation </td>
		<td>{{$work_rs->designation}} </td>
		<td style="width:250px;padding:10px; background: #cbc0d9;">Email Address</td>
		<td>{{$work_rs->email}}</td>
	</tr>
	
	
</table>	
</body>

</html>