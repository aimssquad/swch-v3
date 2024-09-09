@extends('employeer.include.app')
@section('title', 'Visitor Register')
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
            <h3 class="page-title">Visitor Register</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Visitor Register</li>
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
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-book" aria-hidden="true"
                  style="color:#ff9e2f;"></i>&nbsp;Visitor Register<span>
               </h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="display table table-striped table-hover">
                     <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Email ID</th>
                            <th>Contact No</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Reference</th>
                            <th>Action</th>
                        
                                </tr>
                     </thead>
                     <tbody>
                        <?php $i = 1; ?>
									@foreach($employee_type_rs as $candidate)
                                        <tr>
                                            
                                            <td>{{ $i}}</td>
											<td>{{ $candidate->name }}</td>
                                            <td>{{ $candidate->desig }}</td>
											 <td>{{ $candidate->email }}</td>
											  <td>{{ $candidate->phone_number }}</td>
											  <td>{{ $candidate->address }}</td>
											  <td>{{ $candidate->purpose }}</td>
											   <td>{{ date('d/m/Y',strtotime($candidate->date)) }}</td>
											    <td>{{ date('h:i a',strtotime($candidate->time)) }}</td>
											    <td>{{ $candidate->reff }}</td>
											   
											<td>
											    <a href="{{url('rota-org/visitor-regis-edit/'.$candidate->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  ><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a>
											    <a href="{{url('rota-org/visitor-regis-deleted/'.$candidate->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  ><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>

						
											</td>
                                        </tr>
                                        <?php
                                         $i++;?>
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
    </script>
@endsection