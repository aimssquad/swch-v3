<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
	<style>
	    .table td, .table th{padding:0 10px !important;}
	</style>
</head>
<body>
	<div class="wrapper">
	 @include('leave.include.header')
		<!-- Sidebar -->
		
		  @include('leave.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Add New Leave Allocation</h4> -->
						<!-- <ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('leavedashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-home">
								<a href="{{url('leave-management/leave-rule-listing')}}">
								 Leave 
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('eave-management/view-leave-rule')}}">Edit Leave Rule</a>
							</li>
							
						</ul> -->
					</div>
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-calendar"></i> Add New Leave Allocation</h4>
										@if(Session::has('message'))										
									<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
									@endif
								</div>
								<div class="card-body">
									<form action="{{ url('leave-management/get-leave-allocation') }}" method="post" enctype="multipart/form-data" >
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										
										<div class="row form-group">
  									<div class="col-md-4">
										<div class="form-group">			
											<label for="employee_type" class="placeholder">Employment Type</label>
										<select id="employee_type"   name="employee_type" type="date" class="form-control input-border-bottom" required="" onchange="paygr(this.value);">
											<option value=""></option>
											
											@foreach($employee_type_rs as $emp)
						                        	<option value="{{$emp->employ_type_name}}">{{$emp->employ_type_name }}</option>
						                        @endforeach
											
										</select>
									
									   </div>
									 </div>
										
										<div class="col-md-4">
										<div class="form-group">			
										<label for="employee_code" class="placeholder">Employee Code</label>
										<select id="employee_code"  id="employee_code" name="employee_code" class="form-control input-border-bottom">
											
											<?php if(isset($remp) && $remp!=''){?>

											@foreach($employees as $empval)
						                        	<option value="{{$empval->emp_code}}" <?php if( $empval->emp_code==$remp){echo 'selected';}?>>{{$empval->emp_fname }} {{$empval->emp_mname }} {{$empval->emp_lname }} ({{$empval->emp_code }})</option>
						                        @endforeach
											
											<?php } ?>
										</select>
										
									   </div>
										</div>
										<div class="col-md-4">
												<div class="form-group">
												    	<label for="inputFloatingLabel-choose-year" class="placeholder">Choose Year</label>
									<select id="inputFloatingLabel-choose-year" name="year_value" class="form-control input-border-bottom" required="">
												<option value="">&nbsp;</option>
														<?php for($i = date("Y")-2; $i <=date("Y")+5; $i++){
								    echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
								} ?>
												</select>
												
										    	</div>
											</div>
									
										<div class="col-md-4"><button class="btn btn-default">Submit</button></div>
										
										
										</div>
										</form>
										
										</div>
										
										
										<form method="post" action="{{ url('leave-management/save-leave-allocation') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th><div class="form-check"><label class="form-check-label">
													<span class="form-check-sign"> Select</span></label></div></th>
													<th>Employment Type</th>
													<th>Employee Code</th>
													<th>Employee name</th>
													<th>Leave Name</th>
													<th>Maximum No.</th>
													
													<th>Leave in Hand</th>
													<th>Effective Year</th>
												
												
													
												</tr>
											</thead>
											
											<tbody>
											<?php print_r($result); ?>
												</tbody>
													<tfoot>
													    <?php if(isset($result) && $result!=''){ ?>
														<tr>
															<td colspan="4"><div class="form-check"><label class="form-check-label"><input id="selectAllval" class="form-check-input" type="checkbox" name="allval" >
													<span class="form-check-sign"> </span>Check All</label></div></td>
															<td colspan="4"><button style="float:right" class="btn btn-default">Save</button></td>
														</tr>
														<?php
													    }
													    ?>
													</tfoot>
										</table>
										</div>
										
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			@include('leave.include.footer')
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
	<!-- Atlantis JS -->
	<script src="assets/js/atlantis.min.js"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="assets/js/setting-demo2.js"></script>
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
<script>
$("#selectAll").click(function() {
    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
$("input[type=checkbox]").click(function() {
    if (!$(this).prop("checked")) {
        $("#selectAll").prop("checked", false);
    }
});

$("#selectAllval").click(function() {
    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
$("input[type=checkbox]").click(function() {
    if (!$(this).prop("checked")) {
        $("#selectAllval").prop("checked", false);
    }
});

jackHarnerSig();


function paygr(val){
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
	
	
		
			$('#allval').click(function(event) {  
		
			if(this.checked) {
				//alert("test");
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;                        
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;                       
				});
			}
		});
		
		
</script>
</body>
</html>