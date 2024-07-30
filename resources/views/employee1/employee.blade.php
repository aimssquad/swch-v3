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
	<!-- Include the xlsx library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

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
									<h4 class="card-title"><i class="far fa-user"></i> Employee <span><a data-toggle="tooltip" data-placement="bottom" title="Add Employee" href="{{ url('addemployee') }}">
	<img width="25px;" src="{{ asset('img/plus1.png')}}"/></a></span></h4>
									@if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	
								</div>
								<div class="card-body">
									<a href="{{ route('download.employees.excel') }}" class="btn btn-primary">Download Employees Excel</a>
									<a href="{{ route('download.sample.employee.excel') }}" class="btn btn-primary">Download Sample Employee Excel</a>
									<button id="download-button" class="btn btn-primary">Download Filtered Data</button>
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
											
											<th>Employee ID</th>
											<th>Employee Code</th>
											<th>Employee Name</th>
											<th>Father Name</th>
											<th>Department</th>
											<th>Designation</th>
											<th>DOB</th>
											<th>DOJ</th>
											<th>Religion</th>
											<th>Caste</th>
											<th>Address</th>
											<th>City</th>
											<th>State</th>
											<th>Country</th>
											<th>Pincode</th>
											<th>Mobile</th>
											<th>Class</th>
											<th>PF No.</th>
											<th>UAN No.</th>
											<th>PAN No.</th>
											<th>Bank</th>
											<th>IFSC Code</th>
											<th>Account No.</th>
											<th>Employee Status</th>
											<th>Status</th>
											<th>Actions</th>
												</tr>
											</thead>
											
											<tbody>
												  @foreach($employee_rs as $employee)
                                            <tr>
                                           
                                            <td>{{ $employee->employee_id}}</td>
                                            <td>{{ $employee->employee_code}}</td>
                                            <td>{{ $employee->employee_name}}</td>
                                            <td>{{ $employee->father_name}}</td>
                                            <td>{{ $employee->department}}</td>
                                            <td>{{ $employee->designation}}</td>
                                            <td>{{ $employee->dob}}</td>
                                            <td>{{ $employee->doj}}</td>
                                            <td>{{ $employee->religion}}</td>
                                            <td>{{ $employee->caste}}</td>
                                            <td>{{ $employee->address}}</td>
                                            <td>{{ $employee->city}}</td>
                                            <td>{{ $employee->state}}</td>
                                            <td>{{ $employee->country}}</td>
                                            <td>{{ $employee->pincode}}</td>
                                            <td>{{ $employee->mobile_no}}</td>
                                            <td>{{ $employee->class}}</td>
                                            <td>{{ $employee->pf_no}}</td>
                                            <td>{{ $employee->uan_no}}</td>
                                            <td>{{ $employee->pan_no}}</td>
                                            <td>{{ $employee->bank}}</td>
                                            <td>{{ $employee->ifsc_code}}</td>
                                            <td>{{ $employee->account_no}}</td>
											<td>{{ $employee->emp_status}}</td>
                                            <td>{{ $employee->status}}</td>
											<td>
												<a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
    <a href="{{ route('employees.destroy', $employee->id) }}">Delete</a>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
	<script>
    $(document).ready(function() {
        const dataTable = $('#basic-datatables').DataTable({}); // Change to your actual table ID

        $('#employee-search').on('keyup', function() {
            dataTable.search(this.value).draw();
        });

        $('#download-button').on('click', function() {
            const filteredData = dataTable.rows({ search: 'applied' }).data().toArray();
            const headers = dataTable.columns().header().toArray().map(th => th.innerText);
            const data = [headers, ...filteredData];

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Filtered Data');
            const filename = 'filtered_data.xlsx';
            
            XLSX.writeFile(wb, filename);
        });
    });
</script>


</body>
</html>