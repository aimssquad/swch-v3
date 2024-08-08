
@extends('employeer.include.app')

@section('title', 'Leave Type List')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
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
				<h3 class="page-title">Leave Type List</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Leave Type List</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 43)
				<a href="{{url('leave/new-leave-type')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Leave Type</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{url('leave/new-leave-type')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Leave Type</a>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
            @if(Session::has('message'))										
            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
            @endif
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped custom-table " id="employeeTable">
					<thead>
						<tr>
							<th class="no-sort">Sl. No.</th>
							<th class="no-sort">Leave Type</th>
							<th class="no-sort">Leave Type Short Code</th>
							<th class="text-nowrap no-sort">Remarks</th>
							<th class="text-end no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
                            @foreach($leave_type_rs as $l)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$l->leave_type_name}}</td>
                                <td>{{$l->alies}}</td>
                                <td>{{$l->remarks}}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                        <a class="dropdown-item" href="{{url('leave/leave-type-listing/'.$l->id)}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{url('leave/leave-type-listing/'.$l->id)}}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>
                                            @endif
                    
                                            {{-- @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
													<a class="dropdown-item" href="#" onclick="confirmDelete('{{ url('organization/delete-holiday-list/' . $holiday->id) }}')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
											<a class="dropdown-item" href="#" onclick="confirmDelete('{{ url('organization/delete-holiday-list/' . $holiday->id) }}')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            @endif --}}
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
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
