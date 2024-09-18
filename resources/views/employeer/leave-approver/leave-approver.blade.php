@extends('employeer.include.app')
@section('title', 'Leave Application Details')
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
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('leaveapprover/leave-dashboard')}}">Leave Approver Dashboard</a></li>
               <li class="breadcrumb-item active">Leave Application Details</li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                   <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Leave Approver
               </h4>
               <div class="row">
                  <div class="col-auto">
                      <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                          @csrf
                          <input type="hidden" name="data" id="data">
                          <input type="hidden" name="headings" id="headings">
                          <input type="hidden" name="filename" id="filename">
                          {{-- put the value - that is your file name --}}
                          <input type="hidden" id="filenameInput" value="Leave-approver">
                          <button type="submit" class="btn btn-success btn-sm">
                              <i class="fas fa-file-excel"></i> Export to Excel
                          </button>
                      </form>
                  </div>
                  <div class="col-auto">
                      <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                           @csrf
                           <input type="hidden" name="data" id="pdfData">
                           <input type="hidden" name="headings" id="pdfHeadings">
                           <input type="hidden" name="filename" id="pdfFilename">
                           <button type="submit" class="btn btn-info btn-sm">
                               <i class="fas fa-file-pdf"></i> Export to PDF
                           </button>
                       </form>
                  </div>
              </div>
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
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
    
</script>
@endsection