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
						<!-- <h4 class="page-title">Organisation</h4> -->

					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-building"></i> HR Complete Organisation @if(count($companies_rs)!=0)

									<form  method="post" action="{{ url('superadmin/complete-hr-internal-export') }}" enctype="multipart/form-data" >
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="start_date" value="{{ $start_date }}">
										<input type="hidden" name="end_date" value="{{ $end_date }}">
										<button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
									</form>

									@endif</h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									<form  method="get" action="{{ url('superadmin/complete-hr-internal') }}" enctype="multipart/form-data" >
                                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    	<div class="row form-group">
                                            <div class="col-md-5">
												<div class=" form-group">
													<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
													<input id="start_date" value="<?php if (isset($start_date) && $start_date) {echo date('Y-m-d', strtotime($start_date));}?>"  name="start_date" type="date" class="form-control input-border-bottom">
									        	</div>
								     		</div>

								     		 <div class="col-md-5">
												<div class=" form-group">
												<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
												<input id="end_date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo date('Y-m-d', strtotime($end_date));}?>"  type="date" class="form-control input-border-bottom">


									        	</div>
								     		</div>
								     		<div class="col-md-2 btn-up">
										      <button class="btn btn-default" type="submit">Submit</button>
											  <a class="btn btn-primary" href="{{ url('superadmin/complete-hr-internal') }}">Reset</a>
								     		</div>
										</div>

									</form>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
													<th>Organisation Name</th>
													<th>Organisation Address</th>

													<!-- <th>Website</th> -->
													<th>Login User ID</th>
													<th>Password</th>
													<th>Phone No.</th>
													<!-- <th>Status</th>
													<th>Verification</th>
													<th>License Applied</th> -->
													<th>License Type</th>
													<th>SWC Employee</th>
													<th>License Applied On</th>
													<th>HR Assigned On</th>
													<th>Updated On</th>
													<th>HR Remarks</th>
													<!-- <th>Action</th> -->
												</tr>
											</thead>

											<tbody>
											  <?php $i = 1;?>
							@foreach($companies_rs as $company)
								<?php
$pass = DB::Table('users')

    ->where('employee_id', '=', $company->reg)

    ->first();

?>
						<tr>
							<td>{{ $loop->iteration }}</td>	<td>{{ $company->com_name }}</td>

							<td>@if($company->address!=''){{ $company->address }} @if($company->address2!=''),{{ $company->address2 }}@endif,{{  $company->road }},{{  $company->city }},{{  $company->zip }},{{  $company->country }}@endif {{ $company->website }}</td>

                            <!-- <td>{{ $company->website }}</td> -->
                              <td>{{ $company->email }}</td>
							     <td>{{ $pass->password }}</td>
                            <td>{{ $company->p_no }}</td>
							<!-- <td>{{ strtoupper($company->status) }}</td>
							    <td>
							        @if($company->verify=='approved')
							       VERIFIED
							       @else
							       NOT VERIFIED
							       @endif</td>
								   <td>
							        @if($company->licence=='yes')
							       APPLIED
							       @else
							       NOT APPLIED
							       @endif</td> -->
                                   <td>@if($company->license_type!='')  {{ $company->license_type  }} @else NA @endif</td>
								   <td>{{ $company->caseworker  }}</td>
								   <td>@if($company->application_submission_date!='')  {{ date('d-m-Y',strtotime($company->application_submission_date))  }}@endif</td>
								   <td>@if($company->hr_assigned_at!='')  {{ date('d-m-Y',strtotime($company->hr_assigned_at))  }}@endif</td>
								   <td>@if($company->hr_updated_at!='')  {{ date('d-m-Y',strtotime($company->hr_updated_at))  }}@endif</td>
								   <td>{{ $company->hr_remarks  }}</td>
							       <!-- <td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{url('superadmin/edit-company/'.$company->id)}}"><i class="far fa-edit"></i>&nbsp; Edit</a>
    <a download class="dropdown-item" href="{{url('superadmin/company-report/'.base64_encode($company->reg))}}"><i class="fas fa-download"></i>&nbsp; Download</a>
  </div>
	</div>
 </td> -->

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