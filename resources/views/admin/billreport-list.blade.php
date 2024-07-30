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
						<!-- <h4 class="page-title">Billing Report</h4> -->

					</div>
			<div class="content">
				<div class="page-inner">

							<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing Report</h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									 <form  method="post" action="{{ url('superadmin/billing-report') }}" enctype="multipart/form-data" >
									 {{csrf_field()}}
										<div class="row">

										  	<div class="col-md-4">
												<div class=" form-group">
												<label for="start_date"  class="placeholder">Form Date</label>
												<input id="start_date"  type="date"  name="start_date" class="form-control input-border-bottom"  onchange="checkreff(this.value);" value="<?php if (isset($start_date)) {echo $start_date;}?>">


									        	</div>
								     		</div>

								     		   <div class="col-md-4">
												<div class=" form-group">
												<label for="end_date"  class="placeholder">To Date</label>
												<input id="end_date"  type="date" name="end_date" class="form-control input-border-bottom"  value="<?php if (isset($end_date)) {echo $end_date;}?>" onchange="checkreff(this.value);">


									        	</div>
								     		</div>
										<div class="col-md-4">
										  	<div class=" form-group">
										  <label for="amount" class="placeholder"> Select Amount</label>

										  <select class="form-control input-border-bottom" id="amount" name="amount">

							<option value="">&nbsp;</option>

			                 @foreach($bill_amout_rs as $dept)
                            <option value='{{ $dept->amount }}' <?php if (isset($amount)) {if ($amount == $dept->amount) {echo 'selected';}}?> >{{ $dept->amount }}</option>

                            @endforeach

						</select>


										  </div>
										  </div>
										 	<div class="col-md-4">
										  	<div class=" form-group">
										  <label for="status" class="placeholder"> Select Status</label>

										  	  				<select class="form-control input-border-bottom" id="status" name="status">

							<option value="">&nbsp;</option>

			                 @foreach($bill_sta_rs as $dept)
                            <option value='{{ $dept->status }}' <?php if (isset($status)) {if ($status == $dept->status) {echo 'selected';}}?> >{{ strtoupper($dept->status )}}</option>

                            @endforeach

						</select>


										  </div>
										  </div>



											<div class="col-md-4">
										  	<div class=" form-group">

<label for="status" class="placeholder"> Select Organisation</label>
										  	  				<select class="form-control input-border-bottom" id="or_name" name="or_name">

							<option value="">&nbsp;</option>

			                 @foreach($orname as $deptgg)
                            <option value='{{ $deptgg->reg }}' <?php if (isset($or_name)) {if ($or_name == $deptgg->reg) {echo 'selected';}}?> >{{ $deptgg->com_name }}</option>

                            @endforeach

						</select>


										  </div>
										  </div>




										</div>


											<div class="row form-group">
										    <div class="col-md-4">
										    <div class="sub-reset-btn">
								     		<a href="#">
    										    <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">View Report</button></a>


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
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing Report<?php

if (isset($result) && $result != '') {
    ?>
											 <form  method="post" action="{{ url('superadmin/billing-report-pdf') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input id="inputFloatingLabel-select-date" value="<?php if (isset($status) && $status) {echo $status;}?>"  name="status" type="hidden" class="form-control input-border-bottom" required="" >
												<input id="inputFloatingLabel-select-date" value="<?php if (isset($start_date) && $start_date) {echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
							<input id="inputFloatingLabel-select-date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >
								<input id="inputFloatingLabel-select-date" name="amount" value="<?php if (isset($amount) && $amount) {echo $amount;}?>"  type="hidden" class="form-control input-border-bottom" required="" >
										<input id="inputFloatingLabel-select-date" name="or_name" value="<?php if (isset($or_name) && $or_name) {echo $or_name;}?>"  type="hidden" class="form-control input-border-bottom" required="" >
										 <button  data-toggle="tooltip" data-placement="bottom" title="Download Pdf" class="btn btn-default" style="margin-top: -30px;float:right;" type="submit"><i class="fas fa-file-pdf"></i></button>
											</form>
											<?php
}?>@if(isset($result) && $result != '')

<form  method="post" action="{{ url('superadmin/billing-report-export') }}" enctype="multipart/form-data" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="s_start_date" value="{{ $start_date }}">
<input type="hidden" name="s_end_date" value="{{ $end_date }}">
<input type="hidden" name="s_amount" value="{{ $amount }}">
<input type="hidden" name="s_status" value="{{ $status }}">

	 <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="margin-top: -30px;float:right;margin-right:2px;" type="submit"><img  style="width: 22px;" src="{{ asset('img/excel-dnld.png')}}"></button>
		</form>

		@endif</h4>


								</div>
								<div class="card-body">

									<div class="table-responsive">

										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
												    	<th>Sl No</th>
												    	<th>Invoice Number</th>
											            <th>Bill  To</th>
													    <th>Bill Amount</th>
														<th> Payment Received</th>
														<th> Due Amount</th>
														<th>Status</th>
													    <th>Bill Date</th>
														<th>License Applied</th>
													</tr>
											</thead>

											<tbody>
															 <?php

if (isset($result) && $result != '') {
    print_r($result);
}?>

											</tbody>
												<tfoot>
												     <?php

if (isset($result) && $result != '') {
    ?>
													  <td></td>

													  <td></td>


         <td  >Total :</td>

         <td>		 <?php

    if (isset($result) && $result != '') {echo $totam;}?></td>
  <td> <?php

    if (isset($result) && $result != '') {echo $topayre;}?></td>
         <td> <?php

    if (isset($result) && $result != '') {echo $totdue;}?></td>
<?php
}
?>
  <td></td>

													  <td></td>
													  <td></td>
													</tfoot>
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