@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    $user_type = Session::get("user_type");

    $modules = [
        8 => [
            'title' => 'Organization',
            'icon' => 'la la-cube',
            'items' => [
                ['route' => 'organization.home', 'label' => 'Dashboard'],
                ['route' => 'organization.statistics', 'label' => 'Organization Statistics'],
                ['route' => 'organization.profile', 'label' => 'Edit Profile'],
                ['route' => 'employees.rti', 'label' => 'Employees According to RTI'],
                ['route' => 'authorizing.officer', 'label' => 'Authorizing Officer'],
                ['route' => 'key.contact', 'label' => 'Key Contact'],
                ['route' => 'level1.user', 'label' => 'Level 1 User'],
                ['route' => 'level2.user', 'label' => 'Level 2 User'],
                ['url' => 'org-dashboarddetails', 'label' => 'Sponsor Compliances'],
                ['url' => 'org-dashboard/change-of-circumstances', 'label' => 'Change Of Circumstances'],
                ['url' => '#', 'label' => 'Governance'],
            ]
        ],
        1 => [
            'title' => 'Employee Management',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'organization/employee/employerdashboard', 'label' => 'Dashboard'],
                ['url' => 'organization/employeeee', 'label' => 'All Employees'],
                ['url' => 'org-settings/vw-department', 'label' => 'Department'],
                ['url' => 'org-settings/vw-designation', 'label' => 'Designation'],
                ['url' => 'org-settings/vw-employee-type', 'label' => 'Employment Type'],
                ['url' => 'rota-org/shift-management', 'label' => 'All Shifts'],
            ]
        ],
        7 => [
            'title' => 'Settings',
            'icon' => 'la la-cog',
            'items' => [
                ['url' => 'organization/settings-dashboard', 'label' => 'Dashboard'],
                ['submenu' => 'Bank Master', 'children' => [
                    ['url' => 'org-settings/vw-cmp-bank', 'label' => 'Company Bank'],
                    ['url' => 'org-settings/vw-emp-bank', 'label' => 'Employee Bank'],
                    ['url' => 'org-settings/vw-ifsc', 'label' => 'IFSC Master'],
                ]],
                ['submenu' => 'HCM Master', 'children' => [
                    ['url' => 'org-settings/vw-caste', 'label' => 'Caste Master'],
                    ['url' => 'org-settings/vw-subcast', 'label' => 'Sub Cast'],
                    ['url' => 'org-settings/vw-class', 'label' => 'Class Master'],
                    ['url' => 'org-settings/vw-pincode', 'label' => 'Pincode Master'],
                    ['url' => 'org-settings/vw-type', 'label' => 'Employee Type Master'],
                    ['url' => 'org-settings/vw-mode-type', 'label' => 'Mode Of Employee'],
                    ['url' => 'org-settings/vw-religion', 'label' => 'Religion Master'],
                    ['url' => 'org-settings/vw-education', 'label' => 'Education Master'],
                    ['url' => 'org-settings/vw-department', 'label' => 'Department'],
                    ['url' => 'org-settings/vw-designation', 'label' => 'Designation'],
                    ['url' => 'org-settings/vw-employee-type', 'label' => 'Employment Type'],
                    ['url' => 'org-settings/vw-paygroup', 'label' => 'Pay Group'],
                    ['url' => 'org-settings/vw-annualpay', 'label' => 'Annual Pay'],
                    ['url' => 'org-settings/vw-bank-sortcode', 'label' => 'Bank Shortcode'],
                    ['url' => 'org-settings/vw-pay-type', 'label' => 'Payment Type'],
                    ['url' => 'org-settings/vw-wedgespay-type', 'label' => 'Wages Pay Mode'],
                    ['url' => 'org-settings/vw-tax', 'label' => 'Tax Master'],
                ]],
            ]
        ],
        2 => [
            'title' => 'Recruitment',
            'icon' => 'la la-user',
            'items' => [
                ['route' => 'recruitment.dashboard', 'label' => 'Dashboard'],
                ['route' => 'recruitment.job-list', 'label' => 'Job List'],
                ['route' => 'recruitment.job-posting', 'label' => 'Job Posting'],
                ['route' => 'recruitment.job-published', 'label' => 'Job Published'],
                ['url' => 'org-recruitment/candidate', 'label' => 'Job Applied'],
                ['url' => 'org-recruitment/short-listing', 'label' => 'Short listing'],
                ['url' => 'org-recruitment/interview', 'label' => 'Interview'],
                // ['url' => 'recruitment/hired_list', 'label' => 'Hired'],
            ]
        ],
        10 => [
            'title' => 'User Access',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'user-access-role/dashboard', 'label' => 'Dashboard'],
                ['url' => 'user-access-role/vw-users', 'label' => 'User Configuration'],
                ['url' => 'user-access-role/view-users-role', 'label' => 'Role Management'],
            ]
        ],
        4 => [
            'title' => 'Holiday Management',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'orgaization/holiday-dashboard', 'label' => 'Dashboard'],
                ['url' => 'organization/holiday-type', 'label' => 'Holiday Type'],
                ['url' => 'organization/holiday-list', 'label' => 'Holiday List'],
            ]
        ],
        3 => [
            'title' => 'Leave Management',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'leave/dashboard', 'label' => 'Dashboard'],
                ['url' => 'leave/leave-type-listing', 'label' => 'Manage Leave Type'],
                ['url' => 'leave/leave-rule-listing', 'label' => 'Leave Rule'],
                ['url' => 'leave/leave-allocation-listing', 'label' => 'Leave Allocation'],
                ['url' => 'leave/leave-balance', 'label' => 'Leave Balance'],
                ['url' => 'leave/leave-report', 'label' => 'Leave Report'],
                ['url' => 'leave/leave-report-employee', 'label' => 'Leave Report Employee Wise'],
            ]
        ],
        9 => [
            'title' => 'Rota',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'rota-org/dashboard', 'label' => 'Dashboard'],
                ['url' => 'rota-org/shift-management', 'label' => 'Shift Management'],
                ['url' => 'rota-org/late-policy', 'label' => 'Late Policy'],
                ['url' => 'rota-org/offday', 'label' => 'Day Off'],
                ['url' => 'rota-org/grace-period', 'label' => 'Grace Period'],
                ['url' => 'rota-org/duty-roster', 'label' => 'Duty Roster'],
            ]
        ],
        6 => [
            'title' => 'Attendance',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'attendance-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'attendance-management/upload-data', 'label' => 'Upload Attendance'],
                ['url' => 'attendance-management/generate-data', 'label' => 'Generate Attendance'],
                ['url' => 'attendance-management/daily-attendance', 'label' => 'Daily Attendance'],
                ['url' => 'attendance-management/attendance-report', 'label' => 'Attendance History'],
                ['url' => 'attendance-management/process-attendance', 'label' => 'Process Attendance'],
                ['url' => 'attendance-management/absent-report', 'label' => 'Absent Report'],
            ]
        ],
        15 => [
            'title' => 'Performance Management',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'org-performances/dashboard', 'label' => 'Dashboard'],
                ['url' => 'org-performances', 'label' => 'Performance Request List'],
                ['url' => 'org-performances/request', 'label' => 'Create Request'],
            ]
        ],
        5 => [
            'title' => 'Employee Corner',
            'icon' => 'la la-bell',
            'items' => [
                ['url' => 'org-user-check-employee', 'label' => 'Employee Corner'],
            ]
        ],
        16 => [
            'title' => 'File Manager',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'file-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'file-management/file-devision-list', 'label' => 'File Division'],
                ['url' => 'file-management/fileManagmentList', 'label' => 'File Manager'],
            ]
        ],
        17 => [
            'title' => 'Hr Support',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'hr-support/dashboard', 'label' => 'Dashboard'],
            ]
        ],
        18 => [
            'title' => 'Organogram Chart',
            'icon' => 'la la-user',
            'items' => [
                ['url' => '#', 'label' => 'Level'],
                ['url' => '#', 'label' => 'Organisation Hierarchy'],
            ]
        ],
        19 => [
            'title' => 'Billing',
            'icon' => 'la la-user',
            'items' => [
                ['url' => '#', 'label' => 'Billing'],
                ['url' => '#', 'label' => 'Payment Receipt'],
            ]
        ],
        16 => [
            'title' => 'Task Management',
            'icon' => 'la la-user',
            'items' => [
                ['url' => 'org-task-management/dashboard', 'label' => 'Dashboard'],
                ['url' => 'org-task-management/projects', 'label' => 'Project List'],
                ['url' => 'org-task-management/create-project', 'label' => 'Create Project'],
            ]
        ],
    ];
// Function to check if any module item matches the current URL
function isActiveModule($moduleItems) {
        foreach ($moduleItems as $item) {
            if (isset($item['route']) && Route::is($item['route'])) {
                return true;
            } elseif (isset($item['url']) && Request::is($item['url'])) {
                return true;
            }
        }
        return false;
    }
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                @if($user_type == "employer")
                    @foreach($sidebarItems as $array_role)
                        @php
                            $module_id = $array_role['module_name'];
                            $isActive = isset($modules[$module_id]) ? isActiveModule($modules[$module_id]['items']) : false;
                        @endphp

                        @if(isset($modules[$module_id]))
                            <li class="menu-title"><span>{{ $modules[$module_id]['title'] }}</span></li>

                            <li class="submenu {{ $isActive ? 'active' : '' }}">
                                <a href="#"><i class="{{ $modules[$module_id]['icon'] }} {{ $isActive ? 'noti-dot' : '' }}"></i> 
                                    <span>{{ $modules[$module_id]['title'] }}</span> 
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @foreach($modules[$module_id]['items'] as $item)
                                        @if(isset($item['route']))
                                            <li><a href="{{ route($item['route']) }}" class="{{ Route::is($item['route']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @elseif(isset($item['submenu']))
                                            <li class="submenu">
                                                <a href="#"><span>{{ $item['submenu'] }}</span> <span class="menu-arrow"></span></a>
                                                <ul>
                                                    @foreach($item['children'] as $child)
                                                        <li><a href="{{ url($child['url']) }}" class="{{ Request::is($child['url']) ? 'active' : '' }}">{{ $child['label'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="{{ url($item['url']) }}" class="{{ Request::is($item['url']) ? 'active' : '' }}">{{ $item['label'] }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

<!-- Two Col Sidebar -->
@include('employeer.layout.side-settings')
<!-- /Two Col Sidebar -->
