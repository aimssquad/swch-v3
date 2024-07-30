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
		  <?php
function my_simple_crypt($string, $action = 'encrypt')
{
    // you may change these values to your own
    $secret_key = 'bopt_saltlake_kolkata_secret_key';
    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
?>
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
								<a href="{{ url('document/staff-report') }}">Staff Report</a>
							</li>

						</ul>
					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title" style="    margin-bottom: 0;"><i class="fas fa-users"></i> Staff Report </h4>
										<?php

if (count($employee_rs) != 0) {
    ?>
											 <form  method="post" action="{{ url('document/staff-report') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

										 <button data-toggle="tooltip" data-placement="bottom" title="Download Report in PDF" class="btn btn-default" style="background:none !important;margin-top: -30px;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>
											</form>


												 <form  method="post" action="{{ url('document/staff-report-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

										 <button data-toggle="tooltip" data-placement="bottom" title="Download Report in Excel"  class="btn btn-default" style="background:none !important;margin-top: -30px;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
											</form>
											<?php
}?>
									@if(Session::has('message'))
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>

											<th>Staff Code</th>
													<th>Staff Name</th>
													<th>Address</th>

													<th>DOB</th>
													<th>Job Start Date</th>
													<th>Telephone</th>
													<th>Nationality</th>
													<th>NI Number</th>
													<th>Visa Expiry Date</th>
														<th>Visa Review</th>
													<th>Passport No.</th>
													<th>Passport Expiry Date</th>
													<th>EUSS Details</th>
													<th>DBS Details</th>
													<th>National Id Details</th>

												</tr>
											</thead>

											<tbody>
												  @foreach($employee_rs as $employee)
												  	<?php

$employefgf = DB::table('users')->where('emid', '=', $employee->emid)->where('employee_id', '=', $employee->emp_code)->first();
if ($employefgf->status == 'active') {

	$colorme='';
	if(($employee->visa_doc_no != null && ($employee->visa_exp_date != null && $employee->visa_exp_date!='1970-01-01')) || ($employee->euss_ref_no != null && ($employee->euss_exp_date != null && $employee->euss_exp_date!='1970-01-01'))){
		$colorme='blue';
	}
	$pass_no = '';
	if ($employee->pass_exp_date != '1970-01-01') {
		if ($employee->pass_exp_date != 'null') {
			$pass_no = '  EXPIRE:' . date('jS F Y', strtotime($employee->pass_exp_date));
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
		if ($employee->nat_exp_date != 'null') {
			$nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
		}
	}

    ?>
                                            <tr @if($colorme !='') style="color:{{$colorme}}" @endif>

                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>


<td>@if( $employee->emp_dob!='1970-01-01' &&  $employee->emp_dob!=''  &&  $employee->emp_dob!='E11') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @elseif($employee->emp_code=='E11')   {{ date('d/m/Y',strtotime($employee->emp_dob)) }}  @endif</td>
<td>@if( $employee->emp_doj!='1970-01-01' &&  $employee->emp_doj!=''  &&  $employee->emp_doj!='E11') {{ date('d/m/Y',strtotime($employee->emp_doj)) }} @elseif($employee->emp_code=='E11')   {{ date('d/m/Y',strtotime($employee->emp_doj)) }}  @endif</td>
 <td>{{ $employee->emp_ps_phone }}</td>
 <td>{{ $employee->nationality }}</td>
 <td>{{ $employee->ni_no }}</td>
 <td>   @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>

<td style="color:red;">    @if( $employee->visa_review_date!='1970-01-01') @if( $employee->visa_review_date!='') {{ date('d/m/Y',strtotime($employee->visa_review_date)) }} @endif  @endif</td>

 <td>{{ $employee->pass_doc_no }}   </td>
      <td>  @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{ date('d/m/Y',strtotime($employee->pass_exp_date)) }} @endif  @endif   </td>
	  <td>{{ $employee->euss_ref_no . $euss_exp }}</td>
     <td>{{ $employee->dbs_ref_no . $dbs_exp }}</td>
     <td>{{ $employee->nat_id_no . $nid_exp }}</td>


                                            </tr>
                                            <?php
}
?>
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
			 @include('document.include.footer')
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
	<script>
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