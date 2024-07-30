<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assetsemcor/css/fonts.min.css']},
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
	<style>
	    .content.custom-card {
    margin-top: -59px;
}
	</style>
</head>
<body>
	<div class="wrapper">
		
 		
  @include('employee-corner-organisation.include.header')
		<!-- Sidebar -->
		
		  @include('employee-corner-organisation.include.sidebar')
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
							<li class="nav-item">
								<a href="#">Employee Access Value</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="{{url('employee-corner-organisation/attendance-status')}}">Attendance Status</a>
							</li>
							
						</ul>
					</div>
			<div class="content custom-card">
				<div class="page-inner">
					
				
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
						
									<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									 <form  method="post" action="{{ url('employee-corner-organisation/attendance-status') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
										<div class="row form-group">
										<div class="col-md-12">
								            		<h4 class="card-title"><i class="far fa-eye">&nbsp &nbsp</i>Attendance Status</h4>
								            </div>
										  	
										

										  <div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">Form Date</label>
												<input id="inputFloatingLabel-select-date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
												

									        	</div>		
								     		</div>

										  <div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
												<input id="inputFloatingLabel-select-date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
												

									        	</div>		
								     		</div>
								     		</div>
								     		<div class="row form-group">
								     		<div class="col-md-3">
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style=" background-color: #1572E8!important; color: #fff!important;">View</button></a>

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
									<h4 class="card-title">Attendance Status</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl No.</th>
													<th>Date</th>
													<th>Clock In</th>
													<th>Clock In Location</th>
													<th>Clock Out</th>
													<th>Clock Out Location</th>	
													<th>Duty Hours</th>												
													
													
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
				 @include('employee-corner-organisation.include.footer')
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