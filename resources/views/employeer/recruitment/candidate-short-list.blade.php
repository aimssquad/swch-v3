@extends('employeer.include.app')
@section('title', 'Short Listing')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Short Listing</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
					<li class="breadcrumb-item active">Short Listing</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    @include('employeer.layout.message')
    <div class="row">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Short Listing
                </h4>
                <div class="row">
                   <div class="col-auto">
                       <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                           @csrf
                           <input type="hidden" name="data" id="data">
                           <input type="hidden" name="headings" id="headings">
                           <input type="hidden" name="filename" id="filename">
                           {{-- put the value - that is your file name --}}
                           <input type="hidden" id="filenameInput" value="Short-listing">
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
                              <th>Sl</th>
                              <th>Job Code</th>
                              <th>Job Title</th>
                              <th>Candidate</th>
                              <th>Email</th>
                              <th>Contact Number</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Action</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php $i = 1;
                             ?>
                          @foreach($candidate_rs as $candidate)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{ $candidate->soc }}</td>
                              <td>{{ $candidate->job_title }}</td>
                              <td>{{ $candidate->name }}</td>
                              <td>{{ $candidate->email }}</td>
                              <td>{{ $candidate->phone }}</td>
                              <td>{{ $candidate->status }}</td>
                              <td>
                                      <?php
                                          $job_details=DB::table('candidate_history')->where('user_id', '=', $candidate->id )->orderBy('id', 'DESC')->first();  
                                          if(!empty($job_details)){    
                                          echo date('d/m/Y ',strtotime($job_details->date));
                                          }
                                          else{
                                              echo date('d/m/Y',strtotime($candidate->date));
                                              if($candidate->date>='2021-02-22'){
                                              echo ' '.date('h:i A ',strtotime($candidate->date));
                                              }
                                          }
                                      ?>
                                  </td>
                              {{-- <td class="drp">
                                  <div class="dropdown">
                                      <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="{{url('recruitment/edit-candidate/'.base64_encode($candidate->id))}}"><i class="far fa-edit"></i>&nbsp; Edit</a> 
                                          <a download class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}"><i class="fas fa-download"></i>&nbsp; Download</a> 
                                          @if($candidate->status=='Application Received')	
                                          <a class="dropdown-item" href="{{url('recruitment/send-letter-job-applied/'.base64_encode($candidate->id))}}"><i class="fas fa-paper-plane"></i>&nbsp; Send</a> 
                                          @endif
                                      </div>
                                  </div>
                              </td> --}}
                              <td class="text-end">
                                  <div class="dropdown dropdown-action">
                                      <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                      <div class="dropdown-menu dropdown-menu-right">
                                          @if($user_type == 'employee')
                                              @foreach($sidebarItems as $value)
                                                  @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                      <a class="dropdown-item" href="{{url('org-recruitment/edit-short-listing/'.base64_encode($candidate->id))}}">
                                                          <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                      </a>
                                                  @endif
                                              @endforeach
                                          @elseif($user_type == 'employer')
                                              <a class="dropdown-item" href="{{url('org-recruitment/edit-short-listing/'.base64_encode($candidate->id))}}">
                                                  <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                              </a>
                                          @endif
                                          @if($user_type == 'employee')
                                              @foreach($sidebarItems as $value)
                                                  @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                      <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}" download>
                                                          <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                      </a>
                                                  @endif
                                              @endforeach
                                          @elseif($user_type == 'employer')
                                              <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}" download>
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

