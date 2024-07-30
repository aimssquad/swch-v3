<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
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
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">


  @include('employee.include.header')
		<!-- Sidebar -->

		  @include('employee.include.sidebar')
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
							<li class="nav-item">
								<a href="#">Add</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="{{url('employee/change-of-circumstances-add')}}">Change Of Circumstances</a>
							</li>

						</ul>
					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Change Of Circumstances <span><a data-toggle="tooltip" data-placement="bottom" title="Change Of Circumstances" href="{{ url('employee/change-of-circumstances-add-new') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
									@if(Session::has('message'))
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
											    		<th>Updated Date</th>
											<th>Employment Type</th>
											<th>Employee ID</th>
													<th>Name Of Member Of The Staff</th>


													<th>Job  Title</th>
														<th>Address</th>


													<th>Contact Number</th>
													<th>Nationality</th>

													<th>BRP  Number</th>

													<th>Visa Expired</th>
														<th>Remarks/Restriction to work</th>
													<th>Passport No</th>
													<th>EUSS Details</th>
													<th>DBS Details</th>
													<th>National Id Details</th>
														<th>Other Documents</th>
														<th>Are Sponsored migrants aware that they must <br>inform [HR/line manager] promptly of changes<br> in contact Details? </th>
															<th>Are Sponsored migrants  aware that they need to<br> cooperate Home Office interview by presenting original<br> passports during the Interview (In applicable cases)?</th>


												<th>Action</th>
												</tr>
											</thead>

											<tbody>

												  @foreach($employee_rs as $employee)
												  <?php
$employeet = DB::table('employee')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $employee->emid)->first();

$employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $employee->emid)
    ->where('cir_id', '=', $employee->id)->orderBy('id', 'DESC')->get();

$dataeotherdoc = '';

if (count($employeetemployeeother) != 0) {

    foreach ($employeetemployeeother as $valother) {
        if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
            $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
        } else {
            $other_exp_date = '';
        }} else {
            $other_exp_date = '';
        }
        $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
    }

}
	$euss_exp = '';
	if ($employee->euss_exp_date != '1970-01-01') {
		if ($employee->euss_exp_date != 'null' && $employee->euss_exp_date != NULL) {
			$euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->euss_exp_date));
		}
	}
	$dbs_exp = '';
	if ($employee->dbs_exp_date != '1970-01-01') {
		if ($employee->dbs_exp_date != 'null' && $employee->dbs_exp_date != NULL) {
			$dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->dbs_exp_date));
		}
	}
	$nid_exp = '';
	if ($employee->nat_exp_date != '1970-01-01') {
		if ($employee->nat_exp_date != 'null' && $employee->nat_exp_date != NULL) {
			$nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
		}
	}
?>
                                            <tr>
                                                <td>{{ date('d/m/Y',strtotime($employee->date_change)) }}</td>
                                           <td>{{ $employeet->emp_status}}</td>
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employeet->emp_fname." ".$employeet->emp_mname." ".$employeet->emp_lname }}</td>


 <td>{{ $employee->emp_designation}}</td>
  <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>




               <td>{{ $employee->emp_ps_phone }}</td>
                <td>{{ $employee->nationality }}</td>
                <td>{{ $employee->visa_doc_no }}</td>


 <td> @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
  <td>{{ $employee->res_remark }}</td>
 <td>{{ $employee->pass_doc_no }}

( @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{ date('d/m/Y',strtotime($employee->pass_exp_date)) }} @endif  @endif)

  </td>
  <td>{{ $employee->euss_ref_no . $euss_exp }}</td>
     <td>{{ $employee->dbs_ref_no . $dbs_exp }}</td>
     <td>{{ $employee->nat_id_no . $nid_exp }}</td>
  <td>{{$dataeotherdoc}}</td>
  <td>{{ $employee->hr }}</td>

  <td>{{ $employee->home }}</td>


 <td>
                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{url('employee/edit-change-cir/'.base64_encode($employee->id))}}"><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}">
                                            </td>
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
			  @include('employee.include.footer')
		</div>

	</div>
	<!--   Core JS Files   -->
<script src="{{ asset('assetsemcor/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
				/* Disable initial sort */
				"aaSorting": []
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