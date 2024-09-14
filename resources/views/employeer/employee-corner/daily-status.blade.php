
@extends('employeer.employee-corner.main')

@section('title', 'Attendance Status')
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
				<h3 class="page-title" style="color:#ff902f"> Attendance Status</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}" style="color:#ff902f">Dashboard</a></li>
					<li class="breadcrumb-item active" style="color:#ff902f"> Attendance Status</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type !== 'employer')
				<a href="{{url('org-employee-corner/add-work-update')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Daily Work Update </a>
				@endif
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                     <form  method="post" action="{{ url('org-employee-corner/attendance-status') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                        <div class="row form-group">
                        <div class="col-md-12">
                                    <h4 class="card-title"><i class="fa fa-braille" style="color:#ff902f">&nbsp &nbsp</i>Attendance Status</h4>
                            </div>
                              
                        

                          <div class="col-md-4">
                                <div class=" form-group form-floating-label">
                                <label for="inputFloatingLabel-select-date"  class="col-form-label">Form Date</label><br/>
                                <input id="inputFloatingLabel-select-date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
                                

                                </div>		
                             </div>

                          <div class="col-md-4">
                                <div class=" form-group form-floating-label">
                                <label for="inputFloatingLabel-select-date"  class="col-form-label">To Date</label><br/>
                                <input id="inputFloatingLabel-select-date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
                                

                                </div>		
                             </div>
                             <div class="col-md-3">
                             <a href="#">	
                            <button class="btn btn-primary" type="submit" style="margin-top:40px;">View</button></a>
                           </div>
                         
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('message'))										
        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
    @endif
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
                                    <th>Sl No.</th>
                                    <th>Date</th>
                                    <th>Clock In</th>
                                    <th>Clock In Location</th>
                                    <th>Clock Out</th>
                                    <th>Clock Out Location</th>	
                                    <th>Duty Hours</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @if(isset($result) && $result!='')
                                    @php
                                        print_r($result);
                                    @endphp
                                @endif
        
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

    function employeetype(val){
		var empid=val;
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("employee_code").innerHTML = response;
		}
		});
	}

</script>

@endsection
