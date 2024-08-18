
@extends('employeer.include.app')

@section('title', 'File Manager')
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
				<h3 class="page-title">File Manager</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">File Manager List</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 48)
				<a href="{{ url('fileManagment/fileManagment-add') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add File Division</a>
                <span><a data-toggle="tooltip" data-placement="bottom" title="Excel Download" href="{{url('fileManagment/report-excel')}}"><img  style="width: 30px; height:25px; border-radius:5px" src="{{ asset('img/ex.png')}}"></a></span>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('fileManagment/fileManagment-add') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add File Division</a>
                <span style="margin-right:10px; margin-top:5px;"><a data-toggle="tooltip" data-placement="bottom" title="Excel Download" href="{{url('fileManagment/report-excel')}}"><img  style="width: 35px; height:37px; border-radius:5px" src="{{ asset('img/ex.png')}}"></a></span>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
		</div>
	</div>
    @if(Session::has('message'))										
    <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
    @endif
	<!-- /Page Header -->
	<div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header">
                    <h4 class="card-title"><i class="far fa-clock" aria-hidden="true"
                            style="color:#10277f;"></i>&nbsp;File Division<span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>File Name</th>
                                    <th>Organization Id</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i=1; ?>
                                @foreach($file_details as $item)

                              <tr>
                                <td><?php echo $i; ?></td>
                                <td>{{$item->file_name}}</td>
                                <td>{{$item->organization_id}}</td>
                                <td>{{$item->status}}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                        @if($item->status!=="pending")
                                                        <a class="dropdown-item" href="{{url("fileManagment/edit-fileManager/$item->id")}}">
                                                            <i class="fa fa-file m-r-5"></i> Create Folder</a>
                                                        </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                @if($item->status ==="pending")        
                                                <a class="dropdown-item" href="{{url("fileManagment/edit-fileManager/$item->id")}}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>
                                                @endif
                                            @endif
            
                                            @if($user_type == 'employer')
                                                @if($item->status !=="pending") 
                                                <a class="dropdown-item" href="{{url("fileManagment/folder-create/$item->id")}}"><i class="fa fa-file m-r-5"></i> Create Folder</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                <?php  $i++ ?>
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

    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
    </script>

@endsection
