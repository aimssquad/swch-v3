@extends('sub-admin.include.app')
@section('title', 'Not Verified Organisation')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Not Verified Organisation</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="#">Organisation Dashboard</a></li>
               <li class="breadcrumb-item active">Not Verified Organisation</li>
            </ul>
         </div>
      </div>
   </div>
   @include('sub-admin.layout.message')
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                  <i class="fa fa-ban" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Not Verified Organisation List
               </h4>
               <div class="row">
                  <div class="col-auto">
                     <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                        @csrf
                        <input type="hidden" name="data" id="data">
                        <input type="hidden" name="headings" id="headings">
                        <input type="hidden" name="filename" id="filename">
                        {{-- put the value - that is your file name --}}
                        <input type="hidden" id="filenameInput" value="Not-verified-organization">
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
                  <table id="basic-datatables" class="table table-striped custom-table" >
                     <thead>
                        <tr>
                           <th>Sl.No.</th>
                           <th>Organisation Name</th>
                           <th>Organisation Address</th>
                           <th>Website</th>
                           <th>Login User ID</th>
                           <th>Password</th>
                           <th>Phone No.</th>
                           <th>Status</th>
                           <th>Verification</th>
                           <th>License Applied</th>
                           <th>Type</th>
                           <th>Created On</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($companies_rs as $company)
                        {{-- @php
                            $pass = DB::Table('users')->where('employee_id', '=', $company->reg)->first();
                        @endphp --}}
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $company->com_name }}</td>
                           <td>@if($company->address!=''){{ $company->address }} @if($company->address2!=''),{{ $company->address2 }}@endif,{{  $company->road }},{{  $company->city }},{{  $company->zip }},{{  $company->country }}@endif</td>
                           <td>{{ $company->website }}</td>
                           <td>{{ $company->email }}</td>
                           <td>{{ $company->pass }}</td>
                           <td>{{$company->country_code}} {{ $company->p_no }}</td>
                           <td>{{ strtoupper($company->status) }}</td>
                           <td>
                              @if($company->verify=='approved')
                              VERIFIED
                              @else
                              NOT VERIFIED
                              @endif
                           </td>
                           <td>
                              @if($company->licence=='yes')
                              APPLIED
                              @else
                              NOT APPLIED
                              @endif
                           </td>
                           <td>@if($company->license_type!='')  {{ $company->license_type  }} @else NA @endif</td>
                           <td>@if($company->created_at!='')  {{ date('d-m-Y h:i a',strtotime($company->created_at))  }}@endif</td>
                           <td class="text-end">
                              <div class="dropdown dropdown-action">
                                 <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="material-icons">more_vert</i>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{url('superadmin/edit-company/'.$company->id)}}">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
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
</div>
</div>    
<!-- /Page Content -->
@endsection
@section('script')
@endsection