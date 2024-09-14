@extends('employeer.include.app')

@section('title', 'Attendance Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Attendance Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Attendance Dashboard</li>
                    </ul>
                </div>
                {{-- <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job Applied</a>
                </div> --}}
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                       

                        <div class="row">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total No of Employee Present</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $employee_rs_count }}</div>
                                                    <div class="fs-12">
                                                        {{-- <a href="{{ url('rota-org/shift-management') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total No of Employee Absent</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $ab_count }}</div>
                                                    <div class="fs-12">
                                                        {{-- <a href="{{ url('rota-org/late-policy') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total No of Employee On Leave</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $co_count }}</div>
                                                    <div class="fs-12">
                                                        {{-- <a href="{{ url('rota-org/offday') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <hr>
                            <div class="col-3 mb-3">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Daily Attendance
                                    <a href="{{ url('attendance-management/daily-attendance') }}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Attendance History
                                    <a href="{{ url('attendance-management/attendance-report') }}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Process Attendance
                                    <a href="{{ url('attendance-management/process-attendance') }}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Absent Report
                                    <a href="{{ url('attendance-management/absent-report') }}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>


                          

                            

                           

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->


@endsection
