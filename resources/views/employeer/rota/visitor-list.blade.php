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
               <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Rota Dashboard</a></li>
               <li class="breadcrumb-item active">Visitor Register</li>
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
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Vesitor Register
                </h4>
                <div class="row">
                   <div class="col-auto">
                       <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                           @csrf
                           <input type="hidden" name="data" id="data">
                           <input type="hidden" name="headings" id="headings">
                           <input type="hidden" name="filename" id="filename">
                           {{-- put the value - that is your file name --}}
                           <input type="hidden" id="filenameInput" value="Vesitor-register">
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
   
    </script>
@endsection