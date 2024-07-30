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
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Experience</h4>
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
								<a href="{{url('superadmin/experience')}}">Experience List</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Experience </h4>
									@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
												
													<th> Name</th>
												<th>Gender</th>
													<th>Email ID</th>
														<th>Password</th>
														<th> Resume</th>
													<th>Phone No.</th>
														<th> Address</th>
													<th>	Total Work Experince</th>
													
															<th>Current Designation / Job Title</th>
																<th>Current Company Name</th>
																	<th>Current  Salary</th>
																		<th>Expected  Salary</th>
															<th> Qualification</th>
																<th> Skill Set</th>
																	<th> Skill Level</th>
																		<th> Course Type</th>
																			<th> Desired Job Type</th>
																				<th>Desired Employment Type</th>
													<th>Status</th>
												
													
													
												
												</tr>
											</thead>
											
											<tbody>
											  <?php $i = 1; ?>
							@foreach($companies_rs as $company)	
							<?php
								$pass=DB::Table('users_job')
		        
				 ->where('employee_id','=',$company->reg) 
				 
		         
				->first(); 
			
							?>
						<tr>
							<td>{{ $loop->iteration }}</td>	
							<td>{{ $company->name }}</td>
                                                                           
						
                            <td>{{ $company->gender }}</td>
                              <td>{{ $company->email }}</td>
							     <td>{{ $pass->password }}</td>  
                         
                             <td><a href="https://workpermitcloud.co.uk/job-portal/public/{{ $company->resume }}" target="_blank"><i class="fas fa-download"></i></a></td>
                                <td>{{ $company->p_no }}</td>
                               <td>{{ $company->address }}</td>
                               
                                   <td>{{ $company->exp }} Year(s) {{ $company->exp_month }}Month(s)</td>
                                     <td>{{ $company->cur_deg }}</td>
                                       <td>{{ $company->cur_or }}</td>
                                         <td>{{ $company->sal }}</td>
                                           <td>{{ $company->exp_sal }}</td>
                                <td>{{ $company->qua }}</td>
                                 <td>{{ $company->skill }}</td>
                                   <td>{{ $company->skill_level }}</td>
                                    <td>{{ $company->course_type }}</td>
                                     <td>{{ $company->desire_job_type }}</td>
                                     <td>{{ $company->desire_emp_type }}</td>
							<td>{{ strtoupper($company->status) }}</td>
							   
							     
						</tr>
								
  @endforeach  
            								</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('admin.include.footer')
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