@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('content')

<div class="content container-fluid pb-0">
				
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Recruitment Dashboard</h3>
                <ul class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee</li> --}}
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row staff-grid-row">
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class="">
                    <a href="{{url('org-recruitment/candidate')}}" class=""><i class="fa fa-clone" data-bs-toggle="tooltip" title="view"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/candidate')}}">Job Applied</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $applied_candidate_count ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('org-recruitment/short-listing')}}" class=""><i class="fa fa-terminal" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/short-listing')}}">Shortlisted</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $shortlisted_count ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class="">
                    <a href="{{url('org-recruitment/interview')}}" class=""><i class="fa fa-desktop" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/interview')}}">Interview</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $interview_count ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('org-recruitment/hired')}}" class=""><i class="fa fa-check" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/hired')}}">Hired</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $hired_count ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('org-recruitment/offer-letter')}}" class=""><i class="fa fa-envelope-open" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/offer-letter')}}">Offer Letter</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('org-recruitment/reject')}}" class=""><i class="fa fa-window-close" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('org-recruitment/reject')}}">Rejected</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $rejected_count ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('recruitment/job_posting')}}" class=""><i class="fa fa-window-restore" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('recruitment/job_posting')}}">Job Posting</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $company_job_rs ?? 0 }}</a></h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class=" ">
                    <a href="{{url('recruitment/job_published')}}" class=""><i class="fa fa-window-maximize" data-bs-toggle="tooltip" title="View"></i></a>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('recruitment/job_published')}}">Job Posting (External)</a></h4>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $company_job_count ?? 0 }}</a></h4>
            </div>
        </div>      
    </div>
    <div class="row">
        <div class="col-md-6">	
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Bar Chart</h5>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="chartBar1" class="h-300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card att-statistics">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <div class="stats-list">
                        <div class="stats-info">
                            <p>Today <strong>3.45 <small>/ 8 hrs</small></strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-primary w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="stats-info">
                            <p>This Week <strong>28 <small>/ 40 hrs</small></strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-warning w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="stats-info">
                            <p>This Month <strong>90 <small>/ 160 hrs</small></strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-success w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="stats-info">
                            <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-danger w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="stats-info">
                            <p>Overtime <strong>4</strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-info w-62" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        // alert("Hii abbas");
    </script>
@endsection