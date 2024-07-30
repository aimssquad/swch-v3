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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../assets/css/fonts.min.css']},
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
	    .card .card-body, .card-light .card-body {
    padding: 20px 10px;
}
.main-panel{margin-top:0;}
	</style>
</head>
<body>
	<div class="wrapper">
		
  @include('settings.include.header')
		<!-- Sidebar -->
		
		  @include('settings.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Company</h4>
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
								<a href="#">Company</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('settings/company')}}">Company</a>
							</li>
						
							<li class="nav-item">
								<a href="#">Edit Company</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Edit Company</h4>
									@if(Session::has('message'))										
							<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body" >
								<form action="{{url('settings/editcompany')}}" method="post" enctype="multipart/form-data">
											 {{csrf_field()}}
										<div class="row form-group">
										<div class="col-md-4">
						<label style="margin-top:10px;">Company Name</label>
						<input type="text" class="form-control"  name="com_name"  value="{{ $Roledata->com_name}}">
					</div>
								
@if ($errors->has('com_name'))
								<div class="error" style="color:red;">{{ $errors->first('com_name') }}</div>
							@endif	
	<div class="col-md-4">
					<label>First Name</label>
						<input type="text" class="form-control" name="f_name"  value="{{ $Roledata->f_name}}" required>
					</div>
					
					<div class="col-md-4">
					<label>Last Name</label>
						<input type="text" class="form-control" name="l_name"  value="{{ $Roledata->l_name}}">
					</div>
							@if ($errors->has('l_name'))
								<div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>
							@endif
					<div class="col-md-4">
					<label>Email ID</label>
						<input type="email" class="form-control" readonly name="email"  value="{{  $Roledata->email }}">
					</div>
						@if ($errors->has('email'))
								<div class="error" style="color:red;">{{ $errors->first('email') }}</div>
							@endif
					<div class="col-md-4">
					<label>Phone No.</label>
						<input type="text" class="form-control" name="p_no"  value="{{  $Roledata->p_no }}">
					</div>
						@if ($errors->has('p_no'))
								<div class="error" style="color:red;">{{ $errors->first('p_no') }}</div>
							@endif
							</div>
					<div class="row form-group">
					<div class="col-md-4">
					<img src="{{ asset($Roledata->logo) }}" height="50px" width="50px"/>
					<label>Logo</label>
					
						<input type="file" class="form-control" name="image"  >
					</div>
					<div class="col-md-4">
					<label>Website</label>
						<input type="text" class="form-control" name="website"  value="@if ($Roledata->website){{  $Roledata->website }}@endif">
					</div>
					
					<div class="col-md-4">
					<label>Fax</label>
						<input type="text" class="form-control" name="fax"  value="@if ($Roledata->fax){{  $Roledata->fax }}@endif">
					</div>
					<div class="col-md-4">
					<label>Company PAN</label>
						<input type="text" class="form-control" name="pan"  value="@if($Roledata->pan){{  $Roledata->pan }}@endif">
						@if ($errors->has('pan'))
								<div class="error" style="color:red;">{{ $errors->first('pan') }}</div>
							@endif
					</div>
						
					</div>
					
					<div class="row form-group">
					<div class="col-md-6">
						<label>Address</label>
						<textarea rows="5"  name="address" class="form-control">@if ($Roledata->address){{  $Roledata->address }}@endif</textarea>
						@if ($errors->has('address'))
								<div class="error" style="color:red;">{{ $errors->first('address') }}</div>
							@endif
					</div>
					
										
										<div class="col-md-6">
						<button type="submit" class="btn btn-default btn-up">Submit</button>
					</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
				 @include('settings.include.footer')
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