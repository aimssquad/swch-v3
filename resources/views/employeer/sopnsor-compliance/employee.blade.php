@extends('employeer.include.app')
@section('title', 'All Employee List')
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
            <h3 class="page-title"> All Employee List</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active">All Employee List</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                   <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;All Employee List
               </h4>
               <div class="row">
                  <div class="col-auto">
                      <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                          @csrf
                          <input type="hidden" name="data" id="data">
                          <input type="hidden" name="headings" id="headings">
                          <input type="hidden" name="filename" id="filename">
                          {{-- put the value - that is your file name --}}
                          <input type="hidden" id="filenameInput" value="All-Employee-List">
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
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-striped custom-table" id="basic-datatables">
                  <thead>
                     <tr>
                       <th>Employee ID</th>
                       <th>Employee Name</th>
                       <th>Job Title</th>
                       <th>DOB</th>
                       <th>Mobile</th>
                       <th>Nationality</th>
                       <th>NI Number</th>
                       <th>Visa Expired</th>
                       <th>Passport No.</th>
                       <th>Address.</th>
                       <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                   @foreach($employee_rs as $employee)
                   <tr>
                  
                   <td>{{ $employee->emp_code}}</td>
                   <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                     <td>{{ $employee->emp_designation}}</td>
   
                     <td>    @if( $employee->emp_dob!='1970-01-01') @if( $employee->emp_dob!='') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @endif  @endif</td>
   
                     <td>{{ $employee->emp_ps_phone }}</td>
                     <td>{{ $employee->nationality }}</td>
                     <td>{{ $employee->ni_no }}</td>
                     <td>    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif @else NA  @endif</td>
                     <td>{{ $employee->pass_doc_no }}</td>
                     <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                     @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                        <td class="text-end">
                           <div class="dropdown dropdown-action">
                              <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}">
                                 <i class="fa-solid fa fa-upload m-r-5"></i> Downlode
                                 </a>
                                
                              </div>
                           </div>
                        </td>
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
<script>
   
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>
@endsection