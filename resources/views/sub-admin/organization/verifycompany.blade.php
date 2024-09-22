@extends('sub-admin.include.app')
@section('title', 'Verified Organisation')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
           <div class="col">
              <h3 class="page-title">Verified Organisation</h3>
              <ul class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Organisation Dashboard</a></li>
                 <li class="breadcrumb-item active">Verified Organisation</li>
              </ul>
           </div>
        </div>
     </div>
     @include('sub-admin.layout.message')
     <!-- /Page Header -->
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form  method="get" action="{{ url('superadmin/verify') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-5">
                                <div class=" form-group">
                                    <label for="for-form-date"  class="col-form-label">From Date</label>
                                    <input id="start_date" value="<?php if (isset($start_date) && $start_date) {echo date('Y-m-d', strtotime($start_date));}?>"  name="start_date" type="date" class="form-control input-border-bottom">
                                </div>
                             </div>

                             <div class="col-md-5">
                                <div class=" form-group">
                                    <label for="for-to-date"  class="col-form-label">To Date</label>
                                    <input id="end_date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo date('Y-m-d', strtotime($end_date));}?>"  type="date" class="form-control input-border-bottom">
                                </div>
                             </div>
                             <div class="col-md-2 btn-up">
                                  <button class="btn btn-primary" type="submit" style="margin-top:25px;">Submit</button>
                                  <a class="btn btn-primary" href="{{ url('superadmin/verify') }}" style="margin-top:25px;">Reset</a>
                             </div>
                        </div>

                    </form>
                </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fa fa-check" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Registered Active Organisation
                    </h4>
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="Active-organization">
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
                                <th>Login User ID</th>
                                <th>Password</th>
                                <th>Phone No.</th>
                                <th>License Type</th>
                                <th>Caseworker Remarks</th>
                                <th>Assigned Date</th>
                                <th>Time Lapsed (Days)</th>
                                <th>Updated On</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies_rs as $company)
							<?php
$pass = DB::Table('users')

    ->where('employee_id', '=', $company->reg)

    ->first();

?>
						<tr>
							<td>{{ $loop->iteration }}</td>	<td>{{ $company->com_name }}</td>

							<td>@if($company->address!=''){{ $company->address }} @if($company->address2!=''),{{ $company->address2 }}@endif,{{  $company->road }},{{  $company->city }},{{  $company->zip }},{{  $company->country }}@endif {{ $company->website }}</td>

                            <!-- <td>{{ $company->website }}</td> -->
                              <td>{{ $company->email }}</td>
							  <td>{{ $company->pass }}</td>
                            <td>{{$company->country_code}} {{ $company->p_no }}</td>
							<!-- <td>{{ strtoupper($company->status) }}</td>
							    <td>
							        @if($company->verify=='approved')
							       VERIFIED
							       @else
							       NOT VERIFIED
							       @endif</td>
								   <td>
							        @if($company->licence=='yes')
							       APPLIED
							       @else
							       NOT APPLIED
							       @endif</td> -->

								   <td>@if($company->license_type!='')  {{ $company->license_type  }} @else NA @endif</td>
								   <td>{{ $company->caseworker  }}</td>
								   <!--<td>{{ $company->assignment_remarks  }} </td>-->
								   <td>@if($company->assignment_date!='')  {{ date('d-m-Y',strtotime($company->assignment_date))  }}@endif </td>
								   <td style="text-align:center;">
									<?php
									
									$fdate=date('Y-m-d');
									$tdate=$company->assignment_date;
									$datetime1 = new DateTime($fdate);
									$datetime2 = new DateTime($tdate);
									$interval = $datetime1->diff($datetime2);
									echo $days = $interval->format('%a');
									?>
								 
								    </td>

							       <td>@if($company->updated_at!='')  {{ date('d-m-Y',strtotime($company->updated_at))  }}@endif</td>
								   <td>
									@if($company->license_type=='Internal')
									{{ \Helpers::getOrgWIPPaymentStatus($company->id) }}
									
									@endif
									</td>
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