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
		<link href="{{asset('rcrop/dist/rcrop.min.css')}}" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('employeeassets/css/demo.css')}}">
	<style>
	.table td, .table th{padding:0 5px !important}
	.form-control {
  font-size: 12px;
    border-color: #ebedf2;
    padding: 0px 5px 0;
    height: 37px !important;
}
.main-panel{margin-top:0;}
.main-panel .content{margin-top:0;}

	</style>
</head>
<body>
	<div class="wrapper">
			
 
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							
								<div class="card-header">
									<h4 class="card-title">Update Profile</h4>
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
           <form name="basicform" id="basicform" method="post" action="{{url('appaddemployee-new/'.base64_encode($employee_rs[0]->emid).'/'.base64_encode($employee_rs[0]->emp_code).'?q='.base64_encode($employee_rs[0]->emp_code))}}" enctype="multipart/form-data" class="multisteps-form__form">
        {{ csrf_field() }}
              <!--single form panel-->
              <div class="multisteps-form__panel rounded bg-white js-active" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Personal  Details</h3>
                <div class="multisteps-form__content">
                 <div class="row">
  	
	
	<div class="col-md-4">
			<input id="emid" type="hidden" class="form-control input-border-bottom" required="" name="emid"  value="{{$emid}}" >
		<div class="form-group ">
		    <label for="inputFloatingLabel" class="placeholder">Employee Code<span style="color:red;">*</span></label>
		<input id="inputFloatingLabel" type="text" class="form-control " required="" value="<?php if(!empty($employee_code)){ echo $employee_code; }  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_code; } ?>" name="emp_code"  readonly="1">
		<input type="hidden" name="reg" value="{{ $Roledata->reg}}"
		
	</div>
	</div>
	</div>
	<div class="col-md-4">
	
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="emp_fname"   value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_fname; } ?>"  >
		<label for="inputFloatingLabel1" class="placeholder">First Name<span style="color:red;">*</span></label>
	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom" name="emp_mid_name" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_mname; } ?>">
		<label for="inputFloatingLabel2" class="placeholder">Middle Name</label>
	</div>
  </div>
  
  </div>
<div class="row">
  	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel3" type="text" class="form-control input-border-bottom" name="emp_lname"  required="" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_lname; } ?>">
		<label for="inputFloatingLabel3" class="placeholder">Last Name<span style="color:red;">*</span></label>
	</div>
	</div>
	
		 <!--	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelfon" type="text" class="form-control input-border-bottom"  name="emp_father_name" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_father_name; } ?>">
		<label for="inputFloatingLabelfon" class="placeholder">Father's Name </label>
	</div>
	</div>-->
	<div class="col-md-4">
		<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel" name="emp_gender">
<option value="">&nbsp;</option>
<option value="Male" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_gender=='Male'){ echo 'selected';} } ?>>Male</option>
<option value="Female"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_gender=='Female'){ echo 'selected';} } ?>>Female</option>
</select>
<label for="selectFloatingLabel" class="placeholder">Gender</label>
</div>
</div>
 <div class="col-md-4">
				   <div class="form-group form-floating-label">
<input id="inputFloatingLabelni" type="text" class="form-control input-border-bottom" name="ni_no" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->ni_no; } ?>">
<label for="inputFloatingLabelni" class="placeholder">NI No.</label>
</div>
</div>

	</div>
		
 
  	<div class="row ">
	
  <!--	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel4" type="date" class="form-control input-border-bottom" name="marital_date" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->marital_date; } ?>">
		<label for="inputFloatingLabel4" class="placeholder">Date of Marriage</label>
	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel5" type="text" class="form-control input-border-bottom" required="" name="spouse_name" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->spouse_name; } ?>">
		<label for="inputFloatingLabel5" class="placeholder">Spouse  Name</label>
	</div>
	</div>-->
	<div class="col-md-4">
		<div class="form-group form-floating-label">
			<input id="inputFloatingLabeldob" type="date" class="form-control input-border-bottom" name="emp_dob" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_dob!='1970-01-01' &&  $employee_rs[0]->emp_dob!='' &&  $employee_rs[0]->emp_code!='E11'){ echo $employee_rs[0]->emp_dob;}else if( $employee_rs[0]->emp_dob!='1970-01-01' &&  $employee_rs[0]->emp_dob!=''){ echo $employee_rs[0]->emp_dob;} }  ?>">
		<label for="inputFloatingLabeldob" class="placeholder">Date of Birth </label>
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabel1" name="marital_status">
<option value="">&nbsp;</option>
<option value="Single"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->marital_status=='Single'){ echo 'selected';} } ?>>Single</option>
<option value="Married"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->marital_status=='Married'){ echo 'selected';} } ?>>Married</option>
<option value="Unmarried"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->marital_status=='Unmarried'){ echo 'selected';} } ?>>Unmarried</option>
<option value="Widow"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->marital_status=='Widow'){ echo 'selected';} } ?>>Widow</option>
<option value="Divorce"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->marital_status=='Divorce'){ echo 'selected';} } ?>>Divorce</option>
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
<label for="selectFloatingLabel3" class="placeholder">Select Nationality</label>
</div>
  </div>
  </div>
  <div class="row">
  
<div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelfon" type="email" class="form-control input-border-bottom" required="" name="emp_ps_email" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_ps_email; } ?>">
		<label for="inputFloatingLabelfon" class="placeholder">Email <span style="color:red;">*</span></label>
	</div>
	</div>
 <div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelphone" type="tel" class="form-control input-border-bottom" required="" name="emp_ps_phone" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_ps_phone; } ?>">
		<label for="inputFloatingLabelphone" class="placeholder">Contact Number <span style="color:red;">*</span></label>
	</div>
	</div>
	
	 <div class="col-md-4">
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabelphonealter" type="tel" class="form-control input-border-bottom" name="em_contact" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_contact; } ?>">
		<label for="inputFloatingLabelphonealter" class="placeholder">Alternative Number</label>
	</div>
	</div>
  </div>
  
  
  
  <h3 style="margin-top:20px;color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Service Details</h3>
 
  <div class="row ">
		<div class="col-md-4">
			<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel3" name="emp_department"  onchange="chngdepartment(this.value);" readonly>
					<option value="">&nbsp;</option>
					 @foreach($department as $dept)
                     <option value="{{$dept->department_name}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_department==$dept->department_name){ echo 'selected';} } ?>>{{$dept->department_name}}</option>
                       @endforeach
				</select>
				<label for="selectFloatingLabel3" class="placeholder" style="margin-top:18px">Department </label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel4"  name="emp_designation" readonly>
					<option value="">&nbsp;</option>
					@if(!empty($designation))
					 @foreach($designation as $desig)
                     <option value="{{$desig->designation_name}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_designation==$desig->designation_name){ echo 'selected';} } ?>>{{$desig->designation_name}}</option>
                       @endforeach
                       @endif
				</select>
				<label for="selectFloatingLabel4" class="placeholder" style="margin-top:18px">Designation </label>
			</div>
		</div>
		<div class="col-md-4">
		<div class="form-group form-floating-label">
<input id="inputFloatingLabel4" type="date" max="<?= date('Y-m-d')?>" readonly class="form-control input-border-bottom"  name="emp_doj" 
value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_doj!='1970-01-01'){ if($employee_rs[0]->emp_doj!=''){ echo $employee_rs[0]->emp_doj;} } } ?>">
<label for="inputFloatingLabel4" class="placeholder" style="margin-top:18px">Date of Joining </label>
</div>
		</div>
	</div>
				   <div class="row">
				   
				   
				   <div class="col-md-4">
<div class="form-group form-floating-label">
				<select class="form-control input-border-bottom" id="selectFloatingLabel5"   name="emp_status" readonly>
					<option value="">&nbsp;</option>
					 @foreach($employee_type as $emp)
                        <option value="{{$emp->employee_type_name}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_status==$emp->employee_type_name){ echo 'selected';} } ?>>{{$emp->employee_type_name}}</option>
                        @endforeach
				</select>
				<label for="selectFloatingLabel5" class="placeholder" style="margin-top:18px">Employment Type </label>
			</div>
</div>
	


<div class="col-md-4">
		<div class="form-group form-floating-label">
<input id="inputFloatingLabel6" readonly type="date" class="form-control input-border-bottom"  name="date_confirm" 
value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->date_confirm!='1970-01-01'){ if($employee_rs[0]->date_confirm!=''){ echo $employee_rs[0]->date_confirm;} } } ?>">
<label for="inputFloatingLabel6" class="placeholder" style="margin-top:18px">Date of Confirmation</label>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel7" readonly type="date" class="form-control input-border-bottom" name="start_date"
value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->start_date!='1970-01-01'){ if($employee_rs[0]->start_date!=''){ echo $employee_rs[0]->start_date;} } } ?>">
<label for="inputFloatingLabel7" class="placeholder" style="margin-top:18px">Contract Start Date</label>
</div>
</div>



</div>

<div class="row">
<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel8" readonly type="date" class="form-control input-border-bottom" name="end_date" 
value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->end_date!='1970-01-01'){ if($employee_rs[0]->end_date!=''){ echo $employee_rs[0]->end_date;} } } ?>">
<label for="inputFloatingLabel8" class="placeholder" style="margin-top:18px">Contract End Date (If Applicable)</label>
</div>
</div>
<!--<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel9" type="text" class="form-control input-border-bottom" required="" name="fte" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->fte; } ?>">
<label for="inputFloatingLabel9" class="placeholder">FTE</label>
</div>
</div>-->
<div class="col-md-4">
<div class="form-group form-floating-label">
<input id="inputFloatingLabel10" type="text" readonly class="form-control input-border-bottom" name="job_loc" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->job_loc; } ?>">
<label for="inputFloatingLabel10" class="placeholder" style="margin-top:18px">Job Location</label>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group">
<label>Profile Picture</label>
<?php  if(request()->get('q')!=''){  ?>
<?php  if($employee_rs[0]->emp_image!=''){  ?>
	<img src="{{ asset( $employee_rs[0]->emp_image ) }}" height="50px" width="50px"/>
<?php

}
}?>
 <input type="file" accept="image/*;capture=camera" name="emp_image" id="emp_image" onchange="Filevalidationproimge()">
  <small> Please select  image which size up to 2mb</small>
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
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Educational Details</h3>
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

											<?php   $tr_id=0;
$countpay= count($employee_quli_rs)			;?>
@if ($countpay!=0)
@foreach($employee_quli_rs as $emquli)
<tr class="itemslot" id="<?php echo $tr_id; ?>" >
					    <td><?php echo ($tr_id+1); ?></td>
						 <td><input type="text" class="form-control" name="quli_{{ $emquli->id}}" value="{{ $emquli->quli}}"></td>
						 <td><input type="text" class="form-control" name="dis_{{ $emquli->id}}" value="{{ $emquli->dis}}"></td>
						 <td><input type="text" class="form-control" name="ins_nmae_{{ $emquli->id}}" value="{{ $emquli->ins_nmae}}"></td>
						 <td><input type="text" class="form-control" name="board_{{ $emquli->id}}" value="{{ $emquli->board}}"></td>
						 <td><input type="text" class="form-control" name="year_passing_{{ $emquli->id}}" value="{{ $emquli->year_passing}}"></td>
						 <td><input type="text" class="form-control" name="perce_{{ $emquli->id}}" value="{{ $emquli->perce}}"></td>
						 <td><input type="text" class="form-control" name="grade_{{ $emquli->id}}" value="{{ $emquli->grade}}">
<input type="hidden" class="form-control" name="emqliup[]" value="{{ $emquli->id}}"></td>
<?php $tr_id++; ?>
					
						 <td>
 @if($emquli->doc!='')
<a href="{{ asset('public/'.$emquli->doc) }}" download target="_blank" />download</a>
@endif
<input type="file" accept="image/*;capture=camera" class="form-control" name="doc_{{ $emquli->id}}" id="doc_h{{ $emquli->id}}" onchange="Filevalidationdocnytrty({{ $emquli->id}})">  <small> Please select  file which size up to 2mb</small></td>
	 <td>
 @if($emquli->doc2!='')
<a href="{{ asset('public/'.$emquli->doc2) }}" download target="_blank" />download</a>
@endif
<input type="file" accept="image/*;capture=camera" class="form-control" name="doc2_{{ $emquli->id}}" id="doc2_h{{ $emquli->id}}" onchange="Filevalidationdocnytrtyhh2({{ $emquli->id}})">  <small> Please select  file which size up to 2mb</small></td>
<td>

 @if ($tr_id==($countpay))
						 <button class="btn btn-success" type="button" id="add<?php echo $tr_id; ?>" onClick="addnewrow(<?php echo $tr_id; ?>)" data-id="<?php echo $tr_id; ?>"> <i class="fas fa-plus"></i> </button>
						
 @endif
	</td>				  </tr>
@endforeach   

										@endif
@if ($countpay==0)
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
						   <td><input type="file" accept="image/*;capture=camera" class="form-control" name="doc2[]" id="doc2<?= $tr_id ?>"  onchange="Filevalidationdocnewdoc(<?= $tr_id ?>)">  <small> Please select  file which size up to 2mb</small></td>
						 <td><button class="btn btn-success" type="button" id="add<?php echo ($tr_id+1); ?>" onClick="addnewrow(<?php echo ($tr_id+1); ?>)" data-id="<?php echo ($tr_id+1); ?>"> <i class="fas fa-plus"></i> </button>
						</td>
					  </tr>
@endif
					</tbody>
					</table> 
				   </div>
                  <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Job Details</h3>
				  

				  <div id="dynamic_row_edu">
<?php   $tredu_id=0;
$countpayjob= count($employee_job_rs)			;?>
				  @if ($countpayjob!=0)
											
@foreach($employee_job_rs as $emplojob)
										 
				  <div class="itemslotedu" id="<?php echo $tredu_id; ?>">
				  <div class="row " >
				  <div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobt" type="text" class="form-control input-border-bottom"  name="job_name[]" value="{{ $emplojob->job_name}}">
		<label for="inputFloatingLabel-jobt" class="placeholder">Job Title</label>
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobs" type="date" class="form-control input-border-bottom" name="job_start_date[]" value="{{ $emplojob->job_start_date}}">
		<label for="inputFloatingLabel-jobs" class="placeholder">Start Date</label>
	</div>
	</div>
	<div class="col-md-4">
		
		<div class="form-group form-floating-label">
		<input id="inputFloatingLabel-jobe" type="date" class="form-control input-border-bottom" name="job_end_date[]" value="{{ $emplojob->job_end_date}}">
		<label for="inputFloatingLabel-jobe" class="placeholder">End Date</label>
	</div>
	</div>
		</div>
		
		          <div class="row"><div class="col-md-4">
<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabelexp"  name="exp[]" >
<option value="">&nbsp;</option>
@for ($i = 0; $i <= 10; $i++)
  
<option value="{{ $i }}" <?php   if($emplojob->exp==$i){ echo 'selected';}  ?>>{{ $i }}</option>
@endfor


</select>
<label for="selectFloatingLabelexp" class="placeholder">Year of Experience</label>
</div>
</div><div class="col-md-6">
				  <div class="form-group form-floating-label">
				      	<textarea id="inputFloatingLabel-jobs"  rows="5" class="form-control"   style="margin-top: 18px;height:135px !important;resize:none;" name="des[]">{{ $emplojob->des}} </textarea> 

<label for="inputFloatingLabel-jobs" class="placeholder">Job Description</label>
</div>
</div>




<?php $tredu_id++; ?>
					  @if ($tredu_id==($countpayjob))
<div class="col-md-2" style="margin-top:13px;">
<button class="btn btn-success" type="button"  id="addedu<?php echo $tredu_id; ?>" onClick="addnewrowedu(<?php echo $tredu_id; ?>)" data-id="<?php echo $tredu_id; ?>"><i class="fas fa-plus"></i> </button>
</div>
@endif
</div>
	</div>		
</br>	

@endforeach   
										@endif
										@if ($countpayjob==0)
<?php  $tredu_id=0; ?>

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
		
		          <div class="row"><div class="col-md-4">
<div class="form-group form-floating-label">
<select class="form-control input-border-bottom" id="selectFloatingLabelexp" name="exp[]">
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
<input id="inputFloatingLabel-jobs" type="text" class="form-control input-border-bottom"  name="des[]">
<label for="inputFloatingLabel-jobs" class="placeholder">Job Description</label>
</div>
</div>




<div class="col-md-2" style="margin-top:13px;">
<button class="btn btn-success" type="button"  id="addedu<?php echo $tredu_id; ?>" onClick="addnewrowedu(<?php echo $tredu_id; ?>)" data-id="<?php echo $tredu_id; ?>"><i class="fas fa-plus"></i> </button>
</div>
</div>
	</div>
@endif
		         </div>																																													 <div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>																																												
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button>
                  </div>
				  
				  
                </div>
				</div>
				
				<div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Training Details</h3>
				
				
                <div class="multisteps-form__content "  >
                 
				   <div id="dynamic_row_train" >
<?php   $tretarin_id=0;
$countpaytrain= count($employee_train_rs)			;?>
 @if ($countpaytrain!=0)
											
@foreach($employee_train_rs as $emplotrain)
				  <div class="itemslottrain" id="<?php echo $tretarin_id; ?>">
				  
                  <div class="row">
				   <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr1" type="text" class="form-control input-border-bottom"  name="tarin_name[]" value="{{ $emplotrain->tarin_name}}">
						<label for="inputFloatingLabeltr1" class="placeholder">Title</label>
					</div>
				   </div>
				   <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom" name="tarin_start_date[]" value="{{ $emplotrain->tarin_start_date}}">
						<label for="inputFloatingLabeltr2" class="placeholder">Start Date</label>
					</div>
				   </div>
				    <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom"  name="tarin_end_date[]" value="{{ $emplotrain->tarin_end_date}}">
						<label for="inputFloatingLabeltr2" class="placeholder">End Date</label>
					</div>
				   </div>
				  </div>
				  
				  <div class="row">
				  <div class="col-md-4">
				     <div class="form-group form-floating-label">
						<input id="inputFloatingLabeltr4" type="text" class="form-control input-border-bottom"   name="train_des[]" value="{{ $emplotrain->train_des}}">
						<label for="inputFloatingLabeltr4" class="placeholder">Description</label>
					</div>
					</div>
<?php $tretarin_id++; ?>
					  @if ($tretarin_id==($countpaytrain))
					<div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button" id="addtarin<?php echo $tretarin_id; ?>" onClick="addnewrowtarin(<?php echo $tretarin_id; ?>)" data-id="<?php echo $tretarin_id; ?>"><i class="fas fa-plus"></i> </button></div>
@endif
				  </div>
                 </div>
@endforeach   
										@endif
										@if ($countpaytrain==0)
 <?php $tretarin_id=0; ?>
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
						<input id="inputFloatingLabeltr4" type="text" class="form-control input-border-bottom"   name="train_des[]">
						<label for="inputFloatingLabeltr4" class="placeholder">Description</label>
					</div>
					</div>
					<div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button" id="addtarin<?php echo $tretarin_id; ?>" onClick="addnewrowtarin(<?php echo $tretarin_id; ?>)" data-id="<?php echo $tretarin_id; ?>"><i class="fas fa-plus"></i> </button></div>
				  </div>
                 </div>
@endif
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
<input id="inputFloatingLabelien" type="text" class="form-control input-border-bottom" name="em_name" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_name; } ?>">
<label for="inputFloatingLabelien" class="placeholder">Name</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<!--<input id="inputFloatingLabelier" type="text" class="form-control input-border-bottom" name="em_relation" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_relation; } ?>">
-->
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
										        	
												<input id="relation_others"  type="text" class="form-control input-border-bottom" name="relation_others"   value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->relation_others; } ?>">
											<label for="relation_others" class="placeholder">Give Details </label>
											</div>
										   </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliemail" type="email" class="form-control input-border-bottom" name="em_email" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_email; } ?>">
<label for="inputFloatingLabeliemail" class="placeholder">Email</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliem" type="text" class="form-control input-border-bottom" name="em_phone" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_phone; } ?>">
<label for="inputFloatingLabeliem" class="placeholder">Emergency Contact No.</label>
</div>
	
	  </div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelienad" type="text" class="form-control input-border-bottom" name="em_address" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->em_address; } ?>">
<label for="inputFloatingLabelienad" class="placeholder">Address</label>
</div>
	
	  </div>
	</div>
	
		<h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Certified Membership</h3>

<div class="row">
	<div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelicl" type="text" class="form-control input-border-bottom" name="titleof_license" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->titleof_license; } ?>">
<label for="inputFloatingLabelicl" class="placeholder">Title of Certified License</label>
</div>
	
	  </div>
	    <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabeliln" type="text" class="form-control input-border-bottom" name="cf_license_number" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->cf_license_number; } ?>">
<label for="inputFloatingLabeliln" class="placeholder">License Number</label>
</div>
	
	  </div>
	   <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelisd" type="date" class="form-control input-border-bottom" name="cf_start_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->cf_start_date!='1970-01-01'){ if($employee_rs[0]->cf_start_date!=''){ echo $employee_rs[0]->cf_start_date;} } } ?>">
<label for="inputFloatingLabelisd" class="placeholder">Start Date</label>
</div>
	
	  </div>
	  <div class="col-md-3">
	   
		<div class="form-group form-floating-label">
<input id="inputFloatingLabelied" type="date" class="form-control input-border-bottom" name="cf_end_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->cf_end_date!='1970-01-01'){ if($employee_rs[0]->cf_end_date!=''){ echo $employee_rs[0]->cf_end_date;} } } ?>">
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
<input id="parmenent_pincode" type="text" class="form-control input-border-bottom" onchange="getcode();"  name="emp_pr_pincode" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_pr_pincode; } ?>">
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
												<input id="parmenent_street_name" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_pr_street_no; } ?>">
												<label for="parmenent_street_name" class="placeholder">Address Line 1</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="parmenent_village" type="text" class="form-control input-border-bottom"  name="emp_per_village" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_per_village; } ?>">
												<label for="parmenent_village" class="placeholder">Address Line 2</label>
											</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-floating-label">
												<input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_pr_state; } ?>">
												<label for="emp_pr_state" class="placeholder">Address Line 3</label>
											</div>
		</div>
		
	
	<div class="col-md-4">
		<div class="form-group form-floating-label">
												<input  id="parmenent_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->emp_pr_city; } ?>">
												<label for="parmenent_city" class="placeholder">City / County</label>
											</div>
</div>

<div class="col-md-4">

<div class="form-group form-floating-label">
	<select class="form-control input-border-bottom"   name="emp_pr_country" id="parmenent_country">
	<option value="">&nbsp;</option>
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->emp_pr_country==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option>
                       @endforeach

												</select>
<label for="parmenent_country" class="placeholder">Country</label>
</div>
		
</div>


	<div class="col-md-4">
			<div class="form-group ">
			<?php  if($employee_rs[0]->pr_add_proof!=''){  ?>
			<a href="{{ asset('public/'.$employee_rs[0]->pr_add_proof) }}" download target="_blank" />download</a>
	
<?php
}?>
			
			<img  id="imgshowproof" width='100%'>
												 <input id="imagedataproof" type="hidden" class="form-control input-border-bottom" name="imagedataproof"  value="">
												
			<input  type="file"  accept="image/x-png,image/jpeg,image/png;capture=camera"  class="form-control imagefile"  name="pr_add_proof" id="pr_add_proof" onchange="Filevalidationdoproff()">
			
			 <small> Please select  file which size up to 2mb</small>
			<label for="pr_add_proof" class="placeholder"> Proof Of Address</label>
			</div>
		</div>

</div>
<h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Other Documents</h3>
<div id="dynamic_row_upload">
<?php   $trupload_id=0;
$countpayuppas= count($employee_upload_rs)			;?>
		@if ($countpayuppas!=0)
											
@foreach($employee_upload_rs as $empuprs)


					
				<div class="row itemslotupload" id="<?php echo $trupload_id; ?>">
				  <div class="col-md-4">
				    <div class="form-group ">
					<input id="selectFloatingLabel" type="text" class="form-control "  name="type_doc_{{ $empuprs->id}}" value="{{ $empuprs->type_doc}}">
												
					<input  type="hidden" class="form-control input-border-bottom" required="" name="id_up_doc[]" value="{{ $empuprs->id}}">
												<label for="selectFloatingLabel" class="placeholder">Type of Document</label>
											</div>
				  </div>
				  
				  <div class="col-md-4">
				  <label>Uplaod Documents</label>

 @if($empuprs->docu_nat!='')
<a href="{{ asset('public/'.$empuprs->docu_nat) }}" target="_blank" download />download</a>
</br>
@endif
				    <input type="file" class="form-control-file" id="docu_nat_{{ $empuprs->id}}"   onchange="Filevalidationdocotherbbg({{ $empuprs->id}})" name="docu_nat_{{ $empuprs->id}}" >
				  <small> Please select  file which size up to 2mb</small>
				  </div>
<?php $trupload_id++; ?>
					  @if ($trupload_id==($countpayuppas))
				  <div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button"  id="addupload<?php echo $trupload_id; ?>" onClick="addnewrowupload(<?php echo $trupload_id; ?>)" data-id="<?php echo $trupload_id; ?>"><i class="fas fa-plus"></i> </button></div>
				@endif

</div>


@endforeach   
										@endif
										@if ($countpayuppas==0)
	<?php $trupload_id=0; ?>
				<div class="row itemslotupload" id="<?php echo $trupload_id; ?>">
				  <div class="col-md-4">
				    <div class="form-group form-floating-label">
					<input id="selectFloatingLabel" type="text" class="form-control input-border-bottom"  name="type_doc[]">
												
												<label for="selectFloatingLabel" class="placeholder">Type of Document</label>
											</div>
				  </div>
				  
				  <div class="col-md-4">
				  <label>Uplaod Documents</label>
				    <input type="file" class="form-control-file"  id="docu_nat<?php echo $trupload_id; ?>" onchange="Filevalidationdocother(<?php echo $trupload_id; ?>)" name="docu_nat[]">
				  <small> Please select  file which size up to 2mb</small>
				  </div>
				  <div class="col-md-4" style="margin-top:13px;"><button class="btn btn-success" type="button"  id="addupload<?php echo $trupload_id; ?>" onClick="addnewrowupload(<?php echo $trupload_id; ?>)" data-id="<?php echo $trupload_id; ?>"><i class="fas fa-plus"></i> </button></div>
				</div>
@endif
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
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->pass_doc_no; } ?>">	
	<label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>	

</div>
</div>	

                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp" name="pass_nat" >
												<option value="">&nbsp;</option>
											
												@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->pass_nat==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option>
                       @endforeach
										
												</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
			<div class="col-md-3">
								
<div class="form-group form-floating-label">
<input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom" name="place_birth" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->place_birth; } ?>">
<label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>	

</div>
</div>
			            <div class="col-md-3">
			<div class="form-group form-floating-label">
			<input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->issue_by; } ?>">
			<label for="inputFloatingLabelib" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
						
						
				  </div>
				  
				  
				  
				   <div class="row">
			 <div class="col-md-3">
							
						<div class="form-group form-floating-label" >	
						<input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->pas_iss_date!='1970-01-01'){ if($employee_rs[0]->pas_iss_date!=''){ echo $employee_rs[0]->pas_iss_date;} } } ?>" >	 
			<label for="inputFloatingLabelid" class="placeholder">Issued Date</label>																												</div>
			</div>
				   <div class="col-md-3">
							<div class="form-group form-floating-label">	
							<input id="pass_exp_date" onblur="getreviewdate();" type="date" class="form-control input-border-bottom" name="pass_exp_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->pass_exp_date!='1970-01-01'){ if($employee_rs[0]->pass_exp_date!=''){ echo $employee_rs[0]->pass_exp_date;} } } ?>">	
			<label for="pass_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label">						
					<input id="pass_review_date"  type="date" class="form-control input-border-bottom" readonly name="pass_review_date"  value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->pass_review_date!='1970-01-01'){ if($employee_rs[0]->pass_review_date!=''){ echo $employee_rs[0]->pass_review_date;} } } ?>">	
			<label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
						
							<div class="col-md-3">
							<label>Upload Document</label>
@if($employee_rs[0]->pass_docu!='')
<a href="{{ asset('public/'.$employee_rs[0]->pass_docu) }}" target="_blank" download />download</a>
</br>
@endif
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
													<input class="form-radio-input" type="radio" name="cur_pass" value="Yes" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->cur_pass=='Yes'){ echo 'checked';} } ?>>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="cur_pass" value="No" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->cur_pass=='No'){ echo 'checked';} } ?>>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
						</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->remarks; } ?>">
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
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="visa_doc_no"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->visa_doc_no; } ?>">
<label for="inputFloatingLabeldn1" class="placeholder">BRP No.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="visa_nat" >
												<option value="">&nbsp;</option>
							
								@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_nat==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option>
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
                     <option value="{{trim($currency_valu->country)}}" <?php  if(request()->get('q')!=''){  if($employee_rs[0]->country_residence==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option>
                       @endforeach	
												</select>
												<label for="selectFloatingLabel" class="placeholder">Country of Residence</label>
											</div>
						</div>
			            <div class="col-md-3">
			<div class="form-group form-floating-label"><input id="inputFloatingLabelib1" type="text" class="form-control input-border-bottom"  name="visa_issue" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->visa_issue; } ?>">	
			<label for="inputFloatingLabelib1" class="placeholder">Issued By</label>	
			
			</div>
			</div>																											
						
				  </div>
				    
					
				  
				  
				   <div class="row">
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="visa_issue_date"  value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_issue_date!='1970-01-01'){ if($employee_rs[0]->visa_issue_date!=''){ echo $employee_rs[0]->visa_issue_date;} } } ?>">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="visa_exp_date" onblur="getreviewvisdate();" type="date" class="form-control input-border-bottom" name="visa_exp_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_exp_date!='1970-01-01'){ if($employee_rs[0]->visa_exp_date!=''){ echo $employee_rs[0]->visa_exp_date;} } } ?>">	
			<label for="visa_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="visa_review_date" readonly type="date" class="form-control input-border-bottom" name="visa_review_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_review_date!='1970-01-01'){ if($employee_rs[0]->visa_review_date!=''){ echo $employee_rs[0]->visa_review_date;} } } ?>">	
			<label for="visa_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
						<div class="col-md-3">
							<label>Upload Front Side Document</label>
@if($employee_rs[0]->visa_upload_doc!='')
<a href="{{ asset('public/'.$employee_rs[0]->visa_upload_doc) }}" download target="_blank" />download</a>
</br>
@endif
		
							
								<img  id="imgshowvisa" width='100%'>
												 <input id="imagedatavisa" type="hidden" class="form-control input-border-bottom" name="imagedatavisa"  value="">
												
								<input type="file"  accept="image/x-png,image/jpeg,image/png;capture=camera" class="form-control imagefile" name="visa_upload_doc" id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
					 <small> Please select  file which size up to 2mb</small>
						</div>
						
						</div>
						
						<div class="row">
					<div class="col-md-3">
							<label>Upload  Back Side Document</label>
@if($employee_rs[0]->visaback_doc!='')
<a href="{{ asset('public/'.$employee_rs[0]->visaback_doc) }}" download target="_blank" />download</a>
</br>
@endif<img  id="imgshowvisaback" width='100%'>
												 <input id="imagedatavisaback" type="hidden" class="form-control input-border-bottom" name="imagedatavisaback"  value="">
								
		
								<input type="file" class="form-control" name="visaback_doc" id="visaback_doc" onchange="Filevalidationdopassdvisaeback()">
								<small> Please select  file which size up to 2mb</small>
						</div>
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current visa?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="visa_cur" value="Yes"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_cur=='Yes'){ echo 'checked';} } ?>>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="visa_cur" value="No"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->visa_cur=='No'){ echo 'checked';} } ?>>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="visa_remarks" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->visa_remarks; } ?>" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
							
						
						</div>
				  
				   
				   
				   </div>
				   
				    <br>
				   <hr>
				      <h4 style="color: #1269db;">EUSS details </h4>
                <div class="multisteps-form__content">
                   <div class="row">
				   		<div class="col-md-3">
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="euss_ref_no"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->euss_ref_no; } ?>">
<label for="inputFloatingLabeldn1" class="placeholder">Reference Number.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="euss_nation" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->euss_nation; } ?>">
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                                          <option value="{{trim($currency_valu->country)}}"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_nation==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option> 
					  @endforeach		</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
	
			        																										
						
				  
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="euss_issue_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_issue_date!='1970-01-01'){ if($employee_rs[0]->euss_issue_date!=''){ echo $employee_rs[0]->euss_issue_date;} } } ?>">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="euss_exp_date" type="date" class="form-control input-border-bottom" name="euss_exp_date" 
onchange="getrevieweussdate();"  value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_exp_date!='1970-01-01'){ if($employee_rs[0]->euss_exp_date!=''){ echo $employee_rs[0]->euss_exp_date;} } } ?>">	
			<label for="euss_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="euss_review_date" type="date" readonly class="form-control input-border-bottom" name="euss_review_date"   value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_review_date!='1970-01-01'){ if($employee_rs[0]->euss_review_date!=''){ echo $employee_rs[0]->euss_review_date;} } } ?>">	
			<label for="euss_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
							@if($employee_rs[0]->euss_upload_doc!='')
<a href="{{ asset('public/'.$employee_rs[0]->euss_upload_doc) }}" download target="_blank" />download</a>
</br>
@endif
								<input type="file" class="form-control" name="euss_upload_doc" id="euss_upload_doc" onchange="Filevalidationdopassduploadae()">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
						
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_cur=='Yes'){ echo 'checked';} } ?> name="euss_cur" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="euss_cur"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->euss_cur=='No'){ echo 'checked';} } ?>  value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->euss_remarks; } ?>"  class="form-control input-border-bottom" name="euss_remarks" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
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
								
<div class="form-group form-floating-label"><input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="nat_id_no"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->nat_id_no; } ?>">
<label for="inputFloatingLabeldn1" class="placeholder">National id number.</label>	

</div>
</div>	
                        <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="nat_nation" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->nat_nation; } ?>">
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_nation==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option> 
					  @endforeach		
												</select>
												<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
											</div>
						</div>																										
	
			        																										
						  <div class="col-md-3">
				  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="nat_country_res" value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->nat_nation; } ?>">
												<option value="">&nbsp;</option>
												
	@foreach($currency_user as $currency_valu)
                     <option value="{{trim($currency_valu->country)}}"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_country_res==trim($currency_valu->country)){ echo 'selected';} } ?>>{{$currency_valu->country}}</option> 
					  @endforeach		
												</select>
												<label for="selectFloatingLabelntp" class="placeholder">Country of Residence</label>
											</div>
						</div>
				  
				   	<div class="col-md-3">
							
						<div class="form-group form-floating-label">
						<input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="nat_issue_date" value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_issue_date!='1970-01-01'){ if($employee_rs[0]->nat_issue_date!=''){ echo $employee_rs[0]->nat_issue_date;} } } ?>">	
			<label for="inputFloatingLabelid1" class="placeholder">Issued Date</label>																												</div>
			</div>
					
				   <div class="col-md-3">
							<div class="form-group form-floating-label" ><input id="nat_exp_date" type="date" class="form-control input-border-bottom" name="nat_exp_date" 
onchange="getreviewnatdate();"  value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_exp_date!='1970-01-01'){ if($employee_rs[0]->nat_exp_date!=''){ echo $employee_rs[0]->nat_exp_date;} } } ?>">	
			<label for="nat_exp_date" class="placeholder">Expiry Date</label>																												</div>
			</div>
				   		<div class="col-md-3">
					
					<div class="form-group form-floating-label"><input id="nat_review_date" type="date" readonly class="form-control input-border-bottom" name="nat_review_date"   value="<?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_review_date!='1970-01-01'){ if($employee_rs[0]->nat_review_date!=''){ echo $employee_rs[0]->nat_review_date;} } } ?>">	
			<label for="nat_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>																												</div>
			</div>
					
							<div class="col-md-3">
							<label>Upload Document</label>
							@if($employee_rs[0]->nat_upload_doc!='')
<a href="{{ asset('public/'.$employee_rs[0]->nat_upload_doc) }}" download target="_blank" />download</a>
</br>
@endif
								<input type="file" class="form-control" name="nat_upload_doc" id="nat_upload_doc" onchange="Filevalidationdopassduploadnat()">
								 <small> Please select  file which size up to 2mb</small>
						</div>
						
						
					
						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_cur=='Yes'){ echo 'checked';} } ?> name="nat_cur" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="nat_cur"  <?php  if(request()->get('q')!=''){  if($employee_rs[0]->nat_cur=='No'){ echo 'checked';} } ?>  value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">
							
								<div class="form-group form-floating-label">
												<input id="inputFloatingLabelrm1" type="text"  value="<?php  if(request()->get('q')!=''){ echo $employee_rs[0]->nat_remarks; } ?>"  class="form-control input-border-bottom" name="nat_remarks" >
												<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
											</div>
						</div>
						
							
		
						</div>
				  
				   
				   
				   </div>
				   </br>
				    <hr>
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
				   
				    <div style="text-align: right;"> <p style="color:red">(*) marked fields are mandatory fields</p></div>
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
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
				   $("#emp_sort_code").attr("readonly", true);  
				  }else{
					  var bank_sort=obj.bank_sort; 
					  $("#emp_sort_code").val(bank_sort);
				   $("#emp_sort_code").attr("readonly", true);
				   
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