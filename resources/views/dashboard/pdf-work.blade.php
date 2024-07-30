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
    /* .rtw-form-view tr td img{position: absolute;width: 15px;top:3px;left:0;}*/.scan-body{text-align:center;padding: 25px 0;}
    .rtw-form-view div{position: relative;padding-left: 28px;}.rtw-form-view td {font-size: 13.5px;padding: 4px 6px !important;}
    .rtw-scan-main tr td{padding:4px 0 !important;}.rtw-form-view tr td img{position: absolute;width: 15px;top:3px;left:0;}
	.excuselist{
    display: inline;
    position: relative;
    padding-right: 5px;}
    @media print {
  body{
    -webkit-print-color-adjust: exact; /*chrome & webkit browsers*/
    color-adjust: exact; /*firefox & IE */
  } 
}
@print{
    @page :footer {color: #fff }
    @page :header {color: #fff}
}
	</style>
</head>

<body>
	<table class="rtw-form-view"  style="border-collapse:collapse;width:100%;margin:auto;font-family: calibri;">
		<tr><th style="text-align: center;"><h3>Right to Work Checklist (RTW)</h3><h4>({{$Roledata->com_name}})</h4> </th></tr>
	</table>
	<table border="1"  class="rtw-form-view"  style="border-collapse:collapse;max-width: 900px;width:100%;margin:auto;font-family: calibri;margin-bottom:10px;border: 1px solid #fff;">
		<tbody>
			
			<tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Name of person:</td>
				<td style="background: #edf0f6;padding: 8px;">{{ $employee_rs->emp_fname }} {{ $employee_rs->emp_mname }} {{ $employee_rs->emp_lname }}</td>
			</tr>
      <tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Work start date:</td>
				<td style="background: #edf0f6;padding: 8px;">@if($work_rs->start_date!='') {{ date('d/m/Y',strtotime($work_rs->start_date))}} @endif</td>
			</tr>
			<tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Date & Time of Check:</td>
				<td style="background: #edf0f6;padding: 8px;">{{date('d/m/Y',strtotime($work_rs->date))}} {{ $work_rs->start_time }}</td>
			</tr>
			 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->type);
	
	?>
			<tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Type of check:</td>
				<td style="background: #edf0f6;padding: 8px;">
			 <div>
             <?php if(in_array("Initial check for new employee/applicant - required before employment", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Initial check before employment
  </label>

</div>		
  
   
 <div>
             <?php  if(in_array("Follow-up check on an existing employee - required before permission to work    expires (under List B - Group 1 or 2)", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/radio-check.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/radio-uncheck.png" alt="">  <?php }
             ?>
    <label>Follow-up check on an employee  </label>

</div>		
  

  

</td>
			</tr>
	 
<?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->medium);
	
	?>
			<tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Medium of check:</td>
				<td style="background: #edf0f6;padding: 8px;">

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
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Evidence Presented:</td>
				<td style="background: #edf0f6;padding: 8px;"><?php
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
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Work start time:</td>
				<td style="background: #edf0f6;padding: 8px;">@if($work_rs->start_date!='') {{ date('d/m/Y',strtotime($work_rs->start_date))}} @endif</td>
			</tr> -->
			<!-- <tr>
				<td style="width: 200px; padding: 8px; background: #bbe1f8;font-weight: 600;">Time of check:</td>
				<td style="background: #edf0f6;padding: 8px;">{{ $work_rs->start_time }}</td>
			</tr> -->
		</tbody>
	</table>


	 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_ap);
	
	?>
	<table  class="rtw-form-view"  border="1" style="margin-bottom:10px !important;margin-top:10px !important;border-collapse:collapse;width:100%;
	margin:auto;font-family: calibri;border: 1px solid #fff;background: #edf0f6;">
		   <tr>
      	<td style="padding: 5px;">You may conduct a physical document check or perform an online check to establish
a right to work. Where a right to work check has been conducted using the online
service, the information is provided in real-time, directly from Home Office systems
and there is no requirement to see the documents listed below.</td>
</tr>
      <tr>
      	<td style="background: #bbe1f8;text-align: center;color: #13335a;font-weight:600;padding: 3px;">
      		Step 1 for physical check
      	</td>
      	
      </tr>
      <tr>
      	<td style="padding: 5px;">You must <b>obtain original</b> documents from either List A or List B of acceptable documents for a manual right to work check.</td>
      </tr>
      <tr>
      	<td colspan="2" style="background: #bbe1f8;text-align: center;color: #13335a;font-weight:600;padding: 3px;">
      		List A
      	</td>
      	
      </tr>
      <tr>
      	<td style="padding: 5px;border-bottom: 1px solid #fff;">
          <div>
             <?php  if(in_array("A passport", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   A passport <b>(current or expired)</b> showing the holder, or a person named in the
passport as the child of the holder, is a British citizen or a citizen of the UK and
Colonies having the right of abode in the UK.
  </label>

</div>
      	
</td>
</tr>
<tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A passport or national", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.    A passport or passport card <b>(current or expired)</b> showing that the holder is a
national of the Republic of Ireland.
  
  </label>

</div>

      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A Registration Certificate", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.      A <b>current</b> document issued by the Home Office to a family member of an EEA
or Swiss citizen, and which indicates that the holder is permitted to stay in the
United Kingdom indefinitely.
  </label>

</div>
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A Registration Certificate or Document", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 4.       A document issued by the Bailiwick of Jersey, the Bailiwick of Guernsey or the
Isle of Man, which has been verified as valid by the Home Office Employer
Checking Service, showing that the holder has been granted unlimited
leave to enter or remain under Appendix EU to the Jersey Immigration
Rules, Appendix EU to the Immigration (Bailiwick of Guernsey) Rules 2008 or
Appendix EU to the Isle of Man Immigration Rules.
  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A current Biometric Immigration", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 5.    A <b>current</b> Biometric Immigration Document (biometric residence permit)
issued by the Home Office to the holder indicating that the person named is
allowed to stay indefinitely in the UK, or has no time limit on their stay in the
UK.
  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A current passport endorsed", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 6.      A <b>current</b> passport endorsed to show that the holder is exempt from
immigration control, is allowed to stay indefinitely in the UK, has the right of
abode in the UK, or has no time limit on their stay in the UK.
  </label>

</div>
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A current Immigration Status", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 7.     A <b>current</b> Immigration Status Document issued by the Home Office to the holder
with an endorsement indicating that the named person is allowed to stay
indefinitely in the UK or has no time limit on their stay in the UK, together with an
official document giving the person’s permanent National Insurance number
and their name issued by a government agency or a previous employer.
  </label>

</div>
      		
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A birth (short or long) or adoption", $timearray)){?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 8.       A birth or adoption certificate issued in the UK, <b>together with</b> an official
document giving the person’s permanent National Insurance number and their
name issued by a government agency or a previous employer
  </label>

</div>
      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php  if(in_array("A birth (short or long) or adoption certificate", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 9.     A birth or adoption certificate issued in the Channel Islands, the Isle of Man
or Ireland, <b>together with</b> an official document giving the person’s permanent
National Insurance number and their name issued by a government agency or
a previous employer.
  </label>

</div>
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("A certificate of registration or naturalisation as a British", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 10.  A certificate of registration or naturalisation as a British citizen, <b>together with</b> an
official document giving the person’s permanent National Insurance number
and their name issued by a government agency or a previous employer.
  </label>

</div>
      	
      		
</td>
      </tr>
	 <?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_bp);
	
	?>
      <tr>
      	<td colspan="2" style="background: #bbe1f8;text-align: center;color: #13335a;font-weight: 600;padding: 3px;">
      		List B Group 1
      	</td>
      	
      </tr>
       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php     if(in_array("A current passport endorsed to show that the holder", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.   A <b>current</b> passport endorsed to show that the holder is allowed to stay in the
UK and is currently allowed to do the type of work in question.


  </label>

</div>
      
      	
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php     if(in_array("A current Biometric Immigration Document", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.  A <b>current</b> Biometric Immigration Document (biometric residence permit)
issued by the Home Office to the holder which indicates that the named
person can currently stay in the UK and is allowed to do the work in question.

  </label>

</div>
      
      		
</td>
      </tr>

      <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
      		
              <div>
             <?php    if(in_array("A current Residence Card", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.    A <b>current</b> document issued by the Home Office to a family member of an
EEA or Swiss citizen, and which indicates that the holder is permitted to stay
in the United Kingdom for a time-limited period and to do the type of work in
question.

  </label>

</div>
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
  <div>
             <?php   if(in_array("A current Immigration Status Document containing a", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 4.   
A document issued by the Bailiwick of Jersey, the Bailiwick of Guernsey or the
Isle of Man, which has been verified as valid by the Home Office Employer
Checking Service, showing that the holder has been granted limited leave to
enter or remain under Appendix EU to the Jersey Immigration Rules, Appendix
EU to the Immigration (Bailiwick of Guernsey) Rules 2008 or Appendix EU to the
Isle of Man Immigration Rules.
  </label>

</div>
      	
</td>
      </tr>
      
      
      
        <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
  <div>
             <?php   if(in_array("A document issued by the Bailiwick of Jersey", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 5.   
A document issued by the Bailiwick of Jersey or the Bailiwick of Guernsey,
which has been verified as valid by the Home Office Employer Checking
Service, showing that the holder has made an application for leave to enter or
remain under Appendix EU to the Jersey Immigration Rules or Appendix EU to
the Immigration (Bailiwick of Guernsey) Rules 2008, on or before 30 June 2021.
  </label>

</div>
      	
</td>
      </tr>
      
      
      
        <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
  <div>
             <?php   if(in_array("A frontier worker permit", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 6.   
A frontier worker permit issued under regulation 8 of the Citizens’ Rights
(Frontier Workers) (EU Exit) Regulations 2020.
  </label>

</div>
      	
</td>
      </tr>
       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
  <div>
             <?php   if(in_array("A current immigration status document containing a photograph", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 7.   
A <b>current</b> immigration status document containing a photograph issued by
the Home Office to the holder with a valid endorsement indicating that the
named person may stay in the UK, and is allowed to do the type of work in
question, together with an official document giving the person’s permanent
National Insurance number and their name issued by a government agency
or a previous employer.
  </label>

</div>
      	
</td>
      </tr>

   <tr>
      	<td colspan="2" style="background: #bbe1f8;text-align: center;color: #13335a;font-weight: 600;padding: 3px;"">
      		List B Group 2
      	</td>
      	
      </tr>
<?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->list_bpc);
	
	?>
  <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php    if(in_array("A Certificate of Application issued", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.  A document issued by the Home Office showing that the holder has made an
application for leave to enter or remain under Appendix EU to the immigration
rules on or before 30 June 2021 <b>together with a Positive Verification Notice</b>
from the Home Office Employer Checking Service.
  </label>

</div>
      	
      		
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php   if(in_array("An Application Registration Card issued", $timearray)){ ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 2.   A document issued by the Bailiwick of Jersey or the Bailiwick of Guernsey,
showing that the holder has made an application for leave to enter or remain
under Appendix EU to the Jersey Immigration Rules or Appendix EU to the
Immigration (Bailiwick of Guernsey) Rules 2008 on or before 30 June 2021
<b>together with a Positive Verification Notice</b> from the Home Office Employer
Checking Service.
  </label>

</div>
      	
</td>
      </tr>

       <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php  if(in_array("A Positive Verification Notice", $timearray)){  ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 3.    An application registration card issued by the Home Office stating that the
holder is permitted to take the employment in question, <b>together with a
Positive Verification Notice</b> from the Home Office Employer Checking Service.
  </label>

</div>
      	
</td>
      </tr>
        <tr>
<td style="padding: 5px;border-bottom: 1px solid #fff;">
<div>
             <?php  if(in_array("A Positive Verification Notice issued", $timearray)){  ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 4.    A <b>Positive Verification Notice </b> issued by the Home Office Employer Checking
Service to the employer or prospective employer, which indicates that the
named person may stay in the UK and is permitted to do the work in question.
  </label>

</div>
      	
</td>
      </tr>
	</table>


<table border="1" class="rtw-form-view"  style="margin:10px 0 !important;border-collapse:collapse;width:100%;
margin:auto;font-family: calibri;border: 1px solid #fff;background: #edf0f6;">
	

	<tr>
      	<td colspan="2" style="background: #b5d8ac;text-align: center;color: #13335a;    font-weight: 600;padding: 3px;">
      		Step 2 Check
      	</td>
      	
      </tr>
     <tr>
     	<td colspan="2" style="padding: 5px;">You must <b>check</b>  that the documents are genuine and that the person presenting
them is the prospective employee or employee, the rightful holder and allowed to
do the type of work you are offering.</td>
     </tr>

     <tr>
     	<td style="padding: 5px;">
     		1. Are photographs consistent across documents
and with the person’s appearance?
     	</td>



     	<td style="padding: 5px;background:#f8fcfe;">
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
     	<td style="padding: 5px;">
     		2. Are dates of birth correct and consistent
across documents?
     	</td>
     	<td style="padding: 5px;background:#f8fcfe;">
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
     	<td style="padding: 5px;">
     		3. Are expiry dates for time-limited permission
to be in the UK in the future i.e. they have not
passed (if applicable)?
     	</td>
     	<td style="padding: 5px;background:#f8fcfe;">
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
     	<td style="padding: 5px;">
     		4. Have you checked work restrictions to determine
if the person is able to work for you and do the
type of work you are offering? (For <b>students</b> who
have limited permission to work during termtime, you <b>must</b> also obtain, copy and retain
details of their academic term and vacation
times covering the duration of their period of
study in the UK for which they will be employed.)
     	</td>
     	<td style="padding: 5px;background:#f8fcfe;">
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
     	<td style="padding: 5px;">
     		5. Are you satisfied the document is genuine,
has not been tampered with and belongs to
the holder?
     	</td>
     	<td style="padding: 5px;background:#f8fcfe;">
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
     	<td style="padding: 5px;">
     		6. Have you checked the reasons for any
different names across documents (e.g.
marriage certificate, divorce decree, deed
poll)? (Supporting documents should also be
photocopied and a copy retained.)
     	</td>
     	<td style="padding: 5px;background:#f8fcfe;">
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
<table border="1" class="rtw-form-view" style="margin-bottom: :10px !important;border-collapse:collapse;
width:100%;margin:auto;font-family: calibri;border: 1px solid #fff;background: #edf0f6;">


<tr>
	<td style="padding: 5px;text-align: center;background:#eaa893;color: #13335a;font-weight: 600;">
		Step 3 Copy
	</td>
</tr>

<tr>
	<td style="padding: 5px;">You <b>must</b> make a clear copy of each document in a format which cannot later be
altered, and retain the copy securely; electronically or in hardcopy. You must copy
and retain:</td>
</tr>

<tr>
	<td style="padding: 5px;">
    <div>
             <?php     if(in_array("any page with the document", $timearray)){   ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label> 1.  <b> Passports</b>: any page with the document expiry date, nationality, date of birth,
signature, leave expiry date, biometric details and photograph, and any page
containing information indicating the holder has an entitlement to enter or
remain in the UK and undertake the work in question. 

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
    <label> 2.     <b>All other documents</b>:the document in full, both sides of a biometric residence
permit. <b>You must also record and retain the date on which the check was made.</b>
  </label>

</div>
	
	</td>
</tr>
</table>
<br>
<table border="1" class="rtw-form-view" style="margin-bottom: :10px !important;border-collapse:collapse;
width:100%;margin:auto;font-family: calibri;border: 1px solid #fff;background: #edf0f6;">


<tr>
	<td style="padding: 5px;text-align: center;background:#bbe1f8;color: #13335a;
    font-weight: 600;">
	Know the type of excuse you have
	</td>
</tr>

<tr>
	<td style="padding: 5px;">If you have correctly carried out the above 3 steps you will have an excuse against
liability for a civil penalty if the above named person is found working for you
illegally. However, you need to be aware of the type of excuse you have as this
determines how long it lasts for, and if, and when you are required to do a followup check.</br>The documents that you have checked and copied are from:</p></td>
</tr>


<?php 
		 $timearray=array();
		 $timearray=explode(',',$work_rs->type_of_excuse);
	
	?>
<tr>
	<td style="padding: 5px;">
	    <div class="excuselist" style="padding-left:0;"> 
	     <label> 1.  <b> List A </b> </label>  </div>
    <div class="excuselist" >
         <?php     if(in_array("List A", $timearray)){   ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label>  You have a <b>continuous statutory excuse</b> for the <b>full duration</b> of the
person’s employment with you. You are not required to carry out any repeat right
to work checks on this.

  </label>

</div>
		
	</td>
</tr>
<tr>
	<td style="padding: 5px;">
	     <div class="excuselist" style="padding-left:0;">
	     <label> 2.   <b>List B: Group 1 </b></label>  </div>
    <div class="excuselist">
          <?php     if(in_array("List B: Group 1", $timearray)){   ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label>  You have a <b>time-limited statutory</b> excuse which expires when
the person’s permission to be in the UK expires. You should carry out a <b>follow-up
check when the document evidencing their permission to work expires</b>.

  </label>

</div>
		
	</td>
</tr>
<tr>
	<td style="padding: 5px;">
	     <div class="excuselist" style="padding-left:0;">
	     <label> 3.   <b>List B: Group 2 </b></label> </div>
    <div class="excuselist">
          <?php     if(in_array("List B: Group 2", $timearray)){   ?>
             <img src="<?=env("BASE_URL");?>public/img/checkbox.png" alt=""> <?php }else{ ?>
   <img src="<?=env("BASE_URL");?>public/img/uncheck.png" alt="">  <?php }
             ?>
    <label>  You have a <b>time-limited statutory excuse</b> which expires six
months from the date specified in your Positive Verification Notice. <b>This means that
you should carry out a follow-up check when this notice expires</b>.

  </label>

</div>
		
	</td>
</tr>
</table>

<table border="1" style="margin-bottom: :10px !important;border-collapse:collapse;width:100%;margin:auto;
overflow-x:scroll;font-family: calibri;border: 1px solid #fff;">

<tr>
	<th style="background:#bbe1f8;padding: 8px;">Know the type of excuse you have</th>
	
	<th style="background:#bbe1f8;padding: 8px;">Date followup required</th>
</tr>


<tr>
	<td style="background: #bbe1f8;">List B: (Group 1)</td>
	
	<td style="background: #f0f6f9;">@if($work_rs->list_rightb_date!='') @if($work_rs->list_rightb_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_rightb_date))}} @endif @endif</td>
</tr>

<tr>
	<td style="background: #bbe1f8;">List B: (Group 2)</td>
	
	<td style="background: #f0f6f9;">@if($work_rs->list_rightbs_date!='') @if($work_rs->list_rightbs_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_rightbs_date))}} @endif @endif</td>
</tr>
<tr>
	<td style="background: #bbe1f8;">EUSS</td>
	
	<td style="background: #f0f6f9;">@if($work_rs->list_euss_date!='') @if($work_rs->list_euss_date!='1970-01-01') {{ date('d/m/Y',strtotime($work_rs->list_euss_date))}} @endif @endif</td>
</tr>

</table>

<table style="width:100%;margin:10px auto;margin: bottom 10px !important;" class="rtw-scan-main">
  @if($work_rs->scan_f_img!='')
	<tr>
		<td>
		<div class="text-center rtw-scan" style="font-family: calibri;padding:35px 0;">
                <div class="scan-hd" style="background:#bbe1f8;">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Evidence Scans-1</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste an image of your scanned RTW documents into the grey form field below.</p>
              </div>
              
              <p class="scan-body" style="background: #f0f6f9;margin:0;">
                 
                <?php
             $secod=array();
             if($work_rs->scan_f=='visa_upload_doc'){
                 
                  $secod=explode(",",$work_rs->scan_f_img);
          ?>
         
          <img style="padding:35px 0;" src="<?=env("BASE_URL");?>public/{{$secod[0]}}" width="50%"/>
                     
          <?php
            }else{
               ?>
               
               <img src="<?=env("BASE_URL");?>public/{{$work_rs->scan_f_img}}" width="50%"/>
                 
               <?php
            }
            ?>
              </p>  
                 
              
              <p class="scan-body" style="background: #f0f6f9;margin:0;" id="scan_nse_id"   @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block;margin-top:20px;padding-left:0;" @else style="display:none;margin-top:20px;padding-left:0;" @endif   >
                   
                   @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')
                   <img src="<?=env("BASE_URL");?>public/{{$secod[1]}}" width="50%"/>@else  @endif
              
          </p>    
                
                 
        
              </div>
          </td>
	</tr>
  @endif
  @if($work_rs->scan_s_img!='')
	<tr>
	    
		<td><div class="text-center rtw-scan" style="font-family: calibri;">
                <div class="scan-hd" style="background:#bbe1f8;">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Evidence Scans-2 (If applicable)</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste an image of your scanned RTW documents into the blue form field below.</p>
              </div>

              <p class="scan-body" style="background: #e0f6ff;border-bottom:none;margin: 0;">
                 
                <?php
             $secod=array();
             if($work_rs->scan_s=='visa_upload_doc'){
                 
                  $secod=explode(",",$work_rs->scan_s_img);
          ?>
          
          <img src="<?=env("BASE_URL");?>public/{{$secod[0]}}" width="50%"/>
                     
          <?php
            }else{
               ?>
               

               <img src="<?=env("BASE_URL");?>public/{{$work_rs->scan_s_img}}" width="50%"/>
                 
               <?php
            }
            ?>
              </p>
                 
              
                <p class="scan-body" style="background: #e0f6ff;margin-top: 0;" id="scan_nrse_id"   @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  style="display:block; margin-top:20px;padding-left:0;" @else style="display:none; margin-top:20px;padding-left:0;" @endif    >
                  
                  @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')
                  <img src="<?=env("BASE_URL");?>public/{{$secod[1]}}" width="50%"/>
                  @else  @endif
          
          </p>
          </div>
          </td>
	</tr>
   @endif
        @if($work_rs->scan_r_img!='')
	<tr>
		<td>
			<div class="text-center rtw-scan" style="font-family: calibri;">
                <div class="scan-hd" style="background:#bbe1f8;">
                <h3 style="text-align: center;margin: 0;font-size: 30px;">RTW Report</h3>
                <p style="text-align: center;margin: 0;">Please copy and paste a clear copy/image of RTW check result in the orange form below.</p>
              </div>

              <p class="scan-body" style="background: #ffedcb; margin: 0;border-bottom:none;">
             
                    <?php
             $secod=array();
             if($work_rs->scan_r=='visa_upload_doc'){
                 
                  $secod=explode(",",$work_rs->scan_r_img);
          ?>
          

          <img src="<?=env("BASE_URL");?>public/{{$secod[0]}}" width="50%"/>
                     
          <?php
            }else{
               ?>
               

               <img src="<?=env("BASE_URL");?>public/{{$work_rs->scan_r_img}}" width="50%"/>
                 
               <?php
            }
            ?>
              
                 
              
                <p style="margin-top:0;" id="scan_nrse_id"   @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block; margin-top:20px;padding-left:0;" @else style="display:none; margin-top:20px;padding-left:0;" @endif    >
                  
                  @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')
                  <img src="<?=env("BASE_URL");?>public/{{$secod[1]}}" width="50%"/> @else  @endif 
              
          </p>
          </p>
              <p>Note: For all RTW checks: please complete form, attach the scanned RTW evidence document photos/scans and <u>save as one PDF</u></p>
              </div>
		</td>
	</tr>
	   @endif
</table>


<table border="1" style="margin-top:10px !important;border-collapse:collapse;width: 100%;margin:10px auto;border:1px solid #fff;">
	<tr>
		<td style="background: #bbe1f8;padding:5px;font-size:13px;">RTW check result</td>
		<td style="background: #f0f6f9;padding:5px;font-size:13px;">{{$work_rs->result}}</td>
		<td style="background: #bbe1f8;padding:5px;font-size:13px;">Remarks</td>
		<td style="background: #f0f6f9;padding:5px;font-size:13px;">{{$work_rs->remarks}}</td>
	</tr>
	

	<tr>
		<td style="background: #bbe1f8;padding:5px;font-size:13px;">Checker's Name</td>
		<td style="background: #f0f6f9;padding:5px;font-size:13px;">{{$work_rs->checker}}</td>
		<td style="background: #bbe1f8;padding:5px;font-size:13px;">Contact No.</td>
		<td style="background: #f0f6f9;padding:5px;font-size:13px;">{{$work_rs->contact}}</td>
	</tr>


	<tr>
		<td style="font-size:13px;background: #bbe1f8;padding:5px;background: #bbe1f8">Designation </td>
		<td style="font-size:13px;background: #f0f6f9;padding:5px;">{{$work_rs->designation}} </td>
		<td style="font-size:13px;padding:5px; background: #bbe1f8;">Email Address</td>
		<td style="font-size:13px;background: #f0f6f9;padding:5px;">{{$work_rs->email}}</td>
	</tr>
	
	
</table>	
</body>

</html>