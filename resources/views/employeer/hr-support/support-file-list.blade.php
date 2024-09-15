
@extends('employeer.include.app')

@section('title', 'Hr Support File')
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
				<h3 class="page-title">Hr Support File List</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('hr-support/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Hr Support File List</li>
				</ul>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><i class="far fa-clock" aria-hidden="true"
                            style="color:#10277f;"></i>&nbsp;Hr Support File List<span>
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
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                     </tr>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($data as $datas)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datas->type->type }}</td>
                                    <td>{{ $datas->title}}</td>
                                    <td>
                                        <a href="{{ isset($datas->id) ? route('support-file.details', ['id' => $datas->id]) : '#' }}"><button class="btn btn-primary btn-sm">View</button></a>
                                        <a data-toggle="tooltip" data-placement="bottom" title="View Description" class="view-support-file-view ml-3" data-id="{{ $datas->id }}">
                                            <button class="btn btn-primary btn-sm">View Description</button>
                                        </a>
                                        {{-- <a href=""><button class="btn btn-info btn-sm">Download Pdf</button></a>
                                        <a href=""><button class="btn btn-info btn-sm">Download Doc</button></a> --}}
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
