@extends('employeer.include.app')

@section('title', 'Employee List')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
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
@section('content')
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
                <a href="{{url('organization/view-add-employee')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Employee</a>
                <div class="view-icons">
                    <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                    <a href="{{url('organization/emplist')}}" class="list-view btn btn-link"><i class="fa-solid fa-bars"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus select-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <input type="text" id="searchEmployeeName" class="form-control floating" onkeyup="searchEmployee()">
                <label class="focus-label">Employee Name</label>
            </div>
        </div>
    </div>
    <!-- /Search Filter -->

    <div class="row staff-grid-row" id="employeeGrid">
        @foreach($employee_rs as $employee)
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3 employee-card" data-emp-name="{{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}">
            <div class="profile-widget">
                <div class="profile-img">
                    <a href="profile.html" class="avatar"><img src="{{asset('assets/img/chadengle.jpg')}}" alt="User Image"></a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if($user_type == 'employee')
                            @foreach($sidebarItems as $value)
                                @if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
                                <a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                @endif
                            @endforeach
                        @elseif($user_type == 'employer')
                        <a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                        @endif
                        
                        @if($user_type == 'employee')
                            @foreach($sidebarItems as $value)
                                @if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                @endif
                            @endforeach
                        @elseif($user_type == 'employer')
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                        @endif
                    </div>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile.html">{{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}</a></h4>
                <div class="small text-muted">Web Designer</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- /Page Content -->

@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    function searchEmployee() {
        var inputName = document.getElementById('searchEmployeeName').value.toLowerCase();
        var employees = document.getElementsByClassName('employee-card');
        var searchTerms = inputName.split(" ");

        for (var i = 0; i < employees.length; i++) {
            var empName = employees[i].getAttribute('data-emp-name').toLowerCase();
            var match = true;

            for (var j = 0; j < searchTerms.length; j++) {
                if (!empName.includes(searchTerms[j])) {
                    match = false;
                    break;
                }
            }

            if (match) {
                employees[i].style.display = "";
            } else {
                employees[i].style.display = "none";
            }
        }
    }

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

    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>
@endsection
