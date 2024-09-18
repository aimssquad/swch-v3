@extends('employeer.include.app')
@section('title', 'Status Search')
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
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Status Search</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
               <li class="breadcrumb-item active">Status Search</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="post" action="{{ url('recruitment/status-search') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row form-group">
                     <div class="col-md-3">
                        <div class=" form-group current-stage">
                           <label for="inputFloatingLabel-recruitment" class="col-form-label">Job Title </label>
                           <select id="job_id" name="job_id" class="select"  style="">
                              <option value="">Select</option>
                              @foreach($company_job_rs as $dept)
                              <option value="{{$dept->id}}">{{$dept->title}}  (Job Code :{{$dept->job_code}} )</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">From Date</label>
                           <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="date" class="form-control input-border-bottom" required="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">To Date</label>
                           <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="date" class="form-control input-border-bottom" required="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <button class="btn btn-primary" style="margin-top: 25px;" type="submit">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                  <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Status Search
              </h4>
              <div class="row">
                 <div class="col-auto">
                     <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                         @csrf
                         <input type="hidden" name="data" id="data">
                         <input type="hidden" name="headings" id="headings">
                         <input type="hidden" name="filename" id="filename">
                         {{-- put the value - that is your file name --}}
                         <input type="hidden" id="filenameInput" value="Status-search">
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
               <?php
                  if(isset($result) && $result!=''  ){
                  ?>
               <form  method="post" action="{{ url('recruitment/status-search-result') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                  <input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                  <button class="btn btn-default" style="margin-top: -30px;float:right;" type="submit">Download Pdf</button>	
               </form>
               <?php
                  }?>
               <?php
                  if(isset($result) && $result!=''  ){
                  ?>
               <form  method="post" action="{{ url('recruitment/status-search-result-excel') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                  <input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                  <button class="btn btn-default" style="margin-top: -30px;float:right;margin-right: 15px;" type="submit">Download Excel</button>	
               </form>
               <?php
                  }?>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="display table table-striped table-hover" >
                     <thead>
                        <tr>
                           <th>Job Code</th>
                           <th>Job Title</th>
                           <th>Candidate</th>
                           <th>Email</th>
                           <th>Contact Number</th>
                           <th>Status</th>
                           <th>Date</th>
                           <th>Mail</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if(isset($result) && $result!=''  ){
                                print_r($result); 
                           }?>
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
<script >
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