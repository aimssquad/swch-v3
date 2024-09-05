@extends('employeer.include.app')
@section('title', 'File Approver Corner')
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
            <h3 class="page-title">Leave Application Details</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Leave Application Details</li>
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
               <h4 class="card-title"><i class="far fa-clock" aria-hidden="true"
                  style="color:#10277f;"></i>&nbsp;File Division<span>
               </h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="display table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Sl No.</th>
                           <th>Employee Code</th>
                           <th>Name</th>
                           <th>Leave Type</th>
                           <th>From Date</th>
                           <th>To Date</th>
                           <th>Date Of Application</th>
                           <th>No. Of Leave</th>
                           <th>Status</th>
                           <th>Remarks(If any)</th>
                           @if(Session::get('user_type')=='employee')
                           <th>Action</th>
                           @endif   
                        </tr>
                     </thead>
                     <tbody>
                        @if(count($LeaveApply)>0)
                        @foreach($LeaveApply as $lvapply)
                        <?php  $leaveapplyDate = date("d-m-Y", strtotime($lvapply->date_of_apply));
                           $leaveapplyfromDate = date("d-m-Y", strtotime($lvapply->from_date));
                           
                           $leaveapplytoDate = date("d-m-Y", strtotime($lvapply->to_date));
                           $pemail = Session::get('emp_email');
                           $Roledata = DB::table('registration')      
                           
                           ->where('email','=',$pemail) 
                           ->first();
                           $job_details=DB::table('employee')->where('emp_code', '=', $lvapply->employee_id )->where('emid', '=', $Roledata->reg )->orderBy('id', 'DESC')->first();
                           
                           //dd($job_details);
                           
                           
                           
                           ?>
                        <tr>
                           <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                           <td style="text-align:center;">{{$lvapply->employee_id}}</td>
                           <td style="text-align:center;"><span class="name">{{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}}</span></td>
                           <td style="text-align:center;"><span class="product">{{$lvapply->leave_type_name}}</span></td>
                           <td style="text-align:center;"><span class="product">{{$leaveapplyfromDate}}</span></td>
                           <td style="text-align:center;"><span class="product">{{$leaveapplytoDate}}</span></td>
                           <td style="text-align:center;"><span class="date">{{$leaveapplyDate}}</span></td>
                           <td style="text-align:center;"><span class="name">{{$lvapply->no_of_leave}}</span></td>
                           <td style="text-align:center;">
                              @if($lvapply->status=='NOT APPROVED')
                              <!-- <a href="#"><button class="btn btn-default not-approved" type="submit"> {{$lvapply->status}}</button></a> -->
                              <a href="#"><button class="badge badge-warning" type="submit">{{$lvapply->status}}</button></a>
                              @elseif($lvapply->status=='REJECTED')
                              <!-- <a href="#"><button class="btn btn-default reject" type="submit">{{$lvapply->status}}</button></a> -->
                              <span class="badge badge-danger">{{$lvapply->status}}</span>
                              @elseif($lvapply->status=='APPROVED')
                              <a href="#"><button class="badge badge-success" type="submit">{{$lvapply->status}}</button></a>
                              @elseif($lvapply->status=='RECOMMENDED')
                              <!-- <a href="#"><button class="btn btn-default recomand" type="submit">{{$lvapply->status}}</button></a> -->
                              <a href="#"><button class="badge badge-info" type="submit">{{$lvapply->status}}</button></a>
                              @elseif($lvapply->status=='CANCEL')
                              <a href="#"><button class="btn btn-default reject" type="submit">{{$lvapply->status}}</button></a>
                              @endif
                           </td>
                           <td>{{ $lvapply->status_remarks }}</td>
                           @if(Session::get('user_type')=='employee')
                           <td>
                              @if($lvapply->status=='RECOMMENDED' || $lvapply->status=='NOT APPROVED')
                              <a href="{{url('leave-approver/leave-approved-right/'.$lvapply->id)}}"><img  style="width: 30px;" src="{{ asset('assets/img/edit.png')}}"></a>
                              @endif
                           </td>
                           @endif
                        </tr>
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