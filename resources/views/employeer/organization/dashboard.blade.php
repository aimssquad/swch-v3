@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ $Roledata->com_name }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>218</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <h3>112</h3>
                            <span>Total Departments</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid fa-dollar-sign"></i></span>
                        <div class="dash-widget-info">
                            <h3>44</h3>
                            <span>Migrants Employees</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                        <div class="dash-widget-info">
                            <h3>37</h3>
                            <span>Toatl Job Types</span>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">New Employees</span>
                                </div>
                                <div>
                                    <span class="text-success">+10%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">10</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees 218</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Earnings</span>
                                </div>
                                <div>
                                    <span class="text-success">+12.5%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Expenses</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Widget -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Statistics</h5>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>Today Leave <strong>4 <small>/ 65</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-primary w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-warning w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-success w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info w-22" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Task Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Tasks</p>
                                        <h3>385</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Overdue Tasks</p>
                                        <h3>19</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                            <div class="progress-bar bg-warning w-22" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                            <div class="progress-bar bg-success w-24" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            <div class="progress-bar bg-danger w-21" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                            <div class="progress-bar bg-info w-10" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                        <div>
                            <p><i class="fa-regular fa-circle-dot text-purple me-2"></i>Completed Tasks <span class="float-end">166</span></p>
                            <p><i class="fa-regular fa-circle-dot text-warning me-2"></i>Inprogress Tasks <span class="float-end">115</span></p>
                            <p><i class="fa-regular fa-circle-dot text-success me-2"></i>On Hold Tasks <span class="float-end">31</span></p>
                            <p><i class="fa-regular fa-circle-dot text-danger me-2"></i>Pending Tasks <span class="float-end">47</span></p>
                            <p class="mb-0"><i class="fa-regular fa-circle-dot text-info me-2"></i>Review Tasks <span class="float-end">5</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ms-2">5</span></h4>
                        <div class="leave-info-box">
                            <div class="media d-flex align-items-center">
                                <a href="profile.html" class="avatar"><img src="{{asset('frontend/assets/img/user.jpg')}}" alt="User Image"></a>
                                <div class="media-body flex-grow-1">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6>
                                    <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-inverse-danger">Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class="leave-info-box">
                            <div class="media d-flex align-items-center">
                                <a href="profile.html" class="avatar"><img src="{{asset('frontend/assets/img/user.jpg')}}" alt="User Image"></a>
                                <div class="media-body flex-grow-1">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6>
                                    <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-inverse-success">Approved</span>
                                </div>
                            </div>
                        </div>
                        <div class="load-more text-center">
                            <a class="text-dark" href="javascript:void(0);">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Statistics Widget -->

        
        <div class="row">

            <!-- Employee Month -->
            <div class="col-xl-6 col-md-12 d-flex">
                <div class="card employee-month-card flex-fill">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-12">
                                <div class="employee-month-details">
                                    <h4>Employee of the month</h4>
                                    <p>We are really proud of the difference you have made which gives everybody the reason to applaud & appreciate</p>
                                </div>
                                <div class="employee-month-content">
                                    <h6>Congrats, Hanna</h6>
                                    <p>UI/UX Team Lead</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="employee-month-img">
                                    <img src="{{asset('frontend/assets/img/employee-img.png')}}" class="img-fluid" alt="User">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Employee Month -->

            <!-- Other Model -->
            <div class="col-xl-6 col-md-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <div class="statistic-header">
                                    <h4>Quick Links</h4>
                                </div>
                            </div>
                            <div class="col-sm-4 text-sm-end">
                                <div class="owl-nav company-nav nav-control"></div>
                            </div>
                        </div>
                        <div class="company-slider owl-carousel">

                            <!-- Company Grid -->
                            <div class="company-grid company-soft-tertiary">
                                <div class="company-top">
                                    <div class="company-icon">
                                        <span class="company-icon-tertiary rounded-circle">HR</span>
                                    </div>
                                    <div class="company-link">
                                        <a href="companies.html">HR Policy</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Grid -->

                            <!-- Company Grid -->
                            <div class="company-grid company-soft-success">
                                <div class="company-top">
                                    <div class="company-icon">
                                        <span class="company-icon-success rounded-circle">EP</span>
                                    </div>
                                    <div class="company-link">
                                        <a href="companies.html">Employer Policy</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Grid -->

                            <!-- Company Grid -->
                            <div class="company-grid company-soft-info">
                                <div class="company-top">
                                    <div class="company-icon">
                                        <span class="company-icon-info rounded-circle">LP</span>
                                    </div>
                                    <div class="company-link">
                                        <a href="companies.html">Leave Policy</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Grid -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /Company Policy -->

        </div>

    </div>
    <!-- /Page Content -->


@endsection
