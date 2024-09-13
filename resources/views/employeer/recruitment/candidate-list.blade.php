@extends('employeer.include.app')
@section('title', 'Job Applied')
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
            <h3 class="page-title">Job Applied</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ url('recruitment/dashboard') }}">Dashboard</a></li>
               <li class="breadcrumb-item active">Job Applied</li>
            </ul>
        </div>
         @include('employeer.layout.message')
      </div>
   </div>
   <!-- /Page Header -->    
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card" style="margin-bottom: 20px;">
            <div class="card-header">
               <h4 class="card-title"><i class="fas fa-briefcase"></i> Job Applied 
                  (Select Date Range to download resume in bulk)
               </h4>
            </div>
            <div class="card-body">
               <form method="get" action="{{url('recruitment/resume-bulk')}}">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="col-form-label">From Date</label>
                           <input type="date" class="form-control" name="formDate">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="col-form-label">To Date</label>
                           <input type="date" class="form-control" name="toDate">
                        </div>
                     </div>
                     <input type="hidden" name="checklist" value="arrayvaluecheck">
                     <div class="col-md-2">
                        <div class="form-group btn-up">
                           <input type="submit" class="btn btn-primary" name="go" value="Download" style="margin-top: 25px;">
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="fas fa-briefcase"></i> Job Applied
               </h4>
               @if(Session::has('message'))										
               <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
               @endif
            </div>
            <div class="card-body">
               <span>
                  <form method="get">
                     <div class="row">
                        <div class="col-md-3 offset-md-2">
                           <div class="form-group">
                              <label class="col-form-label">From Date</label>
                              <input type="date" class="form-control" name="formDate">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label">To Date</label>
                              <input type="date" class="form-control" name="toDate">
                           </div>
                        </div>
                        <!-- <input type="hidden" name="checklist" value="arrayvaluecheck"> -->
                        <div class="col-md-2">
                           <div class="form-group btn-up">
                              <input type="submit" class="btn btn-primary" name="go" value="go" style="margin-top: 25px;">
                           </div>
                        </div>
                     </div>
                  </form>
               </span>
               <hr>
               <div class="table-responsive">
                  <table id="basic-datatables" class="table table-striped custom-table datatable" >
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
                                                    <a class="dropdown-item" href="{{url('org-recruitment/edit-candidate/'.base64_encode($candidate->id))}}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                @endif
                                            @endforeach
                                        @elseif($user_type == 'employer')
                                            <a class="dropdown-item" href="{{url('org-recruitment/edit-candidate/'.base64_encode($candidate->id))}}">
                                                <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                            </a>
                                        @endif
                                        @if($user_type == 'employee')
                                            @foreach($sidebarItems as $value)
                                                @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                    <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}">
                                                        <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                                    </a>
                                                @endif
                                            @endforeach
                                        @elseif($user_type == 'employer')
                                            <a class="dropdown-item" href="{{asset('public/'.$candidate->resume)}}">
                                                <i class="fa fa-arrow-circle-down m-r-5"></i> Downlode
                                            </a>
                                        @endif
                                        @if($user_type == 'employee')
                                            @foreach($sidebarItems as $value)
                                                @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                                    <a class="dropdown-item" href="{{url('org-recruitment/send-letter-job-applied/'.base64_encode($candidate->id))}}">
                                                        <i class="fa fa-upload m-r-5"></i> Send
                                                    </a>
                                                @endif
                                            @endforeach
                                        @elseif($user_type == 'employer')
                                            <a class="dropdown-item" href="{{url('org-recruitment/send-letter-job-applied/'.base64_encode($candidate->id))}}">
                                                <i class="fa fa-upload m-r-5"></i> Send
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
</div>
<!-- /Page Content -->
@endsection