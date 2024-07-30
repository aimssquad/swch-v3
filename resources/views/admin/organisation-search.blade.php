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
	
	<style>
	    .form-floating-label .placeholder{padding:0.375rem 0rem;}
	</style>
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Employee Tracker</h4> -->
						
					
					</div>
			<div class="content">
				<div class="page-inner">
					
				
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
						
				<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i>&nbsp; Employee Tracker 
									</h4>
								</div>
								<div class="card-body">
									 <form  method="post" action="{{ url('superadmin/view-search-dasboard') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    	<div class="row form-group">
                                  <div class="col-md-3">
												
										<div class=" form-group current-stage">		
											<label for="inputFloatingLabel-recruitment" class="placeholder">Select User </label>
											  <select id="employee_id" name="employee_id" class="form-control input-border-bottom">
											    <option value="">Select</option>
											    @foreach($or_active as $dept)
                     <option value="{{$dept->employee_id}}">{{$dept->name}}  (Employee Code :{{$dept->employee_id}} )</option>
                       @endforeach
											  </select>
											    
											</div>
										  </div>


                                            <div class="col-md-3">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
												<input id="start_date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="date" class="form-control input-border-bottom"  onchange="checkreff(this.value);">
												

									        	</div>		
								     		</div>

								     		 <div class="col-md-3">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
												<input id="end_date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="date" class="form-control input-border-bottom" onchange="checkreff(this.value);">
												

									        	</div>		
								     		</div>
								     		<div class="col-md-3 btn-up">
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
	
	
	 function checkreff(val) {
	if(val!=''){

		$("#start_date").prop('required',true);
		$("#end_date").prop('required',true);
	}else{
	
				$("#start_date").prop('required',false);
		$("#end_date").prop('required',false);
	}
  
}
	</script>
</body>
</html>