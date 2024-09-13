@extends('employeer.include.app')

@section('title', 'Employees According to RTI')

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Employees According to RTI</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"> Employees According to RTI</li>
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
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Employees According to RTI
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
                             <th>Employee Name</th>
                             <th>Department</th>
                             <th>Job Type</th>
                             <th>Job Title</th>
                             <th>Immigration Status</th>
                             <th>Action</th> 
                          </tr>
                       </thead>
                       <tbody>
                            @php
                                $employee_or_rs = DB::table('company_employee')->where('emid','=',$companies_rs->reg)->get();
                                $countwmploor= count($employee_or_rs);
                            @endphp
                            @if ($countwmploor!=0)
                                @foreach($employee_or_rs as $empuprotgans)
                                    @if ($empuprotgans->name!='')								
                                        <tr>
                                            <td>{{$$loop->iteration}}</td>
                                            <td>{{ $empuprotgans->name }}</td>
                                            <td>{{ $empuprotgans->department }}</td>
                                            <td>{{ $empuprotgans->job_type }}</td>
                                            <td>{{ $empuprotgans->designation }}</td>
                                            <td>{{ $empuprotgans->immigration }}</td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a aria-expanded="false" data-bs-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                        <a href="#" class="dropdown-item"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach   
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


