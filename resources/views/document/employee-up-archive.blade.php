<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}']},
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

  @include('document.include.header')
		<!-- Sidebar -->

		  @include('document.include.sidebar')
		<!-- End Sidebar -->
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
								<a href="{{url('document/employee-archive-report')}}">Employee Archive Report</a>
							</li>

						</ul>
					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Employee Archive Report</h4>

						 @if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
								</div>
								<div class="card-body">
								 <form  method="post" action="{{ url('document/employee-archive-report') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="row form-group">
											<div class="col-md-6">
												<div class="form-group">
												    	<label for="inputFloatingLabel-choose-year" class="placeholder">Employee  Code</label>
									<select id="inputFloatingLabel-choose-year" name="em_code" class="form-control input-border-bottom" required="" onchange="checkemp(this.value);">
												<option value="">&nbsp;</option>


												 @foreach($employee_rs as $employee)
												<option value="{{ $employee->emp_code}}" > {{ $employee->emp_fname}}
												{{ $employee->emp_mname}} {{ $employee->emp_lname}}({{ $employee->emp_code}} )</option>
											@endforeach

												</select>

										    	</div>
											</div>
												<div class="col-md-6">
												<div class="form-group">
												    <label for="em_gan" class="placeholder">Employee Document</label>
													<select id="em_gan" name="em_gan" class="form-control input-border-bottom" required="">
														<option value="">&nbsp;</option>
													<option value="pr_add_proof">Proof Of Correspondence Address </option>

													<option value="pass_docu">Passport Document </option>
													<option value="visa_upload_doc">Visa Document </option>
													<option value="dbs_upload_doc">DBS Document </option>
												</select>

										    	</div>
											</div>
											</div>
											<div class="row form-group">

											<div class="col-md-6">
												<button type="submit" class="btn btn-default">View</button>
											</div>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
						@if(isset($paths))
						@foreach($paths as $path)
						@php
						//dd($path);

							if (isset($path) && $path != '') {
    							$secod = explode(",", $path);


								//dd($secod);
								
    					@endphp
						
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">View</h4>
									</div>
									<div class="card-body" style="width:100%;margin:auto;">
										@if(count($secod)==1)
											<embed src="https://workpermitcloud.co.uk/hrms/public/{{$path}}" frameborder="0" width="100%" height="300px"></embed>

										@elseif(count($secod)==2)
											<embed src="https://workpermitcloud.co.uk/hrms/public/{{$secod[0]}}" frameborder="0" width="100%" height="300px"></embed>
											<embed style="margin-top:20px;padding-left:0;" src="https://workpermitcloud.co.uk/hrms/public/{{$secod[1]}}" frameborder="0" width="100%" height="auto"></embed>

										@endif
									</div>
									<div class="col-md-6 text-right">
										@if(count($secod)==1)
											<a data-toggle="tooltip" data-placement="bottom" title="Download" href="https://workpermitcloud.co.uk/hrms/public/{{$path}}" download    class="btn btn-default" style="background:none !important;" ><img  style="width: 25px;" src="{{ asset('img/dnld.png')}}"></a>

											@elseif(count($secod)==2)
											<a data-toggle="tooltip" data-placement="bottom" title="Download" href="https://workpermitcloud.co.uk/hrms/public/{{$secod[0]}}" download    class="btn btn-default" style="background:none !important;" ><img  style="width: 25px;" src="{{ asset('img/dnld.png')}}"></a>
											<a data-toggle="tooltip" data-placement="bottom" title="Download" href="https://workpermitcloud.co.uk/hrms/public/{{$secod[1]}}" download    class="btn btn-default" style="background:none !important;" ><img  style="width: 25px;" src="{{ asset('img/dnld.png')}}"></a>
										@endif
									</div>
								</div>
							</div>
						</div>
						@php
						}
						@endphp
						@endforeach
						@endif
					</div>
				</div>
			</div>
			  @include('document.include.footer')
		</div>

		<!-- Custom template | don't include it in your project! -->

		<!-- End Custom template -->
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


	<!-- Chart JS -->
	<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script >
	function checkemp(empid){

	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedreportfileById')}}/'+empid,
        cache: false,
		success: function(response){


			document.getElementById("em_gan").innerHTML = response;
			//$('#em_gan').val(@if(isset($em_gan)) $em_gan @endif);
		}
		});
   }

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
