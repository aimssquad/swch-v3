@extends('employeer.include.app')
@section('title', 'Interview')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Interview</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Interview</li>
				</ul>
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="table table-striped custom-table datatable" >
                       <thead>
                          <tr>
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
                        @foreach($candidate_rs as $candidate)
                            <tr>
                                <td>{{ $candidate->soc }}</td>
                                <td>{{ $candidate->job_title }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->email }}</td>
                                <td>{{ $candidate->phone }}</td>
                                <td>{{ $candidate->status }}</td>
                                <td>
                                    <?php
                                        $job_details=DB::table('candidate_history')->where('user_id', '=', $candidate->id ) 
                                        ->where(function ($query) {
                                                $query  ->where('status','=','Interview')
                                                    ->orWhere('status','=','Online Screen Test')
                                                    ->orWhere('status','=','Written Test')
                                                    ->orWhere('status','=','Telephone Interview')
                                                    ->orWhere('status','=','Face to Face Interview')
                                                    ->orWhere('status','=','Job Offered');
                                            })->orderBy('id', 'DESC')->first();			
                                            if(!empty($job_details)){ 
                                            echo date('d/m/Y',strtotime($job_details->date));}
                                            else{
                                                echo date('d/m/Y',strtotime($candidate->date));
                                            }
                                    ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                        <a class="dropdown-item" href="{{url('recruitment/edit-interview/'.base64_encode($candidate->id))}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{url('recruitment/edit-interview/'.base64_encode($candidate->id))}}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>
                                            @endif
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                        <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}"downlode>
                                                            <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}"downlode>
                                                    <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                </a>
                                            @endif
                                            @if($candidate->status=='Interview')	
                                                @if($user_type == 'employee')
                                                    @foreach($sidebarItems as $value)
                                                        @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                            <a class="dropdown-item" href="{{url('recruitment/send-letter-job-shorting/'.base64_encode($candidate->id))}}">
                                                                <i class="fa fa-upload m-r-5"></i> Send
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @elseif($user_type == 'employer')
                                                    <a class="dropdown-item" href="{{url('recruitment/send-letter-job-shorting/'.base64_encode($candidate->id))}}">
                                                        <i class="fa fa-upload m-r-5"></i> Send
                                                    </a>
                                                @endif
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

