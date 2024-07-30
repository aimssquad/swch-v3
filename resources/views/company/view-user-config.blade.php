<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
	
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
	 @include('role.include.header')
		<!-- Sidebar -->
		
		  @include('role.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
							<!-- <h4 class="page-title">Role Management</h4> -->
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
								<a href="{{url('role/vw-users')}}">User</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="#">User Configuration</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
								
											@if(isset($user) && !empty($user->id))
                            	
							<h4 class="card-title"> <i class="flaticon-profile"></i> Edit User Configuration</h4>
                            	@else
                                
							<h4 class="card-title"> <i cl ss="flaticon-profile"></i> Add User Configuration</h4>
                                @endif 
								</div>
								<div class="card-body">
									<form action="{{ url('role/vw-user-config') }}" method="post" enctype="multipart/form-data" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<div class="row form-group">
															<div class="col-md-3">
											
											<div class="form-group">
												<label for="selectFloatingLabel" class="placeholder">Employee Code</label>
												<select  class="form-control " id="selectFloatingLabel"  required="" name="emp_code" onchange="getEmployeeName()" <?php if(!empty($user->id)){echo 'style="display:none"';}?>>
					<option value="">Select Employee Code</option>
								<?php foreach($employees as $employee){ ?>
								<option value="<?php echo $employee->emp_code; ?>" <?php if(!empty($user->id)){ if($user->employee_id== $employee->emp_code){echo 'selected'; }} ?> ><?php echo $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname." (".$employee->emp_code.") "; ?></option>
								<?php } ?>
					</select>
					<input type="text" name="employee_id" value="<?php if(!empty($user->id)){echo $user->employee_id;} ?>" <?php if(empty($user->id)){echo 'style="display:none"';}?> class="form-control input-border-bottom" id="selectFloatingLabel" readonly="1" />
                        
												
												 @if ($errors->has('emp_code'))
						        <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
						@endif
											</div>
												
											</div>
											
											<div class="col-md-3">
											
											<div class="form-group ">
												<input id="inputFloatingLabel" type="text" class="form-control " required="" name="name" value="<?php if(!empty($user->id)){echo $user->name;}?>"  readonly="1">
												<label for="inputFloatingLabel" class="placeholder">Employee Name</label>
											</div>
											
												</div>
											<div class="col-md-3">
												<div class="form-group ">
												<input id="inputFloatingLabel1" type="email" <?php if(!empty($user->id)){echo 'readonly';}?>  class="form-control " required="" name="user_email" value="<?php if(!empty($user->id)){echo $user->email;}?>"  >
												<label for="inputFloatingLabel1" class="placeholder">Email</label>
											</div>
											</div>
											<div class="col-md-3">
												
											<div class="form-group">
												<label for="inputFloatingLabel2" class="placeholder">User Password</label>
												<input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom"  name="user_pass" value="<?php if(!empty($user->id)){echo $user->password;}?>">
												
												
												 @if ($errors->has('user_pass'))
        				<div class="error" style="color:red;">{{ $errors->first('user_pass') }}</div>
					@endif
											</div>
											</div>
											<div class="col-md-3" <?php if(empty($user->id)){ ?>style="display:none" <?php } ?>>
												
											<div class="form-group">
												<label for="selectFloatingLabel3" class="placeholder">User Password</label>
												<select id="selectFloatingLabel3"  class="form-control input-border-bottom"   name="status">
							<option value="active" <?php if(!empty($user->status)){  if($user->status == "active"){ ?> selected="selected" <?php } }?>  >Active</option>
							<option value="deactive" <?php if(!empty($user->status)){ if($user->status == "deactive"){ ?> selected="selected" <?php } } ?>>Deactive</option>
						</select>
												
												
												
											</div>
											</div>
											</div>
											<div class="row form-group">
										 <div class="col-md-12">
											
										<button type="submit" class="btn btn-default">Submit</button>
										</div>
										</div>
										</div>
										
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
				 @include('role.include.footer')
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
			
			
			function getEmployeeName()
	{	
		//$('#emplyeename').show();		
		var emp_code = $("#selectFloatingLabel option:selected").text();
		var empid = $("#selectFloatingLabel option:selected").val();
		var name = emp_code.split("(");
		
$.ajax({
				type:'GET',
				url:'{{url('role/get-employee-all-details')}}/'+empid,
				success: function(response){


 

				  
				   var obj = jQuery.parseJSON(response);
				  console.log(obj);
				  
					  var bank_sort=obj[0].emp_ps_email; 

					  $("#inputFloatingLabel1").val(bank_sort);
				   $("#inputFloatingLabel1").attr("readonly", true);
				   
				  
				   
				
				  
			  
				}
			});
		$("#inputFloatingLabel").val(name[0]); 
			


		//$("#emp_name").attr("readonly", true);  
	}
	</script>
</body>
</html>