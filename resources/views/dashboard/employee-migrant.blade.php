<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

  @include('dashboard.include.header')
		<!-- Sidebar -->


		  <?php
   function my_simple_crypt( $string, $action = 'encrypt' ) {
    // you may change these values to your own
    $secret_key = 'bopt_saltlake_kolkata_secret_key';
    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'encrypt' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}
?>
		<!-- End Sidebar -->
		<div class="main-panel" style="width:100%">
		<div class="page-header">
						<!-- <h4 class="page-title">Migrant Employee</h4> -->
						<ul class="breadcrumbs">
						<li class="nav-home">
								<a href="{{url('dashboarddetails')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<!-- <li class="nav-home">
								<a href="{{url('dashboarddetails')}}">Sponsor Complaience</a>
							</li>
							<li class="separator">
								/
							</li> -->
							<li class="nav-item active">
								<a href="{{url('dashboard-migrant-employees')}}">Migrant Employee</a>
							</li>

						</ul>
					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"> <i class="far fa-user-circle" aria-hidden="true" style="color:#10277f;"></i> &nbsp; Migrant Employee </h4>
									@include('layout.message')
								</div>
								<div class="card-body">
                                    <div class="card-header">
                                        <h4 class="card-title"> &nbsp; Visa Notification </h4>

                                    </div>
                                    <br>
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
                                                <tr>
											        <th>Employee ID</th>
													<th>Employee Name</th>
													<th>DOB</th>
													<th>Mobile</th>
													<th>Nationality</th>
													<th>NI Number</th>
													<th>Visa Expired</th>
                                                    <th>Visa Reminder - 90 days </th>
                                                    <th>View </th>
                                                    <th>Send </th>
                                                    <th>Visa Reminder - 60 days </th>
                                                    <th>View </th>
                                                    <th>Send</th>
                                                    <th>Visa Reminder - 30 days </th>
                                                    <th>View </th>
                                                    <th>Send </th>
													<th>Passport No.</th>
													<th>Address.</th>
													<th>Email Send</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>
												  @foreach($employee_rs as $employee)

                                            <tr>

                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
											<td>    @if( $employee->emp_dob!='1970-01-01') @if( $employee->emp_dob!='') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @endif  @endif</td>
											<td>{{ $employee->emp_ps_phone }}</td>
											<td>{{ $employee->nationality }}</td>
											<td>{{ $employee->ni_no }}</td>
											<td>    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
											<td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 90  days'))}} @endif  @endif</td>
											<td class="icon"> @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')<a href="{{url('dashboard/migrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="view" target="_blank"><img  style="width: 18px;" src="{{ asset('assets/img/view.png')}}"></a>@endif  @endif</td>
											<td class="icon"> @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')<a href="{{url('dashboard/migrant-firstletter-sendnew/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="Send" ><img  style="width: 14px;" src="{{ asset('assets/img/send.png')}}"></a> @endif  @endif</td>

											<td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 60  days'))}}  @endif  @endif</td>
											<td class="icon">@if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')<a href="{{url('dashboard/migrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="View" target="_blank"><img  style="width: 14px;" src="{{ asset('assets/img/view.png')}}"></a>  @endif  @endif</td>

  											<td class="icon">@if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')<a href="{{url('dashboard/migrant-secondletter-sendnew/'.base64_encode($employee->emp_code))}}" ><img  style="width: 14px;" src="{{ asset('assets/img/send.png')}}"></a>  @endif  @endif</td>

  											<td style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 30  days'))}} @endif  @endif </td>
  											<td class="icon">@if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') <a href="{{url('dashboard/migrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="View" target="_blank"><img  style="width: 14px;" src="{{ asset('assets/img/view.png')}}"></a>   @endif  @endif</td>



    										<td class="icon">@if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')<a href="{{url('dashboard/migrant-thirdletter-sendnew/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="Send" ><img  style="width: 14px;" src="{{ asset('assets/img/send.png')}}"></i></a>  @endif  @endif</td>

											<!-- sss -->

 											<td>{{ $employee->pass_doc_no }}</td>
  											<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  											@if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                                           <td class="icon">

                                            <a href="{{url('dashboard/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" data-toggle="tooltip" data-placement="bottom" title="Send" ><img  style="width: 14px;" src="{{ asset('assets/img/send.png')}}"></a>
                                            </td>
                                            <td class="icon">

                    							<a href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" data-toggle="tooltip" data-placement="bottom" title="Download" ><img  style="width: 14px;" src="{{ asset('assets/img/download.png')}}"></i></a>


                                            </td>

                                            </tr>

                                     @endforeach

											</tbody>
										</table>
									</div>

                                    <div class="card-header">
                                        <h4 class="card-title"> &nbsp; EUSS Notification </h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="basic-datatables2" class="display table table-striped table-hover">
                                           <thead style="background: linear-gradient(-45deg, #30feff, #17276d) !important;color: #fff;">
                                              <tr>
                                                 <th>Employee Code</th>
                                                 <th>Employee Name</th>
                                                 <th>Address</th>
                                                 <th>Reference Number No.</th>
                                                 <th>Issue Date</th>
                                                 <th>Expiry Date</th>
                                                 <th>Reminder - 90 days </th>
                                                 <th>View </th>
                                                 <th>Send </th>
                                                 <th>Reminder - 60 days </th>
                                                 <th>View </th>
                                                 <th>Send </th>
                                                 <th>Reminder - 30 days </th>
                                                 <th>View</th>
                                                 <th>Send </th>
                                                 <th>Passport No.</th>
												 <th>Address.</th>
                                                 <th>Email Send</th>
                                                 <th>Action</th>
                                              </tr>
                                           </thead>
                                           <tbody>
                                              @foreach($employee_rs as $employee)
                                              @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='')
                                              <tr>
                                                 <td>{{ $employee->emp_code}}</td>
                                                 <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                                 </td>
                                                 <td>{{ $employee->euss_ref_no }}</td>
                                                 <td>    @if( $employee->euss_issue_date!='1970-01-01') @if( $employee->euss_issue_date!='') {{ date('d/m/Y',strtotime($employee->euss_issue_date)) }} @endif  @endif</td>
                                                 <td>    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{ date('d/m/Y',strtotime($employee->euss_exp_date)) }} @endif  @endif</td>
                                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 90  days'))}}
                                                    &nbsp &nbsp
                                                 <td><a href="{{url('dashboard/eussmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                                 &nbsp
                                                 <td><a href="{{url('dashboard/eussmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                                    @endif  @endif
                                                 </td>
                                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 60  days'))}}
                                                    &nbsp &nbsp
                                                 <td> <a href="{{url('dashboard/eussmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
                                                 &nbsp
                                                 <td><a href="{{url('dashboard/eussmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 30  days'))}}
                                                    &nbsp &nbsp
                                                 <td><a href="{{url('dashboard/eussmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                                 &nbsp
                                                 <td><a href="{{url('dashboard/eussmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                                 <td>{{ $employee->pass_doc_no }}</td>
  											<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  											@if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                                                 <td>
                                                    <a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                                 </td>
                                                 <td class="icon">
                                                    <a href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" data-toggle="tooltip" data-placement="bottom" title="Download" ><img  style="width: 14px;" src="{{ asset('assets/img/download.png')}}"></i></a>
                                                </td>
                                              </tr>
                                              @endif
                                              @endif
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

            $('#basic-datatables2').DataTable({
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
