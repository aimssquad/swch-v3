@php
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
$user_type = Session::get("user_type"); 
@endphp  
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul class="sidebar-vertical">
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 8) 
                                <li class="menu-title">
                                    <span>Main</span>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube {{Request::is('organization/employerdashboard')?'noti-dot':'';}}"></i> <span>Organization</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="#">Dashboard</a></li>
                                        <li><a href="chat.html">Organization Statistics</a></li>
                                        <li><a href="chat.html">Edit Profile</a></li>
                                        <li><a href="#">Employees According to RTI</a></li>
                                        <li><a href="contacts.html">Authorizing Officer</a></li>
                                        <li><a href="inbox.html">Key Contact</a></li>
                                        <li><a href="file-manager.html">level 1 user</a></li>
                                        <li><a href="file-manager.html">level 2 user</a></li>
                                        @foreach($sidebarItems  as $array_role)
                                            @if($array_role['module_name'] == 15) 
                                            <li><a href="{{url('org-dashboarddetails')}}" class="{{Request::is('org-dashboarddetails')?'noti-dot':'';}}">Sponsor Compliance</a></li>
                                            @endif
                                        @endforeach
                                        <li><a href="file-manager.html">Change Of Circumstances</a></li>
                                        <li><a href="file-manager.html">Governance</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endif
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] ==1) 
                                <li class="menu-title">
                                    <span>EMPLOYEE MANAGEMENT</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('organization/employerdashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('organization/employerdashboard')}}" class="{{Request::is('organization/employerdashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('organization/employeeee')}}">All Employees</a></li>
                                        <li><a href="{{url('org-settings/vw-department')}}">Department</a></li>
                                        <li><a href="{{url('org-settings/vw-designation')}}">Designation</a></li>
                                        <li><a href="{{url('org-settings/vw-employee-type')}}">Employment Type</a></li>
                                        <li><a href="{{url('rota-org/shift-management')}}">All Shifts</a></li>
                                        {{-- <li><a href="leave-settings.html">All Shifts</a></li> --}}
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 7) 
                                <li class="menu-title">
                                    <span>Settings</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('organization/settings-dashboard')?'noti-dot':'';}}"><i class="la la-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('organization/settings-dashboard')}}" class="{{Request::is('organization/settings-dashboard')?'noti-dot':'';}}"><span> Dashboard</span></a>
                                        </li>
                                        <li class="submenu">
                                            <a href="#"><span> Bank Master</span> <span class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{url('org-settings/vw-cmp-bank')}}">Company Bank</a></li>
                                                <li><a href="{{url('org-settings/vw-emp-bank')}}">Employee Bank</a></li>
                                                <li><a href="{{url('org-settings/vw-ifsc')}}">IFSC Master</a></li>
                                            </ul>
                                        </li>
                                        <li class="submenu">
                                            <a href="#"><span> HCM Master</span> <span class="menu-arrow"></span></a>
                                            <ul>
                                                <li><a href="{{url('org-settings/vw-caste')}}">Caste Master</a></li>
                                                <li><a href="{{url('org-settings/vw-subcast')}}">Sub Cast</a></li>
                                                <li><a href="{{url('org-settings/vw-class')}}">Class Master</a></li>
                                                <li><a href="{{url('org-settings/vw-pincode')}}">Pincode Master</a></li>
                                                <li><a href="{{url('org-settings/vw-type')}}">Employee Type Master</a></li>
                                                <li><a href="{{url('org-settings/vw-mode-type')}}">Mode Of Employee</a></li>
                                                <li><a href="{{url('org-settings/vw-religion')}}">Religion Master</a></li>
                                                <li><a href="{{url('org-settings/vw-education')}}">Education Master</a></li>
                                                <li><a href="{{url('org-settings/vw-department')}}">Department</a></li>
                                                <li><a href="{{url('org-settings/vw-designation')}}">Designation</a></li>
                                                <li><a href="{{url('org-settings/vw-employee-type')}}">Employment Type</a></li>
                                                <li><a href="{{url('org-settings/vw-paygroup')}}">Pay Group</a></li>
                                                <li><a href="{{url('org-settings/vw-annualpay')}}">Annual Pay</a></li>
                                                <li><a href="{{url('org-settings/vw-bank-sortcode')}}">Bank Shortcode</a></li>
                                                <li><a href="{{url('org-settings/vw-pay-type')}}">Payment Type</a></li>
                                                <li><a href="{{url('org-settings/vw-wedgespay-type')}}">Wedges pay mode</a></li>
                                                <li><a href="{{url('org-settings/vw-tax')}}">Tax Master</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 2) 
                                <li class="menu-title">
                                    <span>Recruitment</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('recruitment/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Recruitment</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{ route('recruitment.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('recruitment.job-list') }}">Job List</a></li>
                                        <li><a href="{{ route('recruitment.job-posting') }}">Job Posting</a></li>
                                        <li><a href="{{ route('recruitment.job-published') }}">Job Published</a></li>
                                        <li><a href="{{ route('recruitment.job-applied') }}">Job Applied</a></li>
                                        <li><a href="{{ route('recruitment.short-listing') }}">Short listing</a></li>
                                        <li><a href="{{ route('recruitment.interview_result') }}">Interview</a></li>
                                        <li><a href="{{ url('recruitment/hired_list') }}">Hired</a></li>
                                        {{-- <li><a href="{{ route('recruitment.offer-letter') }}">Generate Offer Letter</a></li>
                                        <li><a href="{{ route('recruitment.rejected') }}">Rejected</a></li> --}}
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 10) 
                                <li class="menu-title">
                                    <span>User Access</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('user-access-role/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Role Management</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('user-access-role/dashboard')}}" class="{{Request::is('user-access-role/dashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('user-access-role/vw-users')}}">User Configuration</a></li>
                                        <li><a href="{{url('user-access-role/view-users-role')}}">Role Management</a></li> 
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] ==4) 
                                <li class="menu-title">
                                    <span>Holiday Management</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('orgaization/holiday-dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Holiday Management</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('orgaization/holiday-dashboard')}}" class="{{Request::is('orgaization/holiday-dashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('organization/holiday-type')}}">Holiday Type</a></li>
                                        <li><a href="{{url('organization/holiday-list')}}">Holiday List</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 3) 
                                <li class="menu-title">
                                    <span>Leave Management</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('leave/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Leave Management</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('leave/dashboard')}}" class="{{Request::is('leave/dashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('leave/leave-type-listing')}}">Manage Leave Type</a></li>
                                        <li><a href="{{url('leave/leave-rule-listing')}}">Leave Rule</a></li>
                                        <li><a href="{{url('leave/leave-allocation-listing')}}">Leave Allocation</a></li>
                                        <li><a href="{{url('leave/leave-balance')}}">Leave Balance</a></li>
                                        <li><a href="{{url('leave/leave-report')}}">Leave Report</a></li>
                                        <li><a href="{{url('leave/leave-report-employee')}}">Leave Report Employee Wise</a></li> 
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 9) 
                                <li class="menu-title">
                                    <span>Rota</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('rota-org/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Rota</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('rota-org/dashboard')}}" class="{{Request::is('rota-org/dashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('rota-org/shift-management')}}">Shift Management</a></li>
                                        <li><a href="{{url('rota-org/late-policy')}}">Late Policy</a></li>
                                        <li><a href="{{url('rota-org/offday')}}">Day Off</a></li>
                                        <li><a href="{{url('rota-org/grace-period')}}">Grace Period</a></li>
                                        <li><a href="{{url('rota-org/duty-roster')}}">Duty Roster</a></li>
                            
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 6) 
                                <li class="menu-title">
                                    <span>Module</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('rota-org/module-dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Visitor</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('rota-org/module-dashboard')}}" class="{{Request::is('rota-org/module-dashboard')?'noti-dot':'';}}">Dashboard</a></li>
                                        <li><a href="{{url('rota-org/visitor-link')}}">Visitor Register Link </a></li>
                                        <li><a href="{{url('rota-org/visitor-regis')}}">Visitor Register </a></li>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 6) 
                                <li class="menu-title">
                                    <span>Attendance</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('attendance-management/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Attendance</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('attendance-management/dashboard')}}" class="{{Request::is('attendance-management/dashboard')?'noti-dot':'';}}">Dashboard</a></li>   
                                        <li><a href="#">Attendance Statistics</a></li>
                                        <li><a href="{{url('attendance-management/upload-data')}}">Upload Attendance</a></li>
                                        <li><a href="{{url('attendance-management/generate-data')}}">Generate Attendance</a></li>
                                        <li><a href="{{url('attendance-management/daily-attendance')}}">Daily Attendance</a></li>
                                        <li><a href="{{url('attendance-management/attendance-report')}}">Attendance History</a></li>
                                        <li><a href="{{url('attendance-management/process-attendance')}}">Process Attendance</a></li>            
                                        <li><a href="{{url('attendance-management/absent-report')}}">Absent Report </a></li>                                
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 6) 
                                <li class="menu-title">
                                    <span>Leave Approver</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('leaveapprover/leave-dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Approver Conner</span> <span class="menu-arrow"></span></a>
                                    <ul>  
                                        <li><a href="{{url('leaveapprover/leave-dashboard')}}" class="{{Request::is('leaveapprover/leave-dashboard')?'noti-dot':'';}}">Dashboard</a></li>  
                                        <li><a href="{{url('leaveapprover/leave-request')}}">Leave Request List</a></li>                               
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 5) 
                                <li class="menu-title">
                                    <span>Employee Corner</span>
                                </li>
                                <li>
                                    <a href="{{url('org-user-check-employee')}}"><i class="la la-bell"></i> <span> Employee Corner</span></a>
                                </li>          
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 16) 
                                <li class="menu-title">
                                    <span>File Manager</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('file-management/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> File Management </span> <span class="menu-arrow"></span></a>
                                    <ul>   
                                        <li><a href="{{url('file-management/dashboard')}}" class="{{Request::is('file-management/dashboard')?'noti-dot':'';}}">Dasboard</a></li>
                                        <li><a href="{{url('file-management/file-devision-list')}}">File Division</a></li>
                                        <li><a href="{{url('file-management/fileManagmentList')}}">File Manager</a></li>                               
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 17) 
                                <li class="menu-title">
                                    <span>Hr Support</span>
                                </li>          
                                <li>
                                    <a href="{{url('hr-support/dashboard')}}" class="{{Request::is('hr-support/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Hr Support</span></a>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 18) 
                                <li class="menu-title">
                                    <span>Organogram Chart</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Organogram Chart</span> <span class="menu-arrow"></span></a>
                                    <ul>   
                                        <li><a href="voice-call.html">Level</a></li>
                                        <li><a href="video-call.html">Organisation Hierarchy</a></li>                               
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 19) 
                                <li class="menu-title">
                                    <span>Billing</span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Billing</span> <span class="menu-arrow"></span></a>
                                    <ul>   
                                        <li><a href="voice-call.html">Billing</a></li>
                                        <li><a href="video-call.html">Payment Receipt</a></li>                                
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 16) 
                                <li class="menu-title">
                                    <span>Task Management </span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('org-task-management/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Task Management  </span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="{{url('org-task-management/dashboard')}}" class="{{Request::is('org-task-management/dashboard')?'noti-dot':'';}}">Dashboard</a></li>   
                                        <li><a href="{{url('org-task-management/projects')}}">Project List</a></li>
                                        <li><a href="{{url('org-task-management/create-project')}}">Create Project</a></li>                              
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                    @if($user_type=="employer")
                        @foreach($sidebarItems  as $array_role)
                            @if($array_role['module_name'] == 15) 
                                <li class="menu-title">
                                    <span>Performance Management </span>
                                </li>          
                                <li class="submenu">
                                    <a href="#" class="{{Request::is('org-performances/dashboard')?'noti-dot':'';}}"><i class="la la-user"></i> <span> Performance Management </span> <span class="menu-arrow"></span></a>
                                    <ul> 
                                        <li><a href="{{url('org-performances/dashboard')}}" class="{{Request::is('org-performances/dashboard')?'noti-dot':'';}}">Dashboard</a></li>  
                                        <li><a href="{{url('org-performances')}}">Performance Request List</a></li>
                                        <li><a href="{{url('org-performances/request')}}">Create Request</a></li>                              
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endIf
                </ul>

            </div>
        </div>
    </div>
    <!-- /Sidebar -->

    <!-- Two Col Sidebar -->
    @include('employeer.layout.side-settings')
    <!-- /Two Col Sidebar -->
