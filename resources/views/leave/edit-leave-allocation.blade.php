<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	
	
	<!-- Fonts and icons -->
	
	<!-- Fonts and icons -->
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
						<!-- <h4 class="page-title">Leave Allocation</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('leavedashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-home">
								<a href="{{url('leave-management/leave-allocation-listing')}}">
								 Leave Allocation
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('leave-management/leave-allocation-dtl')}}">Edit Leave Allocation</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
										
									
                            	<h4 class="card-title"> <i class="far fa-check-circle" aria-hidden="true" style="color:#10277f;"></i> &nbsp; Edit Leave Allocation</h4>
							
								</div>
								<div class="card-body">
									<form action="{{ url('attendance/save-edit-leave-allocation') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $leave_allocation->id;  ?>">
                            <input type="hidden" name="leave_type_id" value="<?php echo $leave_allocation->leave_type_id; ?>">
                             <input type="hidden" name="leave_rule_id" value="<?php echo $leave_allocation->leave_rule_id; ?>">
									 
										<div class="row form-group">
                                        
                                      

                                        
										<div class="col-md-4">
										  <div class="form-group">		
										  <label for="leave_type_name" class="placeholder">Leave Type.</label>
									    	<input   type="text" class="form-control input-border-bottom" required="" id="leave_type_name" name="leave_type_name" value="<?php  if(!empty($leave_type->leave_type_name)){echo $leave_type->leave_type_name;} ?>" readonly>
									    	
											
										</div>
										
										</div>
										
											<div class="col-md-4">
										  <div class="form-group">	
										  <label for="employee_code" class="placeholder">Employee Code</label>
									    	<input   type="text" class="form-control input-border-bottom" required="" id="employee_code" name="employee_code" value="<?php  if(!empty($leave_allocation->employee_code)){echo $leave_allocation->employee_code;} ?>" readonly>
									    	
											
										</div>
										
										</div>
							
							<div class="col-md-4">
										  <div class="form-group">	
										  <label for="max_no" class="placeholder">Max No. Of Leave </label>
									    	<input   type="text" class="form-control input-border-bottom" required="" name="max_no" id="max_no" value="<?php  if(!empty($leave_allocation->max_no)){echo $leave_allocation->max_no;} ?>" readonly>
									    	
											
										</div>
										
										</div>
										</div>
										<div class="row form-group">
										 <?php
												$leaveemdata = DB::table('employee_type')      
                 ->where('id','=', $leave_allocation->employee_type)
                 
                  ->first(); 
												 
												 
												 ?>
										<div class="col-md-4">
										  <div class="form-group">	
										  <label for="employee_type" class="placeholder">Employee Type</label>
									    	<input   type="text" class="form-control input-border-bottom" required="" name="employee_type" id="employee_type" value="<?php  if(!empty($leave_allocation->employee_type)){echo $leaveemdata->employee_type_name;} ?>" readonly>
									    	
											
										</div>
										
										</div>
											<div class="col-md-4">
										  <div class="form-group">	
										  <label for="leave_in_hand" class="placeholder">Leave in Hand. </label>
									    	<input   type="text" class="form-control input-border-bottom" required="" name="leave_in_hand" id="leave_in_hand" value="<?php  if(!empty($leave_allocation->leave_in_hand)){echo $leave_allocation->leave_in_hand;} ?>" >
									    	
											
										</div>
										
										</div>
											<div class="col-md-4">
										  <div class="form-group">	
										  <label for="month_yr" class="placeholder">Effective Year</label>
									    	<input   type="text" class="form-control input-border-bottom" required="" name="month_yr" id="month_yr" value="<?php  echo $leave_allocation->month_yr; ?>" readonly>
									    	
											
										</div>
										
										</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12"><button class="btn btn-default">Submit</button></div>
										</div>
									</form>
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