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
							<li class="nav-item active">
								<a href="{{url('recruitment/search')}}">  Search</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
				
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
						
									<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								
								<div class="card-body">
									 <form  method="post" action="{{ url('recruitment/search') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
													<div class="row form-group">
										<div class="col-md-3">
											<div class=" form-group current-stage">		
											<label for="inputFloatingLabel-recruitment" class="placeholder">Current Stage of Recruitment</label>
											  <select id="inputFloatingLabel-recruitment" name="status" class="form-control input-border-bottom" required=""  style="">
											    <option value="">Select</option>
											    <option value="Application Received"  <?php if(isset($status) && $status=='Application Received') { echo 'selected';}?>>Application Received</option>
													<option value="Short listed" <?php if(isset($status) && $status=='Short listed') { echo 'selected';}?>>Short listed</option>
											   
												<option value="Interview" <?php if(isset($status) && $status=='Interview') { echo 'selected';}?>>Interview</option>
													<option value="Online Screen Test"  <?php if(isset($status) && $status=='Online Screen Test') { echo 'selected';}?> >Online Screen Test</option>	
													<option value="Written Test"   <?php if(isset($status) && $status=='Written Test') { echo 'selected';}?> >Written Test</option>
																							
															<option value="Telephone Interview"   <?php if(isset($status) && $status=='Telephone Interview') { echo 'selected';}?> >Telephone Interview</option>
															<option value="Face to Face Interview"   <?php if(isset($status) && $status=='Face to Face Interview') { echo 'selected';}?> >Face to Face Interview</option>
												 
												 <option value="Job Offered" <?php if(isset($status) && $status=='Job Offered') { echo 'selected';}?>>Job Offered</option>
											
												<option  value="Hired" <?php if(isset($status) && $status=='Hired') { echo 'selected';}?>>Hired</option>
												<option value="Hold"  <?php if(isset($status) && $status=='Hold') { echo 'selected';}?>>Hold</option>
												<option value="Rejected" <?php if(isset($status) && $status=='Rejected') { echo 'selected';}?>>Rejected</option>
											  </select>
											    
											</div>
										  </div>
										  	<div class="col-md-3">
											<div class=" form-group current-stage">		
											<label for="inputFloatingLabel-recruitment" class="placeholder">Job Title </label>
											  <select id="job_id" name="job_id" class="form-control input-border-bottom"  style="">
											    <option value="">Select</option>
											    @foreach($company_job_rs as $dept)
                     <option value="{{$dept->id}}">{{$dept->title}}  (Job Code :{{$dept->job_code}} )</option>
                       @endforeach
											  </select>
											    
											</div>
										  </div>

                                            <div class="col-md-3">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
												<input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="date" class="form-control input-border-bottom" required="" style="">
												

									        	</div>		
								     		</div>

								     		 <div class="col-md-3">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
												<input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="date" class="form-control input-border-bottom" required="" style="">
												

									        	</div>		
								     		</div>
								     		<div class="col-md-3">
										      <button class="btn btn-default" style="margin-top: 25px;" type="submit">Submit</button>
								     	</div>
										</div>
	
									</form>
									
									
								</div>
							</div>
						</div>
					</div>


						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Search</h4>
																		      <?php

if(isset($result) && $result!=''  ){
											?>
											 <form  method="post" action="{{ url('recruitment/search-result') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input id="inputFloatingLabel-select-date" value="<?php if(isset($status) && $status) { echo $status;}?>"  name="status" type="hidden" class="form-control input-border-bottom" required="" >
												<input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
							<input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
								<input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
									
										 <button class="btn btn-default" style="margin-top: -30px;float:right;" type="submit">Download Pdf</button>	
											</form>
											<?php
}?>
					<?php

if(isset($result) && $result!=''  ){
											?>
											 <form  method="post" action="{{ url('recruitment/search-result-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input id="inputFloatingLabel-select-date" value="<?php if(isset($status) && $status) { echo $status;}?>"  name="status" type="hidden" class="form-control input-border-bottom" required="" >
												<input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
							<input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
									<input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
									
								
										 <button class="btn btn-default" style="margin-top: -30px;float:right;margin-right: 15px;" type="submit">Download Excel</button>	
											</form>
											<?php
}?>
		
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Job Code</th>
													<th>Job Title</th>
													<th>Candidate</th>
													<th>Email</th>
													<th>Contact Number</th>
													<th>Status</th>
													<th>Date</th>
													<th>Action</th>
													
												</tr>
											</thead>
											
											<tbody>
												 <?php

if(isset($result) && $result!=''  ){
												 print_r($result); 
}?>
											</tbody>
										</table>
									</div>
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
			function employeetype(val){
		var empid=val;
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("employee_code").innerHTML = response;
		}
		});
	}
	</script>
</body>
</html>