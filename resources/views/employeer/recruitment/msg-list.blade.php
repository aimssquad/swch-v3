@extends('employeer.include.app')
@section('title', 'Message Center')
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
            <h3 class="page-title">Message Center</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Message Center</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 44)
            <a href="{{ url('org-recruitment/add-message-centre') }}" class="btn add-btn"><i class="fas fa-paper-plane"></i> Send Message</a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('org-recruitment/add-message-centre') }}" class="btn add-btn"><i class="fas fa-paper-plane"></i> Send Message</a>
            @endif
         </div>
         @include('employeer.layout.message')
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="card custom-card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">
                <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
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
               <table id="basic-datatables" class="table table-striped custom-table datatable" >
                  <thead>
                     <tr>
                        <th>Sl.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Message</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($msg_rs as $company)
                     @php
                        $pass = DB::Table('candidate')->where('id', '=', $company->employee_id)->first();
                     @endphp
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if(isset($pass->name)){{ $pass->name }}@endif</td>
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
</div>
<!-- /Page Content -->
@endsection
@section('script')
@endsection