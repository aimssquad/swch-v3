<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}'] },
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>


	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
		@include('circumtance.include.header')
		<!-- Sidebar -->

		@include('circumtance.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="#">
						Home
						</a>
					</li>
					<li class="separator">
					/
					</li>
					<li class="nav-item">
						<a href="#">Edit</a>
					</li>
					<li class="separator">
					/
					</li>
					<li class="nav-item active">
						<a href="{{url('employee/change-of-circumstances-add')}}">Change Of Circumstances</a>
					</li>

				</ul>
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Change Of Circumstances</h4>
									@if(Session::has('message'))
									<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
									@endif
								</div>
								<div class="card-body" style="">
									<form action="{{url('employee/edit-change-cir')}}" method="post" enctype="multipart/form-data">
										{{csrf_field()}}
								    	<input type="hidden" name="newid" value="{{$employee_changers->id}}">
										<div class="row">
										    <div class="col-md-4">
												<div class="form-group">
													<label for="emp_code" class="placeholder">Select Employee</label>
													<select class="form-control input-border-bottom" id="emp_code" name="emp_code" required  onchange="checkemp(this.value);">
														<option value="">&nbsp;</option>
													@foreach($employee_rs as $employee)
														<option value="{{$employee->emp_code}}" @if($employee->emp_code==$employee_changers->emp_code)  selected @endif >
														{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
													@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Employee Code</label>
													<input id="emp_id" readonly type="text" class="form-control " value="{{$employee_changers->emp_code}}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Existing Employee Name</label>
													<input id="emp_name" name="previous_emp_name" readonly type="text" class="form-control " value="{{ $employee_newrs->emp_fname.' '.$employee_newrs->emp_mname.' '.$employee_newrs->emp_lname }}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="emp_fname" class="placeholder">Employee First Name</label>
													<input id="emp_fname" name="emp_fname" readonly type="text" class="form-control " value="{{ $employee_newrs->emp_fname }}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="emp_mname" class="placeholder">Employee Middle Name</label>
													<input id="emp_mname" name="emp_mname"  type="text" class="form-control " value="{{ $employee_newrs->emp_mname }}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Employee Last Name</label>
													<input id="emp_lname" name="emp_lname"  type="text" class="form-control " value="{{ $employee_newrs->emp_lname }}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Department</label>
														<select class="form-control input-border-bottom" id="department"  name="department" onchange="chngdepartment(this.value);">
															<option value="">&nbsp;</option>
															@foreach($department as $dept)
                     										<option value="{{$dept->department_name}}" @if($dept->department_name==$employee_changers->emp_department) selected @endif>{{$dept->department_name}}</option>
                       										@endforeach
														</select>

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Job Title</label>
													<!-- <input id="emp_designation" readonly type="text" class="form-control " name="emp_designation" value="{{$employee_changers->emp_designation}}"> -->

													<select class="form-control input-border-bottom" id="emp_designation"  name="emp_designation">
														<option value="">&nbsp;</option>
														@if(!empty($designation))
					 									@foreach($designation as $desig)
                     									<option value="{{$desig->designation_name}}" @if ($employee_changers->emp_designation == $desig->designation_name) selected @endif>{{$desig->designation_name}}</option>
                       									@endforeach
                       									@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
						    						<label for="emp_ps_phone" class="placeholder">Contact Number</label>
													<input id="emp_ps_phone" type="text"  class="form-control input-border-bottom"  required name="emp_ps_phone" value="{{$employee_changers->emp_ps_phone}}">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
		    										<label for="inputFloatingLabeldob" class="placeholder">Date of Birth </label>
													<input id="emp_dob" type="date" class="form-control input-border-bottom" name="emp_dob"  value="<?php if ($employee_changers->emp_dob != '1970-01-01') {if ($employee_changers->emp_dob != '') {echo $employee_changers->emp_dob;}}?>">

												</div>
											</div>
	 										<div class="col-md-4">
				   								<div class="form-group">
				       								<label for="inputFloatingLabelni" class="placeholder">NI No.</label>
													<input id="ni_no" type="text" class="form-control input-border-bottom" name="ni_no" value="{{$employee_changers->ni_no}}">

												</div>

											</div>
											<div class="col-md-4">
  												<div class="form-group">
      												<label for="selectFloatingLabel3" class="placeholder">Select Nationality</label>
													<select class="form-control input-border-bottom" id="nationality" name="nationality">
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}" <?php if ($employee_changers->nationality == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
                       									@endforeach
													</select>

												</div>
  											</div>
									   	</div>
                						<h4  class="card-title">Contact Information (Correspondence Address)</h4>
										<hr>
                   						<div class="row form-group">
                       						<div class="col-md-4">
												<div class="form-group">
													<label for="parmenent_pincode" class="placeholder">Post Code</label>
													<input id="emp_pr_pincode" type="text" class="form-control input-border-bottom"  onchange="getcode();"   name="emp_pr_pincode"  value="{{$employee_changers->emp_pr_pincode}}">
												</div>
											</div>
											<div class="col-md-4">
											 	<div class="form-group">
											     	<label for="se_add" class="placeholder">Select Address  </label>
													<select class="form-control input-border-bottom" id="se_add" name="se_add" onchange="countryfunjj(this.value);">
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
			    									<label for="parmenent_street_name" class="placeholder">Adress Line 1</label>
													<input id="emp_pr_street_no" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no"   value="{{$employee_changers->emp_pr_street_no}}">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
			    									<label for="parmenent_village" class="placeholder">Adress Line 2</label>
													<input id="emp_per_village" type="text" class="form-control input-border-bottom"  name="emp_per_village" value="{{$employee_changers->emp_per_village}}">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
			    									<label for="emp_pr_state" class="placeholder">Adress Line 3</label>
													<input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state"  value="{{$employee_changers->emp_pr_state}}">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
		    										<label for="parmenent_city" class="placeholder">City / County</label>
													<input  id="emp_pr_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city"  value="{{$employee_changers->emp_pr_city}}">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
    												<label for="parmenent_country" class="placeholder">Country</label>
													<select class="form-control input-border-bottom"   name="emp_pr_country" id="emp_pr_country">
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}" <?php if ($employee_changers->emp_pr_country == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
											<?php if ($employee_changers->pr_add_proof != '') {?>
												<a href="{{ asset('public/'.$employee_changers->pr_add_proof) }}" download target="_blank" />download</a>
											<?php
											}?>

											<div class="col-md-4">
												<div class="form-group ">
													<label for="pr_add_proof" class="placeholder"> Proof Of Address</label>
													<input  type="file" class="form-control "  name="pr_add_proof" id="pr_add_proof" onchange="Filevalidationdoproff()">
													<small> Please select  file which size up to 2mb</small>

												</div>
											</div>
										</div>
										<h4 style="color: #1269db;">Passport Details</h4>
                						<hr>
                   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group">
    												<label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>
    												<input id="pass_doc_no" type="text" class="form-control input-border-bottom" name="pass_doc_no"  value="{{$employee_changers->pass_doc_no}}">
												</div>
											</div>
                        					<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
													<select class="form-control input-border-bottom" id="pass_nat" name="pass_nat" >
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->pass_nat == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
    												<label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>
													<input id="place_birth" type="text" class="form-control input-border-bottom" name="place_birth" value="{{$employee_changers->place_birth}}">
												</div>
											</div>
			            					<div class="col-md-3">
												<div class="form-group">
			    									<label for="inputFloatingLabelib" class="placeholder">Issued By</label>
													<input id="issue_by" type="text" class="form-control input-border-bottom"  name="issue_by"  value="{{$employee_changers->issue_by}}">
												</div>
											</div>
				  						</div>
				   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group" >
						    						<label for="inputFloatingLabelid" class="placeholder">Issued Date</label>
													<input id="pas_iss_date" type="date" class="form-control input-border-bottom" name="pas_iss_date" value="<?php if ($employee_changers->pas_iss_date != '1970-01-01') {if ($employee_changers->pas_iss_date != '') {echo $employee_changers->pas_iss_date;}}?>">
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
							    					<label for="pass_exp_date" class="placeholder">Expiry Date</label>
													<input id="pass_exp_date" type="date" class="form-control input-border-bottom" onchange="getreviewdate();"  name="pass_exp_date" value="<?php if ($employee_changers->pass_exp_date != '1970-01-01') {if ($employee_changers->pass_exp_date != '') {echo $employee_changers->pass_exp_date;}}?>">
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
					    							<label for="pass_review_date" class="placeholder" >Eligible Review Date</label>
													<input id="pass_review_date" type="date" class="form-control input-border-bottom" readonly name="pass_review_date" value="<?php if ($employee_changers->pass_review_date != '1970-01-01') {if ($employee_changers->pass_review_date != '') {echo $employee_changers->pass_review_date;}}?>">
												</div>
											</div>
											<div class="col-md-3">
												<label>Upload Document</label>
												<?php if ($employee_changers->pass_docu != '') {?>
														<a href="{{ asset('public/'.$employee_changers->pass_docu) }}" download target="_blank" />download</a>

												<?php
												}?>
												<input type="file" class="form-control"  name="pass_docu" id="pass_docu" onchange="Filevalidationdopassdocu()">
												<small> Please select  file which size up to 2mb</small>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
						  						<div class="form-check">
													<label>Is this your current passport?</label><br>
													<label class="form-radio-label">
														<input class="form-radio-input" type="radio" name="cur_pass" id="cur_pass" value="Yes"  <?php if ($employee_changers->cur_pass == 'Yes') {echo 'checked';}?>>
														<span class="form-radio-sign">Yes</span>
													</label>
													<label class="form-radio-label ml-3">
														<input class="form-radio-input" type="radio" name="cur_pass" id="cur_pass1" value="No"  <?php if ($employee_changers->cur_pass == 'No') {echo 'checked';}?>>
														<span class="form-radio-sign">No</span>
													</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
													<input id="remarks" type="text" class="form-control input-border-bottom" name="remarks" value="{{$employee_changers->remarks}}">
												</div>
											</div>
										</div>
				   						<br>
				   						<h4 style="color: #1269db;">Visa/BRP details</h4>
              							<hr>
                   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group ">
													<label for="inputFloatingLabeldn1" class="placeholder">Visa/BRP No.</label>
													<input id="visa_doc_no" type="text" class="form-control input-border-bottom"  name="visa_doc_no"  value="{{$employee_changers->visa_doc_no}}">
												</div>
											</div>
                        					<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
													<select class="form-control input-border-bottom" id="visa_nat"  name="visa_nat" >
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
														<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->visa_nat == trim($currency_valu->country)) {echo 'selected';}?> >{{$currency_valu->country}}</option>
														@endforeach

													</select>
												</div>
											</div>
											<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabel" class="placeholder">Country of Residence</label>
													<select class="form-control input-border-bottom" id="country_residence"  name="country_residence" >
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->country_residence == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
			            					<div class="col-md-3">
												<div class="form-group">
			    									<label for="inputFloatingLabelib1" class="placeholder">Issued By</label>
			    									<input id="visa_issue" type="text" class="form-control input-border-bottom"  name="visa_issue"  value="{{$employee_changers->visa_issue}}">
												</div>
											</div>
				  						</div>
				   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group">
						    						<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>
													<input id="visa_issue_date" type="date" class="form-control input-border-bottom" name="visa_issue_date" value=" <?php if ($employee_changers->visa_issue_date != '1970-01-01') {if ($employee_changers->visa_issue_date != '') {echo $employee_changers->visa_issue_date;}}?>">
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group" >
							    					<label for="visa_exp_date" class="placeholder">Expiry Date</label>
							    					<input id="visa_exp_date" onchange="getreviewvisdate();" type="date" class="form-control input-border-bottom" name="visa_exp_date" value="<?php if ($employee_changers->visa_exp_date != '1970-01-01') {if ($employee_changers->visa_exp_date != '') {echo $employee_changers->visa_exp_date;}}?>">
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
					    							<label for="visa_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
					    							<input id="visa_review_date" type="date" value="<?php if ($employee_changers->visa_review_date != '1970-01-01') {if ($employee_changers->visa_review_date != '') {echo $employee_changers->visa_review_date;}}?>" readonly class="form-control input-border-bottom" name="visa_review_date">
												</div>
											</div>
											<div class="col-md-3">
												<label>Upload Document</label>
												<?php if ($employee_changers->visa_upload_doc != '') {?>
													<a href="{{ asset('public/'.$employee_changers->visa_upload_doc) }}" download target="_blank" />download</a>
												<?php
												}?>
												<input type="file" class="form-control" name="visa_upload_doc" id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
												<small> Please select  file which size up to 2mb</small>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-check">
													<label>Is this your current passport?</label><br>
													<label class="form-radio-label">
														<input class="form-radio-input" type="radio" name="visa_cur" id="visa_cur" value="Yes"  <?php if ($employee_changers->visa_cur == 'Yes') {echo 'checked';}?>>
														<span class="form-radio-sign">Yes</span>
													</label>
													<label class="form-radio-label ml-3">
														<input class="form-radio-input" type="radio" name="visa_cur" id="visa_cur1" value="No" <?php if ($employee_changers->visa_cur == 'No') {echo 'checked';}?> >
														<span class="form-radio-sign">No</span>
													</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
													<input id="visa_remarks" type="text" class="form-control input-border-bottom" name="visa_remarks" value="{{$employee_changers->visa_remarks}}">
												</div>
											</div>
										</div>
										<br>
										<hr>
										<h4 style="color: #1269db;">EUSS/Time limit details </h4>
										<div class="multisteps-form__content">
											<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label for="euss_ref_no" class="placeholder">Reference Number.</label>
															<input id="euss_ref_no" type="text" class="form-control input-border-bottom"  name="euss_ref_no"  value="{{$employee_changers->euss_ref_no}}">
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="euss_nation" class="placeholder">Nationality</label>
															<select class="form-control input-border-bottom" id="euss_nation"  name="euss_nation" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->euss_nation;}?>">
																	<option value="">&nbsp;</option>

															@foreach($currency_user as $currency_valu)
																<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->euss_nation == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
															@endforeach
															</select>

														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="euss_issue_date" class="placeholder">Issued Date</label>
															<input id="euss_issue_date" type="date" class="form-control input-border-bottom" name="euss_issue_date" value="<?php if ($employee_changers->euss_issue_date != '1970-01-01') {if ($employee_changers->euss_issue_date != '') {echo $employee_changers->euss_issue_date;}}?>">
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group" >
															<label for="euss_exp_date" class="placeholder">Expiry Date</label>
															<input id="euss_exp_date" type="date" class="form-control input-border-bottom" name="euss_exp_date"
																onchange="getrevieweussdate();"  value="<?php if ($employee_changers->euss_exp_date != '1970-01-01') {if ($employee_changers->euss_exp_date != '') {echo $employee_changers->euss_exp_date;}}?>">
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="euss_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
															<input id="euss_review_date" type="date" readonly class="form-control input-border-bottom" name="euss_review_date"   value="<?php if ($employee_changers->euss_review_date != '1970-01-01') {if ($employee_changers->euss_review_date != '') {echo $employee_changers->euss_review_date;}}?>">
														</div>
													</div>
													<div class="col-md-3">
														<label>Upload Document</label><span id="download_euss_upload_doc"></span>
														<input type="file" class="form-control" name="euss_upload_doc" id="euss_upload_doc" onchange="Filevalidationdopassduploadae()">
														<small> Please select  file which size up to 2mb</small>
													</div>
													<div class="col-md-3">
														<div class="form-check">
															<label>Is this your current status?</label><br>
															<label class="form-radio-label">
																<input class="form-radio-input" type="radio"  <?php if ($employee_changers->euss_cur == 'Yes') {echo 'checked';}?> name="euss_cur" id="euss_cur" value="Yes" checked="">
																<span class="form-radio-sign">Yes</span>
															</label>
															<label class="form-radio-label ml-3">
																<input class="form-radio-input" type="radio" name="euss_cur"  id="euss_cur1" <?php if ($employee_changers->euss_cur == 'No') {echo 'checked';}?>  value="No">
																<span class="form-radio-sign">No</span>
															</label>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="euss_remarks" class="placeholder">Remarks</label>
															<input id="euss_remarks" type="text"  value="<?php echo $employee_changers->euss_remarks;?>"  class="form-control input-border-bottom" name="euss_remarks" >
														</div>
													</div>
												</div>
											</div>

										<br><hr>
										<h4 style="color: #1269db;">Disclosure and Barring Service (DBS) details </h4><hr>
                						<div class="multisteps-form__content">
                   							<div class="row">
				   								<div class="col-md-3">
													<div class="form-group">
														<label for="inputFloatingLabeldn1" class="placeholder">DBS Type</label>
														<select class="form-control input-border-bottom" id="dbs_type"  name="dbs_type" >
																<option value="">&nbsp;</option>
																<option value="Basic"  <?php if ($employee_changers->dbs_type == "Basic") {echo 'selected';}?>>Basic</option>
																<option value="Standard"  <?php if ($employee_changers->dbs_type == "Standard") {echo 'selected';}?>>Standard</option>
																<option value="Advanced"  <?php if ($employee_changers->dbs_type == "Advanced") {echo 'selected';}?>>Advanced</option>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="inputFloatingLabeldn1" class="placeholder">Reference Number.</label>
														<input id="dbs_ref_no" type="text" class="form-control input-border-bottom"  name="dbs_ref_no"  value="{{$employee_changers->dbs_ref_no}}">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_nation" class="placeholder">Nationality</label>
														<select class="form-control input-border-bottom" id="dbs_nation"  name="dbs_nation" >
																<option value="">&nbsp;</option>

														@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->dbs_nation == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
														@endforeach
														</select>

													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_issue_date" class="placeholder">Issued Date</label>
														<input id="dbs_issue_date" type="date" class="form-control input-border-bottom" name="dbs_issue_date" value="<?php if ($employee_changers->dbs_issue_date != '1970-01-01') {if ($employee_changers->dbs_issue_date != '') {echo $employee_changers->dbs_issue_date;}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" >
														<label for="dbs_exp_date" class="placeholder">Expiry Date</label>
														<input id="dbs_exp_date" type="date" class="form-control input-border-bottom" name="dbs_exp_date"
															onchange="getreviewdbsdate();"  value="<?php if ($employee_changers->dbs_exp_date != '1970-01-01') {if ($employee_changers->dbs_exp_date != '') {echo $employee_changers->dbs_exp_date;}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
														<input id="dbs_review_date" type="date" readonly class="form-control input-border-bottom" name="dbs_review_date"   value="<?php if ($employee_changers->dbs_review_date != '1970-01-01') {if ($employee_changers->dbs_review_date != '') {echo $employee_changers->dbs_review_date;}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<label>Upload Document</label><?php if ($employee_changers->dbs_upload_doc != '') {?>
													<a href="{{ asset('public/'.$employee_changers->dbs_upload_doc) }}" download target="_blank" />download</a>

													<?php
													}?>

													<input type="file" class="form-control" name="dbs_upload_doc" id="dbs_upload_doc" onchange="Filevalidationdopassduploadae()">
													<small> Please select  file which size up to 2mb</small>
												</div>
												<div class="col-md-3">
													<div class="form-check">
														<label>Is this your current status?</label><br>
														<label class="form-radio-label">
															<input class="form-radio-input" type="radio" id="dbs_cur"  name="dbs_cur" value="Yes" <?php if ($employee_changers->dbs_cur == 'Yes') {echo 'checked';}?>>
															<span class="form-radio-sign">Yes</span>
														</label>
														<label class="form-radio-label ml-3">
															<input class="form-radio-input" type="radio" name="dbs_cur"  id="dbs_cur1"  value="No" <?php if ($employee_changers->dbs_cur == 'No') {echo 'checked';}?>>
															<span class="form-radio-sign">No</span>
														</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_remarks" class="placeholder">Remarks</label>
														<input id="dbs_remarks" type="text"  value="{{$employee_changers->dbs_remarks}}"  class="form-control input-border-bottom" name="dbs_remarks" >
													</div>
												</div>
											</div>

										</br>
				    					<hr>
				      					<h4 style="color: #1269db;">National Id details  </h4>
                						<div class="multisteps-form__content">
                   							<div class="row">
				   								<div class="col-md-3">
													<div class="form-group">
														<label for="nat_id_no" class="placeholder">National id number.</label>
														<input id="nat_id_no" type="text" class="form-control input-border-bottom"  name="nat_id_no"  value="<?php echo $employee_changers->nat_id_no;?>">
													</div>
												</div>
                        						<div class="col-md-3">
				  									<div class="form-group">
				      									<label for="nat_nation" class="placeholder">Nationality</label>
														<select class="form-control input-border-bottom" id="nat_nation"  name="nat_nation" value="<?php echo $employee_changers->nat_nation;?>">
															<option value="">&nbsp;</option>
															@foreach($currency_user as $currency_valu)
                     										<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->nat_nation == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
					  										@endforeach
														</select>
													</div>
												</div>
						  						<div class="col-md-3">
				  									<div class="form-group">
														<label for="nat_country_res" class="placeholder">Country of Residence</label>
														<select class="form-control input-border-bottom" id="nat_country_res"  name="nat_country_res" value="<?php echo $employee_changers->nat_nation;?>">
															<option value="">&nbsp;</option>
															@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}"  <?php if ($employee_changers->nat_country_res == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="nat_issue_date" class="placeholder">Issued Date</label>
														<input id="nat_issue_date" type="date" class="form-control input-border-bottom" name="nat_issue_date" value="<?php if ($employee_changers->nat_issue_date != '1970-01-01') {if ($employee_changers->nat_issue_date != '') {echo $employee_changers->nat_issue_date;}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" >
														<label for="nat_exp_date" class="placeholder">Expiry Date</label>
															<input id="nat_exp_date" type="date" class="form-control input-border-bottom" name="nat_exp_date" onchange="getreviewnatdate();"  value="<?php if ($employee_changers->nat_exp_date != '1970-01-01') {if ($employee_changers->nat_exp_date != '') {echo $employee_changers->nat_exp_date;}}?>">
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group">
					    								<label for="nat_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
					    								<input id="nat_review_date" type="date" readonly class="form-control input-border-bottom" name="nat_review_date"   value="<?php if ($employee_changers->nat_review_date != '1970-01-01') {if ($employee_changers->nat_review_date != '') {echo $employee_changers->nat_review_date;}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<label>Upload Document</label><span id="download_nat_upload_doc"></span>
													</br>

													<input type="file" class="form-control" name="nat_upload_doc" id="nat_upload_doc" onchange="Filevalidationdopassduploadnat()">
								 					<small> Please select  file which size up to 2mb</small>
												</div>
												<div class="col-md-3">
													<div class="form-check">
														<label>Is this your current status?</label><br>
														<label class="form-radio-label">
															<input class="form-radio-input" type="radio"  <?php if ($employee_changers->nat_cur == 'Yes') {echo 'checked';}?> name="nat_cur" id="nat_cur" value="Yes" checked="">
															<span class="form-radio-sign">Yes</span>
														</label>
														<label class="form-radio-label ml-3">
															<input class="form-radio-input" type="radio" name="nat_cur" id="nat_cur1" <?php if ($employee_changers->nat_cur == 'No') {echo 'checked';}?>  value="No">
															<span class="form-radio-sign">No</span>
														</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
								    					<label for="nat_remarks" class="placeholder">Remarks</label>
														<input id="nat_remarks" type="text"  value="<?php echo $employee_changers->nat_remarks;?>"  class="form-control input-border-bottom" name="nat_remarks" >
													</div>
												</div>
											</div>

										<br>
						   				<h4 style="color: #1269db;">Other  details </h4><hr>
                						<div class="multisteps-form__content">
											<?php $truotherdocpload_id = 0;
											$countpayuppasother = count($employee_otherd_doc_rs);?>
											<div id="dynamic_row_upload_other">
											@if ($countpayuppasother!=0)
											@foreach($employee_otherd_doc_rs as $empuprs)
                   								<div class="row itemslototherupload" id="<?php echo $truotherdocpload_id; ?>">
				   									<div class="col-md-3">
														<div class="form-group form-floating-label">
															<input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_name_{{ $empuprs->id}}" value="{{ $empuprs->doc_name}}">
															<label for="inputFloatingLabeldn1" class="placeholder">Document name.</label>
														</div>
													</div>
				   									<div class="col-md-3">
														<div class="form-group form-floating-label">
															<input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"   name="doc_ref_no_{{ $empuprs->id}}" value="{{ $empuprs->doc_ref_no}}">
															<label for="inputFloatingLabeldn1" class="placeholder">Document reference number.</label>
														</div>
													</div>
			            							<div class="col-md-3">
				  										<div class="form-group form-floating-label">
															<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation_{{ $empuprs->id}}" >
																<option value="">&nbsp;</option>
																@foreach($currency_user as $currency_valu)
                     											<option value="{{trim($currency_valu->country)}}"  <?php if ($empuprs->doc_nation == trim($currency_valu->country)) {echo 'selected';}?>>{{$currency_valu->country}}</option>
                       											@endforeach
															</select>
															<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
														</div>
													</div>
				   									<div class="col-md-3">
														<div class="form-group form-floating-label">
															<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom"   name="doc_issue_date_{{ $empuprs->id}}" value="<?php if ($empuprs->doc_issue_date != '' && $empuprs->doc_issue_date != '1970-01-01') {echo $empuprs->doc_issue_date;}?>" >
															<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>
														</div>
													</div>
													<input type="hidden" class="form-control" name="emqliotherdoc[]" value="{{ $empuprs->id}}"></td>
				   									<div class="col-md-3">
														<div class="form-group form-floating-label" >
															<input id="doc_exp_date<?php echo $truotherdocpload_id; ?>" type="date" class="form-control input-border-bottom"  name="doc_exp_date_{{ $empuprs->id}}" value="<?php if ($empuprs->doc_exp_date != '' && $empuprs->doc_exp_date != '1970-01-01') {echo $empuprs->doc_exp_date;}?>" onchange="getreviewnatdateother(<?php echo $truotherdocpload_id; ?>);">
															<label for="doc_exp_date" class="placeholder">Expiry Date</label>
														</div>
													</div>
				   									<div class="col-md-3">
														<div class="form-group form-floating-label">
															<input id="doc_review_date<?php echo $truotherdocpload_id; ?>" type="date" readonly class="form-control input-border-bottom"  name="doc_review_date_{{ $empuprs->id}}" value="<?php if ($empuprs->doc_review_date != '' && $empuprs->doc_review_date != '1970-01-01') {echo $empuprs->doc_review_date;}?>">
															<label for="doc_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
														</div>
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
																<input class="form-radio-input" type="radio" name="doc_cur_{{ $empuprs->id}}" value="Yes"   <?php if ($empuprs->doc_cur == 'Yes') {echo 'checked';}?>>
																<span class="form-radio-sign">Yes</span>
															</label>
															<label class="form-radio-label ml-3">
																<input class="form-radio-input" type="radio"  value="No" name="doc_cur_{{ $empuprs->id}}" <?php if ($empuprs->doc_cur == 'No') {echo 'checked';}?>>
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
													<?php $truotherdocpload_id++;?>
					  								@if ($truotherdocpload_id==($countpayuppasother))
				 									<div class="col-md-4" style="margin-top:13px;">
														<button class="btn btn-success" type="button"  id="adduploadother<?php echo $truotherdocpload_id; ?>" onClick="addnewrowuploadother(<?php echo $truotherdocpload_id; ?>)" data-id="<?php echo $truotherdocpload_id; ?>"><i class="fas fa-plus"></i> </button>
													</div>
													@endif
												</div>
				    							</br>
											@endforeach
											@endif
											@if ($countpayuppasother==0)
											<div class="row itemslototherupload" id="<?php echo $truotherdocpload_id; ?>">
				   								<div class="col-md-3">
													<div class="form-group form-floating-label">
														<input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_name[]">
														<label for="inputFloatingLabeldn1" class="placeholder">Document name.</label>
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group form-floating-label">
														<input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_ref_no[]">
														<label for="inputFloatingLabeldn1" class="placeholder">Document reference number.</label>
													</div>
												</div>
			            						<div class="col-md-3">
				  									<div class="form-group form-floating-label">
														<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation[]" >
															<option value="">&nbsp;</option>
															@foreach($currency_user as $currency_valu)
                     										<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       										@endforeach
														</select>
														<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group form-floating-label">
														<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="doc_issue_date[]">
														<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group form-floating-label" >
														<input id="doc_exp_date<?php echo $truotherdocpload_id; ?>" type="date" class="form-control input-border-bottom" name="doc_exp_date[]" onchange="getreviewnatdateother(<?php echo $truotherdocpload_id; ?>);">
														<label for="doc_exp_date" class="placeholder">Expiry Date</label>
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group form-floating-label">
														<input id="doc_review_date<?php echo $truotherdocpload_id; ?>" type="date" readonly class="form-control input-border-bottom" name="doc_review_date[]">
														<label for="doc_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
													</div>
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
		 										<div class="col-md-4" style="margin-top:13px;">
													<button class="btn btn-success" type="button"  id="adduploadother<?php echo $truotherdocpload_id; ?>" onClick="addnewrowuploadother(<?php echo $truotherdocpload_id; ?>)" data-id="<?php echo $truotherdocpload_id; ?>"><i class="fas fa-plus"></i> </button>
												</div>
											</div>
				    						</br>
											@endif
				   						</div>

										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="date_change" class="placeholder" >Changed Date</label>
													<input id="date_change" type="date"  value="<?php if ($employee_changers->date_change != '1970-01-01') {if ($employee_changers->date_change != '') {echo $employee_changers->date_change;}}?>" class="form-control input-border-bottom" required name="date_change" >
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="res_remark" class="placeholder">Remarks/Restriction to work</label>
													<input id="res_remark" type="text" class="form-control input-border-bottom" name="res_remark"   value="{{$employee_changers->res_remark}}">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="hr" class="placeholder">Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details</label>
													<select id="hr"  class="form-control input-border-bottom" required   name="hr">
														<option value="">&nbsp;</option>
														<option value="Yes"  <?php if ($employee_changers->hr == 'Yes') {echo 'selected';}?>>Yes</option>
														<option value="No" <?php if ($employee_changers->hr == 'No') {echo 'selected';}?>>No</option>
														<option value="N/A" <?php if ($employee_changers->hr == 'N/A') {echo 'selected';}?>>N/A</option>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="home" class="placeholder">Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?
													</label>
													<select id="home"  class="form-control input-border-bottom" required   name="home">
														<option value="">&nbsp;</option>
														<option value="Yes"  <?php if ($employee_changers->home == 'Yes') {echo 'selected';}?>>Yes</option>
														<option value="No" <?php if ($employee_changers->home == 'No') {echo 'selected';}?>>No</option>
														<option value="N/A" <?php if ($employee_changers->home == 'N/A') {echo 'selected';}?>>N/A</option>
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

   function chngdepartment(empid){

$.ajax({
type:'GET',
url:'{{url('pis/getEmployeedesigById')}}/'+empid,
cache: false,
success: function(response){


 document.getElementById("emp_designation").innerHTML = response;
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

	function getreviewdbsdate(){
		var empid=document.getElementById("dbs_exp_date").value;

		$.ajax({
			type:'GET',
			url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        	cache: false,
			success: function(response){
				console.log(response);

			 	$("#dbs_review_date").val(response);
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



	function checkemp(val){
		var empid=val;

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeetaxempByIdnewemployee')}}/'+empid,
        cache: false,
		success: function(response){

			 var obj = jQuery.parseJSON(response);
				console.log(obj);
			  var emp_code=obj.emp_code;
			 var emp_name=obj.emp_fname+" "+obj.emp_mname+" "+obj.emp_lname;
			 $.ajax({
				type:'GET',
				url:'{{url('pis/getEmployeedesigById')}}/'+obj[0].emp_department,
				cache: false,
				success: function(response){
					document.getElementById("emp_designation").innerHTML = response;
					$("#emp_designation").val(obj[0].emp_designation);
				}
			});

				  $("#emp_id").val(emp_code);
				   $("#emp_name").val(emp_name);
				   $("#emp_fname").val(emp_fname);
				   $("#emp_mname").val(emp_mname);
				   $("#emp_lname").val(emp_lname);
				    $("#emp_id").attr("readonly", true);
					 $("#emp_name").attr("readonly", true);

					 $("#department").val(obj[0].emp_department);
					 // $("#emp_designation").val(obj.emp_designation);
				    $("#emp_designation").attr("readonly", true);
				     if(obj.emp_dob!='1970-01-01'){
				     $("#emp_dob").val(obj.emp_dob);
				     }
				        $("#emp_ps_phone").val(obj.emp_ps_phone);
				         $("#ni_no").val(obj.ni_no);
				          $("#nationality").val(obj.nationality);


				           $("#emp_pr_street_no").val(obj.emp_pr_street_no);
				            $("#emp_per_village").val(obj.emp_per_village);
				             $("#emp_pr_state").val(obj.emp_pr_state);
				              $("#emp_pr_city").val(obj.emp_pr_city);
				               $("#emp_pr_pincode").val(obj.emp_pr_pincode);
				                $("#emp_pr_country").val(obj.emp_pr_country);

				                 $("#pass_doc_no").val(obj.pass_doc_no);
				            $("#pass_nat").val(obj.pass_nat);
				             $("#place_birth").val(obj.place_birth);
				              $("#issue_by").val(obj.issue_by);
				                if(obj.pas_iss_date!='1970-01-01'){
				               $("#pas_iss_date").val(obj.pas_iss_date);
				                }
				                if(obj.pass_exp_date!='1970-01-01'){
				                $("#pass_exp_date").val(obj.pass_exp_date);
				                }
				                 if(obj.pass_review_date!='1970-01-01'){
				                $("#pass_review_date").val(obj.pass_review_date);
				                 }
				                $("#remarks").val(obj.remarks);
				                if(obj.cur_pass=='Yes'){
				                     $("#cur_pass").attr("checked", true);

				                }else{
				                   $("#cur_pass1").attr("checked", true);

				                }

				                 $("#visa_doc_no").val(obj.visa_doc_no);
				            $("#visa_nat").val(obj.visa_nat);
				             $("#country_residence").val(obj.country_residence);
				              $("#visa_issue").val(obj.visa_issue);
				              if(obj.visa_issue_date!='1970-01-01'){
				               $("#visa_issue_date").val(obj.visa_issue_date);
				              }
				               if(obj.visa_exp_date!='1970-01-01'){
				                $("#visa_exp_date").val(obj.visa_exp_date);
				               }
				                 if(obj.visa_review_date!='1970-01-01'){
				                $("#visa_review_date").val(obj.visa_review_date);
				                 }
				                $("#visa_remarks").val(obj.visa_remarks);
				                if(obj.visa_cur=='Yes'){
				                     $("#visa_cur").attr("checked", true);

				                }else{
				                   $("#visa_cur1").attr("checked", true);

				                }



		}
		});
	}

	function getcode(){

    var getaddres=$("#emp_pr_pincode").val();
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


			   $("#emp_pr_country").val(obj.country);
			    $("#emp_pr_street_no").val(obj.address);
			     $("#emp_per_village").val(obj.address2);
			      $("#emp_pr_state").val(obj.road);
			      $("#emp_pr_city").val(obj.city);
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
