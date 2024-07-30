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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
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
		
  @include('settings.include.header')
		<!-- Sidebar -->
		
		  @include('settings.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h2 class="text-white pb-2 fw-bold" style="padding-left:20px;">Pay Item</h2> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('settingdashboard')}}">
									Home
								</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item">
								<a href="#">Payroll</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="{{url('settings/payitemlist')}}">Rate Details</a>
							</li>
                            
						
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title">Rate Details
								</h4>
                                <div class="d-flex justify-content-between">
                                <div>
                                        <!-- right -->
                                    </div>
                                    <div>
                                       <a href="{{url('settings/rate-master-details-add')}}"><button class="btn btn-outline-success">Add</button></a>
                                    </div>
                                </div>
	@if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
								
                                <tr>
                <th>Sl. No.</th>
                <th>Head Name</th>
				<th>Head Type</th>
                <th>Calculation Type</th>
				<th>InPercentage</th>
                <th>InRupees</th>
				<th>Min Value</th>
                <th>Max Values</th>
                <th>Effective From</th>
                <th>Effective To</th>
                <th>Status</th>
				<th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rate as $ratedtl)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ratedtl->head_name }}</td>
                                        <td>{{ $ratedtl->head_type }}</td>
										@if($ratedtl->cal_type == 'V')
                                        <td>Variable</td>
										@else
										<td>Fixed</td>
										@endif

                                        <td>{{ $ratedtl->inpercentage }}</td>
                                        <td>{{ $ratedtl->inrupees }}</td>
                                        <td>{{ $ratedtl->min_basic }}</td>
                                        <td>{{ $ratedtl->max_basic }}</td>
                                        <td>{{ $ratedtl->from_date }}</td>
                                        <td>{{ $ratedtl->to_date }}</td>
                                        <td>{{ ucfirst($ratedtl->status)}}</td>
    									<td><a href="{{url('settings/getupdateratedetails/'.$ratedtl->id)}}" data-toggle="tooltip"data-placement="bottom" title="Edit"><img  style="width: 19px;" src="{{ asset('assets/img/edit.png')}}"></a></td>
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