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
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">


					</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-user"></i> Activity Log </h4>

								</div>
								<div class="card-body">
								<form  method="post" action="{{ url('superadmin/activity-log') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    	<div class="row form-group">
                                            <div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
												<input id="start_date" value="<?php if (isset($start_date) && $start_date) {echo $start_date;}?>"  name="start_date" type="date" class="form-control input-border-bottom">


									        	</div>
								     		</div>

								     		 <div class="col-md-4">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
												<input id="end_date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo $end_date;}?>"  type="date" class="form-control input-border-bottom">


									        	</div>
								     		</div>
								     		<div class="col-md-4 btn-up">
										      <button class="btn btn-default" type="submit">Submit</button>
								     	</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
					@if($data_post>0)
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-user"></i> Activity Log </h4>
									@if(Session::has('message'))
									<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
									@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th width="5%">Sl.No.</th>
													<th width="10%">Date</th>
													<th width="15%">Module</th>

													<th width="15%">User Email</th>
													<th>Activity</th>
												</tr>
											</thead>

											<tbody>
											  <?php $i = 1;?>
												@foreach($data_rs as $record)

											<tr>
												<td>{{ $loop->iteration }}</td>

												<td>{{ date('d-m-Y h:i a',strtotime($record->created_at))}}</td>

												<td>{{$record->module_name}}</td>



												<td>{{$record->useremail}}</td>

												<td>{{$record->action_text}}</td>


											</tr>

										@endforeach
            								</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif
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
		});
	</script>
</body>
</html>