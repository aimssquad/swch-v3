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

	<style> .add-shift {
    float: right;
} .add-shift .add-shift-btn {
    padding: 6px 24px !important;
    font-size: 14px !important;
    margin: 0px 20px 15px 0px !important;
    background-color: #9e9797 !important;
    color: #fff !important;
}  </style>
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">COS  File Update View</h4> -->
						<!--<ul class="breadcrumbs">-->
						<!--	<li class="nav-home">-->
						<!--		<a href="#">-->
						<!--			<i class="flaticon-home"></i>-->
						<!--		</a>-->
						<!--	</li>-->
						<!--	 <li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="{{url('superadmin/view-cos')}}"> COS  File Update View</a>-->
						<!--	</li>-->
						<!--</ul>-->
					</div>
			<div class="content">
				<div class="page-inner">

							<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-file-word"></i> COS  File Update View</h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									 <form  method="post" action="{{ url('superadmin/view-cos') }}" enctype="multipart/form-data" >
									 {{csrf_field()}}
										<div class="row form-group">


										<div class="col-md-4">
										  	<div class=" form-group">

<label for="employee_id" class="placeholder"> Select Employee</label>
										  	  				<select class="form-control input-border-bottom" id="employee_id" name="employee_id" required="" >

							<option value="">&nbsp;</option>
								<option value="all" <?php if (isset($employee_id)) {if ($employee_id == 'all') {echo 'selected';}}?>>All</option>
			                 @foreach($employee_rs as $dept)
                            <option value='{{ $dept->employee_id }}' <?php if (isset($employee_id)) {if ($employee_id == $dept->employee_id) {echo 'selected';}}?> >{{ $dept->name }}</option>

                            @endforeach

						</select>


										  </div>
										  </div>






										</div>


											<div class="row form-group">
										    <div class="col-md-4">
										    <div class="sub-reset-btn">
								     		<a href="#">
    										    <button class="btn btn-default" type="submit" style=" background-color: #1572E8!important; color: #fff!important;">View COS</button></a>


										    </div>

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
									<h4 class="card-title">COS  File Update View</h4>


								</div>
								<div class="card-body">

									<div class="table-responsive">

										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
												    <th>Sl No</th>
													<th>Organisation Name</th>
													<th>Organisation Employee</th>
												    <th>SWC Employee</th>
												    <th>Applied for Cos-Date</th>
                                                    <th>Reply from HO-date</th>
                                                    <th>Additional information sent - date</th>

                                                    <th>Status</th>
                                                    <th>CoS assigned date</th>
                                                    <th>Remarks</th>
												</tr>
											</thead>

											<tbody>
															 <?php

if (isset($result) && $result != '') {
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
		  function chngdepartmentshift(empid){



			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
        cache: false,
		success: function(response){


			document.getElementById("employee_code").innerHTML = response;
		}
		});
   }
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
	</script>
</body>
</html>