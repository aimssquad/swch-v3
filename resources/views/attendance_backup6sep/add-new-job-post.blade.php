<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
	  @include('recruitment.include.header')
		<!-- Sidebar -->
		
		  @include('recruitment.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<!-- <h4 class="page-title">Recruitment</h4> -->
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
<a href="{{url('recruitment/job-post')}}">Job Posting</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="#"> New Job Posting</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									@if(isset($_GET['id']))
                            	
							<h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Job Posting</h4>
                            	@else
                                
							<h4 class="card-title"><i class="fas fa-briefcase"></i> Add Job Posting</h4>
                                @endif 
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}					<div class="row form-group">
										<div class="col-md-4">
											<div class=" form-group">		
											<label for="inputFloatingLabel-soc-code" style="margin-top: 20px;" class="placeholder">SOC Code</label>
										<select id="inputFloatingLabel-soc-code" class="form-control input-border-bottom" required="" name="soc"  onchange="chngdepartment(this.value);" style="margin-top: 24px;">
											  	<option value="">&nbsp;</option>
											    	 @foreach($department_rs as $dept)
                     <option value="{{$dept->id}}" <?php  if(isset($_GET['id'])){  if($designation[0]->soc==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                       @endforeach
											  </select>
											    
											</div>
										</div>



								     	<div class="col-md-4">
                                            <label for="title" class="placeholder">Job Title</label>
								     		 	<input id="title" type="text"  name="title" class="form-control input-border-bottom" required="" style="margin-top: 22px;"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->title;  }?>{{ old('title') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
												
											  
											   
								     	
								     			
								     	</div>


										<!-- <div class="col-md-4">
											<div class=" form-group form-floating-label">		
											
											  <select id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											  	<option>Select</option>
											    <option>HR Manager</option>
												<option>Taxation expert</option>
												
											  </select>
											    <label for="inputFloatingLabel-soc-code" style="margin-top: 20px;" class="placeholder">Job Title</label>
											</div>
										</div> -->
									      
											<div class="col-md-4">
												<div class=" form-group">
												    <label for="inputFloatingLabel-job-details" class="placeholder">Job Code</label>
													<input id="inputFloatingLabel-job-details" type="text"  name="job_code"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->job_code;  }?>{{ old('job_code') }}"  class="form-control input-border-bottom" required="" style="margin-top: 22px;">
												
												
												</div>
											</div>
								
										
										</div>
										<div class="row form-group">

								     	<div class="col-md-4">
<label for="job_desc" class="placeholder">Job Description</label>
								     		<input id="job_desc" type="text"  name="job_desc" class="form-control input-border-bottom" required="" style="margin-top: 22px;" value="<?php if(isset($_GET['id'])){  echo $designation[0]->job_desc;  }?>{{ old('job_desc') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
												
								     	
								     			
								     	</div>
											<!-- <div class="col-md-6">
												<div class=" form-group form-floating-label">
												<input id="inputFloatingLabel-job-description" type="text" class="form-control input-border-bottom" required="" style="margin-top: 22px;">
												<label for="inputFloatingLabel-job-description" class="placeholder">Job Description</label>
												</div>
											</div> -->


                                         
										<div class="col-md-4">
											<div class=" form-group">		
											<label for="inputFloatingLabel-job-type" style="margin-top: 20px;" class="placeholder">Job Type</label>
											 <select id="inputFloatingLabel-job-type" name="job_type" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											  	 <option value="">&nbsp;</option>
											  
												<option value="Full Time"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Full Time'){ echo 'selected';} } ?>>Full Time</option>
												
												<option value="Part Time"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Part Time'){ echo 'selected';} } ?>>Part Time</option>
												<option value="Contractual"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Contractual'){ echo 'selected';} } ?>>Contractual</option>
												
												
												
											  </select>
											    
											</div>
										</div>

										 <div class="col-md-4">
											<div class=" form-group">		
											<label for="working_hour" style="margin-top: 20px;" class="placeholder">Working Hours (Weekly)</label>
											  <select id="working_hour" name="working_hour" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											  	 														  <option value="">&nbsp;</option>
														 @for ($i = 1; $i <= 80; $i++)
  
<option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($designation[0]->working_hour==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
@endfor
											  </select>
											    
											</div>
										</div>

									</div>
										
										<div class="row form-group">
								
											<div class="col-md-6">
												<label for="inputFloatingLabel-salary" class="placeholder">Job Experience</label>
												<div class="row">
													<div class="col-md-4">
														 <div class=" form-group">	
													<select id="inputFloatingLabel-selaect-salary" name="work_min"  class="form-control input-border-bottom" required="">
														  <option value="">Min</option>
														 @for ($i = 0; $i <= 15; $i++)
  
<option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($designation[0]->work_min==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
@endfor
																											 
														  
														</select>
													</div>
												</div>

												<div class="col-md-4">
														 <div class=" form-group">	
														<select id="inputFloatingLabel-selaect-salary" name="work_max"   class="form-control input-border-bottom" required="">
														  <option  value="">Max</option>
														   @for ($j = 0; $j <= 50; $j++)
  
<option value="{{ $j }}" <?php  if(request()->get('id')!=''){  if($designation[0]->work_max==$j){ echo 'selected';}}  ?>>{{ $j }}</option>
@endfor
														
																											 
														  
														</select>
													</div>
												</div>
										</div>
									</div>



											<div class="col-md-6">
												<label for="inputFloatingLabel-salary" class="placeholder">Annual Basic Salary</label>
												<div class="row">
													<div class="col-md-4">
														 <div class=" form-group">
														     <label for="basic_min" class="placeholder">Min</label>			
<input id="basic_min" type="text" class="form-control input-border-bottom" required="" name="basic_min"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->basic_min;  }?>{{ old('basic_min') }}">
								 														 
									
													</div>
												</div>

												<div class="col-md-4">
														 <div class=" form-group">
														     	<label for="basic_max" class="placeholder">Max</label>		
														 <input id="basic_max" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;" name="basic_max"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->basic_max;  }?>{{ old('basic_max') }}">
	
														
													</div>
												</div>
										</div>
									</div>
											
										</div>
										
										<div class="row">
										  <!-- 
											<div class="col-md-4">
											  <div class=" form-group form-floating-label">			
											  <input id="inputFloatingLabel-post-code" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											   <label for="inputFloatingLabel-other-salary" class="placeholder">Other Salary Details</label>
											</div>
											</div> -->
											<div class="col-md-6">
										      <div class=" form-group">	
										      <label for="inputFloatingLabel-add-1" class="placeholder">Number Of Vacancies</label>
											    <input id="inputFloatingLabel-add-1" type="number" class="form-control input-border-bottom" required="" style="margin-top: 24px;" name="no_vac"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->no_vac;  }?>{{ old('no_vac') }}">
											   
											</div>
											</div>
											<div class="col-md-6">
											<div class=" form-group">
											    <label for="inputFloatingLabel-add-2" class="placeholder">Job Location</label>	
											 <input id="inputFloatingLabel-add-2" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;" name="job_loc"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->job_loc;  }?>{{ old('job_loc') }}">
											    
												
												
											</div>
											</div>
										</div>
										<div class="row form-group">
										
											<div class="col-md-12">
												<h2>Desired Candidate</h2>
											</div>
											
											<div class="col-md-4">

											 <div class=" form-group">	
											 <label for="inputFloatingLabel-qualification" class="placeholder">Qualifications</label>
											  <input id="inputFloatingLabel-qualification" type="text" class="form-control input-border-bottom" required="" style="margin-top: 24px;" name="quli"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->quli;  }?>{{ old('quli') }}">
											    
											</div>
											</div>


											<div class="col-md-4">
											 <div class=" form-group">		
											 <label for="inputFloatingLabel-skill-set" class="placeholder">Skill Set</label>
											  <input id="inputFloatingLabel-skill-set" type="text" class="form-control input-border-bottom" required="" style="margin-top: 24px;" name="skill"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->skill;  }?>{{ old('skill') }}">
											    
											</div>
											</div>


										<div class="col-md-4">
											<div class=" form-group">		
											<label for="skil_set" style="margin-top: 20px;" class="placeholder">Skill Level</label>
											  <select id="skil_set" type="text" class="form-control input-border-bottom" required="" name="skil_set"  style="margin-top: 24px;">
											  	 <option value="" >&nbsp;</option>
											    <option  value="1"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='1'){ echo 'selected';} } ?>>1</option>
												<option  value="2"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='2'){ echo 'selected';} } ?>>2</option>
												<option  value="3"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='3'){ echo 'selected';} } ?>>3</option>
												<option  value="4"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='4'){ echo 'selected';} } ?>>4</option>
												<option  value="5"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='5'){ echo 'selected';} } ?>>5</option>
												<option  value="6"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='6'){ echo 'selected';} } ?>>6</option>
												<option  value="PhD"  <?php  if(request()->get('id')!=''){  if($designation[0]->skil_set=='PhD'){ echo 'selected';} } ?>>PhD</option>
												
											  </select>
											    
											</div>
										</div>

										</div>

										<div class="row form-group">
										 	<div class="col-md-4">
												<label for="inputFloatingLabel-age" class="placeholder">Age</label>
												<div class="row">
													<div class="col-md-4">
														 <div class=" form-group">	
														<select id="inputFloatingLabel-age"  name="age_min" class="form-control input-border-bottom" required="">
														  <option value="">Min</option>
														  @for ($k = 15; $k <= 35; $k++)
  
<option value="{{ $k }}" <?php  if(request()->get('id')!=''){  if($designation[0]->age_min==$k){ echo 'selected';}}  ?>>{{ $k }}</option>
@endfor
											  
														</select>
													</div>
												</div>

												<div class="col-md-4">
														 <div class=" form-group">	
														<select id="inputFloatingLabel-age" name="age_max"  class="form-control input-border-bottom" required="">
														  <option value="">Max</option>
														   @for ($l = 30; $l <= 70; $l++)
  
<option value="{{ $l }}" <?php  if(request()->get('id')!=''){  if($designation[0]->age_max==$l){ echo 'selected';}}  ?>>{{ $l }}</option>
@endfor
																											 
														  
														</select>
													</div>
												</div>
										</div>
									</div>

										<div class="col-md-4">
											<div class=" form-group">	

										
											<!-- 	<input id="inputFloatingLabel-gender" type="text" class="form-control input-border-bottom" required="" style="margin-top: 22px;">
												<label for="inputFloatingLabel-gender" class="placeholder">Gender</label> -->
											

									             <h6>Gender</h6>  
<label for="vehicle1"  style="margin-top: 24px;">Male</label>&nbsp &nbsp &nbsp
											  	 <input type="checkbox" id="gender_male" name="gender_male" value="Male" <?php  if(request()->get('id')!=''){  if($designation[0]->gender_male=='Male'){ echo 'checked';} } ?>>
											  	   
<label for="vehicle1">Female</label>
											  	    <input type="checkbox" id="gender" name="gender" value="Female" <?php  if(request()->get('id')!=''){  if($designation[0]->gender=='Female'){ echo 'checked';} } ?>>
											  	   
											

											
											</div>
										</div>

										<div class="col-md-4">
											<div class=" form-group">		
											<label for="inputFloatingLabel-preferred-location" style="margin-top: 20px;" class="placeholder">Preferred Location(UK)</label>
											<select id="inputFloatingLabel-preferred-location" name="pref_loc" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											    <option value="">&nbsp;</option>
												 @foreach($location as $locationlo)
                     <option value="{{$locationlo->id}}" <?php if(request()->get('id')!=''){  if($designation[0]->pref_loc==$locationlo->id){ echo 'selected';}}  ?>>{{$locationlo->name}}</option>
                       @endforeach
											 
											  </select>
											    
											</div>
										</div>
									    
									   </div>

									   <div class="row form-group">	
									   		<div class="col-md-4">
											<div class=" form-group">		
											<label for="inputFloatingLabel-preferred-country" style="" class="placeholder">Preferred Country</label>
											 <select id="inputFloatingLabel-preferred-country" name="country" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
											    <option value="">&nbsp;</option>
												 @foreach($cuurenci_master as $desig)
                     <option value="{{$desig->country}}" <?php if(request()->get('id')!=''){  if($designation[0]->country==$desig->country){ echo 'selected';}}  ?>>{{$desig->country}}</option>
                       @endforeach
											 
											  </select>
											    
											</div>
										</div>

										<div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-job-posting-date"  class="placeholder">Job Posting Date</label>
												<input id="inputFloatingLabel-job-posting-date"  type="date"  class="form-control input-border-bottom" required="" style="margin-top: 20px;" name="post_date"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->post_date;  }?>{{ old('post_date') }}">
												

									        	</div>		
								     	</div>


										<div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-end-date"  class="placeholder">Closing Date</label>
												<input id="inputFloatingLabel-end-date"  type="date"  class="form-control input-border-bottom" required="" style="margin-top: 20px;" name="clos_date"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->clos_date;  }?>{{ old('clos_date') }}">
												

									        	</div>		
								     	</div>

									   </div>	





									

										<div class="row form-group">
											<div class="col-md-4">
											  <div class=" form-group">
											      <label for="inputFloatingLabel-mail" class="placeholder" style="margin-top: 5px"> Contact Number</label>
												<input id="inputFloatingLabel-mail" type="tel" class="form-control input-border-bottom" required="" style="margin-top: 10px;"  name="con_num"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->con_num;  }?>{{ old('con_num') }}">
													
											</div>	
											</div>

											<div class="col-md-4">
											  <div class=" form-group">
											      	<label for="inputFloatingLabel-number" class="placeholder" style="margin-top: 5px">Email</label>
												<input id="inputFloatingLabel-number" type="email" class="form-control input-border-bottom" required="" style="margin-top: 10px;" name="email"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->email;  }?>{{ old('email') }}">
												
											  </div>	
											</div>
											 <?php  if(request()->get('id')!=''){
												 ?>
											<div class="col-md-4">
											  <div class=" form-group">
													<label for="status" class="placeholder" style="margin-top: 5px">Status</label>
											<select class="form-control input-border-bottom" id="status" required="" name="status">
<option value="">&nbsp;</option>
<option value="Job Created" <?php  if(request()->get('id')!=''){  if($designation[0]->status=='Job Created'){ echo 'selected';} } ?>>Job Created</option>
<option value="Published"  <?php  if(request()->get('id')!=''){  if($designation[0]->status=='Published'){ echo 'selected';} } ?>>Published</option>
</select>

											
											</div>	
											</div>
											<?php } ?>
									    </div>	

									    <div class="row form-group">
										 <div class="col-md-12">
										    <button class="btn btn-default" type="submit">Submit</button>
										 </div>
										</div>	
										
									    	
										
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
 @include('recruitment.include.footer')
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
		
		  function chngdepartment(empid){
	   
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getjobpostById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			var obj = jQuery.parseJSON(response);
			 
			  var title=obj.title;
			 var job_desc=obj.des_job;
			 
				  $("#title").val(title);
				   $("#job_desc").val(job_desc);
				    $("#skil_set").val(obj.skil_set);
				    $("#title").attr("readonly", true);
					 $("#job_desc").attr("readonly", true);
		}
		});
   }
	</script>
</body>
</html>