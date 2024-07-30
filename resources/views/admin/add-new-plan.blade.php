<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
		<link rel="icon" href="{{ asset('img/favicon.png')}}">
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
	 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

	 <style>
input[type=checkbox], input[type=radio] {
    /* padding-right: 10px; */
    margin-right: 8px;
}
.vat{margin-top:17px;}
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
						<!-- <h4 class="page-title">Package</h4> -->
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-archive"></i> Add Subscription Plan</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{ url('superadmin/add-plan') }}" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" name="id"  class="form-control" value="<?php if (!empty($employee_type->id)) {echo $employee_type->id;}?>">
										<div class="row">
		 	                                <div class="col-md-3">
										        <div class="form-group ">
										            <label for="plan_name" class="placeholder">Plan Name</label>
										      	        <input type="text" id="plan_name" name="plan_name"  class="form-control "   value="<?php if (!empty($employee_type->id)) {echo $employee_type->plan_name;}?>" required>
											    </div>
										    </div>
										    <div class="col-md-3">
										        <div class="form-group ">
										            <label for="validity" class="placeholder">Validity <small>(in Days)</small></label>
										      	    <input type="number" id="validity" name="validity"  class="form-control "   value="<?php if (!empty($employee_type->id)) {echo $employee_type->validity;}?>" required>
											    </div>
										    </div>
										    <div class="col-md-3">
										        <div class="form-group ">
										            <label for="price" class="placeholder">Plan Price</label>
										      	    <input type="number" id="price" name="price"  class="form-control " step=".01"  value="<?php if (!empty($employee_type->id)) {echo $employee_type->price;}?>">
											    </div>
										    </div>
   	                                        <div class="col-md-3">
										        <div class="form-group ">
										  	        <label for="status" class="placeholder">Status</label>
										            <select id="status"  class="form-control "   name="status" required >
                                                        <option value="">Select Status</option>
								                        <option value="active" <?php if (!empty($employee_type->id)) {if (!empty($employee_type->status)) {if ($employee_type->status == "active") {?> selected="selected" <?php }}}?>  >Active</option>
							                            <option value="inactive" <?php if (!empty($employee_type->id)) {if (!empty($employee_type->status)) {if ($employee_type->status == "inactive") {?> selected="selected" <?php }}}?>>Inactive</option>
						                            </select>
											    </div>
										    </div>
                                            <div class="col-md-12 btn-up">
                                                <button type="submit" class="btn btn-default">Submit</button></div>
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
	</script>
	  <script>CKEDITOR.replace( 'editor' );</script>
	  	  <script>CKEDITOR.replace( 'editor2' );</script>
	  	  	  <script>CKEDITOR.replace( 'editor3' );</script>
</body>
</html>