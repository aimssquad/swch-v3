@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('content')
@php
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
@endphp

<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Employee</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active">Employee</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				<a href="{{url('organization/view-add-employee')}}" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Employee</a>
				<div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
	
	<!-- Search Filter -->
	{{-- <div class="row filter-row">
		<div class="col-sm-6 col-md-3"></div>
		<div class="col-sm-6 col-md-3"></div>
		<div class="col-sm-6 col-md-3">
			<div class="input-block mb-3 form-focus select-focus">
				<input type="text" id="search" class="form-control floating">
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<a href="#" class="btn btn-success w-100">Search</a>
		</div>     
	</div> --}}
	<!-- /Search Filter -->
	
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped custom-table datatable" id="employeeTable">
					<thead>
						<tr>
							<th>Employee ID</th>
							<th>Employee Name</th>
							<th>DOB</th>
							<th>Mobile</th>
							<th class="text-nowrap">Email</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Address</th>
							<th class="text-end no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($employee_rs as $employee)
						<tr>
							<td>{{ $employee->emp_code}}</td>
							<td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
							<td>@if( $employee->emp_dob!='1970-01-01' &&  $employee->emp_dob!=''  &&  $employee->emp_dob!='E11') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @elseif($employee->emp_dob=='E11')   {{ date('d/m/Y',strtotime($employee->emp_dob)) }}  @endif</td>
							<td>{{ $employee->emp_ps_phone }}</td>
							<td>{{ $employee->emp_ps_email }}</td>
							<td>{{ $employee->emp_department }}</td>
							<td>{{ $employee->emp_designation }}</td>
							<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
							<td class="text-end">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
										<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
<!-- /Page Content -->


@endsection

@section('script')
	<!-- Include jQuery and DataTables JS library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            dom: '<"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
            language: {
                lengthMenu: "Show _MENU_ entries",
                search: "Search:"
            }
        });
    });
</script>

@endsection
