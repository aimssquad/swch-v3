<?php
$arrrole = Session::get('empsu_role');
$userType = Session::get('usersu_type');
//dd($arrrole);
?>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.png')}}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        @if($userType=='admin')
                        <span>
                            Superadmin
                            <span class="user-level">HRMS</span>
                            <span class="caret"></span>
                        </span>
                        @endif
                        @if($userType=='user')
                        <span>
                            {{Session::get('empsu_name')}}
                            <span class="user-level">HRMS</span>
                            <span class="caret"></span>
                        </span>
                        @endif
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">

                            <li>
                                <a href="{{url('superadminLogout')}}">
                                    <span class="link-collapse">Logout</span>
                                </a>
                            </li>
                            @if($userType=='admin')
                            <li>
                                <a href="{{url('superadmin/change-password')}}">
                                    <span class="link-collapse">Change Password</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @if($userType=='admin')
                <ul class="nav nav-primary">
                    <li class="nav-item active">
                        <a href="{{url('superadmindasboard')}}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                            <span class="caret"></span>
                        </a>

                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>

                    </li>

                    <li class="nav-item">
                        <a href="{{url('superadmin/view-search-dasboard')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Employee Tracker</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-file-manager')}}">
                            <i class="fas fa-th-list"></i>
                            <p>File Managers</p>

                        </a>

                    </li>

                    <!--<li class="nav-item">-->
                    <!--    <a href="{{url('superadmin/list-country')}}">-->
                    <!--        <i class="fas fa-th-list"></i>-->
                    <!--        <p>Country Wise List</p>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <li class="nav-item">
                        <a href="{{url('superadmin/view-search-application')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Application Status</p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#HrSupport">
                            <i class="fas fa-th-list"></i>
                            <p>HR Support System </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="HrSupport">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/hr-support-file-type')}}">
                                        <span class="sub-item">Hr Support File Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/hr-support-files')}}">
                                        <span class="sub-item">Hr Support Files</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-th-list"></i>
                            <p>Organisation </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/active')}}">
                                        <span class="sub-item">Active Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/notverify')}}">
                                        <span class="sub-item">Not Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/verify')}}">
                                        <span class="sub-item">Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">License Not Applied</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">License Applied</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Employee List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/organisation-employee')}}">
                                        <span class="sub-item">Organisation Wise Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/message-center')}}">
                                        <span class="sub-item">Message Center</span>
                                    </a>
                                </li>


                            </ul>

                        </div>
                    </li>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutsubadmin">
                            <i class="fas fa-th-list"></i>
                            <p>Sub Admin </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsubadmin">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('subadmin/active')}}">
                                        <span class="sub-item">Active Sub Admin</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('subadmin/notverify')}}">
                                        <span class="sub-item">Not Verified Sub Admin</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('subadmin/verify')}}">
                                        <span class="sub-item">Verified Sub Admin</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">License Not Applied</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">License Applied</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Employee List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/organisation-employee')}}">
                                        <span class="sub-item">Organisation Wise Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/message-center')}}">
                                        <span class="sub-item">Message Center</span>
                                    </a>
                                </li> --}}
                            </ul>
                            

                        </div>
                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjsbill">
                            <i class="fas fa-layer-group"></i>
                            <p>Billing</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjsbill">
                            <ul class="nav nav-collapse">

                                <li>
                                    <a href="{{url('superadmin/taxforbill')}}">
                                        <span class="sub-item">Tax Master</span>
                                    </a>
                                </li>
                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/invoice-candidates')}}">-->
                                <!--        <span class="sub-item">Candidates for Invoice</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a href="{{url('superadmin/billing')}}">
                                        <span class="sub-item">Billing</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('subadmin/sub_billing')}}">
                                        <span class="sub-item">Sub Admin Billing</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-received')}}">
                                        <span class="sub-item">Payment Received </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/billing-report')}}">
                                        <span class="sub-item"> Report </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/billing-search')}}">
                                        <span class="sub-item">Billing Search </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-search')}}">
                                        <span class="sub-item">Payment Received Search</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjs">
                            <i class="far fa-user"></i>
                            <p>Employee Management</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjs">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/employee-config')}}">
                                        <span class="sub-item">Employee</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-users-role')}}">
                                        <span class="sub-item">Role Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-admin-role')}}">
                                        <span class="sub-item">Admin Role Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-sidebar-role')}}">
                                        <span class="sub-item">Side Bar Permission</span>
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstime">
                            <i class="fas fa-layer-group"></i>
                            <p>Time Shift Management
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstime">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-time-schedule')}}">
                                        <span class="sub-item">Time Schedule</span>
                                    </a>
                                </li>


                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/offday')}}">-->
                                <!--        <span class="sub-item">Day off </span>-->
                                <!--    </a>-->
                                <!--</li>-->

                                <li>
                                    <a href="{{url('superadmin/duty-roster')}}">
                                        <span class="sub-item">Duty Roster </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/work-update')}}">
                                        <span class="sub-item">Daily Work Update </span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-referred')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Referred Master</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/visa-activity')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Visa Activity Configuration</p>

                        </a>

                    </li>


                    <li class="nav-item">
                        <a href="{{url('superadmin/package')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Package </p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassign">
                            <i class="fas fa-layer-group"></i>
                            <p>Assign</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassign">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-organisation-assignment')}}">

                                        <p> Organisation </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-tareq')}}">

                                        <p> Application </p>

                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-add-hr')}}">

                                        <p> Hr File </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-recruitment-file')}}">

                                        <p> Recruitment File </p>

                                    </a>

                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-add-cos')}}">

                                        <p> COS File </p>

                                    </a>

                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-visa-file')}}">

                                        <p> Visa File </p>

                                    </a>

                                </li>



                                <li>
                                    <a href="{{url('superadmin/view-add-visa')}}">

                                        <p> Administrative Review </p>

                                    </a>

                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassigviewn">
                            <i class="fas fa-layer-group"></i>
                            <p> View</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassigviewn">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-hr')}}">

                                        <p> Hr File Update </p>

                                    </a>
                                </li>


                                <li> <a href="{{url('superadmin/view-cos')}}">

                                        <p> COS File Update </p>

                                    </a>
                                </li>





                            </ul>
                        </div>
                    </li>



                    <li class="nav-item">
                        <a href="{{url('superadmin/view-reminder')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Invoice Reminder</p>

                        </a>

                    </li>





                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimecomp">
                            <i class="fas fa-layer-group"></i>
                            <p>Complain
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimecomp">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-complain')}}">
                                        <span class="sub-item">Open Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-solved-complain')}}">
                                        <span class="sub-item">Solved Complain</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-closed-complain')}}">
                                        <span class="sub-item">Closed Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/search-complain')}}">
                                        <span class="sub-item">Search</span>
                                    </a>
                                </li>




                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/enquiry')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Enquiry </p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a href="{{url('superadmin/activity-log')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Activity Log</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/plans')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscription Plans </p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/subscriptions')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscriptions </p>

                        </a>

                    </li>

                    <!-- <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarMockIntw">
                            <i class="far fa-user"></i>
                            <p>Mock Interviews</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarMockIntw">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/positions')}}">
                                        <span class="sub-item">Position Master</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/interview-questions')}}">
                                        <span class="sub-item">Question Master</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/interview-candidate')}}">
                                        <span class="sub-item">Interview Candidates</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/pre-mock-interviews')}}">
                                        <span class="sub-item">Pre-Mock Interviews</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <!--<a data-toggle="collapse" href="#sidebarQB">-->
                            <!--<i class="far fa-user"></i>-->
                            <!--<p>Question Bank</p>-->
                            <!--<span class="caret"></span>-->
                        <!--</a>-->
                        <!--<div class="collapse" id="sidebarQB">-->
                        <!--    <ul class="nav nav-collapse">-->
                        <!--        <li>-->
                        <!--            <a href="{{url('superadmin/industries')}}">-->
                        <!--                <span class="sub-item">Industries</span>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a href="{{url('superadmin/questions')}}">-->
                        <!--                <span class="sub-item">Question Master</span>-->
                        <!--            </a>-->
                        <!--        </li>-->

                        <!--    </ul>-->
                        <!--</div>-->
                    </li>

                </ul>
            @endif
            @if($userType=='sub-admin')
                <ul class="nav nav-primary">
                    <li class="nav-item active">
                        <a href="{{url('superadmindasboard')}}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                            <span class="caret"></span>
                        </a>

                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>

                    </li>

                    {{-- <li class="nav-item">
                        <a href="{{url('superadmin/view-search-dasboard')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Employee Tracker</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-file-manager')}}">
                            <i class="fas fa-th-list"></i>
                            <p>File Managers</p>

                        </a>

                    </li> --}}

                    <!--<li class="nav-item">-->
                    <!--    <a href="{{url('superadmin/list-country')}}">-->
                    <!--        <i class="fas fa-th-list"></i>-->
                    <!--        <p>Country Wise List</p>-->
                    <!--    </a>-->
                    <!--</li>-->

                    {{-- <li class="nav-item">
                        <a href="{{url('superadmin/view-search-application')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Application Status</p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#HrSupport">
                            <i class="fas fa-th-list"></i>
                            <p>HR Support System </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="HrSupport">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/hr-support-file-type')}}">
                                        <span class="sub-item">Hr Support File Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/hr-support-files')}}">
                                        <span class="sub-item">Hr Support Files</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </li> --}}

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-th-list"></i>
                            <p>Organisation </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/active')}}">
                                        <span class="sub-item">Active Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/notverify')}}">
                                        <span class="sub-item">Not Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/verify')}}">
                                        <span class="sub-item">Verified Organisation</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">License Not Applied</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">License Applied</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Employee List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/organisation-employee')}}">
                                        <span class="sub-item">Organisation Wise Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/message-center')}}">
                                        <span class="sub-item">Message Center</span>
                                    </a>
                                </li> --}}
                                
                                {{-- <li>
                                    <a href="{{ url('subadmin/link/' . $emp_email) }}">
                                        <span class="sub-item">Share Link</span>
                                    </a>
                                </li>     --}}
                               
                            </ul>

                        </div>
                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjsbill">
                            <i class="fas fa-layer-group"></i>
                            <p>Billing</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjsbill">
                            <ul class="nav nav-collapse">

                                <li>
                                    <a href="{{url('superadmin/taxforbill')}}">
                                        <span class="sub-item">Tax Master</span>
                                    </a>
                                </li>
                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/invoice-candidates')}}">-->
                                <!--        <span class="sub-item">Candidates for Invoice</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a href="{{url('superadmin/billing')}}">
                                        <span class="sub-item">Billing</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-received')}}">
                                        <span class="sub-item">Payment Received </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/billing-report')}}">
                                        <span class="sub-item"> Report </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/billing-search')}}">
                                        <span class="sub-item">Billing Search </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-search')}}">
                                        <span class="sub-item">Payment Received Search</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjs">
                            <i class="far fa-user"></i>
                            <p>Employee Management</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjs">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/employee-config')}}">
                                        <span class="sub-item">Employee</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-users-role')}}">
                                        <span class="sub-item">Role Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-admin-role')}}">
                                        <span class="sub-item">Admin Role Management</span>
                                    </a>
                                </li>




                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstime">
                            <i class="fas fa-layer-group"></i>
                            <p>Time Shift Management
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstime">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-time-schedule')}}">
                                        <span class="sub-item">Time Schedule</span>
                                    </a>
                                </li>


                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/offday')}}">-->
                                <!--        <span class="sub-item">Day off </span>-->
                                <!--    </a>-->
                                <!--</li>-->

                                <li>
                                    <a href="{{url('superadmin/duty-roster')}}">
                                        <span class="sub-item">Duty Roster </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/work-update')}}">
                                        <span class="sub-item">Daily Work Update </span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-referred')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Referred Master</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/visa-activity')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Visa Activity Configuration</p>

                        </a>

                    </li>


                    <li class="nav-item">
                        <a href="{{url('superadmin/package')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Package </p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassign">
                            <i class="fas fa-layer-group"></i>
                            <p>Assign</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassign">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-organisation-assignment')}}">

                                        <p> Organisation </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-tareq')}}">

                                        <p> Application </p>

                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-add-hr')}}">

                                        <p> Hr File </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-recruitment-file')}}">

                                        <p> Recruitment File </p>

                                    </a>

                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-add-cos')}}">

                                        <p> COS File </p>

                                    </a>

                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-visa-file')}}">

                                        <p> Visa File </p>

                                    </a>

                                </li>



                                <li>
                                    <a href="{{url('superadmin/view-add-visa')}}">

                                        <p> Administrative Review </p>

                                    </a>

                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassigviewn">
                            <i class="fas fa-layer-group"></i>
                            <p> View</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassigviewn">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-hr')}}">

                                        <p> Hr File Update </p>

                                    </a>
                                </li>


                                <li> <a href="{{url('superadmin/view-cos')}}">

                                        <p> COS File Update </p>

                                    </a>
                                </li>





                            </ul>
                        </div>
                    </li>



                    <li class="nav-item">
                        <a href="{{url('superadmin/view-reminder')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Invoice Reminder</p>

                        </a>

                    </li>





                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimecomp">
                            <i class="fas fa-layer-group"></i>
                            <p>Complain
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimecomp">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-complain')}}">
                                        <span class="sub-item">Open Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-solved-complain')}}">
                                        <span class="sub-item">Solved Complain</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-closed-complain')}}">
                                        <span class="sub-item">Closed Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/search-complain')}}">
                                        <span class="sub-item">Search</span>
                                    </a>
                                </li>




                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/enquiry')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Enquiry </p>

                        </a>

                    </li>

                    <li class="nav-item">
                        <a href="{{url('superadmin/activity-log')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Activity Log</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/plans')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscription Plans </p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{url('superadmin/subscriptions')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscriptions </p>

                        </a>

                    </li> --}}

                    <!-- <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarMockIntw">
                            <i class="far fa-user"></i>
                            <p>Mock Interviews</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarMockIntw">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/positions')}}">
                                        <span class="sub-item">Position Master</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/interview-questions')}}">
                                        <span class="sub-item">Question Master</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/interview-candidate')}}">
                                        <span class="sub-item">Interview Candidates</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/pre-mock-interviews')}}">
                                        <span class="sub-item">Pre-Mock Interviews</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <!--<a data-toggle="collapse" href="#sidebarQB">-->
                            <!--<i class="far fa-user"></i>-->
                            <!--<p>Question Bank</p>-->
                            <!--<span class="caret"></span>-->
                        <!--</a>-->
                        <!--<div class="collapse" id="sidebarQB">-->
                        <!--    <ul class="nav nav-collapse">-->
                        <!--        <li>-->
                        <!--            <a href="{{url('superadmin/industries')}}">-->
                        <!--                <span class="sub-item">Industries</span>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a href="{{url('superadmin/questions')}}">-->
                        <!--                <span class="sub-item">Question Master</span>-->
                        <!--            </a>-->
                        <!--        </li>-->

                        <!--    </ul>-->
                        <!--</div>-->
                    </li>

                </ul>
            @endif

            @if($userType=='user')
                <ul class="nav nav-primary">
                    <li class="nav-item active">
                        <a href="{{url('superadmindasboard')}}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                            <span class="caret"></span>
                        </a>

                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>

                    </li>
                    
                    {{-- @if(in_array('1', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-search-dasboard')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Employee Tracker</p>

                        </a>

                    </li>
                    @endif --}}

                    @if(in_array('1', $arrrole))
                    <li class="nav-item">
                        <a  href="{{ url('superadmin/employee-config')}}"> 
                            <i class="fas fa-th-list"></i>
                            <p>Employee </p>
                            <span class="caret"></span>
                        </a>
                    </li>
                    @endif

                    {{-- @if(in_array('2', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-search-application')}}">
                            <i class="fas fa-th-list"></i>
                            <p>Application Status</p>

                        </a>

                    </li>
                    @endif --}}
                    @if(in_array('2', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarRecrut">
                            <i class="fas fa-th-list"></i>
                            <p>Recruitment </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarRecrut">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/active')}}">
                                        <span class="sub-item">Assigned</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/notverify')}}">
                                        <span class="sub-item">Requested</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/verify')}}">
                                        <span class="sub-item">Ongoing</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">Hired</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">Unbilled</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Billed</span>
                                    </a>
                                </li>
                                


                            </ul>

                        </div>
                    </li>
                    @endif

                    {{-- @if(in_array('3', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-th-list"></i>
                            <p>Organisation </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/active')}}">
                                        <span class="sub-item">Active Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/notverify')}}">
                                        <span class="sub-item">Not Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/verify')}}">
                                        <span class="sub-item">Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">License Not Applied</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">License Applied</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Employee List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/organisation-employee')}}">
                                        <span class="sub-item">Organisation Wise Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/message-center')}}">
                                        <span class="sub-item">Message Center</span>
                                    </a>
                                </li>


                            </ul>

                        </div>
                    </li>
                    @endif --}}

                    @if(in_array('3', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-th-list"></i>
                            <p>Organisation </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/active')}}">
                                        <span class="sub-item">Active Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/notverify')}}">
                                        <span class="sub-item">Not Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/verify')}}">
                                        <span class="sub-item">Verified Organisation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-not-applied')}}">
                                        <span class="sub-item">License Not Applied</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/license-applied')}}">
                                        <span class="sub-item">License Applied</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/employee-list')}}">
                                        <span class="sub-item">Employee List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/organisation-employee')}}">
                                        <span class="sub-item">Organisation Wise Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/message-center')}}">
                                        <span class="sub-item">Message Center</span>
                                    </a>
                                </li>


                            </ul>

                        </div>
                    </li>
                    @endif

                    @if(in_array('4', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjsbill">
                            <i class="fas fa-layer-group"></i>
                            <p>Billing</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjsbill">
                            <ul class="nav nav-collapse">

                                <li>
                                    <a href="{{url('superadmin/taxforbill')}}">
                                        <span class="sub-item">Tax Master</span>
                                    </a>
                                </li>
                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/invoice-candidates')}}">-->
                                <!--        <span class="sub-item">Candidates for Invoice</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a href="{{url('superadmin/billing')}}">
                                        <span class="sub-item">Billing</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-received')}}">
                                        <span class="sub-item">Payment Received </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/billing-report')}}">
                                        <span class="sub-item"> Report </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/billing-search')}}">
                                        <span class="sub-item">Billing Search </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/payment-search')}}">
                                        <span class="sub-item">Payment Received Search</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(in_array('5', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjs">
                            <i class="far fa-user"></i>
                            <p>Employee Management</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjs">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/employee-config')}}">
                                        <span class="sub-item">Employee</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-users-role')}}">
                                        <span class="sub-item">Role Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-admin-role')}}">
                                        <span class="sub-item">Admin Role Management</span>
                                    </a>
                                </li>




                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(in_array('6', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstime">
                            <i class="fas fa-layer-group"></i>
                            <p>Time Shift Management
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstime">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-time-schedule')}}">
                                        <span class="sub-item">Time Schedule</span>
                                    </a>
                                </li>


                                <!--<li>-->
                                <!--    <a href="{{url('superadmin/offday')}}">-->
                                <!--        <span class="sub-item">Day off </span>-->
                                <!--    </a>-->
                                <!--</li>-->

                                <li>
                                    <a href="{{url('superadmin/duty-roster')}}">
                                        <span class="sub-item">Duty Roster </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/work-update')}}">
                                        <span class="sub-item">Daily Work Update </span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(in_array('7', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-referred')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Referred Master</p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('8', $arrrole))

                    <li class="nav-item">
                        <a href="{{url('superadmin/visa-activity')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Visa Activity Configuration</p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('9', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/package')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Package </p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('10', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassign">
                            <i class="fas fa-layer-group"></i>
                            <p>Assign</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassign">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-organisation-assignment')}}">

                                        <p> Organisation </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-tareq')}}">

                                        <p> Application </p>

                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-add-hr')}}">

                                        <p> Hr File </p>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-recruitment-file')}}">

                                        <p> Recruitment File </p>

                                    </a>

                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-add-cos')}}">

                                        <p> COS File </p>

                                    </a>

                                </li>
                                <li>
                                    <a href="{{url('superadmin/view-visa-file')}}">

                                        <p> Visa File </p>

                                    </a>

                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-add-visa')}}">

                                        <p> Administrative Review </p>

                                    </a>

                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(in_array('11', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimeassigviewn">
                            <i class="fas fa-layer-group"></i>
                            <p> View</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimeassigviewn">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-hr')}}">

                                        <p> Hr File Update </p>

                                    </a>
                                </li>


                                <li> <a href="{{url('superadmin/view-cos')}}">

                                        <p> COS File Update </p>

                                    </a>
                                </li>





                            </ul>
                        </div>
                    </li>
                    @endif


                    @if(in_array('12', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-reminder')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Invoice Reminder</p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('13', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarLayoutjstimecomp">
                            <i class="fas fa-layer-group"></i>
                            <p>Complain
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutjstimecomp">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/view-complain')}}">
                                        <span class="sub-item">Open Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/view-solved-complain')}}">
                                        <span class="sub-item">Solved Complain</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{url('superadmin/view-closed-complain')}}">
                                        <span class="sub-item">Closed Complain</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('superadmin/search-complain')}}">
                                        <span class="sub-item">Search</span>
                                    </a>
                                </li>




                            </ul>
                        </div>
                    </li>
                    @endif


                    @if(in_array('14', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/enquiry')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Enquiry </p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('15', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/plans')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscription Plans </p>

                        </a>

                    </li>
                    @endif

                    {{-- @if(in_array('16', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/subscriptions')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Subscriptions </p>

                        </a>

                    </li>
                    @endif --}}
                     @if(in_array('16', $arrrole))
                    <li class="nav-item">
                        <a href="{{url('superadmin/view-file-manager')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>File Manager </p>

                        </a>

                    </li>
                    @endif

                    @if(in_array('20', $arrrole))
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#sidebarQB">
                            <i class="far fa-user"></i>
                            <p>Question Bank</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarQB">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{url('superadmin/industries')}}">
                                        <span class="sub-item">Industries</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('superadmin/questions')}}">
                                        <span class="sub-item">Question Master</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endif


                    @if(in_array('17', $arrrole))
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#sidebarHrSupport">
                                <i class="fas fa-th-list"></i>
                                <p>Hr Support </p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarHrSupport">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{url('superadmin/hr-support-file-type')}}">
                                            <span class="sub-item">Hr Support File Types</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('superadmin/hr-support-files')}}">
                                            <span class="sub-item">Hr Support Files</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                    @endif


                </ul>
            @endif


        </div>
    </div>
</div>
