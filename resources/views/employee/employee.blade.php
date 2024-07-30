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
		
  @include('employee.include.header')
		<!-- Sidebar -->
		
		  @include('employee.include.sidebar')
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
		<div class="main-panel">
		    	<div class="page-header">
						<!--<h4 class="page-title">Employee</h4>-->
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
								<a href="{{ url('employee/dashboard') }}">Employee</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Employee 
										<span><a data-toggle="tooltip" data-placement="bottom" title="Excel Download" href="{{url('employee/excel-report')}}"><img  style="width: 30px; height:25px; border-radius:5px" src="{{ asset('img/ex.png')}}"></a></span>	
										<span><a data-toggle="tooltip" data-placement="bottom" title="Pdf Download" href="{{url('employee/all-employee-pdf-report')}}"><img  style="width: 30px; height:30px; border-radius:5px" src="{{ asset('img/dnld-pdf.png')}}"></a></span>
										<span><a data-toggle="tooltip" data-placement="bottom" title="Add Employee" href="{{ url('addemployee') }}">
	                                <img width="25px;" src="{{ asset('img/plus1.png')}}"/></a></span></h4>
									  @include('layout.message')
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
											
											<th>Employee ID</th>
													<th>Employee Name</th>
													
													
													<th>DOB</th>
													<th>Mobile</th>
														<th>Email</th>
														<th>Department</th>
														<th>Designation</th>
													<th>Nationality</th>
													<th>NI Number</th>
													<th>Visa Expired</th>
													<th>Passport No.</th>
													<th>Address.</th>
													<th>Action</th>
												
												</tr>
											</thead>
											
											<tbody>
												  @foreach($employee_rs as $employee)
                                            <tr>
                                           
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>

<td>    @if( $employee->emp_dob!='1970-01-01' &&  $employee->emp_dob!=''  &&  $employee->emp_dob!='E11') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @elseif($employee->emp_dob=='E11')   {{ date('d/m/Y',strtotime($employee->emp_dob)) }}  @endif</td>

 <td>{{ $employee->emp_ps_phone }}</td>
  <td>{{ $employee->emp_ps_email }}</td>
  <td>{{ $employee->emp_department }}</td>
  <td>{{ $employee->emp_designation }}</td>
 <td>{{ $employee->nationality }}</td>
 <td>{{ $employee->ni_no }}</td>
 <td>    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
 <td>{{ $employee->pass_doc_no }}</td>
  <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
  
  
  <td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{ url('addemployee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="far fa-edit"></i>&nbsp; Edit</a> 
    <a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}"><i class="far fa-file-pdf"></i>&nbsp; Download PDF</a> 
   <a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}"><i class="far fa-file-excel"></i>&nbsp; Download Excel</a>
  </div>
</div>




                
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