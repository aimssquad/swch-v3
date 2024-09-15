@extends('employeer.include.app')

@section('title', 'Settings Dashboard')

@section('content')

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Settings Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings Dashboard</li>
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
                            <!-- Buttons -->
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                    Add New Department
                                    <a href="{{url('org-settings/add-new-department')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                    Add New Dsignation
                                    <a href="{{url('org-settings/designation')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                    Add New Employee Type
                                    <a href="{{url('org-settings/employee-type')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                   Add Employee Mode Type
                                    <a href="{{url('org-settings/add-mode-emp')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                   Add Employee Master Type
                                    <a href="{{url('org-settings/add-new-type')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">
                                   Add Education Master Type
                                    <a href="{{url('org-settings/add-new-education')}}">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Department</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $department_count }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-department')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Designation</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $designation_count }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-designation')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Employee Type</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $employee_type_count }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-type')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Employee Mode</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $employee_mode_count }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-mode-type')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Employee Master</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $employee_master_count}}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-type')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="fa fa-braille" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Total Education Master</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{ $education_count }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-settings/vw-education')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-12 col-md-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="statistic-header">
                            <h4>Recent Activities</h4>
                            <div class="important-notification">
                                <a href="activities.html">
                                    View All <i class="fe fe-arrow-right-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="notification-tab">
                            <div class="tab-content">
                                <div class="tab-pane active" id="notification_tab">
                                    <div class="employee-noti-content">
                                        <ul class="employee-notification-list">
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-danger rounded-circle">HR</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            Your leave request has been
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>02:10 PM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-info rounded-circle">ER</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            You’re enrolled in upcom....
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>12:40 PM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-warning rounded-circle">SM</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            Your annual compliance trai
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>11:00 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-warning rounded-circle">DT</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            Jessica has requested feedba
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>10:30 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-warning rounded-circle">DT</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            Gentle remainder about train
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>09:00 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
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
