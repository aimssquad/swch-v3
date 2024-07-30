<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		 .star{color:red;}
		 .sampleupload{background: #102784;
    color: #fff;
    text-decoration: none;
    padding: 9px 10px;
    border-radius: 5px;
    font-size: 9px;position: relative;
    top: -13px;}
	</style>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
	<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
			<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
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
	@include('dashboard.include.header')
 
		<!-- End Sidebar -->
		<div class="main-panel"  style="width:100%">
		<div class="page-header">
						<!-- <h4 class="page-title">Organisation</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('dashboarddetails')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<!-- <li class="nav-home">
								<a href="{{url('dashboarddetails')}}">Sponsor Complaience</a>
							</li>
							<li class="separator">
								/
							</li> -->
							<li class="nav-item active">
								<a href="{{url('dashboard/edit-dashboard-company')}}">Organisational Profile</a>
							</li>

							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"> <i class="far fa-building" aria-hidden="true" style="color:#10277f;"></i> &nbsp; Organisation Profile </h4>
									@if(Session::has('message'))										
							<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body" style="">
									<form action="#" method="post" enctype="multipart/form-data">
											 {{csrf_field()}}
											 <input  type="hidden" class="form-control "   name="reg"  value="{{ $Roledata->reg}}">
										<div class="row">
										 
										<div class="col-md-4">
						<div class="form-group ">
						    <label for="inputFloatingLabel" class="placeholder">Organisation Name 
							<a  style="padding: 5px 10px;top: 0;
    text-decoration: none !important;" href="https://find-and-update.company-information.service.gov.uk" class="sampleupload" target="_blank">Find</a> <span class="star">(*)</span></label>
												<input id="inputFloatingLabel" type="text" class="form-control "  readonly  name="com_name"  value="{{ $Roledata->com_name}}">
												
											</div>
					</div>
							<div class="col-md-4">
										     <div class="form-group ">
										         <label for="selectFloatingLabel" class="placeholder">Type of Organisation  <span class="star">(*)</span> </label>
										         <input type="text" class="form-control " name="com_type"   readonly value="{{$Roledata->com_type}}" >
												
												
											</div>
										   </div>
										     <div class="col-md-4 write-type" id="others-type"  <?php  if($Roledata->com_type=='others-type'){ ?> style="display:block;" <?php }else{?> style="display:none;" <?php }  ?>>
										   	<div class="form-group ">
										   	    	<label for="inputFloatingLabel8" class="placeholder">Type Name</label>
												<input id="inputFloatingLabel8" type="text" class="form-control " readonly  name="others_type"  value="@if($Roledata->others_type){{  $Roledata->others_type }}@endif">
											
											</div>
										   </div>
							<div class="col-md-4">
											<div class="form-group ">
											    	<label for="inputFloatingLabel7" class="placeholder"> Registration No 	<a  style="padding: 5px 10px;top: 0;
    text-decoration: none !important;" href="https://find-and-update.company-information.service.gov.uk" class="sampleupload" target="_blank">Find</a></label>
												<input id="inputFloatingLabel7" type="text" class="form-control " readonly  name="com_reg"  value="@if($Roledata->com_reg){{  $Roledata->com_reg }}@endif">
											
											</div>
											</div>
											
	
									
									
										</div>
										
										
									    <div class="row form-group">	
									
									<div class="col-md-4">
									<div class="form-group ">
									    	<label for="inputFloatingLabel4" class="placeholder">Contact No. <span class="star">(*)</span></label>
												<input id="inputFloatingLabel4" type="text" class="form-control"  readonly name="p_no"  value="{{  $Roledata->p_no }}">
											
											</div>
									</div>
										<div class="col-md-4">
									<div class="form-group">
									<label for="inputFloatingLabel3" class="placeholder">Login Email ID  <span class="star">(*)</span></label>
												<input id="inputFloatingLabel3" type="text" class="form-control " readonly name="email"  value="{{  $Roledata->email }}">
												<input  type="hidden" class="form-control "  name="pass"  value="{{  $Roledata->pass }}">
												
											</div>
									</div>
							
						<div class="col-md-4">
									<div class="form-group" style="padding-right: 16px;">
									<label for="inputFloatingLabel3" class="placeholder">Organisation Email ID  <span class="star">(*)</label>
												<input id="organ_email" type="text" class="form-control " readonly required="" name="organ_email"  value="{{  $Roledata->organ_email }}">
												
											</div>
									</div>
						
					
					<div class="col-md-8">
											<div class="form-group" style="padding-right: 16px;">
											    	<label for="inputFloatingLabel5" class="placeholder">Website</label>
												<input id="inputFloatingLabel5" type="text" class="form-control " readonly  name="website"   value="@if ($Roledata->website){{  $Roledata->website }}@endif">
											
											</div>
											</div>
					
							<div class="col-md-4">				
								<div class="form-group">
											    	<label for="land" class="placeholder">Landline Number</label>
												<input id="land" type="text" class="form-control " readonly  name="land"   value="@if ($Roledata->land){{  $Roledata->land }}@endif">
											
											</div>
											</div>
									</div>
										
										
									
										
										
										<div class="row form-group">
										   
										   <div class="col-md-4">
										     <div class="form-group " style="padding-left: 16px;">
										         	<label for="trad_name" class="placeholder">Trading Name  <span class="star">(*)</span></label>
												<input id="trad_name" type="text" class="form-control " readonly  name="trad_name"  value="@if($Roledata->trad_name){{  $Roledata->trad_name }}@endif">
											
											</div>
										   </div>
										   
										   <div class="col-md-4">
										     <div class="form-group ">
										         <label for="inputFloatingLabel9" class="placeholder">Trading Period  <span class="star">(*)</span></label>
										          <input type="text" class="form-control " name="com_year"   readonly value="{{$Roledata->com_year}}" >
											
												
												
											</div>
										   </div>
										   <div class="col-md-4">
										     <div class="form-group " style="padding-right:16px;">
										         	<label for="selectFloatingLabel1" class="placeholder">Name Of Sector  <span class="star">(*)</span></label>
										         <input type="text" class="form-control " name="com_nat"   readonly value="{{$Roledata->com_nat}}" >
											
											
											</div>
										   </div>
										   <div class="col-md-4 Other-service-activities" id="Other-service-activities" <?php  if($Roledata->com_nat=='Other service activities'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group ">
										        	<label for="inputFloatingLabel10" class="placeholder">Name Of Sector  <span class="star">(*)</span></label>
												<input id="inputFloatingLabel10" type="text" class="form-control" readonly name="nature_type"  value="@if($Roledata->nature_type){{  $Roledata->nature_type }}@endif" >
											
											</div>
										   </div>
										    <div class="col-md-4">
										     <div class="form-group "style= "padding-left: 16px;">
										         <label for="trad_status" class="placeholder">Have you changed Organisation /<br>Trading  name in last 5 years?    <span class="star">(*)</label>
												<select class="form-control" id="trad_status" required="" disabled name="trad_status" onchange="trade_epmloyee(this.value);">>
													<option value="">&nbsp;</option>
													
                     <option value="Yes" <?php   if($Roledata->trad_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
                        <option value="No" <?php   if($Roledata->trad_status=='No'){ echo 'selected';}  ?>>No</option>
													
												</select>
												
											</div>
										   </div>
										     <div class="col-md-6 " id="criman_new" <?php  if($Roledata->trad_status=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group " style="padding-top: 30px;">
										        <label for="trad_other" class="placeholder">Give Details</label>
												<input id="trad_other" type="text" disabled class="form-control " name="trad_other"  value="@if($Roledata->trad_other){{  $Roledata->trad_other }}@endif">
												
											</div>
										   </div>
										    <div class="col-md-6">
										     <div class="form-group " style= "padding-left: 16px;">
										         	<label for="penlty_status" class="placeholder">Did your organisation faced penalty<br> (e.g., recruiting illegal employee) in last  3 years?    <span class="star">(*)</label>
												<select class="form-control " disabled id="penlty_status" required="" name="penlty_status" onchange="penlty_epmloyee(this.value);">
													<option value="">&nbsp;</option>
													
                     <option value="Yes" <?php   if($Roledata->penlty_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
                        <option value="No" <?php   if($Roledata->penlty_status=='No'){ echo 'selected';}  ?>>No</option>
													
												</select>
											
											</div>
										   </div>
										     <div class="col-md-6 " id="criman_penlty_new" <?php  if($Roledata->penlty_status=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group " style="padding-top:30px; padding-right: 16px;">
										        	<label for="penlty_other" class="placeholder">Give Details</label>
												<input id="penlty_other" type="text" disabled class="form-control " name="penlty_other"  value="@if($Roledata->penlty_other){{  $Roledata->penlty_other }}@endif">
											
											</div>
										   </div>
										  
										  
													<div class="col-md-4">
					<div class="form-group" style= "padding-left: 16px;">
												<label for="exampleFormControlFile1">Your Logo</label>
																	<img src="{{ asset($Roledata->logo) }}" height="50px" width="50px"/>
											
											</div>
					</div>
										</div>
										
										<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding-left: 16px;margin-bottom: 16px;">Authorised Person Details</h3>
										
										<div class="row">
											<div class="col-md-4">
										<div class="form-group " style= "padding-left: 16px;">
										    	<label for="inputFloatingLabel1" class="placeholder">First Name  <span class="star">(*)</span></label>
												<input id="inputFloatingLabel1" type="text" class="form-control "  readonly  name="f_name"  value="{{ $Roledata->f_name}}">
											
											</div>
										</div>
										
										<div class="col-md-4">
										<div class="form-group ">
										    	<label for="inputFloatingLabel2" class="placeholder">Last Name  <span class="star">(*)</span></label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly name="l_name"  value="{{ $Roledata->l_name}}">
											
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style="padding-right: 16px;">
										    <label for="inputFloatingLabel2" class="placeholder">Designation  <span class="star">(*)</span> </label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly  name="desig"  value="{{ $Roledata->desig}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style= "padding-left: 16px;">
										    <label for="con_num" class="placeholder">Phone No  <span class="star">(*)</span> </label>
												<input id="con_num" type="text" class="form-control "  name="con_num"  readonly value="{{ $Roledata->con_num}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group ">
										    	<label for="authemail" class="placeholder">Email  <span class="star">(*)</span> </label>
												<input id="authemail" type="text" class="form-control "  name="authemail" readonly  value="{{ $Roledata->authemail}}">
											
											</div>
										</div>
																		<div class="col-md-4">
					<div class="form-group" style="padding-top: 30px;">
												<label for="exampleFormControlFile1">Proof Of Id</label>
																	<img src="{{ asset($Roledata->proof) }}" height="50px" width="50px"/>
											
											</div>
					</div>
					 <div class="col-md-6">
										     <div class="form-group " style= "padding-left: 16px;">
										         	<label for="bank_status" class="placeholder">Do you have a history of Criminal <br>conviction/Bankruptcy/Disqualification/<br>Disqualification?    <span class="star">(*)</label>
												<select class="form-control " disabled id="bank_status" required="" name="bank_status" onchange="bank_epmloyee(this.value);">>
													<option value="">&nbsp;</option>
													
                     <option value="Yes" <?php   if($Roledata->bank_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
                        <option value="No" <?php   if($Roledata->bank_status=='No'){ echo 'selected';}  ?>>No</option>
													
												</select>
											
											</div>
										   </div>
										     <div class="col-md-6 " id="criman_bank_new" <?php  if($Roledata->bank_status=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group " style="padding-top: 50px; padding-right:16px;">
										        	<label for="bank_other" class="placeholder">Give Details </label>
												<input id="bank_other" disabled type="text" class="form-control" name="bank_other"  value="@if($Roledata->bank_other){{  $Roledata->bank_other }}@endif">
											
											</div>
										   </div>
										</div>
											<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding-right: 16px 0;margin-bottom: 16px;margin-left: 16px;">Key Contact </h3>
									
										<div class="row">
											<div class="col-md-4">
										<div class="form-group " style="padding-left:16px;">
										<label for="key_f_name" class="placeholder">First Name  <span class="star">(*)</label>
												<input readonly id="key_f_name" type="text" class="form-control " required=""  name="key_f_name"  value="{{ $Roledata->key_f_name}}">
												
											</div>
										</div>
										
										<div class="col-md-4">
										<div class="form-group ">
										<label for="key_f_lname" class="placeholder">Last Name  <span class="star">(*)</label>
												<input readonly id="key_f_lname" type="text" class="form-control " required="" name="key_f_lname"  value="{{ $Roledata->key_f_lname}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style="padding-right: 16px;">
										<label for="key_designation" class="placeholder">Designation <span class="star">(*) </label>
												<input readonly id="key_designation" type="text" class="form-control " name="key_designation"  value="{{ $Roledata->key_designation}}" required>
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style="padding-left:16px;">
										<label for="key_phone" class="placeholder">Phone No  <span class="star">(*)</label>
												<input readonly id="key_phone" type="text" class="form-control " required="" name="key_phone"  value="{{ $Roledata->key_phone}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group ">
										<label for="key_email" class="placeholder">Email  <span class="star">(*)</label>
												<input readonly id="key_email" type="text" class="form-control " required="" name="key_email"  value="{{ $Roledata->key_email}}">
												
											</div>
										</div>
																	<div class="col-md-4">
					<div class="form-group" style="padding-top:30px;">
												<label for="exampleFormControlFile1">Proof Of Id</label>
													@if($Roledata->key_proof!='')
																<a href="{{ asset($Roledata->key_proof) }}" target="_blank">	<img src="{{ asset($Roledata->key_proof) }}" height="50px" width="50px"/></a>
																		@endif
												
											</div>
					</div>
					 <div class="col-md-6">
										     <div class="form-group " style="padding-left:16px;">
											 <label for="key_bank_status" class="placeholder">Do you have a history of Criminal<br> conviction/Bankruptcy/Disqualification?    <span class="star">(*)</label>
												<select disabled class="form-control " id="key_bank_status" required="" name="key_bank_status" onchange="key_bank_epmloyee(this.value);">>
													<option value="">&nbsp;</option>
													
                     <option value="Yes" <?php   if($Roledata->key_bank_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
                        <option value="No" <?php   if($Roledata->key_bank_status=='No'){ echo 'selected';}  ?>>No</option>
													
												</select>
												
											</div>
										   </div>
										     <div class="col-md-6 " id="criman_key_bank_new" <?php  if($Roledata->key_bank_status=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group " style="padding-top:30px; padding-right:16px;">
											<label for="key_bank_other" class="placeholder">Give Details </label>
												<input readonly id="key_bank_other" type="text" class="form-control " name="key_bank_other"  value="@if($Roledata->key_bank_other){{  $Roledata->key_bank_other }}@endif">
												
											</div>
										   </div>
										</div>
										
										
										


											<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px; margin-left:16px;">Level 1 User    </h3>
										
										<div class="row">
											<div class="col-md-4">
										<div class="form-group " style="padding-left: 16px;">
										<label for="level_f_name" class="placeholder">First Name  <span class="star">(*)</label>
												<input readonly id="level_f_name" type="text" class="form-control " required=""  name="level_f_name"  value="{{ $Roledata->level_f_name}}">
												
											</div>
										</div>
										
										<div class="col-md-4">
										<div class="form-group ">
										<label for="level_f_lname" class="placeholder">Last Name  <span class="star">(*)</label>
												<input readonly id="level_f_lname" type="text" class="form-control " required="" name="level_f_lname"  value="{{ $Roledata->level_f_lname}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style="padding-right: 16px;">
										<label for="level_designation" class="placeholder">Designation <span class="star">(*) </label>
												<input readonly id="level_designation" type="text" class="form-control " name="level_designation"  value="{{ $Roledata->level_designation}}" required>
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group " style="padding-left: 16px;">
										<label for="level_phone" class="placeholder">Phone No  <span class="star">(*)</label>
												<input readonly id="level_phone" type="text" class="form-control " required="" name="level_phone"  value="{{ $Roledata->level_phone}}">
												
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group ">
										<label for="level_email" class="placeholder">Email  <span class="star">(*)</label>
												<input readonly id="level_email" type="text" class="form-control " required="" name="level_email"  value="{{ $Roledata->level_email}}">
												
											</div>
										</div>
																	<div class="col-md-4">
					<div class="form-group"style="padding-top: 30px;" >
												<label for="exampleFormControlFile1">Proof Of Id</label>
													@if($Roledata->level_proof!='')
																<a href="{{ asset($Roledata->level_proof) }}" target="_blank">	<img src="{{ asset($Roledata->level_proof) }}" height="50px" width="50px"/></a>
																		@endif
												
											</div>
					</div>
					 <div class="col-md-6">
										     <div class="form-group " style="padding-left: 16px;">
											 	<label for="level_bank_status" class="placeholder">Do you have a history of Criminal <br>conviction/Bankruptcy/Disqualification?    <span class="star">(*)</label>
												<select disabled class="form-control " id="level_bank_status" required="" name="level_bank_status" onchange="level_bank_epmloyee(this.value);">>
													<option value="">&nbsp;</option>
													
                     <option value="Yes" <?php   if($Roledata->level_bank_status=='Yes'){ echo 'selected';}  ?>>Yes</option>
                        <option value="No" <?php   if($Roledata->level_bank_status=='No'){ echo 'selected';}  ?>>No</option>
													
												</select>
											
											</div>
										   </div>
										     <div class="col-md-6 " id="criman_level_bank_new" <?php  if($Roledata->level_bank_status=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group " style="padding-right: 16px; padding-top:30px;">
											<label for="level_bank_other" class="placeholder">Give Details </label>
												<input readonly id="level_bank_other" type="text" class="form-control " name="level_bank_other"  value="@if($Roledata->level_bank_other){{  $Roledata->level_bank_other }}@endif">
												
											</div>
										   </div>
										</div>
										<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px; margin-left:16px;">Organisation Address</h3>
										
										<div class="row">
											<div class="col-md-3">
											  <div class="form-group " style= "padding-left: 16px;">
											      	<label for="inputFloatingLabel15" class="placeholder">Address Line 1</label>
												<input id="inputFloatingLabel15" type="text" class="form-control "  name="address" readonly value="@if($Roledata->address){{  $Roledata->address }}@endif">
											
										   </div>
											</div>
											<div class="col-md-3">
											  <div class="form-group ">
											      	<label for="address2" class="placeholder">Address Line 2</label>
												<input id="address2" type="text" class="form-control "  name="address2" readonly  value="@if($Roledata->address2){{  $Roledata->address2 }}@endif">
											
										   </div>
											</div>
											<div class="col-md-3">
											  <div class="form-group ">
											      	<label for="road" class="placeholder">Address Line 3</label>
												<input id="road" type="text" class="form-control "  name="road"  readonly value="@if($Roledata->road){{  $Roledata->road }}@endif">
											
										   </div>
											</div>
												<div class="col-md-3">
											  <div class="form-group " style="padding-right: 16px;">
											      	<label for="city" class="placeholder">City / County</label>
												<input id="city" type="text" class="form-control "  name="city"  readonly value="@if($Roledata->city){{  $Roledata->city }}@endif">
											
										   </div>
											</div>
												<div class="col-md-3">
											  <div class="form-group " style="padding-left: 16px;">
											      <label for="zip" class="placeholder">Post Code</label>
												<input id="zip" type="text" class="form-control "  name="zip" readonly  value="@if($Roledata->zip){{  $Roledata->zip }}@endif">
												
										   </div>
											</div>
											<div class="col-md-3">
											
											 <div class="form-group ">
											     	<label for="selectFloatingLabel" class="placeholder">Country</label>
											      <input type="text" class="form-control " name="country"   readonly value="{{$Roledata->country}}" >
											
												
											</div>
											 
												
											</div>
									
										</div>
										<?php   $truplouii_id=1;
$countwmploor= count($employee_or_rs)			;?>
									@if ($countwmploor!=0)		
								<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px;margin-bottom: 16px;">Organisation Employee (According to latest RTI)</h3>@endif	
									
		@if ($countwmploor!=0)
		@foreach($employee_or_rs as $empuprotgans)
	
		<div class="row">
		
		
		
		
		<div class="col-md-3">
											  <div class="form-group " style=" padding-left: 16px;">
											      	 @if($truplouii_id==1)
			<label for="name<?= $truplouii_id?>" class="placeholder">Full Name</label>
			@endif
												<input type="text" class="form-control "  value="{{ $empuprotgans->name}}"  id="name<?= $truplouii_id?>" name="name[]" readonly>

										
										   </div>
											</div>
											<div class="col-md-2">
											  <div class="form-group ">
											      	 @if($truplouii_id==1)
											      	 
		<label for="department<?= $truplouii_id?>" class="placeholder">Department</label>
		@endif
												<input type="text" class="form-control " value="{{ $empuprotgans->department}}"  id="department<?= $truplouii_id?>" name="department[]" readonly>

											
										   </div>
											</div>
												<div class="col-md-2">
											  <div class="form-group ">
			 @if($truplouii_id==1)
										<label for="job_type<?= $truplouii_id?>" class="placeholder">Job Type</label>
										@endif
	<input type="text" class="form-control " value="{{ $empuprotgans->job_type}}"  id="job_type<?= $truplouii_id?>" name="job_type[]" readonly>

										   </div>
											</div>
											<div class="col-md-2">
											  <div class="form-group ">
											      	 @if($truplouii_id==1)
			<label for="designation<?= $truplouii_id?>" class="placeholder">Job Title</label>
			@endif
												<input type="text" class="form-control " value="{{ $empuprotgans->designation}}" id="designation<?= $truplouii_id?>" name="designation[]" readonly >

										
										   </div>
											</div>
										
											<div class="col-md-3">
											  <div class="form-group " style= "padding-right: 16px;" >
											      	 @if($truplouii_id==1)
											      	<label for="immigration<?= $truplouii_id?>" class="placeholder">Immigration Status
</label>
@endif
	
	<input type="text" class="form-control " value="{{ $empuprotgans->immigration}}"  id="immigration<?= $truplouii_id?>" name="immigration[]" readonly>

											
												
											
										   </div>
											</div>
											
		
		
									
								
									</div>
										
										
										
										@if ($truplouii_id!=($countwmploor))
		
									
											@endif
												<?php $truplouii_id++;?>
										@endforeach   
		
		@endif
		
			
			
				<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px; margin-left: 16px;">Trading Hours</h3>
										
										<div class="row">
										    
										    	
										  
										   
	<div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
											<label for="day2" class="placeholder">Day</label>
												<input type="text" class="form-control " id="day2"  value="Monday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group "  style="">
											      <label for="mon_status" class="placeholder">Status</label>
											  <input type="text" class="form-control " id="mon_status"  value="{{$Roledata->mon_status}}" readonly>
												
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="mon_status_open">
										    <div class="form-group " style="">
										        	<label for="mon_time" class="placeholder">Opening Time</label>
											<input type="text" class="form-control " id="mon_time"   <?php  if($Roledata->mon_status=='open'){  ?> value="{{$Roledata->mon_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
												
											
											
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="mon_status_close" >
										    <div class="form-group " style="padding-right: 16px;">
										        	<label for="mon_close" class="placeholder">Closing Time</label>
											<input type="text" class="form-control " id="mon_close"   <?php  if($Roledata->mon_status=='open'){  ?> value="{{$Roledata->mon_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
											
											
											</div>
										   </div>
										   
										   </div>
										   
										   
										   
										   
										   
									
										   
										   <div class="row">
										   
										   <div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day3"  value="Tuesday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group " style="">
											
											  <input type="text" class="form-control " id="tue_status"  value="{{$Roledata->tue_status}}" readonly>
												
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="tue_status_open" >
										    <div class="form-group ">
										
											<input type="text" class="form-control " id="tue_time"  <?php  if($Roledata->tue_status=='open'){  ?> value="{{$Roledata->tue_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?>  readonly>
												
													
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="tue_status_close">
										    <div class="form-group "  style="padding-right: 16px;" >
											
													<input type="text" class="form-control " id="tue_close"  <?php  if($Roledata->tue_status=='open'){  ?> value="{{$Roledata->tue_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
													
												
											</div>
										   </div>
 </div>
						   <div class="row">

<div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day3"  value="Wednesday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group ">
											 
												 <input type="text" class="form-control " id="wed_status"  value="{{$Roledata->wed_status}}" readonly>
												
												
												
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="wed_status_open" >
										    <div class="form-group ">
										
											<input type="text" class="form-control " id="wed_time"   <?php  if($Roledata->wed_status=='open'){  ?> value="{{$Roledata->wed_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?>  readonly>
												
												
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="wed_status_close" >
										    <div class="form-group " style="padding-right: 16px;">
										
											<input type="text" class="form-control " id="wed_close"  <?php  if($Roledata->wed_status=='open'){  ?> value="{{$Roledata->wed_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
												
												
											</div>
										   </div>
										   
										    </div>
										    
										   
										   
									
										   
										  
										  
										   
										   <div class="row">
										   
										   
										   	<div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day3"  value="Thursday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group ">
										
											   <input type="text" class="form-control " id="thu_status"  value="{{$Roledata->thu_status}}" readonly>
												
												
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="thu_status_open" >
										    <div class="form-group ">
										
											 <input type="text" class="form-control " id="thu_time"   <?php  if($Roledata->thu_status=='open'){  ?> value="{{$Roledata->thu_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
												
												
												
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="thu_status_close" >
										    <div class="form-group " style="padding-right:16px;">
											
											<input type="text" class="form-control " id="thu_close"  <?php  if($Roledata->thu_status=='open'){  ?> value="{{$Roledata->thu_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
												
												
													
											
											</div>
										   </div>
											
										 </div>
										   
										   
										   <div class="row">	
											
											
											
											<div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day3"  value="Friday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group ">
											 
											  <input type="text" class="form-control " id="fri_status"  value="{{$Roledata->fri_status}}" readonly>
											
											
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="fri_status_open">
										    <div class="form-group ">
										
											<input type="text" class="form-control " id="fri_time"  <?php  if($Roledata->fri_status=='open'){  ?> value="{{$Roledata->fri_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="fri_status_close">
										    <div class="form-group " style="padding-right: 16px;">
										
											<input type="text" class="form-control " id="fri_close"  <?php  if($Roledata->fri_status=='open'){  ?> value="{{$Roledata->fri_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
												
												
											</div>
										   </div>
										   
										    </div>
										   
										   
										   <div class="row">
										   <div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day3"  value="Saturday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group ">
											  
											  <input type="text" class="form-control " id="sat_status"  value="{{$Roledata->sat_status}}" readonly>
											
												
											
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="sat_status_open" >
										    <div class="form-group ">
										
											<input type="text" class="form-control " id="sat_time" <?php  if($Roledata->sat_status=='open'){  ?> value="{{$Roledata->sat_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
												
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="sat_status_close" >
										    <div class="form-group "style="padding-right: 16px;" >
										
											<input type="text" class="form-control " id="sat_close" <?php  if($Roledata->sat_status=='open'){  ?> value="{{$Roledata->sat_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
												
											
												
											</div>
										   </div>
										    </div>
										   
										   
										   <div class="row">
										   
										   	<div class="col-md-3">
											  <div class="form-group" style="padding-left: 16px;">
		
										
												<input type="text" class="form-control " id="day1"  value="Sunday" readonly>

										   </div>
											</div>
											
											
											
												<div class="col-md-3">
											  <div class="form-group ">
											  
											  <input type="text" class="form-control " id="sun_status"  value="{{$Roledata->sun_status}}" readonly>
											
											
												
												
										   </div>
											</div>
											
											
											
											
											 <div class="col-md-3" id="sun_status_open">
										    <div class="form-group ">
										
											<input type="text" class="form-control " id="sun_time"   <?php  if($Roledata->sun_status=='open'){  ?> value="{{$Roledata->sun_time}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
											
												
												
											</div>
										   </div>
										   
										   
										   
										    <div class="col-md-3 " id="sun_status_close" >
										    <div class="form-group " style="padding-right: 16px;">
											
											<input type="text" class="form-control " id="sun_close"   <?php  if($Roledata->sun_status=='open'){  ?> value="{{$Roledata->sun_close}}"  <?php }else{ ?> value="Closed"  <?php }  ?> readonly>
											
											
												
												
											</div>
										   </div>
										   
										  	</div>	
									
									
									
									
	
										   
	
										   							
									
	<?php  
$countpayuppas= count($employee_upload_rs)			;?>
		@if ($countpayuppas!=0)
										<h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px; margin-left:16px;">Upload Documents</h3>
										@endif
										<div id="education_fields">
										<?php   $trupload_id=0;
			?>
		@if ($countpayuppas!=0)
											
@foreach($employee_upload_rs as $empuprs)


										<div class="row form-group">
										<div class="col-md-4">
										  <div class="form-group " style="padding-left: 16px;">
										      	 @if($trupload_id==0)
										      	<label class="placeholder">Type of Document</label>
										      	@endif
										       <input type="text" class="form-control " name="type_doc"   readonly value="{{$empuprs->type_doc}}" >
										  	
												
											
												<input  type="hidden" class="form-control "  name="id_up_doc[]" value="{{ $empuprs->id}}">
											</div>
										  
										</div>

										@if($empuprs->type_doc=='Others Document')
										<div class="col-md-4" id="other_doc_{{ $empuprs->id}}">

											<div class="form-group " style="padding-right: 16px;">
											     	 @if($trupload_id==0)
												<label for="other_doc_input_{{ $empuprs->id}}">Other Doc.Type</label>
												@endif
												<input type="text" class="form-control " id="other_doc_input_{{ $empuprs->id}}" readonly name="other_doc_{{ $empuprs->id}}" value="{{$empuprs->other_txt}}">
											</div>
											
										</div>

										@endif
										<div class="col-md-4" style="display: none;" id="other_doc_{{ $empuprs->id}}">

											<div class="form-group " style="padding-right: 16px;">
											     	 @if($trupload_id==0)
												<label for="other_doc_input_{{ $empuprs->id}}">Other Doc.Type</label>
												@endif
												<input type="text" class="form-control " id="other_doc_input_{{ $empuprs->id}}" readonly name="other_doc_{{ $empuprs->id}}" disabled>
											</div>
											
										</div>
										
										
										<div class="col-md-4">
										  <div class="form-group">
										       @if($empuprs->docu_nat!='')
										        	 @if($trupload_id==0)
												<label for="other_doc_input_{{ $empuprs->id}}">Upload Document : <a href="#" class="sampleupload" target="_blank">Sample Document</a></label></br>
												@endif
<a href="{{ asset('public/'.$empuprs->docu_nat) }}" data-toggle="tooltip" data-placement="bottom" title="Upload" target="_blank" download />

<i class="fas fa-upload"></i></a>
</br>
@endif
												
											</div>
										  
										</div>
										<?php $trupload_id++; ?>
										 
				
				
				@if ($trupload_id==($countpayuppas))
				
										
										@endif
										</div>
									
										@endforeach   
										@endif
										
										</div>
									
										<div class="row form-group" style="padding-left:16px;">
										  <div class="col-md-12">
										   <button type="button" class="btn btn-default" onclick="goBack()">Back</button>
										  </div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
	<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
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
    divtest.innerHTML = '<div class="row form-group"><div class="col-md-4"><div class="form-group "><select class="form-control "  name="type_doc[]" onchange="checkdoctype('+ room +')" id="d_type'+ room +'"><option value="">&nbsp;</option><option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option><option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option><option value="Proof of Business Premises (Tenancy Agreement)" >Proof of Business Premises (Tenancy Agreement)</option><option value="Franchise Agreement" >Franchise Agreement</option><option value="Copy Of Lease Or Freehold Property" >Copy Of Lease Or Freehold Property</option><option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option><option value="PAYEE And Account Reference Letter From HMRC" >PAYEE And Account Reference Letter From HMRC</option><option value="Governing Body Registration"  >Governing Body Registration</option><option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option><option value="VAT Certificate (if you have)"  >VAT Certificate (if you have)</option><option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option><option value="Others Document"  >Others Document</option></select><label class="placeholder">Type of Document</label></div></div><div class="col-md-4" id="other_doc'+ room +'" style="display:none"><div class="form-group "><label for="newdoc_'+ room +'">Other Doc.Type</label><input type="text" class="form-control " id="newdoc_'+ room +'" name="other_doc[]"></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlFile1">Upload Document</label><input type="file" class="form-control-file" id="exampleFormControlFile1" name="docu_nat[]"></div><span>*Document Size not more than 300 KB</span></div><div class="col-md-4"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
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
</script>
<script>
function goBack() {
  window.history.back();
}
</script>
</body>
</html>