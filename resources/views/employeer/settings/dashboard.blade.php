@extends('employeer.include.app')

@section('title', 'Settings Dashboard')

@section('content')

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Settings Dashboard
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Buttons -->
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Add New Department
                                    <a href="your-link-here">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Add New Dsignation
                                    <a href="your-link-here">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                    Add New Employee Type
                                    <a href="your-link-here">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                   Add Employee Mode Type
                                    <a href="your-link-here">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                   Add Employee Master Type
                                    <a href="your-link-here">
                                        <button type="button" class="btn-close" aria-label="add">
                                            <i class="fas fa-add"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="alert alert-outline-info alert-dismissible fade show">
                                   Add Education Master Type
                                    <a href="your-link-here">
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
                                                
                                                <div class="fw-semibold d-flex justify-content-between">Information Alert</div>
                                                {{-- <div class="fs-12 op-8 mb-1">Information alert to show to information message</div> --}}
                                                <div class="fs-12">
                                                    <a href="javascript:void(0);" class="text-primary fw-semibold"><i class="fa fa-arrow-circle-right" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i>Viwe all</a>
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
                                            <div class="me-2">                                                    
                                                <i class="feather-info flex-shrink-0"></i>
                                            </div>
                                            <div class="text-primary w-100">
                                                <div class="fw-semibold d-flex justify-content-between">Information Alert<button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button></div>
                                                <div class="fs-12 op-8 mb-1">Information alert to show to information message</div>
                                                <div class="fs-12">
                                                    <a href="javascript:void(0);" class="text-secondary fw-semibold me-2 d-inline-block">cancel</a>
                                                    <a href="javascript:void(0);" class="text-primary fw-semibold">open</a>
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
                                            <div class="me-2">                                                    
                                                <i class="feather-info flex-shrink-0"></i>
                                            </div>
                                            <div class="text-primary w-100">
                                                <div class="fw-semibold d-flex justify-content-between">Information Alert<button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button></div>
                                                <div class="fs-12 op-8 mb-1">Information alert to show to information message</div>
                                                <div class="fs-12">
                                                    <a href="javascript:void(0);" class="text-secondary fw-semibold me-2 d-inline-block">cancel</a>
                                                    <a href="javascript:void(0);" class="text-primary fw-semibold">open</a>
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
                                            <div class="me-2">                                                    
                                                <i class="feather-info flex-shrink-0"></i>
                                            </div>
                                            <div class="text-primary w-100">
                                                <div class="fw-semibold d-flex justify-content-between">Information Alert<button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button></div>
                                                <div class="fs-12 op-8 mb-1">Information alert to show to information message</div>
                                                <div class="fs-12">
                                                    <a href="javascript:void(0);" class="text-secondary fw-semibold me-2 d-inline-block">cancel</a>
                                                    <a href="javascript:void(0);" class="text-primary fw-semibold">open</a>
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
                                            <div class="me-2">                                                    
                                                <i class="feather-info flex-shrink-0"></i>
                                            </div>
                                            <div class="text-primary w-100">
                                                <div class="fw-semibold d-flex justify-content-between">Information Alert<button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button></div>
                                                <div class="fs-12 op-8 mb-1">Information alert to show to information message</div>
                                                <div class="fs-12">
                                                    <a href="javascript:void(0);" class="text-secondary fw-semibold me-2 d-inline-block">cancel</a>
                                                    <a href="javascript:void(0);" class="text-primary fw-semibold">open</a>
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
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="activities.html">
                                                        <span class="badge-soft-danger rounded-circle">AU</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="activities.html">
                                                            Our HR system will be down
                                                        </a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>11:50 AM</li>
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
