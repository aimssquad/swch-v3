@extends('employeer.include.app')

@section('title', 'Level 1 User')

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Level 1 User</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"> Level 1 User </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
           <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Level 1 User 
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
                            <th>Sl No.</th>
                            <th> Name</th>
                            <th>Designation </th>
                            <th>Phone No</th>
                            <th>Email Id</th>
                            <th>Do you have a history of Criminal conviction/Bankruptcy?</th>
                            <th>Proof Of Id</th>
                          </tr>
                       </thead>
                       <tbody> 
                            @if ($Roledata->level_f_name!='')								
                                <tr>
                                    <td>1</td>
                                    <td>{{ $Roledata->level_f_name }} {{ $Roledata->level_f_lname }}</td>
                                    <td>{{ $Roledata->level_designation }}</td>
                                    <td>{{ $Roledata->level_phone }}</td>
                                    <td>{{ $Roledata->level_email }}</td>
                                    <td>{{ $Roledata->level_bank_status }} 	@if ($Roledata->level_bank_status=='Yes')	 ( {{ $Roledata->level_bank_other }} ) 	@endif	</td>
                                    <td>
                                        @if (!empty($Roledata->level_proof))
                                            <a href="{{ asset('storage/' . $Roledata->level_proof) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $Roledata->level_proof) }}" height="50px" width="50px"/>
                                            </a>
                                        @else
                                            No Proof Available
                                        @endif
                                    </td>
                                </tr>
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
<!--script Content-->
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
<!--/script Content-->
@endsection





