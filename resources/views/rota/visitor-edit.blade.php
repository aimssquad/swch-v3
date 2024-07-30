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
		
  @include('rota.include.header')
		<!-- Sidebar -->
		
		  @include('rota.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Time Shift Management</h4> -->
						
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('rotadashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-home">
								<a href="{{url('rota/visitor-regis')}}">
								Visitor
								</a>
							</li>
							 <li class="separator">
								/
							<li class="nav-item active">
								<a href="#"> Edit Visitor</a>
							</li>
							
						</ul>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
				
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"> <i class="far fa-clock" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Visitor Details</h4>
								</div>
								<div class="card-body">
									<form action="{{url('rota/visitor-edit')}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
										<div class="row form-group">
										   <div class="col-md-4">
										  	<div class=" form-group">
										  	    <input type="hidden" name="visitor_id" value="<?php print_r($visitor->id) ?>">		
                                            	<label for="inputFloatingLabel-grade" class="placeholder">Name</label>
										  	  	 <input type="text" class="form-control" name="name" value="<?php print_r($visitor->name) ?>">
										  </div>
										  </div>
										 <div class="col-md-4">
											<div class="form-group">
												<label for="designation" class="placeholder">Designation </label>
												 <input type="text" class="form-control" name="desig" value="<?php print_r($visitor->desig) ?>">
												
											</div>
										</div> 	
									
											<div class="col-md-4">
												<div class="form-group">
													<label for="designation" class="placeholder">Number </label>
													<input type="number"  name="phone_number" class="form-control" value="<?php print_r($visitor->phone_number) ?>">
												</div>
											</div>
										</div>


										<div class="row form-group">
											<div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Email</label>
												 <input id="inputFloatingLabel-shift-in-time" type="email" class="form-control input-border-bottom"  name="email" value="<?php print_r($visitor->email) ?>"  placeholder="" style="">
												</div>
											   </div>
											   
											   <div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Address</label>
												 <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"   name="address" value="<?php print_r($visitor->address) ?>"  placeholder="" style="">
												</div>
											   </div>
											   
											   <div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Description</label>
												 <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"  name="purpose" value="<?php print_r($visitor->purpose) ?>"  placeholder="" style="">
												</div>
											   </div>
										</div>
										
										<div class="row form-group">
											<div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Date</label>
												 <input id="inputFloatingLabel-shift-in-time" type="date" class="form-control input-border-bottom"   name="date" value="<?php print_r($visitor->date) ?>"  placeholder="" style="">
												</div>
											   </div>
											   
											   <div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Time</label>
												 <input id="inputFloatingLabel-shift-in-time" type="time" class="form-control input-border-bottom"   name="time" value="<?php print_r($visitor->time) ?>"  placeholder="" style="">
												</div>
											   </div>
											   
											   <div class="col-md-4">
												<div class=" form-group">	
												 <label for="inputFloatingLabel-shift-in-time" class="placeholder">Refarence</label>
												 <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"  name="reff" value="<?php print_r($visitor->reff) ?>"  placeholder="" style="">
												</div>
											   </div>
										</div>

										
										  <div class="row form-group">
										    <div class="col-md-4">
										    <div class="sub-reset-btn">	
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style=" background-color: #1572E8!important; color: #fff!important;">Submit</button></a>
											<!-- <i class="fas fa-ban reset-ban-icon"></i> -->
										    <a href="#">	
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Reset</button></a>
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
				 @include('rota.include.footer')
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
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }

   function employeeList(){
	var degId= $('#designation option:selected').text();
	console.log(degId);
	$.ajax({
              url:"{{url('rota/add-shift-management-desi')}}"+'/'+degId,
         		type: "GET",
         		success: function(response) {
         		    console.log(response);
                  document.getElementById("empId").innerHTML = response;
         		}
         	});
   }
   
	</script>
</body>
</html>