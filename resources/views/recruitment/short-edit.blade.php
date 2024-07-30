<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../assets/css/fonts.min.css']},
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
	<style>.app-form-text h5 {    margin: 0;
    color: #1572e8;
    padding: 15px 7px;
}.app-form-text h5 span {
    color: #000;
    padding-left: 10px;
}.download a {
    color: #fff;
    text-decoration: none;
}
.form-group{padding:0;}
.row:nth-child(even) {
    background-color: #e9e9e9;
}
.row:nth-child(odd) {
    background-color: #f7f7f7;
}
</style>
</head>
<body>
	<div class="wrapper">
		
  @include('recruitment.include.header')
		<!-- Sidebar -->
		
		  @include('recruitment.include.sidebar')
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
							<li class="nav-item">
								<a href="{{url('recruitment/short-listing')}}"> Short Listing </a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="#"> Short Listing  Details</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-user-tie"></i> Short Listing  Details</h4>
								</div>
								<div class="card-body">
								<form action="{{url('recruitment/edit-short-listing')}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
						<input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
				<input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
				
										
								<div class="row form-group">
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Job Title:<span>{{$job->job_title}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Candidate Name:<span>{{$job->name}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Email:<span>{{$job->email}}</span></h5>
												</div>
											</div>
											
										@if($job->dob!='')
										<div class="col-md-4">
												<div class="app-form-text">
													<h5>Date Of Birth:<span>{{ date('d/m/Y',strtotime($job->dob))}}</span></h5>
												</div>
											</div>
											@endif
											<div class="col-md-4">
												<div class="app-form-text">
												<h5>Contact Number:<span>+{{$job->phone}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Gender:<span>{{$job->gender}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Total Year of Experience:<span>{{$job->exp}} Years {{$job->exp_month}} Months</span></h5>
												</div>
											</div>
																						
									
											<div class="col-md-4">
												<div class="app-form-text">
                                                    <h5>Education Qualification:<span>{{$job->edu}}</span></h5>
												</div>
											</div>

											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Skill Set:<span>{{$job->skill}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Skill level:<span>{{$job->skill_level}}</span></h5>
												</div>
											</div>
										
											
									
										<div class="col-md-4">
												<div class="app-form-text">
													<h5>Current Organization:<span>{{$job->cur_or}}</span></h5>
												</div>
										</div>
										<div class="col-md-4">
												<div class="app-form-text">
													<h5>Current Job Title:<span>{{$job->cur_deg}}</span></h5>
												</div>
										</div>
										<div class="col-md-4">
												<div class="app-form-text">
													<h5>Current Salary:<span> @if($job->sal!='')  {{ number_format($job->sal,2)}}  @endif</span></h5>
												</div>
										</div>
									
                                       <div class="col-md-6">
												<div class="app-form-text">
													<h5>Current Location / Address:<span>{{$job->location}} @if(!empty($job->zip)) ,{{$job->zip}} @endif</span></h5>
												</div>
										</div>
										<div class="col-md-6">
												<div class="app-form-text">
													<h5>Expected Salary:<span>@if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}} @endif</span></h5>
												</div>
										</div>
								     	<div class="col-md-4">
												<div class="app-form-text">
													<h5>Apply Date:<span> <?php
													echo date('d/m/Y',strtotime($job->date));
	    if($job->date>='2021-02-22'){
         echo ' '.date('h:i A ',strtotime($job->date));
	    }
         ?></span></h5>
												</div>
										</div>
								      	@if($job->apply!='')
										<div class="col-md-4">
												<div class="app-form-text">
													<h5>How the candidate applied ?:<span>{{ $job->apply }}</span></h5>
												</div>
											</div>
											@endif
											 </div>
                                        <!--------------------  -->
										<div class="row form-group" style="padding: 3px 0 15px;">
										    	<div class="col-md-4">
											<div class=" form-group current-stage">		
											 <label  >Are  there suitable settled workers available to be recruited for this role ?</label>
											  <select class="form-control" required="" name="recruited"  style="margin-top: 10px;"  onchange="trade_epmloyee(this.value);">
											      
											 	<option value=""   >Select</option>
											  
												<option value="Yes"  <?php  if($job->recruited!=''){  if($job->recruited=='Yes'){ echo 'selected';} } ?> >Yes</option>
												<option value="No" <?php  if($job->recruited!=''){  if($job->recruited=='No'){ echo 'selected';} } ?>>No</option>
											  </select>
											   
											</div>
											
										  </div>
										  	<div class="col-md-2">
										  	     </div>
										   <div class="col-md-4 " id="criman_new" <?php  if($job->recruited=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
										    <div class="form-group">
										    	<label for="other" class="placeholder">Give Details </label>
												<input id="other" type="text" class="form-control input-border-bottom" name="other"  value=" @if($job->other){{  $job->other }}@endif ">
												
											</div>
										   </div>
											<div class="col-md-4">
											<div class=" form-group current-stage">		
												 <label>Current Stage of Recruitment</label>
											  <select class="form-control" required="" name="status"  style="margin-top: 10px;">
 <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
											 											   
											  
												<option value="Interview"  <?php  if($job->status!=''){  if($job->status=='Interview'){ echo 'selected';} } ?> >Interview</option>
												<option value="Hold" <?php  if($job->status!=''){  if($job->status=='Hold'){ echo 'selected';} } ?>>Hold</option>
											  </select>
											    <!--<label for="inputFloatingLabel-recruitment" class="placeholder">Current Stage of Recruitment</label>-->
											</div>
										  </div>
                                             
                                             
                                              <div class="col-md-8" style="    padding-top: 25px;">
											<div class=" form-group">
											    
											  <input type="text" placeholder="Remarks" style="margin-top:9px" class="form-control" value="<?php  if($job->remarks!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->remarks;} } ?>" name="remarks">
											    
											</div>
							   	    	</div>
										  
										  
                                       </div>   

                                      
                                      <div class="row form-group">
                                      

							   	    	 <div class="col-md-4">
											<div class="form-group" style="margin: 7px 0 15px;">
											    <label>Date </label>	
											  <input type="date" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->date;} } ?>"  name="date">
											    
											</div>
							   	    	</div>
							   	    	<div class="col-md-4">
											<div class="form-group" style="margin: 7px 0 15px;">
											    <label>From Time </label>	
											  <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->from_time;} } ?>"  name="from_time">
											    
											</div>
							   	    	</div>
							   	    	<div class="col-md-4">
											<div class="form-group" style="margin: 7px 0 15px;">
											    <label>To Time </label>	
											  <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->to_time;} } ?>"  name="to_time">
											    
											</div>
							   	    	</div>
							   	    	 <div class="col-md-6">
											<div class=" form-group" style="margin: 7px 0 15px;">
											    
											  <input type="text" placeholder="Interview Place" style="margin-top:9px" class="form-control" value="<?php  if($job->place!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->place;} } ?>"  name="place">
											    
											</div>
							   	    	</div>
							   	    	<div class="col-md-6" >
											<div class=" form-group" style="margin: 7px 0 15px;">
											    
											  <input type="text" placeholder="Interview Panel " style="margin-top:9px" class="form-control" value="<?php  if($job->panel!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->panel;} } ?>"  name="panel">
											    
											</div>
							   	    	</div>
							   	    		
							   	    </div>	
                                       	<div class="row form-group" style="margin-top:15px;background:none;">
										 <div class="col-md-12">
										    <button class="btn btn-default sub" type="submit">Submit</button>
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
		 function trade_epmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_new").style.display = "block";	
		$("#other").prop('required',true);
		
	}else{
		document.getElementById("criman_new").style.display = "none";	
			$("#other").prop('required',false);
	}
  
}
	</script>
</body>
</html>