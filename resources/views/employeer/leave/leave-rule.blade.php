
@extends('employeer.include.app')

@section('title', 'Leave Rule')
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
				<h3 class="page-title">Leave Rule</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Leave Rule</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 44)
				<a href="{{ url('leave/save-leave-rule') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Leave Rule</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('leave/save-leave-rule') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Leave Rule</a>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
                    </h4>
                    <div>
                        <!-- Excel Link -->
                        <a href="path_to_excel_export" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                        
                        <!-- PDF Link -->
                        <a href="path_to_pdf_export" class="btn btn-info btn-sm">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </a>
                    </div>
                 </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" id="employeeTable">
                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Employee Type</th>
                                    <th>Leave Type</th>
                                    <th>Max. No.</th>
                                    <th>Effective From</th>
                                    <th>Effective To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leave_rule_rs as $leaveRule)
                                    <?php
                                    //dd($leaveRule);
                                        $leaveemdata = DB::table('employ_type_master')      
                                            ->where('employ_type_id','=', $leaveRule->employee_type)
                                            ->first();  
                                    ?>
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$leaveRule->employ_type_name}}</td>
                                        <td>{{$leaveRule->leave_type_name}}</td>
                                        <td>{{$leaveRule->max_no}}</td>
                                        
                                        <td>{{$leaveRule->effective_from}}</td>
                                        <td>{{$leaveRule->effective_to}}</td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($user_type == 'employee')
                                                        @foreach($sidebarItems as $value)
                                                            @if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 44)
                                                                <a class="dropdown-item" href="{{url('leave/view-leave-rule/'.$leaveRule->id)}}">
                                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @elseif($user_type == 'employer')
                                                        <a class="dropdown-item" href="{{url('leave/view-leave-rule/'.$leaveRule->id)}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                    @endif
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
<!-- /Page Content -->


@endsection

@section('script')
	<!-- Include jQuery and DataTables JS library -->
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
           
           $('#allval').click(function(event) {  
           
               if(this.checked) {
                   //alert("test");
                   // Iterate each checkbox
                   $(':checkbox').each(function() {
                       this.checked = true;                        
                   });
               } else {
                   $(':checkbox').each(function() {
                       this.checked = false;                       
                   });
               }
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
