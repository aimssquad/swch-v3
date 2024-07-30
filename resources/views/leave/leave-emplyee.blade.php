<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>

	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
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
		
  @include('leave.include.header')
		<!-- Sidebar -->
		
		  @include('leave.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Leave Management</h4> -->
						
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('leavedashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('leave-management/leave-report-employee')}}">Leave Report Employee wise</a>
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
									 <form  method="post" action="{{ url('leave-management/leave-report-employee') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
										<div class="row form-group">
										    
										    	<div class="col-md-4">
												<div class="form-group">
												    	<label for="inputFloatingLabel-choose-year" class="placeholder">Choose Year</label>
									<select id="inputFloatingLabel-choose-year" name="year_value" class="form-control input-border-bottom" required="">
												<option value="">&nbsp;</option>
														<?php for($i = date("Y")-2; $i <=date("Y")+20; $i++){
														    ?>
								    <option value="<?= $i?>"  
 <?php if(isset($result) && $result!= ""  ){ if($i==$year_value){ echo "selected" ;}}?>> <?= $i ?></option>
 <?php
								} ?>
												</select>
												
										    	</div>
											</div>
													  <div class="col-md-4">
										  	<div class=" form-group">		
										  
<label for="employee_code" class="placeholder">Employee Code</label>
										  	  <select id="employee_code" type="text" class="form-control input-border-bottom" name="employee_code"   required>
											   
												<option value="">&nbsp;</option>
			                 @foreach($employee_rs as $employee)
                            <option value='{{ $employee->emp_code }}' <?php if(isset($result) && $result!= ""  ){ if($employee->emp_code ==$employee_code){ echo "selected" ;}}?>  >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{ $employee->emp_code }})</option>
												
                            @endforeach</select>
										  	
										  </div>
										  </div>
</div>

<div class="row form-group">

								     		<div class="col-md-3">
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">View</button></a>

										    <a href="#">	
										    <button class="btn btn-default" type="reset" style=" background-color: #1572E8!important; color: #fff!important;">Reset</button></a>

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
									<h4 class="card-title"><i class="far fa-file-archive" aria-hidden="true" style="color:#10277f;"></i> &nbsp;Leave Report Employee Wise</h4>
										<?php

if(isset($result) && $result!=''  ){
											?>
											 <form  method="post" action="{{ url('leave-management/leave-report-employee-wise') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
												<input  value="<?php echo $year_value;?>"  name="year_value" type="hidden" class="form-control input-border-bottom" required="" >	
													
										 <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>	
											</form>
												 <form  method="post" action="{{ url('leave-management/leave-report-employee-wise-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
												<input  value="<?php echo $year_value;?>"  name="year_value" type="hidden" class="form-control input-border-bottom" required="" >	
													
										 <buttondata-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>	
											</form>
											<?php
}?>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl No.</th>
													<th>Employee Code</th>
													<th>Employee Name</th>
													<th>Leave Type</th>
													<th>Date Of Application	</th>
													<th>Duration</th>
													<th>No. Of Days</th>
													
													
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
				 @include('leave.include.footer')
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
			function chngdepartmentdesign(val){
		var empid=val;
	
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("employee_code").innerHTML = response;
		}
		});
	}
	   function chngdepartment(empid){
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }
   
   
	</script>
</body>
</html>