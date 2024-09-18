@extends('employeer.include.app')
@section('title', 'Generate Offer Letter')
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
				<h3 class="page-title">Generate Offer Letter</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
					<li class="breadcrumb-item active">Generate Offer Letter</li>
				</ul>
			</div>
            <div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 44)
				<a href="{{ url('org-recruitment/generate-letter') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Generate Offer Letter</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('org-recruitment/generate-letter') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Generate Offer Letter</a>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    @include('employeer.layout.message')
    <div class="row">
        <div class="card  custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Generate Offer Letter

                </h4>
                <div class="row">
                   <div class="col-auto">
                       <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                           @csrf
                           <input type="hidden" name="data" id="data">
                           <input type="hidden" name="headings" id="headings">
                           <input type="hidden" name="filename" id="filename">
                           {{-- put the value - that is your file name --}}
                           <input type="hidden" id="filenameInput" value="Generate-offer-letter">
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
                            <th>Job Code</th>
                            <th>Job Title</th>
                            <th>Candidate</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Offered Salary</th>
                            <th>Date Of Joining </th>
                            <th>Action</th>
                          </tr>
                       </thead>
                       <tbody>
                        <?php $i = 1; ?>
                        @foreach($candidate_rs as $candidate)
                                        <tr>
                                            
											<td>{{ $candidate->soc }}</td>
                                            <td>{{ $candidate->job_title }}</td>
											 <td>{{ $candidate->name }}</td>
											  <td>{{ $candidate->email }}</td>
											   <td>{{ $candidate->phone }}</td>
											    <td>Offer Letter Generated</td>
												<td>
												<?php
                                                    echo date('d/m/Y',strtotime($candidate->cr_date));
                                                ?></td><td>{{ $candidate->offered_sal }}</td>
                                                    <td>
                                                                                                <?php
                                                    echo date('d/m/Y',strtotime($candidate->date_jo));
                                                ?></td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                        <a class="dropdown-item" href="{{url('recruitment/edit-hired/'.base64_encode($candidate->id))}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i>View
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{url('recruitment/edit-hired/'.base64_encode($candidate->id))}}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> View
                                                </a>
                                            @endif
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                        <a class="dropdown-item" href="{{asset('public/pdf/'.$candidate->dom_pdf)}}" download>
                                                            <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{asset('public/pdf/'.$candidate->dom_pdf)}}" download>
                                                    <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                </a>
                                            @endif
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
@endsection

