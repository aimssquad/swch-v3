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
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
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
						<a href="#">Add</a>
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
									<form action="{{url('employee/change-of-circumstances-add-new')}}" method="post" enctype="multipart/form-data">
										{{csrf_field()}}
										<div class="row">
										    <div class="col-md-4">
												<div class="form-group">
													<label for="emp_code" class="placeholder">Select Employee</label>
													<select class="form-control input-border-bottom" id="emp_code" name="emp_code" required  onchange="checkemp(this.value);">
														<option value="">&nbsp;</option>
													@foreach($employee_rs as $employee)
                     									<option value="{{$employee->emp_code}}" >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
                       								@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Employee Code</label>
													<input id="emp_id" readonly type="text" class="form-control " value="">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="emp_name" class="placeholder">Existing Employee Name</label>
													<input id="emp_name" name="previous_emp_name"  readonly type="text" class="form-control " value="">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="emp_fname" class="placeholder">Employee First Name</label>
													<input id="emp_fname" name="emp_fname" readonly type="text" class="form-control " value="">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="emp_mname" class="placeholder">Employee Middle Name</label>
													<input id="emp_mname" name="emp_mname"  type="text" class="form-control " value="">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Employee Last Name</label>
													<input id="emp_lname" name="emp_lname"  type="text" class="form-control " value="">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Department</label>
													<select class="form-control input-border-bottom" id="department"  name="department" onchange="chngdepartment(this.value);">
														<option value="">&nbsp;</option>
														@foreach($department as $dept)
															<option value="{{$dept->department_name}}" >{{$dept->department_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<label for="inputFloatingLabel" class="placeholder">Job Title</label>
													<!-- <input id="emp_designation" readonly type="text" class="form-control " name="emp_designation" value=""> -->
													<select class="form-control input-border-bottom" id="emp_designation"  name="emp_designation">
														<option value="">&nbsp;</option>
														@if(!empty($designation))
														@foreach($designation as $desig)
														<option value="{{$desig->designation_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_designation == $desig->designation_name) {echo 'selected';}}?>>{{$desig->designation_name}}</option>
														@endforeach
														@endif
													</select>

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
						    						<label for="emp_ps_phone" class="placeholder">Contact Number</label>
													<input id="emp_ps_phone" type="text"  class="form-control input-border-bottom"  required name="emp_ps_phone" value="">

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
		    										<label for="inputFloatingLabeldob" class="placeholder">Date of Birth </label>
													<input id="emp_dob" type="date" class="form-control input-border-bottom" name="emp_dob" value="">

												</div>
											</div>
	 										<div class="col-md-4">
				   								<div class="form-group">
				       								<label for="inputFloatingLabelni" class="placeholder">NI No.</label>
													<input id="ni_no" type="text" class="form-control input-border-bottom" name="ni_no" value="">

												</div>

											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="selectFloatingLabel3" class="placeholder">Select Nationality</label>
													<select class="form-control input-border-bottom" id="nationality" name="nationality">
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
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
													<input id="emp_pr_pincode" type="text" class="form-control input-border-bottom"  onchange="getcode();"   name="emp_pr_pincode" >

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
													<input id="emp_pr_street_no" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no"  >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
			    									<label for="parmenent_village" class="placeholder">Adress Line 2</label>
													<input id="emp_per_village" type="text" class="form-control input-border-bottom"  name="emp_per_village">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
			    									<label for="emp_pr_state" class="placeholder">Adress Line 3</label>
													<input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state"  >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
		    										<label for="parmenent_city" class="placeholder">City / County</label>
													<input  id="emp_pr_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city" >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
    												<label for="parmenent_country" class="placeholder">Country</label>
													<select class="form-control input-border-bottom"   name="emp_pr_country" id="emp_pr_country">
														<option value="">&nbsp;</option>

														@foreach($currency_user as $currency_valu)
                     										<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
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
    												<input id="pass_doc_no" type="text" class="form-control input-border-bottom" name="pass_doc_no" >
												</div>
											</div>
                        					<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
													<select class="form-control input-border-bottom" id="pass_nat" name="pass_nat" >
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     										<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>
													<input id="place_birth" type="text" class="form-control input-border-bottom" name="place_birth">
												</div>
											</div>
			            					<div class="col-md-3">
												<div class="form-group">
			    									<label for="inputFloatingLabelib" class="placeholder">Issued By</label>
													<input id="issue_by" type="text" class="form-control input-border-bottom"  name="issue_by" >
												</div>
											</div>
				  						</div>
				   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group" >
													<label for="inputFloatingLabelid" class="placeholder">Issued Date</label>
													<input id="pas_iss_date" type="date" class="form-control input-border-bottom" name="pas_iss_date"  >
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
							    					<label for="pass_exp_date" class="placeholder">Expiry Date</label>
													<input id="pass_exp_date" type="date" class="form-control input-border-bottom" onchange="getreviewdate();"  name="pass_exp_date">
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
													<label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
													<input id="pass_review_date" type="date" class="form-control input-border-bottom" readonly name="pass_review_date">
												</div>
											</div>
											<div class="col-md-3">
												<label>Upload Document</label>
												<span id="download_passport_doc"></span>
												</br>
												<input type="file" class="form-control"  name="pass_docu" id="pass_docu" onchange="Filevalidationdopassdocu()">
												<small> Please select  file which size up to 2mb</small>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
						  						<div class="form-check">
													<label>Is this your current passport?</label><br>
													<label class="form-radio-label">
														<input class="form-radio-input" type="radio" name="cur_pass" id="cur_pass" value="Yes">
														<span class="form-radio-sign">Yes</span>
													</label>
													<label class="form-radio-label ml-3">
														<input class="form-radio-input" type="radio" name="cur_pass" id="cur_pass1" value="No" >
														<span class="form-radio-sign">No</span>
													</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
													<input id="remarks" type="text" class="form-control input-border-bottom" name="remarks" >
												</div>
											</div>
										</div>
				   						<br>
				   						<h4 style="color: #1269db;">Visa/BRP details</h4>
              							<hr>
                   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group">
													<label for="inputFloatingLabeldn1" class="placeholder">BRP/Visa No.</label>

													<input id="visa_doc_no" type="text" class="form-control input-border-bottom"  name="visa_doc_no"  >

												</div>
											</div>
                        					<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
													<select class="form-control input-border-bottom" id="visa_nat"  name="visa_nat" >
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-3">
				  								<div class="form-group">
				      								<label for="selectFloatingLabel" class="placeholder">Country of Residence</label>
													<select class="form-control input-border-bottom" id="country_residence"  name="country_residence">
														<option value="">&nbsp;</option>
														@foreach($currency_user as $currency_valu)
                     									<option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       									@endforeach
													</select>
												</div>
											</div>
			            					<div class="col-md-3">
												<div class="form-group">
			    									<label for="inputFloatingLabelib1" class="placeholder">Issued By</label>
			    									<input id="visa_issue" type="text" class="form-control input-border-bottom"  name="visa_issue" >
												</div>
											</div>
				  						</div>
				   						<div class="row">
				   							<div class="col-md-3">
												<div class="form-group">
						    						<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>
													<input id="visa_issue_date" type="date" class="form-control input-border-bottom" name="visa_issue_date"  >
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group" >
							    					<label for="visa_exp_date" class="placeholder">Expiry Date</label>
							    					<input id="visa_exp_date" onchange="getreviewvisdate();" type="date" class="form-control input-border-bottom" name="visa_exp_date" >
												</div>
											</div>
				   							<div class="col-md-3">
												<div class="form-group">
					    							<label for="visa_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
					    							<input id="visa_review_date" type="date" readonly class="form-control input-border-bottom" name="visa_review_date">
												</div>
											</div>
											<div class="col-md-3">
												<label>Upload Document </label><span id="download_visa_upload_doc"></span>
												<input type="file" class="form-control" name="visa_upload_doc"  id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
												<small> Please select  file which size up to 2mb</small>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>Upload  Back Side Document </label><span id="download_visaback_doc"></span>
													<input type="file" class="form-control" name="visaback_doc"  id="visaback_doc" onchange="Filevalidationdopassdvisaeback()">
													<small> Please select  file which size up to 2mb</small>
											</div>
											<div class="col-md-3">
												<div class="form-check">
													<label>Is this your current passport?</label><br>
													<label class="form-radio-label">
														<input class="form-radio-input" type="radio" name="visa_cur" id="visa_cur" value="Yes"  >
														<span class="form-radio-sign">Yes</span>
													</label>
													<label class="form-radio-label ml-3">
														<input class="form-radio-input" type="radio" name="visa_cur" id="visa_cur1" value="No"  >
														<span class="form-radio-sign">No</span>
													</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
													<input id="visa_remarks" type="text" class="form-control input-border-bottom" name="visa_remarks" >
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
														<input id="euss_ref_no" type="text" class="form-control input-border-bottom"  name="euss_ref_no"  value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->euss_ref_no;}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="euss_nation" class="placeholder">Nationality</label>
														<select class="form-control input-border-bottom" id="euss_nation"  name="euss_nation" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->euss_nation;}?>">
																<option value="">&nbsp;</option>

														@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_nation == trim($currency_valu->country)) {echo 'selected';}}?>>{{$currency_valu->country}}</option>
														@endforeach
														</select>

													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="euss_issue_date" class="placeholder">Issued Date</label>
														<input id="euss_issue_date" type="date" class="form-control input-border-bottom" name="euss_issue_date" value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_issue_date != '1970-01-01') {if ($employee_rs[0]->euss_issue_date != '') {echo $employee_rs[0]->euss_issue_date;}}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" >
														<label for="euss_exp_date" class="placeholder">Expiry Date</label>
														<input id="euss_exp_date" type="date" class="form-control input-border-bottom" name="euss_exp_date"
															onchange="getrevieweussdate();"  value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_exp_date != '1970-01-01') {if ($employee_rs[0]->euss_exp_date != '') {echo $employee_rs[0]->euss_exp_date;}}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="euss_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
														<input id="euss_review_date" type="date" readonly class="form-control input-border-bottom" name="euss_review_date"   value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_review_date != '1970-01-01') {if ($employee_rs[0]->euss_review_date != '') {echo $employee_rs[0]->euss_review_date;}}}?>">
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
															<input class="form-radio-input" type="radio"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_cur == 'Yes') {echo 'checked';}}?> name="euss_cur" id="euss_cur" value="Yes" checked="">
															<span class="form-radio-sign">Yes</span>
														</label>
														<label class="form-radio-label ml-3">
															<input class="form-radio-input" type="radio" name="euss_cur"  id="euss_cur1" <?php if (request()->get('q') != '') {if ($employee_rs[0]->euss_cur == 'No') {echo 'checked';}}?>  value="No">
															<span class="form-radio-sign">No</span>
														</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="euss_remarks" class="placeholder">Remarks</label>
														<input id="euss_remarks" type="text"  value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->euss_remarks;}?>"  class="form-control input-border-bottom" name="euss_remarks" >
													</div>
												</div>
											</div>
										</div>
										<br>

										<h4 style="color: #1269db;">Disclosure and Barring Service (DBS) details </h4><hr>
										<div class="multisteps-form__content">
										<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label for="inputFloatingLabeldn1" class="placeholder">DBS Type</label>
														<select class="form-control input-border-bottom" id="dbs_type"  name="dbs_type" >
																<option value="">&nbsp;</option>
																<option value="Basic">Basic</option>
																<option value="Standard">Standard</option>
																<option value="Advanced">Advanced</option>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="inputFloatingLabeldn1" class="placeholder">Reference Number.</label>
														<input id="dbs_ref_no" type="text" class="form-control input-border-bottom"  name="dbs_ref_no"  value="">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_nation" class="placeholder">Nationality</label>
														<select class="form-control input-border-bottom" id="dbs_nation"  name="dbs_nation" >
																<option value="">&nbsp;</option>

														@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}"  >{{$currency_valu->country}}</option>
														@endforeach
														</select>

													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_issue_date" class="placeholder">Issued Date</label>
														<input id="dbs_issue_date" type="date" class="form-control input-border-bottom" name="dbs_issue_date" value="">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" >
														<label for="dbs_exp_date" class="placeholder">Expiry Date</label>
														<input id="dbs_exp_date" type="date" class="form-control input-border-bottom" name="dbs_exp_date"
															onchange="getreviewdbsdate();"  value="">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
														<input id="dbs_review_date" type="date" readonly class="form-control input-border-bottom" name="dbs_review_date"   value="">
													</div>
												</div>
												<div class="col-md-3">
													<label>Upload Document</label><span id="download_dbs_upload_doc"></span>

													<input type="file" class="form-control" name="dbs_upload_doc" id="dbs_upload_doc" onchange="Filevalidationdopassduploadae()">
													<small> Please select  file which size up to 2mb</small>
												</div>
												<div class="col-md-3">
													<div class="form-check">
														<label>Is this your current status?</label><br>
														<label class="form-radio-label">
															<input class="form-radio-input" type="radio" id="dbs_cur"  name="dbs_cur" value="Yes" checked="">
															<span class="form-radio-sign">Yes</span>
														</label>
														<label class="form-radio-label ml-3">
															<input class="form-radio-input" type="radio" name="dbs_cur"  id="dbs_cur1"  value="No">
															<span class="form-radio-sign">No</span>
														</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="dbs_remarks" class="placeholder">Remarks</label>
														<input id="dbs_remarks" type="text"  value=""  class="form-control input-border-bottom" name="dbs_remarks" >
													</div>
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
														<input id="nat_id_no" type="text" class="form-control input-border-bottom"  name="nat_id_no"  value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->nat_id_no;}?>">
													</div>
												</div>
                        						<div class="col-md-3">
				  									<div class="form-group">
				      									<label for="nat_nation" class="placeholder">Nationality</label>
														<select class="form-control input-border-bottom" id="nat_nation"  name="nat_nation" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->nat_nation;}?>">
															<option value="">&nbsp;</option>
															@foreach($currency_user as $currency_valu)
                     										<option value="{{trim($currency_valu->country)}}"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_nation == trim($currency_valu->country)) {echo 'selected';}}?>>{{$currency_valu->country}}</option>
					  										@endforeach
														</select>
													</div>
												</div>
						  						<div class="col-md-3">
				  									<div class="form-group">
														<label for="nat_country_res" class="placeholder">Country of Residence</label>
														<select class="form-control input-border-bottom" id="nat_country_res"  name="nat_country_res" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->nat_nation;}?>">
															<option value="">&nbsp;</option>
															@foreach($currency_user as $currency_valu)
															<option value="{{trim($currency_valu->country)}}"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_country_res == trim($currency_valu->country)) {echo 'selected';}}?>>{{$currency_valu->country}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="nat_issue_date" class="placeholder">Issued Date</label>
														<input id="nat_issue_date" type="date" class="form-control input-border-bottom" name="nat_issue_date" value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_issue_date != '1970-01-01') {if ($employee_rs[0]->nat_issue_date != '') {echo $employee_rs[0]->nat_issue_date;}}}?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group" >
														<label for="nat_exp_date" class="placeholder">Expiry Date</label>
															<input id="nat_exp_date" type="date" class="form-control input-border-bottom" name="nat_exp_date" onchange="getreviewnatdate();"  value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_exp_date != '1970-01-01') {if ($employee_rs[0]->nat_exp_date != '') {echo $employee_rs[0]->nat_exp_date;}}}?>">
													</div>
												</div>
				   								<div class="col-md-3">
													<div class="form-group">
					    								<label for="nat_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
					    								<input id="nat_review_date" type="date" readonly class="form-control input-border-bottom" name="nat_review_date"   value="<?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_review_date != '1970-01-01') {if ($employee_rs[0]->nat_review_date != '') {echo $employee_rs[0]->nat_review_date;}}}?>">
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
															<input class="form-radio-input" type="radio"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_cur == 'Yes') {echo 'checked';}}?> name="nat_cur" id="nat_cur" value="Yes" checked="">
															<span class="form-radio-sign">Yes</span>
														</label>
														<label class="form-radio-label ml-3">
															<input class="form-radio-input" type="radio" name="nat_cur" id="nat_cur1" <?php if (request()->get('q') != '') {if ($employee_rs[0]->nat_cur == 'No') {echo 'checked';}}?>  value="No">
															<span class="form-radio-sign">No</span>
														</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
								    					<label for="nat_remarks" class="placeholder">Remarks</label>
														<input id="nat_remarks" type="text"  value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->nat_remarks;}?>"  class="form-control input-border-bottom" name="nat_remarks" >
													</div>
												</div>
											</div>
										</div>
										<br><hr>
						 				<h4 style="color: #1269db;">Other  details</h4>
				     					<div class="multisteps-form__content" id="otherdetils">


					 					</div>
										<hr>
					 					<div class="row">
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="date_change" class="placeholder" style="margin-top:-24px;">Changed Date</label>
													<input id="date_change" type="date" class="form-control input-border-bottom" required name="date_change" >
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
								    				<label for="res_remark" class="placeholder">Remarks/Restriction to work</label>
													<input id="res_remark" type="text" class="form-control input-border-bottom" name="res_remark"  >
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
								    				<label for="hr" class="placeholder">Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details</label>
													<select id="hr"  class="form-control input-border-bottom" required   name="hr">
												    	<option value="">&nbsp;</option>
														<option value="Yes"  >Yes</option>
														<option value="No">No</option>
														<option value="N/A">N/A</option>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
								    				<label for="home" class="placeholder">Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?</label>
												 	<select id="home"  class="form-control input-border-bottom" required   name="home">
												    	<option value="">&nbsp;</option>
														<option value="Yes"  >Yes</option>
														<option value="No">No</option>
														<option value="N/A">N/A</option>
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

	function getrevieweussdate(){
		var empid=document.getElementById("euss_exp_date").value;
// alert(empid);
		$.ajax({
			type:'GET',
			url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        	cache: false,
			success: function(response){
				console.log(response);

			 	$("#euss_review_date").val(response);
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

	Filevalidationdopassduploadae = () => {
        const fi = document.getElementById('euss_upload_doc');
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
                      	$("#euss_upload_doc").val('');
                }
            }
        }
    }




	function getreviewnatdate(){
		var empid=document.getElementById("nat_exp_date").value;

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewById')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);

		 $("#nat_review_date").val(response);
		}
		});
	}

	Filevalidationdopassduploadnat = () => {
        const fi = document.getElementById('nat_upload_doc');
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
                      	$("#nat_upload_doc").val('');
                }
            }
        }
    }



	function checkemp(val){
		var empid=val;
		$("#download_passport_doc").hide();
		$("#download_visa_upload_doc").hide();

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeetaxempByIdnewemployee')}}/'+empid,
        cache: false,
		success: function(response){

			 var obj = jQuery.parseJSON(response);
				console.log(obj);
			  var emp_code=obj[0].emp_code;
			 var emp_name=obj[0].emp_fname+" "+obj[0].emp_mname+" "+obj[0].emp_lname;
			 var emp_fname=obj[0].emp_fname;
			 var emp_mname=obj[0].emp_mname;
			 var emp_lname=obj[0].emp_lname;
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
					 $("#emp_fname").attr("readonly", true);
					 $("#emp_mname").attr("readonly", false);
					 $("#emp_lname").attr("readonly", false);
					  $("#department").val(obj[0].emp_department);



				    //$("#emp_designation").attr("readonly", true);
				     if(obj[0].emp_dob!='1970-01-01'){
				     $("#emp_dob").val(obj[0].emp_dob);
				     }
				        $("#emp_ps_phone").val(obj[0].emp_ps_phone);
				         $("#ni_no").val(obj[0].ni_no);
				          $("#nationality").val(obj[0].nationality);


				           $("#emp_pr_street_no").val(obj[0].emp_pr_street_no);
				            $("#emp_per_village").val(obj[0].emp_per_village);
				             $("#emp_pr_state").val(obj[0].emp_pr_state);
				              $("#emp_pr_city").val(obj[0].emp_pr_city);
				               $("#emp_pr_pincode").val(obj[0].emp_pr_pincode);
				                $("#emp_pr_country").val(obj[0].emp_pr_country);

				                 $("#pass_doc_no").val(obj[0].pass_doc_no);
				            $("#pass_nat").val(obj[0].pass_nat);
				             $("#place_birth").val(obj[0].place_birth);
				              $("#issue_by").val(obj[0].issue_by);
				                if(obj[0].pas_iss_date!='1970-01-01'){
				               $("#pas_iss_date").val(obj[0].pas_iss_date);
				                }
				                if(obj[0].pass_exp_date!='1970-01-01'){
				                $("#pass_exp_date").val(obj[0].pass_exp_date);
				                }
				                 if(obj[0].pass_review_date!='1970-01-01'){
				                $("#pass_review_date").val(obj[0].pass_review_date);
				                 }
				                $("#remarks").val(obj[0].remarks);
				                if(obj[0].cur_pass=='Yes'){
				                     $("#cur_pass").attr("checked", true);

				                }else{
				                   $("#cur_pass1").attr("checked", true);

				                }

								if(obj[0].pass_docu!="" && obj[0].pass_docu!=null){

									$("#download_passport_doc").html('<a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].pass_docu +'" target="_blank">download</a>');

									$("#download_passport_doc").show();
								}

								if(obj[0].visa_upload_doc!="" && obj[0].visa_upload_doc!=null){

									$("#download_visa_upload_doc").html(' <a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].visa_upload_doc +'" target="_blank">download</a>');

									$("#download_visa_upload_doc").show();
								}

								if(obj[0].visaback_doc!="" && obj[0].visaback_doc!=null){
									//console.log('visabacldoc::::'+obj[0].visaback_doc);
									$("#download_visaback_doc").html(' <a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].visaback_doc +'" target="_blank">download</a>');

									$("#download_visaback_doc").show();
								}else{
									$("#download_visaback_doc").hide();
								}

				                $("#visa_doc_no").val(obj[0].visa_doc_no);
				            	$("#visa_nat").val(obj[0].visa_nat);
				             	$("#country_residence").val(obj[0].country_residence);
				              	$("#visa_issue").val(obj[0].visa_issue);
				             	if(obj[0].visa_issue_date!='1970-01-01'){
				               		$("#visa_issue_date").val(obj[0].visa_issue_date);
				              	}
				               	if(obj[0].visa_exp_date!='1970-01-01'){
				                	$("#visa_exp_date").val(obj[0].visa_exp_date);
				               	}
				                if(obj[0].visa_review_date!='1970-01-01'){
				                	$("#visa_review_date").val(obj[0].visa_review_date);
				                }
				                $("#visa_remarks").val(obj[0].visa_remarks);
				                if(obj[0].visa_cur=='Yes'){
				                     $("#visa_cur").attr("checked", true);

				                }else{
				                   $("#visa_cur1").attr("checked", true);

				                }

								if(obj[0].dbs_upload_doc!="" && obj[0].dbs_upload_doc!=null){

									$("#download_dbs_upload_doc").html(' <a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].dbs_upload_doc +'" target="_blank">download</a>');

									$("#download_dbs_upload_doc").show();
								}

								$("#dbs_ref_no").val(obj[0].dbs_ref_no);
								$("#dbs_nation").val(obj[0].dbs_nation);

								if(obj[0].dbs_issue_date!='1970-01-01'){
				               		$("#dbs_issue_date").val(obj[0].dbs_issue_date);
				              	}

								if(obj[0].dbs_exp_date!='1970-01-01'){
				               		$("#dbs_exp_date").val(obj[0].dbs_exp_date);
				              	}

								if(obj[0].dbs_review_date!='1970-01-01'){
				               		$("#dbs_review_date").val(obj[0].dbs_review_date);
				              	}

								if(obj[0].dbs_cur=='Yes'){
				                     $("#dbs_cur").attr("checked", true);

				                }else{
				                   $("#dbs_cur1").attr("checked", true);

				                }
								$("#dbs_remarks").val(obj[0].dbs_remarks);
								$("#dbs_type").val(obj[0].dbs_type);


								if(obj[0].euss_upload_doc!="" && obj[0].euss_upload_doc!=null){

									$("#download_euss_upload_doc").html(' <a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].euss_upload_doc +'" target="_blank">download</a>');

									$("#download_euss_upload_doc").show();
								}

								$("#euss_nation").val(obj[0].euss_nation);
								$("#euss_ref_no").val(obj[0].euss_ref_no);

								if(obj[0].euss_exp_date!='1970-01-01'){
				               		$("#euss_exp_date").val(obj[0].euss_exp_date);
				              	}

								if(obj[0].euss_issue_date!='1970-01-01'){
				               		$("#euss_issue_date").val(obj[0].euss_issue_date);
				              	}

								if(obj[0].euss_review_date!='1970-01-01'){
				               		$("#euss_review_date").val(obj[0].euss_review_date);
				              	}

								if(obj[0].euss_cur=='Yes'){
				                     $("#euss_cur").attr("checked", true);

				                }else{
				                   $("#euss_cur1").attr("checked", true);

				                }
								$("#euss_remarks").val(obj[0].euss_remarks);

								if(obj[0].nat_upload_doc!="" && obj[0].nat_upload_doc!=null){

									$("#download_nat_upload_doc").html(' <a style="color:blue;"  href="{{ asset('public/') }}/'+ obj[0].nat_upload_doc +'" target="_blank">download</a>');

									$("#download_nat_upload_doc").show();
								}

								$("#nat_id_no").val(obj[0].nat_id_no);
								$("#nat_nation").val(obj[0].nat_nation);
								$("#nat_country_res").val(obj[0].nat_country_res);

								if(obj[0].nat_exp_date!='1970-01-01'){
				               		$("#nat_exp_date").val(obj[0].nat_exp_date);
				              	}

								if(obj[0].nat_issue_date!='1970-01-01'){
				               		$("#nat_issue_date").val(obj[0].nat_issue_date);
				              	}

								if(obj[0].nat_review_date!='1970-01-01'){
				               		$("#nat_review_date").val(obj[0].nat_review_date);
				              	}

								if(obj[0].nat_cur=='Yes'){
				                     $("#nat_cur").attr("checked", true);

				                }else{
				                   $("#nat_cur1").attr("checked", true);

				                }
								$("#nat_remarks").val(obj[0].nat_remarks);




						  		$("#otherdetils").html(obj[1]);



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


			   $("#emp_pr_country").val(obj[0].country);
			    $("#emp_pr_street_no").val(obj[0].address);
			     $("#emp_per_village").val(obj[0].address2);
			      $("#emp_pr_state").val(obj[0].road);
			      $("#emp_pr_city").val(obj[0].city);
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

	Filevalidationdopassdvisaeback = () => {
        const fi = document.getElementById('visaback_doc');
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
                      	$("#visaback_doc").val('');
                }
            }
        }
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
