<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
	<style>.app-form-text h5 {
    color: #1572e8;
    padding: 24px 20px;
}.app-form-text h5 span {
    color: #000;
    padding-left: 10px;
}.download a {
    color: #fff;
    text-decoration: none;
}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('attendance.include.header')
		<!-- Sidebar -->
		
		  @include('attendance.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Attendance Management</h4>
						
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
								<a href="{{url('attendance/daily-attendance')}}"> Daily Attendance </a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">  Daily Attendance   Details</a>
							</li>
						</ul>
					</div>
						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">  Daily Attendance  Details</h4>
								</div>
								<div class="card-body">
								<form action="{{url('attendance/edit-daily')}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
						<input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
										
								<div class="row form-group">
												<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Department Name</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly  name="department"  value="{{ $job_details->emp_department}}">
												
												
											</div>
											</div>
												<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Designation Name</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly  name="designation"  value="{{ $job_details->emp_designation}}">
												
												
											</div>
											</div>
											<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Employee Code</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly name="employee_code"   value="{{ $job->employee_code}}">
												
												
											</div>
										</div>	
											
							   	    </div>	
									<div class="row form-group">
									    	<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Employee Name</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->employee_name}}">
												
												
											</div>
										</div>
												<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Date</label>
												<input id="inputFloatingLabel2" type="date" class="form-control " readonly  name="date"    value="{{ $job->date}}">
												
												
											</div>
											</div>
											<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Clock In</label>
												<input id="inputFloatingLabel2" type="time" class="form-control " name="time_in"    value="{{$job->time_in}}">
												
												
											</div>
										</div>	
											
							   	    </div>
									<div class="row form-group">
												<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Clock In Location</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->time_in_location}}">
												
												
											</div>
										</div>
											<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Clock Out</label>
												<input id="inputFloatingLabel2" type="time" class="form-control " name="time_out"   value="{{ $job->time_out}}">
												
												
												
											</div>
										</div>	
										<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Clock Out Location</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->time_out_location}}">
												
												
											</div>
										</div>	
	<div class="col-md-4">
											 <div class="form-group ">
											 <label for="inputFloatingLabel2" class="placeholder">Duty Hours</label>
												<input id="inputFloatingLabel2" type="text" class="form-control " readonly  value="{{ $job->duty_hours}}">
												
												
											</div>
											</div>										
							   	    </div>
                                       	<div class="row form-group">
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
				 @include('attendance.include.footer')
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
</body>
</html>