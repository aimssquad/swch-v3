@extends('employeer.include.app')
@section('title', 'Message Centre')
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
            <h3 class="page-title"> Message Centre</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Message Centre</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @if(Session::has('message'))										
   <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
   @endif
   <div class="row">
      <div class="col-md-12">
         <div class="table-responsive">
            <table class="table table-striped custom-table datatable" id="employeeTable">
               <thead>
                  <tr>
                     <th>Sl.No.</th>
                     <th>Employee Code</th>
                     <th>Employee Name</th>
                     <th>Email</th>
                     <th>Subject</th>
                     <th>Date</th>
                     <th>Message</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $i = 1; ?>
                  @foreach($msg_rs as $company)
                  <?php
                     $pass=DB::Table('employee')
                     
                     ->where('emid','=',$company->emid) 
                     ->where('emp_code','=',$company->employee_id) 
                     
                     ->first(); 
                     
                     ?>
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $pass->emp_code }}</td>
                     <td>{{ $pass->emp_fname }} {{ $pass->emp_mname }} {{ $pass->emp_lname }}</td>
                     <td>{{ $company->email }}</td>
                     <td>{{ $company->subject }}</td>
                     <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>
                     <td>{{ strip_tags($company->msg) }}</td>
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