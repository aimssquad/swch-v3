<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assetsemcor/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
		
 		
  @include('employee-corner.include.header')
		<!-- Sidebar -->
		
		  @include('employee-corner-organisation.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Change Of Circumstances</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Employee Access Value</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('employee-corner/change-of-circumstances')}}">Change Of Circumstances</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"> Change Of Circumstances</h4>
									@if(Session::has('message'))										
							<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body" style="">
									<form action="{{url('employee-corner/circumstances-edit')}}" method="post" enctype="multipart/form-data">
											 {{csrf_field()}}
											 <input  type="hidden" class="form-control input-border-bottom" required=""  name="emp_code"  value="{{ $employee_rs->emp_code}}">
										
										<div class="row">
									<div class="col-md-4">
						<div class="form-group ">
						<label for="inputFloatingLabel" class="placeholder">Employee Code</label>
												<input id="inputFloatingLabel" readonly type="text" class="form-control " value="{{ $employee_rs->emp_code }}">
												
											</div>
					</div>
											<div class="col-md-4">
						<div class="form-group ">
						<label for="inputFloatingLabel" class="placeholder">Employee Name</label>
												<input id="inputFloatingLabel" readonly type="text" class="form-control " value="{{ $employee_rs->emp_fname." ".$employee_rs->emp_mname." ".$employee_rs->emp_lname }}">
												
											</div>
					</div>
								<div class="col-md-4">
						<div class="form-group ">
						<label for="inputFloatingLabel" class="placeholder">Job Title</label>
												<input id="inputFloatingLabel" readonly type="text" class="form-control " name="emp_designation" value="{{ $employee_rs->emp_designation}}">
												
											</div>
					</div>
									
												 
									
								
									
									
													<div class="col-md-4">
						<div class="form-group form-floating-label">
												<input id="emp_ps_phone" type="text"  class="form-control input-border-bottom"  required name="emp_ps_phone" value="{{ $employee_rs->emp_ps_phone}}">
												<label for="emp_ps_phone" class="placeholder">Contact Number</label>
											</div>
					</div>
					<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabeldob" type="date" class="form-control input-border-bottom" name="emp_dob" value="<?php   if($employee_rs->emp_dob!='1970-01-01'){ if($employee_rs->emp_dob!=''){ echo $employee_rs->emp_dob;} }  ?>">
		<label for="inputFloatingLabeldob" class="placeholder">Date of Birth </label>
	</div>
	</div>
	 <div class="col-md-4">
				   <div class="form-group form-floating-label">
<input id="inputFloatingLabelni" type="text" class="form-control input-border-bottom" name="ni_no" value="<?php  echo $employee_rs->ni_no; ?>">
<label for="inputFloatingLabelni" class="placeholder">NI No.</label>
</div>

</div>
<div class="col-md-4">
  <div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel3" name="nationality">
<option value="">&nbsp;</option>
@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php   if($employee_rs->nationality==trim($currency_valu->country)){ echo 'selected';}  ?>>{{$currency_valu->country}}</option>
                       @endforeach
</select>
<label for="selectFloatingLabel3" class="placeholder">Select Nationality</label>
</div>
  </div>
					
					
							
									   </div>

                <h4  class="card-title">Contact Information (Correspondence Address)</h4>
                <hr>
                   <div class="row form-group">
                       <div class="col-md-4">
<div class="form-group form-floating-label">
<input id="parmenent_pincode" type="text" class="form-control input-border-bottom" onchange="getcode();"  name="emp_pr_pincode" value="<?php   echo $employee_rs->emp_pr_pincode; ?>">
<label for="parmenent_pincode" class="placeholder">Post Code</label>
</div>
</div>
	<div class="col-md-4">
											
											 <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="se_add" name="se_add" onchange="countryfunjj(this.value);">
											
												</select>
												<label for="se_add" class="placeholder">Select Address  </label>
											</div>
											 </div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="parmenent_street_name" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no"  value="<?php   echo $employee_rs->emp_pr_street_no;  ?>">
												<label for="parmenent_street_name" class="placeholder">Adress Line 1</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="parmenent_village" type="text" class="form-control input-border-bottom"  name="emp_per_village" value="<?php   echo $employee_rs->emp_per_village;  ?>">
												<label for="parmenent_village" class="placeholder">Adress Line 2</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state"  value="<?php  echo $employee_rs->emp_pr_state;  ?>">
												<label for="emp_pr_state" class="placeholder">Adress Line 3</label>
											</div>
		</div>
		

	<div class="col-md-4">
		<div class="form-group form-floating-label">
												<input  id="parmenent_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city" value="<?php   echo $employee_rs->emp_pr_city;  ?>">
												<label for="parmenent_city" class="placeholder">City / County</label>
											</div>
</div>

<div class="col-md-4">

<div class="form-group form-floating-label">
	<select class="form-control input-border-bottom"   name="emp_pr_country" id="parmenent_country">
	<option value="">&nbsp;</option>
	
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if($employee_rs->emp_pr_country==trim($currency_valu->country)){ echo 'selected';} ?>>{{$currency_valu->country}}</option>
                       @endforeach
												</select>
<label for="parmenent_country" class="placeholder">Country</label>
</div>
		
</div>


	<div class="col-md-4">
			<div class="form-group ">
			<?php  if($employee_rs->pr_add_proof!=''){  ?>
			<a href="{{ asset('public/'.$employee_rs->pr_add_proof) }}" download target="_blank" />download</a>
	
<?php
}?>
			<input  type="file" class="form-control "  name="pr_add_proof" id="pr_add_proof" onchange="Filevalidationdoproff()">
			<small> Please select  file which size up to 2mb</small>
			<label for="pr_add_proof" class="placeholder"> Proof Of Address</label>
			</div>
		</div>

</div>

			
																																																																
              
               
				
				
             
			  
			   
			<h4 style="color: #1269db;">Passport Details</h4>
                <hr> 
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no" value="<?php echo $employee_rs->pass_doc_no;  ?>">	
	<label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>	

</div>
</div>	

                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp" name="pass_nat" >
												<option value="">&nbsp;</option>
											
												@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php   if($employee_rs->pass_nat==trim($currency_valu->country)){ echo 'selected';}  ?>>{{$currency_valu->country}}</option>
                       @endforeach
										
												</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
			<div class="col-md-3">
								
<div class="form-group form-floating-label">
<input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom" name="place_birth" value="<?php  echo $employee_rs->place_birth; ?>">
<label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>	

</div>
</div>
			            <div class="col-md-3">
			<div class="form-group form-floating-label">
			<input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by" value="<?php   echo $employee_rs->issue_by;  ?>">
			<label for="inputFloatingLabelib" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
						
						
				  </div>
				  
				  
				  
				   <div class="row">
				   <div class="col-md-3">
							
						<div class="form-group form-floating-label" >	
						<input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" value="<?php    if($employee_rs->pas_iss_date!='1970-01-01'){ if($employee_rs->pas_iss_date!=''){ echo $employee_rs->pas_iss_date;} }  ?>" >	 
			<label for="inputFloatingLabelid" class="placeholder">Issued Date</label>																												</div>
			</div>
				   <div class="col-md-3">
							<div class="form-group form-floating-label">	
							<input id="pass_exp_date" type="date" class="form-control input-border-bottom" onblur="getreviewdate();" name="pass_exp_date" value="<?php   if($employee_rs->pass_exp_date!='1970-01-01'){ if($employee_rs->pass_exp_date!=''){ echo $employee_rs->pass_exp_date;} } ?>">	
			<label for="pass_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label">						
					<input id="pass_review_date" type="date" class="form-control input-border-bottom" readonly name="pass_review_date"  value="<?php  if($employee_rs->pass_review_date!='1970-01-01'){ if($employee_rs->pass_review_date!=''){ echo $employee_rs->pass_review_date;} }  ?>">	
			<label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
						
						<div class="col-md-3">
							<label>Upload Document</label>
@if($employee_rs->pass_docu!='')
<a href="{{ asset('public/'.$employee_rs->pass_docu) }}" target="_blank" download />download</a>
</br>
@endif
								<input type="file" class="form-control"  name="pass_docu" id="pass_docu" onchange="Filevalidationdopassdocu()">
								<small> Please select  file which size up to 2mb</small>
						</div>
						</div>
						
						<div class="row">
						
						<div class="col-md-3">
						  <div class="form-check">
												<label>Is this your current passport?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="cur_pass" value="Yes" <?php   if($employee_rs->cur_pass=='Yes'){ echo 'checked';}  ?>>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="cur_pass" value="No" <?php    if($employee_rs->cur_pass=='No'){ echo 'checked';}  ?>>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
						</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks" value="<?php  echo $employee_rs->remarks;  ?>">
												<label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
											</div>
						</div>
						</div>
				  
				   
				   
				   
				   <br>
				  
				   
				   <h4 style="color: #1269db;">Visa Details</h4>
               <hr>
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="visa_doc_no"  value="<?php  echo $employee_rs->visa_doc_no; ?>">
<label for="inputFloatingLabeldn1" class="placeholder">BRP No.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="visa_nat" >
												<option value="">&nbsp;</option>
							
								@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php if($employee_rs->visa_nat==trim($currency_valu->country)){ echo 'selected';}  ?>>{{$currency_valu->country}}</option>
                       @endforeach					

												</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
<div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabel"  name="country_residence">
												<option value="">&nbsp;</option>
											
											@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if($employee_rs->country_residence==trim($currency_valu->country)){ echo 'selected';}  ?>>{{$currency_valu->country}}</option>
                       @endforeach	
												</select>
												<label for="selectFloatingLabel" class="placeholder">Country of Residence</label>
											</div>
						</div>
			            <div class="col-md-3">
			<div class="form-group form-floating-label"><input id="inputFloatingLabelib1" type="text" class="form-control input-border-bottom"  name="visa_issue" value="<?php echo $employee_rs->visa_issue; ?>">	
			<label for="inputFloatingLabelib1" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
						
				  </div>
				    
					
				  
				  
				   <div class="row">
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="visa_issue_date"  value="<?php   if($employee_rs->visa_issue_date!='1970-01-01'){ if($employee_rs->visa_issue_date!=''){ echo $employee_rs->visa_issue_date;} }  ?>">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="visa_exp_date" onblur="getreviewvisdate();" type="date" class="form-control input-border-bottom" name="visa_exp_date" value="<?php   if($employee_rs->visa_exp_date!='1970-01-01'){ if($employee_rs->visa_exp_date!=''){ echo $employee_rs->visa_exp_date;} }  ?>">	
			<label for="visa_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="visa_review_date" type="date" readonly class="form-control input-border-bottom" name="visa_review_date" value="<?php    if($employee_rs->visa_review_date!='1970-01-01'){ if($employee_rs->visa_review_date!=''){ echo $employee_rs->visa_review_date;} } ?>">	
			<label for="visa_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
@if($employee_rs->visa_upload_doc!='')
<a href="{{ asset('public/'.$employee_rs->visa_upload_doc) }}" download target="_blank" />download</a>
</br>
@endif
		
								<input type="file" class="form-control" name="visa_upload_doc"  id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
								<small> Please select  file which size up to 2mb</small>
						</div>
						
						</div>
						
						<div class="row">
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current passport?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="visa_cur" value="Yes"  <?php   if($employee_rs->visa_cur=='Yes'){ echo 'checked';} ?>>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="visa_cur" value="No"  <?php    if($employee_rs->visa_cur=='No'){ echo 'checked';}  ?>>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="visa_remarks" value="<?php   echo $employee_rs->visa_remarks;  ?>" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
						
						</div>
						
						
						   <h4 style="color: #1269db;">Other  details </h4>
                <div class="multisteps-form__content">
				<?php $truotherdocpload_id=0; 
				
				
				$countpayuppasother= count($employee_otherd_doc_rs)	;?>
				<div id="dynamic_row_upload_other">
				@if ($countpayuppasother!=0)
											
@foreach($employee_otherd_doc_rs as $empuprs)


                   <div class="row itemslototherupload" id="<?php echo $truotherdocpload_id; ?>">
				   <div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_name_{{ $empuprs->id}}" value="{{ $empuprs->doc_name}}">
<label for="inputFloatingLabeldn1" class="placeholder">Document name.</label>	

</div>
</div>	
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"   name="doc_ref_no_{{ $empuprs->id}}" value="{{ $empuprs->doc_ref_no}}">
<label for="inputFloatingLabeldn1" class="placeholder">Document reference number.</label>	

</div>
</div>	
                    																									
	
			            <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation_{{ $empuprs->id}}" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}"  <?php  if($empuprs->doc_nation==trim($currency_valu->country)){ echo 'selected';}  ?>>{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																											
						 
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom"   name="doc_issue_date_{{ $empuprs->id}}" value="<?php if($empuprs->doc_issue_date!='' && $empuprs->doc_issue_date!='1970-01-01') { echo $empuprs->doc_issue_date;} ?>" >	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
			<input type="hidden" class="form-control" name="emqliotherdoc[]" value="{{ $empuprs->id}}"></td>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="doc_exp_date<?php echo $truotherdocpload_id; ?>" type="date" class="form-control input-border-bottom"  name="doc_exp_date_{{ $empuprs->id}}" value="<?php if($empuprs->doc_exp_date!='' && $empuprs->doc_exp_date!='1970-01-01') { echo $empuprs->doc_exp_date;} ?>"
onchange="getreviewnatdateother(<?php echo $truotherdocpload_id; ?>);">	
			<label for="doc_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="doc_review_date<?php echo $truotherdocpload_id; ?>" type="date" readonly class="form-control input-border-bottom"  name="doc_review_date_{{ $empuprs->id}}" value="<?php if($empuprs->doc_review_date!='' && $empuprs->doc_review_date!='1970-01-01') { echo $empuprs->doc_review_date;} ?>">	
			<label for="doc_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
							 @if($empuprs->doc_upload_doc!='')
<a href="{{ asset('public/'.$empuprs->doc_upload_doc) }}" target="_blank" download />download</a>
</br>
@endif
								<input type="file" class="form-control" name="doc_upload_doc_{{ $empuprs->id}}" id="doc_upload_doc<?php echo $truotherdocpload_id; ?>" onchange="Filevalidationdopassduploadnatother(<?php echo $truotherdocpload_id; ?>)">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
					
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="doc_cur_{{ $empuprs->id}}" value="Yes"   <?php    if($empuprs->doc_cur=='Yes'){ echo 'checked';} ?>>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio"  value="No" name="doc_cur_{{ $empuprs->id}}" <?php    if($empuprs->doc_cur=='No'){ echo 'checked';} ?>>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom"  name="doc_remarks_{{ $empuprs->id}}" value="{{ $empuprs->doc_remarks}}">
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
			
				<?php $truotherdocpload_id++; ?>
					  @if ($truotherdocpload_id==($countpayuppasother))
				 <div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button"  id="adduploadother<?php echo $truotherdocpload_id; ?>" onClick="addnewrowuploadother(<?php echo $truotherdocpload_id; ?>)" data-id="<?php echo $truotherdocpload_id; ?>"><i class="fas fa-plus"></i> </button></div>
				
				
				@endif
						</div>
				  
				    </br>
					@endforeach   
										@endif
										@if ($countpayuppasother==0)
										
										<div class="row itemslototherupload" id="<?php echo $truotherdocpload_id; ?>">
				   <div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_name[]">
<label for="inputFloatingLabeldn1" class="placeholder">Document name.</label>	

</div>
</div>	
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_ref_no[]">
<label for="inputFloatingLabeldn1" class="placeholder">Document reference number.</label>	

</div>
</div>	
                    																									
	
			            <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation[]" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																											
						 
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="doc_issue_date[]">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="doc_exp_date<?php echo $truotherdocpload_id; ?>" type="date" class="form-control input-border-bottom" name="doc_exp_date[]" 
onchange="getreviewnatdateother(<?php echo $truotherdocpload_id; ?>);">	
			<label for="doc_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="doc_review_date<?php echo $truotherdocpload_id; ?>" type="date" readonly class="form-control input-border-bottom" name="doc_review_date[]">	
			<label for="doc_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
								<input type="file" class="form-control" name="doc_upload_doc[]" id="doc_upload_doc<?php echo $truotherdocpload_id; ?>" onchange="Filevalidationdopassduploadnatother(<?php echo $truotherdocpload_id; ?>)">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
					
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="doc_remarks[]" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
		 <div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button"  id="adduploadother<?php echo $truotherdocpload_id; ?>" onClick="addnewrowuploadother(<?php echo $truotherdocpload_id; ?>)" data-id="<?php echo $truotherdocpload_id; ?>"><i class="fas fa-plus"></i> </button></div>
				
						</div>
				  
				    </br>
										
										@endif
				   
				   
				   
				   
				   </div>
				   </div>
				   						<div class="row">
							<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="date_change" type="date" class="form-control input-border-bottom" required name="date_change" >
												<label for="date_change" class="placeholder"  style="margin-top:-24px;">Changed Date</label>
											</div>
						</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="res_remark" type="text" class="form-control input-border-bottom" name="res_remark"  >
												<label for="res_remark" class="placeholder">Remarks/Restriction to work</label>
											</div>
						</div>
							<div class="col-md-6">
							
								<div class="form-group">
								    	<label for="hr" class="placeholder">Are Sponsored migrants aware that they must <BR>inform [HR/line manager] promptly of<br> changes in contact Details</label>
												  <select id="hr"  class="form-control input-border-bottom" required   name="hr">
												      <option value="">&nbsp;</option>
								<option value="Yes"  >Yes</option>
							<option value="No">No</option>
								<option value="N/A">N/A</option>
						</select>
												
												</select>
												
			
											</div>
						</div>
							<div class="col-md-6">
							
								<div class="form-group">
								    <label for="home" class="placeholder">Are Sponsored migrants  aware that they <br>need to cooperate Home Office interview<br> by 
			presenting original passports during the<br> Interview (In applicable cases)?
</label>
												  <select id="home"  class="form-control input-border-bottom" required   name="home">
												      <option value="">&nbsp;</option>
								<option value="Yes"  >Yes</option>
							<option value="No">No</option>
								<option value="N/A">N/A</option>
						</select>
												
												</select>
												
			
											</div>
						</div>
						
							
						
						</div>
				  
				   
				   
				   
				   
				   
				    
			   
				
										<div class="row form-group">
										  <div class="col-md-12">
										   <button type="submit" class="btn btn-default">Submit</button>
										  </div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
		 @include('employee-corner.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
<script src="{{ asset('assetsemcor/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
	
<script> 
   $('#selectFloatingLabel').change(function() {
        $('.write-type').hide();
        $('#' + $(this).val()).show();
 });
 
 
 
</script>

<script>
$('#selectFloatingLabel1').change(function() {
        $('.Other-service-activities').hide();
        $('#' + $(this).val()).show();
 });
 </script>
 <script>
$('#selectFloatingLabel2').change(function() {
        $('.prmt').hide();
        $('#' + $(this).val()).show();
 });
 </script>
<script>
var room = 1;
function education_fields() {
	// alert(room);
 
    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+room);
	var rdiv = 'removeclass'+room;
    divtest.innerHTML = '<div class="row form-group"><div class="col-md-4"><div class="form-group form-floating-label"><select class="form-control input-border-bottom" required="" name="type_doc[]" onchange="checkdoctype('+ room +')" id="d_type'+ room +'"><option value="">&nbsp;</option><option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option><option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option><option value="Proof of Business Premises (Tenancy Agreement)" >Proof of Business Premises (Tenancy Agreement)</option><option value="Franchise Agreement" >Franchise Agreement</option><option value="Copy Of Lease Or Freehold Property" >Copy Of Lease Or Freehold Property</option><option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option><option value="PAYEE And Account Reference Letter From HMRC" >PAYEE And Account Reference Letter From HMRC</option><option value="Governing Body Registration"  >Governing Body Registration</option><option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option><option value="VAT Certificate (if you have)"  >VAT Certificate (if you have)</option><option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option><option value="Others Document"  >Others Document</option></select><label class="placeholder">Type of Document</label></div></div><div class="col-md-4" id="other_doc'+ room +'" style="display:none"><div class="form-group form-floating-label"><label for="newdoc_'+ room +'">Other Doc.Type</label><input type="text" class="form-control input-border-bottom" id="newdoc_'+ room +'" name="other_doc[]"></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlFile1">Upload Document</label><input type="file" class="form-control-file" id="exampleFormControlFile1" name="docu_nat[]"></div><span>*Document Size not more than 300 KB</span></div><div class="col-md-4"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
   
   
    function countryfun(empid){
	   
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getcompanycountryById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("currency").innerHTML = response;
		}
		});
   }
</script>

<script type="text/javascript">
	function checktype(id){
 // alert(id);
		var dtype=$("#doc_type_"+id).val();
		if (dtype=='Others Document') {

			$("#other_doc_"+id).show();
			$("#other_doc_input_"+id).prop('disabled', false);


		}
		else{
			
			$("#other_doc_"+id).hide();
			$("#other_doc_"+id).val('');

		}
	}


	function checkdoctype(rid){
  //alert(rid);
		var dtype1=$("#d_type"+rid).val();
		if (dtype1=='Others Document') {

			$("#other_doc"+rid).show();

		}
		else{
			$("#other_doc"+rid).val('');
			$("#other_doc"+rid).hide();

		}
	}

	function checkfor1sttime()
	{
		var dtype2=$(".checkfor1sttime").val();
		if (dtype3=='Others Document') {

			$("#noalreadydoc").show();

		}
		else{
			$("#noalreadydoc").val('');
			$("#noalreadydoc").hide();

		}
	}
	
	
		$(document).ready(function(){
      $("#filladdress").on("click", function(){
         if (this.checked)
         {
            $("#present_street_name").val($("#parmenent_street_name").val());
            $("#present_city").val($("#parmenent_city").val());
           
            $("#emp_ps_country").val($("#parmenent_country").val());
            $("#present_pincode").val($("#parmenent_pincode").val());
            $("#emp_ps_village").val($("#parmenent_village").val());
              $("#emp_ps_state").val($("#emp_pr_state").val());
            $("#present_street_name").prop("readonly", true);
            $("#present_city").prop("readonly", true);
            $("#emp_ps_country").prop("readonly", true);
            $("#present_state").prop("readonly", true);
            $("#present_pincode").prop("readonly", true);
           
        }
        else
        {
            $("#present_street_name").val('');
            $("#present_city").val('');
            $("#present_country").val('');
             $("#emp_ps_state").val('');
            $("#present_pincode").val('');
            
            $("#present_street_name").prop("readonly", false);
            $("#present_city").prop("readonly", false);
            $("#present_country").prop("readonly", false);
           
            $("#present_pincode").prop("readonly", false);
          
    }
    });

    /*$(document).on('change','#emp_bank_name', function(e){
    	var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
    	$('#emp_ifsc_code').val(ifsccode);

    });*/
});
function crinabi(val) {
	if(val=='Yes'){
	document.getElementById("criman_new").style.display = "block";	
	}else{
		document.getElementById("criman_new").style.display = "none";	
	}
  
}
   
   	function getreviewdate(){
		var empid=document.getElementById("pass_exp_date").value; 
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#pass_review_date").val(response);
		}
		});
	}
	
		function getreviewvisdate(){
		var empid=document.getElementById("visa_exp_date").value; 
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#visa_review_date").val(response);
		}
		});
	}

function getcode(){
    
    var getaddres=$("#parmenent_pincode").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigappaddressByIhhd')}}/'+getaddres,
        cache: false,
		success: function(response){
		
			   $("#se_add").html(response);
			   
		}
		});
    
}
function countryfunjj(value){
    
 
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigappaddressByIhhdjfjjbfg')}}/'+value,
        cache: false,
		success: function(response){
console.log(response);
 var obj = jQuery.parseJSON(response);
			  console.log(obj);
			  
			  
			   $("#parmenent_country").val(obj.country);
			    $("#parmenent_street_name").val(obj.address);
			     $("#parmenent_village").val(obj.address2);
			      $("#emp_pr_state").val(obj.road);
			      $("#parmenent_city").val(obj.city);
		}
		});
    
}	
		Filevalidationdoproff = () => { 
        const fi = document.getElementById('pr_add_proof'); 
        // Check if any file is selected. 
        
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 
                 if (file <= 2048) { 
                    
                } else { 
                  alert( 
                      "File is too Big, please select a file up to 2mb");
                      	$("#pr_add_proof").val('');  
                } 
            } 
        } 
    }
    
    
    
    	Filevalidationdopassdocu = () => { 
        const fi = document.getElementById('pass_docu'); 
        // Check if any file is selected. 
        
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 
                 if (file <= 2048) { 
                    
                } else { 
                  alert( 
                      "File is too Big, please select a file up to 2mb");
                      	$("#pass_docu").val('');  
                } 
            } 
        } 
    }


	Filevalidationdopassdvisae = () => { 
        const fi = document.getElementById('visa_upload_doc'); 
        // Check if any file is selected. 
        
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 
                 if (file <= 2048) { 
                    
                } else { 
                  alert( 
                      "File is too Big, please select a file up to 2mb");
                      	$("#visa_upload_doc").val('');  
                } 
            } 
        } 
    }
	function getreviewnatdateother(val){
		var empid=document.getElementById("doc_exp_date"+val).value; 
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#doc_review_date"+val).val(response);
		}
		});
	}
	
	Filevalidationdopassduploadnatother = (val) => { 
        const fi = document.getElementById('doc_upload_doc'+val); 
        // Check if any file is selected. 
        
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 
                 if (file <= 2048) { 
                    
                } else { 
                  alert( 
                      "File is too Big, please select a file up to 2mb");
                      	$("#doc_upload_doc"+val).val('');  
                } 
            } 
        } 
    }
	
	
		function addnewrowuploadother(rowid)
	{



		if (rowid != ''){
				$('#adduploadother'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('settings/get-add-row-item-upload-other')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row_upload_other").append(response);
					  $('#adduploadother'+rowid).attr('disabled',true);

				}
			});
	}

	
	function delRowuploadother(rowid)
	{
		var lastrow = $(".itemslototherupload:last").attr("id");
		
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#adduploadother'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButtonuploadother',function() {
            $(this).closest("div.itemslototherupload").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
	}
</script>
</body>
</html>