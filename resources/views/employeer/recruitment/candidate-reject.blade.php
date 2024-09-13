@extends('employeer.include.app')
@section('title', ' Rejected')
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
				<h3 class="page-title"> Rejected</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active"> Rejected</li>
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
                                        $job_details=DB::table('candidate_history')->where('user_id', '=', $candidate->id ) ->where('status','=','Rejected') ->orderBy('id', 'DESC')->first();
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
                                                        <a class="dropdown-item" href="{{url('recruitment/edit-reject/'.base64_encode($candidate->id))}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i>Edit
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{url('recruitment/edit-reject/'.base64_encode($candidate->id))}}">
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

