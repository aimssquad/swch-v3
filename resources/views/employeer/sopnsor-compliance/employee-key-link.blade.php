@extends('employeer.include.app')
@section('title', 'Key Contact')
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
            <h3 class="page-title"> Key Contact</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active">Key Contact</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            {{-- @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
            <a href="{{ url('org-settings/add-new-ifsc') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add IFSC </a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('org-settings/add-new-ifsc') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add IFSC</a>
            @endif --}}
            {{-- 
            <div class="view-icons">
               <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
               <a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
            </div>
            --}}
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
                   <i class="far fa-key" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Key Contact
               </h4>
               <div class="row">
                  <div class="col-auto">
                      <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                          @csrf
                          <input type="hidden" name="data" id="data">
                          <input type="hidden" name="headings" id="headings">
                          <input type="hidden" name="filename" id="filename">
                          {{-- put the value - that is your file name --}}
                          <input type="hidden" id="filenameInput" value="Key-Contact">
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
                  <table class="table table-striped custom-table" id="basic-datatables">
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
                        @if ($Roledata->f_name!='')								
                        <tr>
                           <td>1</td>
                           <td>{{ $Roledata->key_f_name }} {{ $Roledata->key_f_lname }}</td>
                           <td>{{ $Roledata->key_designation }}</td>
                           <td>{{ $Roledata->key_phone }}</td>
                           <td>{{ $Roledata->key_email }}</td>
                           <td>{{ $Roledata->key_bank_status }} 	@if ($Roledata->key_bank_status=='Yes')	 ( {{ $Roledata->key_bank_other }} ) 	@endif	</td>
                           <td>	@if ($Roledata->key_proof!='')	<a href="{{ asset($Roledata->key_proof) }}" target="_blank">	<img src="{{ asset($Roledata->key_proof) }}" height="50px" width="50px"/></a>
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
<script>
   
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>
@endsection