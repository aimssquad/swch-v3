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
      <h4 class="card-title"><i class="far fa-hourglass" aria-hidden="true" style="color:#10277f;"></i> &nbsp;Leave Balance </h4>
      <?php
         if(count($leave_balance_rs)!=0  ){
                             ?>
      <form  method="post" action="{{ url('leave-management/leave-balance') }}" enctype="multipart/form-data" >
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <button data-toggle="tooltip" data-placement="bottom" title="Download Report" class="btn btn-primaary" style="margin-top: -30px;float:right; margin-bottom:10px;background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"> &nbsp;</button>	
      </form>
      <form  method="post" action="{{ url('leave-management/leave-balance-excel') }}" enctype="multipart/form-data" >
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-primary" style="margin-top: -30px;float:right;margin-bottom:10px;background:none !important;" type="submit"><img  style="width:35px;" src="{{ asset('img/excel-dnld.png')}}"> &nbsp;</button>	
      </form>
      <?php
         }?>
      @if(Session::has('message'))										
      <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
      @endif
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="table-responsive">
            <table class="table table-striped custom-table " id="employeeTable">
               <thead>
                  <tr>
                     <th class="no-sort">Sl.No.</th>
                     <th class="no-sort">Employee Code</th>
                     <th class="no-sort">Employee Name</th>
                     <th class="no-sort">Leave Type</th>
                     <th class="no-sort">Leave Balance</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($leave_balance_rs as $leave_balance)
                  <tr>
                     <td>{{$loop->iteration}}</td>
                     <td>{{ $leave_balance->emp_code }}</td>
                     <td>{{ $leave_balance->emp_fname.' '.$leave_balance->emp_mname.' '.$leave_balance->emp_lname }}</td>
                     <td>{{ $leave_balance->leave_type_name }}</td>
                     <td>{{ $leave_balance->leave_in_hand }}</td>
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