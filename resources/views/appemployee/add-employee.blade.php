<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->

	<script src="{{ asset('employeeassets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
		<link rel="stylesheet" href="{{ asset('employeeassets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/atlantis.min.css')}}">
	<link href="{{asset('rcrop/dist/rcrop.min.css')}}" media="screen" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/calander.css')}}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('employeeassets/css/demo.css')}}">
	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<style>
	.table td, .table th{padding:0 5px !important}
	.form-control {
  font-size: 12px;
    border-color: #ebedf2;
    padding: 0px 5px 0;
    height: 37px !important;
}
input[type="date"]
{
    display:block;
  border:none;border-bottom:1px solid #ebedf2;border-radius:0;
    /* Solution 1 */
     -webkit-appearance: textfield;
    -moz-appearance: textfield;
    min-height: 1.2em; 
  
    /* Solution 2 */
    /* min-width: 96%; */
}
.main-panel{margin-top:0;}
.main-panel > .content{margin-top:0;}
	</style>
</head>
<body>
	<div class="wrapper">
			

		<!-- Sidebar -->
		
	
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
						
								<div class="card-header">
									<h4 class="card-title">Add New Employee</h4>
								</div>
								
									<div class="multisteps-form">
        <!--progress bar-->
        <div class="row">
          <div class="col-12 col-lg-12 ml-auto mr-auto mb-4" style="display:none;">
            <div class="multisteps-form__progress">
              <button class="multisteps-form__progress-btn js-active" type="button" title="User Info">User Info</button>
			  <button class="multisteps-form__progress-btn" type="button" title="service">Service</button>
			  <button class="multisteps-form__progress-btn" type="button" title="training">Training</button>
              <button class="multisteps-form__progress-btn" type="button" title="Address">Address</button>
              <button class="multisteps-form__progress-btn" type="button" title="Order Info">Order Info</button>
			  <button class="multisteps-form__progress-btn" type="button" title="license">License</button>
              <button class="multisteps-form__progress-btn" type="button" title="Comments">Comments</button>
			  <button class="multisteps-form__progress-btn" type="button" title="imigration">Immigration</button>
            </div>
          </div>
        </div>
         
        <!--form panels-->
        <div class="row">
          <div class="col-12 col-lg-12 m-auto">
          
			  <form name="basicform" id="basicform" method="post" action="{{url('appaddemployee')}}" enctype="multipart/form-data" class="multisteps-form__form">
        {{ csrf_field() }}
              <!--single form panel-->
              <div class="multisteps-form__panel rounded bg-white js-active" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Personal Details</h3>
                <div class="multisteps-form__content">
                 <div class="row">
  	
	
	<div class="col-md-4">
		<input id="emid" type="hidden" class="form-control input-border-bottom" required="" name="reg"  value="{{$emid}}" >
		<div class="form-group">
		    <label for="inputFloatingLabel" class="placeholder" style="margin-top:-12px;">Employee Code<span style="color:red;">*</span></label>
		<input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" value="<?=trim($employee_code);?>" readonly name="emp_code"  >
		
	</div>
	</div>
	<div class="col-md-4">
	
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="emp_fname"   >
		<label for="inputFloatingLabel1" class="placeholder">First Name <span style="color:red;">*</span></label>
	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom" name="emp_mid_name">
		<label for="inputFloatingLabel2" class="placeholder">Middle Name</label>
	</div>
  </div>
  
  </div>
<div class="row">
  	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel3" type="text" class="form-control input-border-bottom" name="emp_lname"  required="" >
		<label for="inputFloatingLabel3" class="placeholder">Last Name <span style="color:red;">*</span></label>
	</div>
	</div>
		<div class="col-md-4">
		<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel"  name="emp_gender">
<option value="">&nbsp;</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
<label for="selectFloatingLabel" class="placeholder">Gender </label>
</div>
</div>
		   <div class="col-md-4">
				   <div class="form-group form-floating-label">
<input id="inputFloatingLabelni" type="text" class="form-control input-border-bottom" name="ni_no" >
<label for="inputFloatingLabelni" class="placeholder">NI No.</label>
</div>
</div>

<!--<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelfon" type="text" class="form-control input-border-bottom"  name="emp_father_name">
		<label for="inputFloatingLabelfon" class="placeholder">Father's Name </label>
	</div>
	</div>
	-->

	
	</div>
	
  	<div class="row ">
	
  <!--	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel4" type="date" class="form-control input-border-bottom" name="marital_date">
		<label for="inputFloatingLabel4" class="placeholder">Date of Marriage</label>
	</div>
	</div>-->
	 <!--<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel5" type="text" class="form-control input-border-bottom" required="" name="spouse_name">
		<label for="inputFloatingLabel5" class="placeholder">Spouse  Name</label>
	</div>
	</div>-->
	<div class="col-md-4">
	    <label for="inputFloatingLabeldob">Date of Birth </label>
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabeldob" type="date" class="form-control input-border-bottom" name="emp_dob">
		
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel1"  name="marital_status">
<option value="">&nbsp;</option>
<option value="Single">Single</option>
<option value="Married">Married</option>
<option value="Unmarried">Unmarried</option>
<option value="Widow">Widow</option>
<option value="Divorce">Divorce</option>
</select>
<label for="selectFloatingLabel1" class="placeholder">Marital Status</label>
</div>
	</div>
	
  <div class="col-md-4">
  <div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel3" name="nationality">
<option value="">&nbsp;</option>
 @foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->nationality==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option>
                       @endforeach
</select>
<label for="selectFloatingLabel3" class="placeholder"> Select Nationality</label>
</div>
  </div>
  </div>
  <div class="row">
  
<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelfon" type="email" class="form-control input-border-bottom" required="" name="emp_ps_email">
		<label for="inputFloatingLabelfon" class="placeholder">Email <span style="color:red;">*</span></label>
	</div>
	</div>

		 <div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelphone" type="tel" class="form-control input-border-bottom" required="" name="emp_ps_phone">
		<label for="inputFloatingLabelphone" class="placeholder">Contact Number <span style="color:red;">*</span></label>
	</div>
	</div>
	
	 <div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelphonealter" type="tel" class="form-control input-border-bottom" name="em_contact">
		<label for="inputFloatingLabelphonealter" class="placeholder">Alternative Number</label>
	</div>
	</div>
  </div>
  
  
  
  <h3 style="margin-top:20px;color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Service Details</h3>
 
  <div class="row ">
		<div class="col-md-4">
			<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel3" name="emp_department"  onchange="chngdepartment(this.value);">
					<option value="">&nbsp;</option>
					 @foreach($department as $dept)
                     <option value="{{$dept->department_name}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_department==$dept->department_name){ echo 'selected';} } ?>>{{$dept->department_name}}</option>
                       @endforeach
				</select>
				<label for="selectFloatingLabel3" class="placeholder">Department </label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel4"  name="emp_designation">
					<option value="">&nbsp;</option>
					
				</select>
				<label for="selectFloatingLabel4" class="placeholder">Designation </label>
			</div>
		</div>
		<div class="col-md-4">
		<div class="form-group ">
		<label for="inputFloatingLabel4" class="placeholder">Date of Joining </label>
<input id="inputFloatingLabel4 form-date" type="date" class="form-control "  name="emp_doj" max="<?= date('Y-m-d')?>" >

</div>
		</div>
	</div>
				   <div class="row">
				   
				   
				   <div class="col-md-4">
<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel5"  name="emp_status">
					<option value="">&nbsp;</option>
					 @foreach($employee_type as $emp)
                        <option value="{{$emp->employee_type_name}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_status==$emp->employee_type_name){ echo 'selected';} } ?>>{{$emp->employee_type_name}}</option>
                        @endforeach
				</select>
				<label for="selectFloatingLabel5" class="placeholder">Employment  Type  </label>
			</div>
</div>
	


<div class="col-md-4">
		<div class="form-group form-floating-label">
<input id="inputFloatingLabel6" type="date" class="form-control input-border-bottom"  name="date_confirm">
<label for="inputFloatingLabel6" class="placeholder">Date of Confirmation</label>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel7" type="date" class="form-control input-border-bottom" name="start_date">
<label for="inputFloatingLabel7" class="placeholder">Contract Start Date</label>
</div>
</div>



</div>

<div class="row">
<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel8" type="date" class="form-control input-border-bottom" name="end_date">
<label for="inputFloatingLabel8" class="placeholder">Contract End Date (If Applicable)</label>
</div>
</div>
  <!--<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel9" type="text" class="form-control input-border-bottom" required="" name="fte" >
<label for="inputFloatingLabel9" class="placeholder">FTE</label>
</div>
</div>-->
<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel10" type="text" class="form-control input-border-bottom" name="job_loc" >
<label for="inputFloatingLabel10" class="placeholder">Job Location</label>
</div>
</div>
</div>

<div class="row">
<div class="col-md-4 form-group">
<label>Profile Picture</label>
 <input type="file" accept="image/*;capture=camera" name="emp_image" id="emp_image" onchange="Filevalidationproimge()">
 
 <small> Please select  image which size up to 2mb</small>
</div>
<div class="col-md-4">
<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabelra" name="emp_reporting_auth" >
<option value="">&nbsp;</option>
 @foreach($employeelists as $employeelist)
                        <option value="{{$employeelist->emp_code}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_reporting_auth==$employeelist->emp_code){ echo 'selected';} } ?>>{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
                        @endforeach
</select>
<label for="selectFloatingLabelra" class="placeholder">Reporting Authority</label>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabells"  name="emp_lv_sanc_auth" >
<option value="">&nbsp;</option>
  @foreach($employeelists as $employee)
                        <option value="{{$employee->emp_code}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_lv_sanc_auth==$employee->emp_code){ echo 'selected';} } ?>>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}} ({{$employee->emp_code}})</option>
                        @endforeach
</select>
<label for="selectFloatingLabells" class="placeholder">Leave Sanction Authority</label>
</div>
</div>
</div>	


<div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>
  
                  <div class="button-row d-flex mt-4">
                     
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
                </div>
              </div>
			  
			  <!--single form panel-->
              
			  
			  
			  
	<!--single form panel-->
              <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Educational  Details</h3>
                <div class="multisteps-form__content">
                   
				   
                  <div class="table-responsive">
				    <table class="table table-bordered" style="width:100%;border-top: 1px solid #ddd;margin-top:15px;">
					<thead>
					  <tr>
					   <th>Sl. No.</th>
					   <th>Qualification</th>
					   <th>Subject</th>
					   <th>Institution Name</th>
					   <th>Awarding Body/ University</th>
					   <th>Year of Passing</th>
					   <th>Percentage</th>
					   <th>Grade/Division</th>
					    <th>Transcript Document</th>
					   <th>Certificate Document</th>
					   <th></th>
					  </tr>
					</thead>
					<tbody id="dynamic_row">
					<?php $tr_id=0; ?>
					  <tr class="itemslot" id="<?php echo $tr_id; ?>" >
					    <td>1</td>
						 <td><input type="text" class="form-control" name="quli[]"></td>
						 <td><input type="text" class="form-control" name="dis[]"></td>
						 <td><input type="text" class="form-control" name="ins_nmae[]"></td>
						 <td><input type="text" class="form-control" name="board[]"></td>
						 <td><input type="text" class="form-control" name="year_passing[]"></td>
						 <td><input type="text" class="form-control" name="perce[]"></td>
						 <td><input type="text" class="form-control" name="grade[]"></td>
						 <td><input type="file" accept="image/*;capture=camera" class="form-control" name="doc[]" id="doc<?= $tr_id=0; ?>"  onchange="Filevalidationdocnew(<?php $tr_id=0; ?>)">  <small> Please select  file which size up to 2mb</small></td>
						  <td><input type="file" accept="image/*;capture=camera" class="form-control" name="doc2[]"  id="doc2<?= $tr_id ?>"  onchange="Filevalidationdocnewdoc(<?= $tr_id ?>)">  <small> Please select  file which size up to 2mb</small></td>
						 <td><button class="btn btn-success" type="button" id="add<?php echo ($tr_id+1); ?>" onClick="addnewrow(<?php echo ($tr_id+1); ?>)" data-id="<?php echo ($tr_id+1); ?>"> <i class="fas fa-plus"></i> </button>
						</td>
					  </tr>
					</tbody>
					</table> 
				   </div>
                  <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Job Details</h3>
				  <?php $tredu_id=0; ?>
				  <div id="dynamic_row_edu">
				  
				  <div class="itemslotedu" id="<?php echo $tredu_id; ?>">
				  <div class="row " >
				  <div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobt" type="text" class="form-control input-border-bottom"  name="job_name[]">
		<label for="inputFloatingLabel-jobt" class="placeholder">Job Title</label>
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobs" type="date" class="form-control input-border-bottom" name="job_start_date[]">
		<label for="inputFloatingLabel-jobs" class="placeholder">Start Date</label>
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobe" type="date" class="form-control input-border-bottom" name="job_end_date[]">
		<label for="inputFloatingLabel-jobe" class="placeholder">End Date</label>
	</div>
	</div>
		</div>
		
		          <div class="row">
				  <div class="col-md-4">
<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabelexp"  name="exp[]">
<option value="">&nbsp;</option>
@for ($i = 0; $i <= 10; $i++)
    The current value is 
<option value="{{ $i }}">{{ $i }}</option>
@endfor


</select>
<label for="selectFloatingLabelexp" class="placeholder">Year of Experience</label>
</div>
</div><div class="col-md-6">
				  
				  <div class="form-group form-floating-label">

	<textarea id="inputFloatingLabel-jobs"  rows="5" class="form-control"  style="margin-top: 18px;height:135px !important;resize:none;"  name="des[]"> </textarea>  
<label for="inputFloatingLabel-jobs" class="placeholder">Job Description</label>
</div>
</div>




<div class="col-md-2" style="margin-top:13px;">
<button class="btn btn-success" type="button"  id="addedu<?php echo $tredu_id; ?>" onClick="addnewrowedu(<?php echo $tredu_id; ?>)" data-id="<?php echo $tredu_id; ?>"><i class="fas fa-plus"></i> </button>
</div>
</div>
	</div>		
</br>	
		         </div>																																																												<div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>																													
                  <div class="button-row d-flex mt-4">
                      
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
				  
				  
                </div>
				</div>
				
				<div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Training Details</h3>
				 <?php $tretarin_id=0; ?>
				
                <div class="multisteps-form__content "  >
                 
				   <div id="dynamic_row_train" >
				  <div class="itemslottrain" id="<?php echo $tretarin_id; ?>">
				   
                  <div class="row">
				   <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr1" type="text" class="form-control input-border-bottom"  name="tarin_name[]">
						<label for="inputFloatingLabeltr1" class="placeholder">Title</label>
					</div>
				   </div>
				   <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom" name="tarin_start_date[]">
						<label for="inputFloatingLabeltr2" class="placeholder">Start Date</label>
					</div>
				   </div>
				    <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom"  name="tarin_end_date[]">
						<label for="inputFloatingLabeltr2" class="placeholder">End Date</label>
					</div>
				   </div>
				  </div>
				  
				  <div class="row">
				  <div class="col-md-4">
				     <div class="form-group form-floating-label">
				         	<textarea id="inputFloatingLabeltr4"  rows="5" class="form-control"   style="margin-top: 18px;height:135px !important;resize:none;"  name="train_des[]"> </textarea>  
						
						<label for="inputFloatingLabeltr4" class="placeholder">Description</label>
					</div>
					</div>
					<div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button" id="addtarin<?php echo $tretarin_id; ?>" onClick="addnewrowtarin(<?php echo $tretarin_id; ?>)" data-id="<?php echo $tretarin_id; ?>"><i class="fas fa-plus"></i> </button></div>
				  </div>
                 </div>
				 </div>
				  
				  																																																																		<div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>																							
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
				  
				  
                </div>
				</div>
				</br>
				
				
				
				<div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
               
                <div class="multisteps-form__content">
                  
<h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Emergency / Next of Kin Contact Details </h3>

	<div class="row">
	<div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelien" type="text" class="form-control input-border-bottom" name="em_name">
<label for="inputFloatingLabelien" class="placeholder">Name</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<!-- <input id="inputFloatingLabelier" type="text" class="form-control input-border-bottom" name="em_relation">-->
<select class="form-control input-border-bottom" id="inputFloatingLabelier" name="em_relation" onchange="crinabi(this.value);">
<option value="">&nbsp;</option>
<option value="Father"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Father'){ echo 'selected';} } ?>>Father</option>
<option value="Mother"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Mother'){ echo 'selected';} } ?>>Mother </option>
<option value="Wife"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Wife'){ echo 'selected';} } ?>>Wife</option>
<option value="Relatives"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Relatives'){ echo 'selected';} } ?>>Relatives</option>
  
  
  <option value="Husband"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Husband'){ echo 'selected';} } ?>>Husband</option>
<option value="Partner"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Partner'){ echo 'selected';} } ?>>Partner</option>
<option value="Son"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Son'){ echo 'selected';} } ?>>Son</option>
<option value="Daughter"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Daughter'){ echo 'selected';} } ?>>Daughter</option>
<option value="Friend"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Friend'){ echo 'selected';} } ?>>Friend</option>
<option value="Others"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Others'){ echo 'selected';} } ?>>Others</option>
</select>
<label for="inputFloatingLabelier" class="placeholder">Relationship</label>
</div>
	
	  </div>
	   	 <div class="col-md-3 " id="criman_new"   <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Others'){ ?> style="display:block;" <?php }else { ?> style="display:none;" <?php   } }else{ ?> style="display:none;" <?php } ?> >
										    <div class="form-group form-floating-label">
										        	
												<input id="relation_others"  type="text" class="form-control input-border-bottom" name="relation_others"  >
											<label for="relation_others" class="placeholder">Give Details </label>
											</div>
										   </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliemail" type="email" class="form-control input-border-bottom" name="em_email" >
<label for="inputFloatingLabeliemail" class="placeholder">Email</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliem" type="text" class="form-control input-border-bottom" name="em_phone" >
<label for="inputFloatingLabeliem" class="placeholder">Emergency Contact No.</label>
</div>
	
	  </div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelienad" type="text" class="form-control input-border-bottom" name="em_address" >
<label for="inputFloatingLabelienad" class="placeholder">Address</label>
</div>
	
	  </div>
	</div>
	<h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Certified Membership</h3>

<div class="row">
	<div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelicl" type="text" class="form-control input-border-bottom" name="titleof_license">
<label for="inputFloatingLabelicl" class="placeholder">Title of Certified License</label>
</div>
	
	  </div>
	    <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliln" type="text" class="form-control input-border-bottom" name="cf_license_number" >
<label for="inputFloatingLabeliln" class="placeholder">License Number</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelisd" type="date" class="form-control input-border-bottom" name="cf_start_date" >
<label for="inputFloatingLabelisd" class="placeholder">Start Date</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelied" type="date" class="form-control input-border-bottom" name="cf_end_date" >
<label for="inputFloatingLabelied" class="placeholder">End Date</label>
</div>
	
	  </div>

	</div>



																														<div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>																																																																				
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
                </div>
              </div>
              <!--single form panel-->
              <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Contact Information (Correspondence Address)</h3>
                <div class="multisteps-form__content">
                   <div class="row form-group">
                       <div class="col-md-4">
<div class="form-group form-floating-label">
<input id="parmenent_pincode" type="text" class="form-control input-border-bottom"   onchange="getcode();" name="emp_pr_pincode">
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
												<input id="parmenent_street_name" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no" >
												<label for="parmenent_street_name" class="placeholder">Address Line 1</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="parmenent_village" type="text" class="form-control input-border-bottom"  name="emp_per_village">
												<label for="parmenent_village" class="placeholder">Address Line 2</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state" >
												<label for="emp_pr_state" class="placeholder">Address Line 3</label>
											</div>
		</div>
	
				   
	<div class="col-md-4">
		<div class="form-group form-floating-label">
												<input  id="parmenent_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city" >
												<label for="parmenent_city" class="placeholder">City / County</label>
											</div>
</div>

<div class="col-md-4">

<div class="form-group form-floating-label">
	<select class="form-control input-border-bottom"   name="emp_pr_country" id="parmenent_country">
	<option value="">&nbsp;</option>
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}"    @if(trim($currency_valu->country)=='United Kingdom') selected  @endif>{{$currency_valu->country}}</option>
                       @endforeach

												</select>
<label for="parmenent_country" class="placeholder">Country</label>
</div>
		
</div>
<div class="col-md-4">
			<div class="form-group ">
							<img  id="imgshowproof" width='100%'>
												 <input id="imagedataproof" type="hidden" class="form-control input-border-bottom" name="imagedataproof"  value="">
												
			<input  type="file"  accept="image/x-png,image/jpeg,image/png;capture=camera"  class="form-control imagefile"  name="pr_add_proof" id="pr_add_proof" onchange="Filevalidationdoproff()">
			 <small> Please select  file which size up to 2mb</small>
			<label for="pr_add_proof" class="placeholder">Proof Of Address</label>
			</div>
		</div>
</div>
<h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Other Documents</h3>
	<?php $trupload_id=0; ?>
	<div id="dynamic_row_upload">
		<div class="row itemslotupload" id="<?php echo $trupload_id; ?>">
				  <div class="col-md-4">
				    <div class="form-group form-floating-label">
					<input id="selectFloatingLabel" type="text" class="form-control input-border-bottom"  name="type_doc[]">
												
												<label for="selectFloatingLabel" class="placeholder">Type of Document</label>
											</div>
				  </div>
				  
				  <div class="col-md-4">
				  <label>Uplaod Documents</label>
				    <input type="file" class="form-control-file" id="docu_nat<?php echo $trupload_id; ?>" onchange="Filevalidationdocother(<?php echo $trupload_id; ?>)" name="docu_nat[]">
				   <small> Please select  file which size up to 2mb</small>
				  </div>
				  <div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button"  id="addupload<?php echo $trupload_id; ?>" onClick="addnewrowupload(<?php echo $trupload_id; ?>)" data-id="<?php echo $trupload_id; ?>"><i class="fas fa-plus"></i> </button></div>
				</div>
	</div>

																							<div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>																																																										
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
                </div>
              </div>
    
	
	
	           <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                
				<h4 style="color: #1269db;">Passport Details</h4>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no">	
	<label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>	

</div>
</div>	

                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp" name="pass_nat">
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
<input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom"  name="place_birth">
<label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>	

</div>
</div>						

			            <div class="col-md-3">
			<div class="form-group form-floating-label">
			<input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by">
			<label for="inputFloatingLabelib" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
					
						
				  </div>
				  
				  
				  
				   <div class="row">
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label" >	
						<input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" >	
			<label for="inputFloatingLabelid" class="placeholder">Issued Date</label>																												</div>
			</div>
				   <div class="col-md-3">
							<div class="form-group form-floating-label">	
							<input id="pass_exp_date" type="date" class="form-control input-border-bottom" onblur="getreviewdate();" name="pass_exp_date">	
			<label for="pass_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label">						
					<input id="pass_review_date" type="date" class="form-control input-border-bottom" readonly name="pass_review_date" >	
			<label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
						<div class="col-md-3">
							<label>Upload Document</label>
								<img  id="imgshowpass" width='100%'>
												 <input id="imagedatapass" type="hidden" class="form-control input-border-bottom" name="imagedatapass"  value="">
												
								<input type="file" accept="image/x-png,image/jpeg,image/png;capture=camera" class="form-control imagefile"  name="pass_docu"  id="pass_docu" onchange="Filevalidationdopassdocu()">
					 <small> Please select  file which size up to 2mb</small>
						</div>
							
						
						</div>
						
						<div class="row">
					
						<div class="col-md-3">
						  <div class="form-check">
												<label>Is this your current passport?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="cur_pass" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="cur_pass" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
						</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks">
												<label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
											</div>
						</div>
						</div>
				  
				   
				   
				   </div>
				   <br>
				   <hr>
				   <h4 style="color: #1269db;">Visa Details</h4>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="visa_doc_no">
<label for="inputFloatingLabeldn1" class="placeholder">BRP No.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="visa_nat" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
	<div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabel" name="country_residence">
												<option value="">&nbsp;</option>
												@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach
												</select>
												<label for="selectFloatingLabel" class="placeholder">Country of Residence</label>
											</div>
						</div>
			            <div class="col-md-3">
			<div class="form-group form-floating-label"><input id="inputFloatingLabelib1" type="text" class="form-control input-border-bottom"  name="visa_issue">	
			<label for="inputFloatingLabelib1" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
						
				  </div>
				    
					
				  
				  
				   <div class="row">
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="visa_issue_date">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="visa_exp_date" onblur="getreviewvisdate();" type="date" class="form-control input-border-bottom" name="visa_exp_date">	
			<label for="visa_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="visa_review_date" readonly   type="date" class="form-control input-border-bottom" name="visa_review_date">	
			<label for="visa_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
						<div class="col-md-3">
							<label>Upload  Front Side Document</label>
										
				<img  id="imgshowvisa" width='100%'>
												 <input id="imagedatavisa" type="hidden" class="form-control input-border-bottom" name="imagedatavisa"  value="">
												
								<input type="file"  accept="image/x-png,image/jpeg,image/png;capture=camera" class="form-control imagefile" name="visa_upload_doc" id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
						 <small> Please select  file which size up to 2mb</small>
						</div>
						
						</div>
						
						<div class="row">
					<div class="col-md-3">
							<label>Upload Back Side Document</label>
								<img  id="imgshowvisaback" width='100%'>
												 <input id="imagedatavisaback" type="hidden" class="form-control input-border-bottom" name="imagedatavisaback"  value="">
												
								<input type="file" class="form-control  imagefile" name="visaback_doc" accept="image/x-png,image/jpeg,image/png;capture=camera" id="visaback_doc" onchange="Filevalidationdopassdvisaeback()">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current visa?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="visa_cur" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="visa_cur" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="visa_remarks" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
		
						</div>
				  
				   
				   
				   </div>
				    </br>
				    <hr>
				    <h4 style="color: #1269db;">EUSS details </h4>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="euss_ref_no">
<label for="inputFloatingLabeldn1" class="placeholder">Reference Number.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="euss_nation" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
	
			        																										
						
				  
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="euss_issue_date">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="euss_exp_date" type="date" class="form-control input-border-bottom" name="euss_exp_date" 
onchange="getrevieweussdate();">	
			<label for="euss_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="euss_review_date" type="date" readonly class="form-control input-border-bottom" name="euss_review_date">	
			<label for="euss_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
								<input type="file" class="form-control" name="euss_upload_doc" id="euss_upload_doc" onchange="Filevalidationdopassduploadae()">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
						
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="euss_cur" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="euss_cur" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="euss_remarks" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
		
						</div>
				  
				   
				   
				   </div>
				   
				   </br>
				    <hr>
				   
				    <h4 style="color: #1269db;">National Id details </h4>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="nat_id_no">
<label for="inputFloatingLabeldn1" class="placeholder">National id number.</label>	

</div>
</div>	
                    																									
	
			            <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="nat_nation" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																											
						    <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="nat_country_res" >
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                       @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Country of Residence</label>
											</div>
						</div>	
				 
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="nat_issue_date">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="nat_exp_date" type="date" class="form-control input-border-bottom" name="nat_exp_date" 
onchange="getreviewnatdate();">	
			<label for="nat_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="nat_review_date" type="date" readonly class="form-control input-border-bottom" name="nat_review_date">	
			<label for="nat_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
								<input type="file" class="form-control" name="nat_upload_doc" id="nat_upload_doc" onchange="Filevalidationdopassduploadnat()">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
						</div>
						
						<div class="row">
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="nat_cur" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="nat_cur" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="nat_remarks" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
		
						</div>
				  
				   
				   
				   </div>
				   </br>
				    <hr>
				    <h4 style="color: #1269db;">Other  details </h4>
                <div class="multisteps-form__content">
				<?php $truotherdocpload_id=0; ?>
				<div id="dynamic_row_upload_other">
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
				   
				   </div>
				   </div>
				   <div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
					<button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                    <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
                  </div>
                </div>
				
				
              <!--single form panel-->
              <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Pay Details</h3>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-4">
								
						<div class="form-group form-floating-label">
							<select class="form-control input-border-bottom" id="emp_group_name" name="emp_group_name" onchange="paygr(this.value);">
								<option value="">&nbsp;</option>					
@foreach($grade as $gradeval)
                     <option value="{{$gradeval->id}}" >{{$gradeval->grade_name}}</option>
                       @endforeach
												</select>
												<label for="emp_group_name" class="placeholder">Pay Group </label>
						</div>
						</div>
						
						<div class="col-md-4">
				    <div class="form-group form-floating-label">
								<select class="form-control input-border-bottom" id="emp_pay_scale"  name="emp_pay_scale">
													<option value="">&nbsp;</option>
													
												</select>
												<label for="emp_pay_scale" class="placeholder">Annual Pay</label>
						</div>
						</div>
							<div class="col-md-4">
								
						<div class="form-group form-floating-label">
							<select class="form-control input-border-bottom" id="wedges_paymode" name="wedges_paymode">
								<option value="">&nbsp;</option>					
@foreach($payment_wedes_rs as $gradevalwed)
                     <option value="{{$gradevalwed->id}}" >{{$gradevalwed->pay_type}}</option>
                       @endforeach
												</select>
												<label for="wedges_paymode" class="placeholder">Wedges pay mode </label>
						</div>
						</div>
						<div class="col-md-4">
								<div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelpt" name="emp_payment_type" onchange="pay_type_epmloyee(this.value);">
													<option value="">&nbsp;</option>
													
@foreach($payment_type_master as $valtion)
                     <option value="{{$valtion->id}}" >{{$valtion->pay_type}}</option>
                       @endforeach
												</select>
												<label for="selectFloatingLabelpt" class="placeholder">Payment Type</label>
											</div>
						</div>
						
						
					
						
						<div class="col-md-4">
								
								<div class="form-group ">
												<input id="daily" type="text" class="form-control input-border-bottom" name="daily">
												<label for="daily" class="placeholder">Basic / Daily Wedges</label>
											</div>
						</div>
						
					<div class="col-md-4">
								
								<div class="form-group ">
												<input id="min_work" type="text" class="form-control" name="min_work">
												<label for="min_work" class="placeholder">Min. Working Hour</label>
											</div>
						</div>
						
				  <div class="col-md-4">
							<div class="form-group ">
												<input id="min_rate" type="text" class="form-control "  name="min_rate">
												<label for="min_rate" class="placeholder">Rate</label>
											</div>
						</div>
				   
				   
				   
				   
				 
				   		<div class="col-md-4">
				   <div class="form-group form-floating-label">
								<select class="form-control input-border-bottom" id="selectFloatingLabeltc"  name="tax_emp" onchange="tax_epmloyee(this.value);">
													<option value="">&nbsp;</option>
													
@foreach($tax_master as $taxtion)
                     <option value="{{$taxtion->id}}" >{{$taxtion->tax_code}}</option>
                       @endforeach
												</select>
												<label for="selectFloatingLabeltc" class="placeholder">Tax Code</label>
						</div>
				   </div>
						<div class="col-md-4">
								<div class="form-group ">
												<input id="tax_ref" type="text" class="form-control "  name="tax_ref">
												<label for="tax_ref" class="placeholder">Tax Reference</label>
											</div>
						</div>
						
						<div class="col-md-4">
								<div class="form-group ">
												<input id="tax_per" type="text" class="form-control "  name="tax_per">
												<label for="tax_per" class="placeholder">Tax Percentage</label>
											</div>
						</div>
						<div class="col-md-4">
							<div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabepm"  name="emp_pay_type">
													<option value="">&nbsp;</option>
													<option value="Cash">Cash</option>
													<option value="Bank">Bank</option>
													
												</select>
												<label for="selectFloatingLabepm" class="placeholder">Payment Mode</label>
											</div>
						</div>
						 <div class="col-md-4">
								<div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" name="emp_bank_name" id="emp_bank_name"  onchange="populateBranch(this.value);">
													<option value="">&nbsp;</option>
													@if(isset($bank) && !empty($bank))
					@foreach($bank as $key=>$value)
						<option value="{{ $value->id}}" >{{ $value->master_bank_name}}</option>
					@endforeach
					@endif
												</select>
												<label for="emp_bank_name" class="placeholder">Bank Name</label>
											</div>
						</div>
						
						<div class="col-md-4">
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelbrn" type="text" class="form-control input-border-bottom"  name="bank_branch_id">
												<label for="inputFloatingLabelbrn" class="placeholder">Branch Name</label>
											</div>
						</div>
						
						
				   
						
						
						
				   
				  <div class="col-md-4">
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelbn" type="text" class="form-control input-border-bottom" name="emp_account_no">
												<label for="inputFloatingLabelbn" class="placeholder">Account No</label>
											</div>
						</div>
						
					<div class="col-md-4">
								<div class="form-group ">
												<input id="emp_sort_code" type="text" class="form-control"  name="emp_sort_code">
												<label for="emp_sort_code" class="placeholder">Sort Code</label>
											</div>
						</div>
						
						<div class="col-md-4">
								<div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelpc" name="currency">
													<option value="">&nbsp;</option>
													
@foreach($currency_master as $currtion)
                     <option value="{{$currtion->code}}" >{{$currtion->code}}</option>
                       @endforeach
													
												</select>
												<label for="selectFloatingLabelpc" class="placeholder">Payment Currency</label>
											</div>
						</div>
				   </div>				   
				   </div>
				   
				   
				   
				  
				   <div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>
                  <div class="button-row d-flex mt-4">
                     
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
					<button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                    <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
                  </div>
                </div>
				
			
				
				
				
				
				<div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Pay Structure</h3>
				
                <div class="multisteps-form__content">
                   
				   
				  <h3 class="multisteps-form__title" style="background: #1572e8;color: #fff;padding: 4px 15px;">Payment (Taxable)</h3> 
					<div class="row form-group">
			
		<label class="col-md-3 checkbox-inline"><input type="checkbox"   name="da" value="1"> Dearness Allowance</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox"  name="hra" value="1"> House Rent Allowance</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox" name="conven_ta" value="1"> Conveyance Allowance</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox"  name="perfomance" value="1"> Performance Allowance</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox"  name="monthly_al" value="1"> Monthly Fixed Allowance</label>
		</div>	
				  
				    <h3 class="multisteps-form__title" style="background: #1572e8;color: #fff;padding: 4px 15px;">Deduction</h3> 
					
					<div class="row form-group">
			
		<label class="col-md-3 checkbox-inline"><input type="checkbox" name="pf_al" value="1" >  NI Deduction</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox" name="income_tax" value="1"> I. Tax Deduction</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox" name="cess" value="1"> I. Tax Cess</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox" name="esi" value="1"> ESI</label>
<label class="col-md-3 checkbox-inline"><input type="checkbox" name="professional_tax" value="1"> Prof Tax</label>
		</div>
				   
				   </div>
				   
				   <hr>
				  
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Back</button>
					
                    <button class="btn btn-success ml-auto"  type="submit" title="Submit" onclick="cropme();">Submit</button>
                    <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
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
	
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('employeeassets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('employeeassets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('employeeassets/js/setting-demo2.js')}}"></script>
		<script src="{{ asset('rcrop/dist/rcrop.min.js') }}"></script>
	<!--<script type="text/javascript" src="jquery-ui-1.10.3/ui/jquery.ui.datepicker.js"></script>-->
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
	
<script type="text/javascript">
//DOM elements
const DOMstrings = {
  stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next' };


//remove class from a set of items
const removeClasses = (elemSet, className) => {

  elemSet.forEach(elem => {

    elem.classList.remove(className);

  });

};

//return exect parent node of the element
const findParent = (elem, parentClass) => {

  let currentNode = elem;

  while (!currentNode.classList.contains(parentClass)) {
    currentNode = currentNode.parentNode;
  }

  return currentNode;

};

//get active button step number
const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

//set all steps before clicked (and clicked too) to active
const setActiveStep = activeStepNum => {

  //remove active state from all the state
  removeClasses(DOMstrings.stepsBtns, 'js-active');

  //set picked items to active
  DOMstrings.stepsBtns.forEach((elem, index) => {

    if (index <= activeStepNum) {
      elem.classList.add('js-active');
    }

  });
};

//get active panel
const getActivePanel = () => {

  let activePanel;

  DOMstrings.stepFormPanels.forEach(elem => {

    if (elem.classList.contains('js-active')) {

      activePanel = elem;

    }

  });

  return activePanel;

};

//open active panel (and close unactive panels)
const setActivePanel = activePanelNum => {

  //remove active class from all the panels
  removeClasses(DOMstrings.stepFormPanels, 'js-active');

  //show active panel
  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === activePanelNum) {

      elem.classList.add('js-active');

      setFormHeight(elem);

    }
  });

};

//set form height equal to current panel height
const formHeight = activePanel => {

  const activePanelHeight = activePanel.offsetHeight;

  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
  const activePanel = getActivePanel();

  formHeight(activePanel);
};

//STEPS BAR CLICK FUNCTION
DOMstrings.stepsBar.addEventListener('click', e => {

  //check if click target is a step button
  const eventTarget = e.target;

  if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
    return;
  }

  //get active button step number
  const activeStep = getActiveStep(eventTarget);

  //set all steps before clicked (and clicked too) to active
  setActiveStep(activeStep);

  //open active panel
  setActivePanel(activeStep);
});

//PREV/NEXT BTNS CLICK
DOMstrings.stepsForm.addEventListener('click', e => {

  const eventTarget = e.target;

  //check if we clicked on `PREV` or NEXT` buttons
  if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
  {
    return;
  }

  //find active panel
  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

  //set active step and active panel onclick
  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
    activePanelNum--;

  } else {

    activePanelNum++;

  }

  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);

});

//SETTING PROPER FORM HEIGHT ONLOAD
window.addEventListener('load', setFormHeight, false);

//SETTING PROPER FORM HEIGHT ONRESIZE
window.addEventListener('resize', setFormHeight, false);

//changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

const setAnimationType = newType => {
  DOMstrings.stepFormPanels.forEach(elem => {
    elem.dataset.animation = newType;
  });
};

//selector onchange - changing animation
const animationSelect = document.querySelector('.pick-animation__select');

animationSelect.addEventListener('change', () => {
  const newAnimationType = animationSelect.value;

  setAnimationType(newAnimationType);
});
</script>


<script>
$(".answer").hide();
$(".coupon_question").click(function() {
    if($(this).is(":checked")) {
        $(".answer").show();
    } else {
        $(".answer").hide();
    }
});
</script>

<script> 
   $('#selectFloatingLabel1').change(function() {
        $('.write-type').hide();
        $('#' + $(this).val()).show();
 });
 
 
 
</script>
<script> 
   $('#selectFloatingLabel5').change(function() {
        $('.contract').hide();
        $('#' + $(this).val()).show();
 });
 
 
 
</script>
<script> 
   $('#selectFloatingLabepm').change(function() {
        $('.bankdet').hide();
        $('#' + $(this).val()).show();
 });
 
 
 
</script>

<script>
var room = 1;

   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
   
   function chngdepartment(empid){
	   var emid="<?= $emid;?>";
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigappById')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("selectFloatingLabel4").innerHTML = response;
		}
		});
   }
   
   
   
   function addnewrow(rowid)
	{



		if (rowid != ''){
				$('#add'+rowid).attr('disabled',true);

		}



		$.ajax({

				url:'{{url('settings/get-add-row-item')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row").append(response);

				}
			});
	}

	function delRow(rowid)
	{
		var lastrow = $(".itemslot:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#add'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButton',function() {
            $(this).closest("tr.itemslot").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
	}
	
			function addnewrowedu(rowid)
	{



		if (rowid != ''){
				$('#addedu'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('settings/get-add-row-item-edu')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row_edu").append(response);

				}
			});
	}

	function delRowedu(rowid)
	{
		var lastrow = $(".itemslotedu:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#addedu'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButtonedu',function() {
            $(this).closest("div.itemslotedu").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
	}
			function addnewrowtarin(rowid)
	{



		if (rowid != ''){
				$('#addtarin'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('settings/get-add-row-item-train')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row_train").append(response);

				}
			});
	}

	function delRowtrain(rowid)
	{
		var lastrow = $(".itemslottrain:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#addtarin'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButtontrain',function() {
            $(this).closest("div.itemslottrain").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
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
            $("#emp_ps_state").prop("readonly", false);
            $("#present_country").prop("readonly", false);
            $("#present_pincode").prop("readonly", false);
          
    }
    });

    /*$(document).on('change','#emp_bank_name', function(e){
    	var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
    	$('#emp_ifsc_code').val(ifsccode);

    });*/
});



	function addnewrowupload(rowid)
	{



		if (rowid != ''){
				$('#addupload'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('settings/get-add-row-item-upload')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row_upload").append(response);

				}
			});
	}

	function delRowupload(rowid)
	{
		var lastrow = $(".itemslotupload:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#addupload'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButtonupload',function() {
            $(this).closest("div.itemslotupload").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
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
	
	
	function paygr(val){
		var empid=val;
	 var emid="<?= $emid;?>";
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeeannulappById')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("emp_pay_scale").innerHTML = response;
		}
		});
	}
	
	function pay_type_epmloyee(val){
			var empid=val;
		var emid="<?= $emid;?>";
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeeminworkappById')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			 var obj = jQuery.parseJSON(response);
			  console.log(obj);
			  var work=obj.work_hour;
			 var rate=obj.rate;
			 if(!rate){
				   $("#min_rate").val('');
				   $("#min_work").val('');
				 $("#daily").attr("readonly",false);
				   $("#min_rate").attr("readonly", true);
					 $("#min_work").attr("readonly", true); 
					
					
				  
			 }else{
				  $("#min_rate").val(rate);
				   $("#min_work").val(work);
				    $("#min_rate").attr("readonly", true);
					 $("#min_work").attr("readonly", true);
					  $("#daily").attr("readonly", true); 
			 }
		}
		});
	}
	
	
	function tax_epmloyee(val){
		var empid=val;
			var emid="<?= $emid;?>";
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeetaxempappById')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			 var obj = jQuery.parseJSON(response);
			 
			  var per_de=obj.per_de;
			 var tax_ref=obj.tax_ref;
			 
				  $("#tax_ref").val(tax_ref);
				   $("#tax_per").val(per_de);
				    $("#tax_ref").attr("readonly", true);
					 $("#tax_per").attr("readonly", true);
					  
			 
		}
		});
	}	
		function populateBranch(val){

			var emp_bank_id = val;
	var emid="<?= $emid;?>";
			$.ajax({
				type:'GET',
				url:'{{url('attendance/get-app-employee-bank')}}/'+emp_bank_id+'/'+emid,
				success: function(response){


 
if ($.trim(response) == null || $.trim(response) == undefined){ 
			
				 
				
				  
				  
			  }else{
				  
				   var obj = jQuery.parseJSON(response);
				  
				  if(obj===null){
					  $("#emp_sort_code").val('');
				   
				  }else{
					  var bank_sort=obj.bank_sort; 
					  $("#emp_sort_code").val(bank_sort);
			
				   
				  }
				   
				
				  
			  }
				}
			});
		}
		
		
</script>
<script>
function diabi(val) {
	if(val=='Yes'){
	document.getElementById("dis_new").style.display = "block";	
	}else{
		document.getElementById("dis_new").style.display = "none";	
	}
  
}
function crinabi(val) {
	if(val=='Others'){
	document.getElementById("criman_new").style.display = "block";	
	}else{
		document.getElementById("criman_new").style.display = "none";	
	}
  
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

	Filevalidationdocotherbbg = (val) => { 
        const fi = document.getElementById('docu_nat_'+val); 
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
                      	$("#docu_nat_"+val).val('');  
                } 
            } 
        } 
    }



	Filevalidationdocnytrtyhh2 = (val) => { 
        const fi = document.getElementById('doc2_h'+val); 
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
                      	$("#doc2_h"+val).val('');  
                } 
            } 
        } 
    }

	Filevalidationdocnytrty = (val) => { 
        const fi = document.getElementById('doc_h'+val); 
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
                      	$("#doc_h"+val).val('');  
                } 
            } 
        } 
    }

	Filevalidationdocnew = (val) => { 
        const fi = document.getElementById('doc'+val); 
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
                      	$("#doc"+val).val('');  
                } 
            } 
        } 
    }
	Filevalidationdocnewdoc = (val) => { 
        const fi = document.getElementById('doc2'+val); 
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
                      	$("#doc2"+val).val('');  
                } 
            } 
        } 
    }

	Filevalidationdocother = (val) => { 
        const fi = document.getElementById('docu_nat'+val); 
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
                      	$("#docu_nat"+val).val('');  
                } 
            } 
        } 
    }



	Filevalidationproimge = () => { 
        const fi = document.getElementById('emp_image'); 
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
                      	$("#emp_image").val('');  
                } 
            } 
        } 
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
    	function addnewrowupload(rowid)
	{



		if (rowid != ''){
				$('#addupload'+rowid).attr('disabled',true);

		}



		//alert(rowid);
		$.ajax({

				url:'{{url('settings/get-add-row-item-upload')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row_upload").append(response);

				}
			});
	}

	function delRowupload(rowid)
	{
		var lastrow = $(".itemslotupload:last").attr("id");
        //alert(lastrow);
        var active_div = (lastrow-1);
        $('#addupload'+active_div).attr('disabled',false);
        $(document).on('click','.deleteButtonupload',function() {
            $(this).closest("div.itemslotupload").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
	}
	
	
</script>
<script>
//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button


// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}



$(document).ready(function() {
$("#pr_add_proof").change(function() {
        if (this.files && this.files[0]) {
            if(this.files[0].type.match('image.*'))
            {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.rcrop-preview-wrapper').remove();
                    $('#imgshowproof').rcrop('destroy');
                    $('#imgshowproof').removeAttr('src');
                    $('#imgshowproof').attr('src', e.target.result);
                    $('#imgshowproof').rcrop({
                        minSize: [200, 200],
                        preserveAspectRatio: true,

                        preview: {
                            display: true,
                            size: [100, 100],
                        }
                    });
                    //$('#btnCrop').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });
    
    
    $("#pass_docu").change(function() {
        if (this.files && this.files[0]) {
            if(this.files[0].type.match('image.*'))
            {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.rcrop-preview-wrapper').remove();
                    $('#imgshowpass').rcrop('destroy');
                    $('#imgshowpass').removeAttr('src');
                    $('#imgshowpass').attr('src', e.target.result);
                    $('#imgshowpass').rcrop({
                        minSize: [200, 200],
                        preserveAspectRatio: true,

                        preview: {
                            display: true,
                            size: [100, 100],
                        }
                    });
                    //$('#btnCrop').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });
    
    
    $("#visa_upload_doc").change(function() {
        if (this.files && this.files[0]) {
            if(this.files[0].type.match('image.*'))
            {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.rcrop-preview-wrapper').remove();
                    $('#imgshowvisa').rcrop('destroy');
                    $('#imgshowvisa').removeAttr('src');
                    $('#imgshowvisa').attr('src', e.target.result);
                    $('#imgshowvisa').rcrop({
                        minSize: [200, 200],
                        preserveAspectRatio: true,

                        preview: {
                            display: true,
                            size: [100, 100],
                        }
                    });
                    //$('#btnCrop').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });
    
    $("#visaback_doc").change(function() {
        if (this.files && this.files[0]) {
            if(this.files[0].type.match('image.*'))
            {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.rcrop-preview-wrapper').remove();
                    $('#imgshowvisaback').rcrop('destroy');
                    $('#imgshowvisaback').removeAttr('src');
                    $('#imgshowvisaback').attr('src', e.target.result);
                    $('#imgshowvisaback').rcrop({
                        minSize: [200, 200],
                        preserveAspectRatio: true,

                        preview: {
                            display: true,
                            size: [100, 100],
                        }
                    });
                    //$('#btnCrop').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });
});
function cropme() {
    
   
       if(document.getElementById('imgshowproof').src== ''){
  
}else{
   var srcOriginal = $('#imgshowproof').rcrop('getDataURL');
    $('#imagedataproof').val(srcOriginal);
}
if(document.getElementById('imgshowpass').src== ''){
 
   
}else{
     var srcOriginal = $('#imgshowpass').rcrop('getDataURL');
    $('#imagedatapass').val(srcOriginal);
    
}
    
    if(document.getElementById('imgshowvisa').src== ''){
 
   
}else{
      var srcOriginal = $('#imgshowvisa').rcrop('getDataURL');
    $('#imagedatavisa').val(srcOriginal);
    
}
  
   if(document.getElementById('imgshowvisaback').src== ''){
 
   
}else{
      var srcOriginal = $('#imgshowvisaback').rcrop('getDataURL');
    $('#imagedatavisaback').val(srcOriginal);
    
} 
    console.log(srcOriginal);
    //document.forms[0].submit();
}
function getrevieweussdate(){
		var empid=document.getElementById("euss_exp_date").value; 
		
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
</script>
 <script type="text/javascript" src="{{ asset('assets/js/date-time-picker.min.js')}}"></script>  
  <!--<script type="text/javascript" src="{{ asset('assets/js/es5-shim.min.js')}}"></script>  -->
     <script type="text/javascript">
            $('.form-date').dateTimePicker({
                mode: 'date',
                format: 'dd-MM-yyyy'
            });
        </script>


  
</body>
</html>