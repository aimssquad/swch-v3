@php
$user_type = Session::get("user_type");
//dd($Roledata->reg);
$roles_auth = DB::table("othorized_organization_module")
            ->where("employee_id", "=", $Roledata->reg)
            ->get()
            ->toArray();;
//dd($roles_auth);            
$module_names = [];
foreach($roles_auth as $role){
    $module_names[] = $role->module_name;    
}
// if($module_names[0] == 1){
//     dd('hello one');
// }
// // dd($data["Roles_auth"]);
//  dd($module_names);   
@endphp
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <nav class="greedys sidebar-horizantal">
            <ul class="list-inline-item list-unstyled links">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dashcube"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if($user_type=="employee")
                        {{-- {{'jjjj'}} --}}
                        @endif
                        <li><a href="admin-dashboard.html">Admin Dashboard</a></li>
                        <li><a href="employee-dashboard.html">Employee Dashboard</a></li>
                        <li><a href="deals-dashboard.html">Deals Dashboard</a></li>
                        <li><a href="leads-dashboard.html">Leads Dashboard</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="chat.html">Chat</a></li>
                        <li class="submenu">
                            <a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="voice-call.html">Voice Call</a></li>
                                <li><a href="video-call.html">Video Call</a></li>
                                <li><a href="outgoing-call.html">Outgoing Call</a></li>
                                <li><a href="incoming-call.html">Incoming Call</a></li>
                            </ul>
                        </li>
                        <li><a href="events.html">Calendar</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="inbox.html">Email</a></li>
                        <li><a href="file-manager.html">File Manager</a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Employees</span>
                </li>
                <li class="submenu">
                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="employees.html">All Employees</a></li>
                        <li><a href="holidays.html">Holidays</a></li>
                        <li><a href="leaves.html">Leaves (Admin) <span class="badge rounded-pill bg-primary float-end">1</span></a></li>
                        <li><a href="leaves-employee.html">Leaves (Employee)</a></li>
                        <li><a href="leave-settings.html">Leave Settings</a></li>
                        <li><a href="attendance.html">Attendance (Admin)</a></li>
                        <li><a href="attendance-employee.html">Attendance (Employee)</a></li>
                        <li><a href="departments.html">Departments</a></li>
                        <li><a href="designations.html">Designations</a></li>
                        <li><a href="timesheet.html">Timesheet</a></li>
                        <li><a href="shift-scheduling.html">Shift & Schedule</a></li>
                        <li><a href="overtime.html">Overtime</a></li>
                    </ul>
                </li>
                <li>
                    <a href="clients.html"><i class="la la-users"></i> <span>Clients</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="projects.html">Projects</a></li>
                        <li><a href="tasks.html">Tasks</a></li>
                        <li><a href="task-board.html">Task Board</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-ticket"></i> <span>Crm</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="contact-list.html"> Contacts</a>
                        </li>
                        <li>
                            <a href="companies.html">Companies</a>
                        </li>
                        <li>
                            <a href="deals.html">  Deals</a>
                        </li>
                        <li>
                            <a href="leads.html"> Leads </a>
                        </li>
                        <li>
                            <a href="pipeline.html">Pipeline </a>
                        </li>
                        <li>
                            <a href="analytics.html">Analytics</a>
                        </li>
                        <li>
                            <a href="activities.html"> Activities </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-ticket"></i> <span>Tickets</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="tickets.html">Tickets</a></li>
                        <li><a href="ticket-details.html">Tickets Detail</a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>HR</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-files-o"></i> <span> Sales </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="estimates.html">Estimates</a></li>
                        <li><a href="invoices.html">Invoices</a></li>
                        <li><a href="payments.html">Payments</a></li>
                        <li><a href="expenses.html">Expenses</a></li>
                        <li><a href="provident-fund.html">Provident Fund</a></li>
                        <li><a href="taxes.html">Taxes</a></li>
                    </ul>
                </li>
            </ul>
            <button class="viewmoremenu">More Menu</button>
            <ul class="hidden-links hidden">
                <li class="submenu">
                    <a href="#"><i class="la la-files-o"></i> <span> Accounting </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="categories.html">Categories</a></li>
                        <li><a href="budgets.html">Budgets</a></li>
                        <li><a href="budget-expenses.html">Budget Expenses</a></li>
                        <li><a href="budget-revenues.html">Budget Revenues</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="salary.html"> Employee Salary </a></li>
                        <li><a href="salary-view.html"> Payslip </a></li>
                        <li><a href="payroll-items.html"> Payroll Items </a></li>
                    </ul>
                </li>
                <li>
                    <a href="policies.html"><i class="la la-file-pdf-o"></i> <span>Policies</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="expense-reports.html"> Expense Report </a></li>
                        <li><a href="invoice-reports.html"> Invoice Report </a></li>
                        <li><a href="payments-reports.html"> Payments Report </a></li>
                        <li><a href="project-reports.html"> Project Report </a></li>
                        <li><a href="task-reports.html"> Task Report </a></li>
                        <li><a href="user-reports.html"> User Report </a></li>
                        <li><a href="employee-reports.html"> Employee Report </a></li>
                        <li><a href="payslip-reports.html"> Payslip Report </a></li>
                        <li><a href="attendance-reports.html"> Attendance Report </a></li>
                        <li><a href="leave-reports.html"> Leave Report </a></li>
                        <li><a href="daily-reports.html"> Daily Report </a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Performance</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-graduation-cap"></i> <span> Performance </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="performance-indicator.html"> Performance Indicator </a></li>
                        <li><a href="performance.html"> Performance Review </a></li>
                        <li><a href="performance-appraisal.html"> Performance Appraisal </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="goal-tracking.html"> Goal List </a></li>
                        <li><a href="goal-type.html"> Goal Type </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-edit"></i> <span> Training </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="training.html"> Training List </a></li>
                        <li><a href="trainers.html"> Trainers</a></li>
                        <li><a href="training-type.html"> Training Type </a></li>
                    </ul>
                </li>
                <li><a href="promotion.html"><i class="la la-bullhorn"></i> <span>Promotion</span></a></li>
                <li><a href="resignation.html"><i class="la la-external-link-square"></i> <span>Resignation</span></a></li>
                <li><a href="termination.html"><i class="la la-times-circle"></i> <span>Termination</span></a></li>
                <li class="menu-title">
                    <span>Administration</span>
                </li>
                <li>
                    <a href="assets.html"><i class="la la-object-ungroup"></i> <span>Assets</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-briefcase"></i> <span> Jobs </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="user-dashboard.html"> User Dasboard </a></li>
                        <li><a href="jobs-dashboard.html"> Jobs Dasboard </a></li>
                        <li><a href="jobs.html"> Manage Jobs </a></li>
                        <li><a href="manage-resumes.html"> Manage Resumes </a></li>
                        <li><a href="shortlist-candidates.html"> Shortlist Candidates </a></li>
                        <li><a href="interview-questions.html"> Interview Questions </a></li>
                        <li><a href="offer_approvals.html"> Offer Approvals </a></li>
                        <li><a href="experiance-level.html"> Experience Level </a></li>
                        <li><a href="candidates.html"> Candidates List </a></li>
                        <li><a href="schedule-timing.html"> Schedule timing </a></li>
                        <li><a href="apptitude-result.html"> Aptitude Results </a></li>
                    </ul>
                </li>
                <li>
                    <a href="knowledgebase.html"><i class="la la-question"></i> <span>Knowledgebase</span></a>
                </li>
                <li>
                    <a href="activities.html"><i class="la la-bell"></i> <span>Activities</span></a>
                </li>
                <li>
                    <a href="users.html"><i class="la la-user-plus"></i> <span>Users</span></a>
                </li>
                <li>
                    <a href="settings.html"><i class="la la-cog"></i> <span>Settings</span></a>
                </li>
                <li class="menu-title">
                    <span>Pages</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="profile.html"> Employee Profile </a></li>
                        <li><a href="client-profile.html"> Client Profile </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-key"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="index.html"> Login </a></li>
                        <li><a href="register.html"> Register </a></li>
                        <li><a href="forgot-password.html"> Forgot Password </a></li>
                        <li><a href="otp.html"> OTP </a></li>
                        <li><a href="lock-screen.html"> Lock Screen </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-exclamation-triangle"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="error-404.html">404 Error </a></li>
                        <li><a href="error-500.html">500 Error </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-hand-o-up"></i> <span> Subscriptions </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="subscriptions.html"> Subscriptions (Admin) </a></li>
                        <li><a href="subscriptions-company.html"> Subscriptions (Company) </a></li>
                        <li><a href="subscribed-companies.html"> Subscribed Companies</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-columns"></i> <span> Pages </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="search.html"> Search </a></li>
                        <li><a href="faq.html"> FAQ </a></li>
                        <li><a href="terms.html"> Terms </a></li>
                        <li><a href="privacy-policy.html"> Privacy Policy </a></li>
                        <li><a href="blank-page.html"> Blank Page </a></li>
                        <li><a href="coming-soon.html"> Coming Soon </a></li>
                        <li><a href="under-maintenance.html"> Under Maintanance </a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>UI Interface</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa-brands fa-get-pocket"></i> <span>Base UI</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="ui-alerts.html">Alerts</a></li>
                        <li><a href="ui-accordion.html">Accordion</a></li>
                        <li><a href="ui-avatar.html">Avatar</a></li>
                        <li><a href="ui-badges.html">Badges</a></li>
                        <li><a href="ui-borders.html">Border</a></li>
                        <li><a href="ui-buttons.html">Buttons</a></li>
                        <li><a href="ui-buttons-group.html">Button Group</a></li>
                        <li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
                        <li><a href="ui-cards.html">Card</a></li>
                        <li><a href="ui-carousel.html">Carousel</a></li>
                        <li><a href="ui-colors.html">Colors</a></li>
                        <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                        <li><a href="ui-grid.html">Grid</a></li>
                        <li><a href="ui-images.html">Images</a></li>
                        <li><a href="ui-lightbox.html">Lightbox</a></li>
                        <li><a href="ui-media.html">Media</a></li>
                        <li><a href="ui-modals.html">Modals</a></li>
                        <li><a href="ui-notification.html">Notification</a></li>
                        <li><a href="ui-offcanvas.html">Offcanvas</a></li>
                        <li><a href="ui-pagination.html">Pagination</a></li>
                        <li><a href="ui-popovers.html">Popovers</a></li>
                        <li><a href="ui-progress.html">Progress</a></li>
                        <li><a href="ui-placeholders.html">Placeholders</a></li>
                        <li><a href="ui-rangeslider.html">Range Slider</a></li>
                        <li><a href="ui-spinner.html">Spinner</a></li>
                        <li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
                        <li><a href="ui-nav-tabs.html">Tabs</a></li>
                        <li><a href="ui-toasts.html">Toasts</a></li>
                        <li><a href="ui-tooltips.html">Tooltips</a></li>
                        <li><a href="ui-typography.html">Typography</a></li>
                        <li><a href="ui-video.html">Video</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dropbox"></i> <span> Advanced UI </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="ui-ribbon.html">Ribbon</a></li>
                        <li><a href="ui-clipboard.html">Clipboard</a></li>
                        <li><a href="ui-drag-drop.html">Drag & Drop</a></li>
                        <li><a href="ui-rangeslider.html">Range Slider</a></li>
                        <li><a href="ui-rating.html">Rating</a></li>
                        <li><a href="ui-text-editor.html">Text Editor</a></li>
                        <li><a href="ui-counter.html">Counter</a></li>
                        <li><a href="ui-scrollbar.html">Scrollbar</a></li>
                        <li><a href="ui-stickynote.html">Sticky Note</a></li>
                        <li><a href="ui-timeline.html">Timeline</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-chart-bar"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="chart-apex.html">Apex Charts</a></li>
                        <li><a href="chart-js.html">Chart Js</a></li>
                        <li><a href="chart-morris.html">Morris Charts</a></li>
                        <li><a href="chart-flot.html">Flot Charts</a></li>
                        <li><a href="chart-peity.html">Peity Charts</a></li>
                        <li><a href="chart-c3.html">C3 Charts</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-icons"></i> <span> Icons </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
                        <li><a href="icon-feather.html">Feather Icons</a></li>
                        <li><a href="icon-ionic.html">Ionic Icons</a></li>
                        <li><a href="icon-material.html">Material Icons</a></li>
                        <li><a href="icon-pe7.html">Pe7 Icons</a></li>
                        <li><a href="icon-simpleline.html">Simpleline Icons</a></li>
                        <li><a href="icon-themify.html">Themify Icons</a></li>
                        <li><a href="icon-weather.html">Weather Icons</a></li>
                        <li><a href="icon-typicon.html">Typicon Icons</a></li>
                        <li><a href="icon-flag.html">Flag Icons</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-object-group"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
                        <li><a href="form-input-groups.html">Input Groups </a></li>
                        <li><a href="form-horizontal.html">Horizontal Form </a></li>
                        <li><a href="form-vertical.html"> Vertical Form </a></li>
                        <li><a href="form-mask.html"> Form Mask </a></li>
                        <li><a href="form-validation.html"> Form Validation </a></li>
                        <li><a href="form-select2.html">Form Select2 </a></li>
                        <li><a href="form-fileupload.html">File Upload </a></li>
                        <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                        <li><a href="form-wizard.html">Form Wizard</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="tables-basic.html">Basic Tables </a></li>
                        <li><a href="data-tables.html">Data Table </a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Extras</span>
                </li>
                <li>
                    <a href="#"><i class="la la-file-text"></i> <span>Documentation</span></a>
                </li>
                <li>
                    <a href="javascript:void(0);"><i class="la la-info"></i> <span>Change Log</span> <span class="badge badge-primary ms-auto">v4.0</span></a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="la la-share-alt"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> <span>Level 1</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <ul class="sidebar-vertical">
            <li class="menu-title">
                <span>Main</span>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-dashcube"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                <ul>
                    @if($user_type=="employer")
                        @foreach($module_names as $array_role)
                        @if($array_role==1)
                        <li><a  href="employee-dashboard.html">Employee Dashboard</a></li>
                        @endif
                        @endforeach
                    @elseif($user_type=="admin")
                        <li><a href="admin-dashboard.html" class="active">Admin Dashboard</a></li>
                         
                    @else 
                        <li><a  href="employee-dashboard.html">Employee Dashboard</a></li>
                        <li><a href="deals-dashboard.html">Deals Dashboard</a></li>
                        <li><a href="leads-dashboard.html">Leads Dashboard</a></li>      
                    @endif
                   
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="chat.html">Chat</a></li>
                    <li class="submenu">
                        <a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="voice-call.html">Voice Call</a></li>
                            <li><a href="video-call.html">Video Call</a></li>
                            <li><a href="outgoing-call.html">Outgoing Call</a></li>
                            <li><a href="incoming-call.html">Incoming Call</a></li>
                        </ul>
                    </li>
                    <li><a href="events.html">Calendar</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="inbox.html">Email</a></li>
                    <li><a href="file-manager.html">File Manager</a></li>
                </ul>
            </li>
            @if($user_type=="employer")
            @foreach($module_names as $array_role)
                @if($array_role==1) 
            <li class="menu-title">
                <span>Employees</span>
            </li>   
                      
            <li class="submenu">
                <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                @endif
                @endforeach
            @endIf
                <ul>
                    <li><a href="employees.html">All Employees</a></li>
                    <li><a href="holidays.html">Holidays</a></li>
                    <li><a href="leaves.html">Leaves (Admin) <span class="badge rounded-pill bg-primary float-end">1</span></a></li>
                    <li><a href="leaves-employee.html">Leaves (Employee)</a></li>
                    <li><a href="leave-settings.html">Leave Settings</a></li>
                    <li><a href="attendance.html">Attendance (Admin)</a></li>
                    <li><a href="attendance-employee.html">Attendance (Employee)</a></li>
                    <li><a href="departments.html">Departments</a></li>
                    <li><a href="designations.html">Designations</a></li>
                    <li><a href="timesheet.html">Timesheet</a></li>
                    <li><a href="shift-scheduling.html">Shift & Schedule</a></li>
                    <li><a href="overtime.html">Overtime</a></li>   
                </ul>
            </li>
            <li>
                <a href="clients.html"><i class="la la-users"></i> <span>Clients</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="projects.html">Projects</a></li>
                    <li><a href="tasks.html">Tasks</a></li>
                    <li><a href="task-board.html">Task Board</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-ticket"></i> <span>Tickets</span><span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="tickets.html">Tickets</a></li>
                    <li><a href="ticket-details.html">Tickets Detail</a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>CRM</span>
                <small class="newly-added-features">New</small>
            </li>
            <li>
                <a href="contact-list.html"><i class="la la-user-shield"></i> <span> Contacts </span></a>
            </li>
            <li>
                <a href="companies.html"><i class="la la-building"></i> <span> Companies </span></a>
            </li>
            <li>
                <a href="deals.html"><i class="la la-cubes"></i> <span> Deals </span></a>
            </li>
            <li>
                <a href="leads.html"><i class="la la-chart-area"></i> <span> Leads </span></a>
            </li>
            <li>
                <a href="pipeline.html"><i class="la la-exchange-alt"></i> <span> Pipeline </span></a>
            </li>
            <li>
                <a href="analytics.html"><i class="la la-dice"></i> <span> Analytics </span></a>
            </li>
            <li>
                <a href="activities.html"><i class="la la-directions"></i> <span> Activities </span></a>
            </li>
            <li class="menu-title">
                <span>HR</span>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-files-o"></i> <span> Sales </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="estimates.html">Estimates</a></li>
                    <li><a href="invoices.html">Invoices</a></li>
                    <li><a href="payments.html">Payments</a></li>
                    <li><a href="expenses.html">Expenses</a></li>
                    <li><a href="provident-fund.html">Provident Fund</a></li>
                    <li><a href="taxes.html">Taxes</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-file-alt"></i> <span> Accounting </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="categories.html">Categories</a></li>
                    <li><a href="budgets.html">Budgets</a></li>
                    <li><a href="budget-expenses.html">Budget Expenses</a></li>
                    <li><a href="budget-revenues.html">Budget Revenues</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-money-bill-wave"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="salary.html"> Employee Salary </a></li>
                    <li><a href="salary-view.html"> Payslip </a></li>
                    <li><a href="payroll-items.html"> Payroll Items </a></li>
                </ul>
            </li>
            <li>
                <a href="policies.html"><i class="la la-file-pdf"></i> <span>Policies</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-chart-pie"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="expense-reports.html"> Expense Report </a></li>
                    <li><a href="invoice-reports.html"> Invoice Report </a></li>
                    <li><a href="payments-reports.html"> Payments Report </a></li>
                    <li><a href="project-reports.html"> Project Report </a></li>
                    <li><a href="task-reports.html"> Task Report </a></li>
                    <li><a href="user-reports.html"> User Report </a></li>
                    <li><a href="employee-reports.html"> Employee Report </a></li>
                    <li><a href="payslip-reports.html"> Payslip Report </a></li>
                    <li><a href="attendance-reports.html"> Attendance Report </a></li>
                    <li><a href="leave-reports.html"> Leave Report </a></li>
                    <li><a href="daily-reports.html"> Daily Report </a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>Performance</span>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-laptop-medical"></i> <span> Performance </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="performance-indicator.html"> Performance Indicator </a></li>
                    <li><a href="performance.html"> Performance Review </a></li>
                    <li><a href="performance-appraisal.html"> Performance Appraisal </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="goal-tracking.html"> Goal List </a></li>
                    <li><a href="goal-type.html"> Goal Type </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-edit"></i> <span> Training </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="training.html"> Training List </a></li>
                    <li><a href="trainers.html"> Trainers</a></li>
                    <li><a href="training-type.html"> Training Type </a></li>
                </ul>
            </li>
            <li><a href="promotion.html"><i class="la la-bullhorn"></i> <span>Promotion</span></a></li>
            <li class="submenu">
                <a href="#"><i class="la la-external-link-square"></i> <span>Resignation</span><span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="resignation.html"> Resignation </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-user-times"></i> <span>Termination</span><span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="termination.html"> Termination </a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>Administration</span>
            </li>
            <li>
                <a href="assets.html"><i class="la la-object-ungroup"></i> <span>Assets</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-briefcase"></i> <span> Jobs </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="user-dashboard.html"> User Dasboard </a></li>
                    <li><a href="jobs-dashboard.html"> Jobs Dasboard </a></li>
                    <li><a href="jobs.html"> Manage Jobs </a></li>
                    <li><a href="manage-resumes.html"> Manage Resumes </a></li>
                    <li><a href="shortlist-candidates.html"> Shortlist Candidates </a></li>
                    <li><a href="interview-questions.html"> Interview Questions </a></li>
                    <li><a href="offer_approvals.html"> Offer Approvals </a></li>
                    <li><a href="experiance-level.html"> Experience Level </a></li>
                    <li><a href="candidates.html"> Candidates List </a></li>
                    <li><a href="schedule-timing.html"> Schedule timing </a></li>
                    <li><a href="apptitude-result.html"> Aptitude Results </a></li>
                </ul>
            </li>
            <li>
                <a href="knowledgebase.html"><i class="la la-question"></i> <span>Knowledgebase</span></a>
            </li>
            <li>
                <a href="users.html"><i class="la la-users-cog"></i> <span>Users</span></a>
            </li>
            <li>
                <a href="settings.html"><i class="la la-cog"></i> <span>Settings</span></a>
            </li>
            <li class="menu-title">
                <span>Pages</span>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-user-tag"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="profile.html"> Employee Profile </a></li>
                    <li><a href="client-profile.html"> Client Profile </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-key"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="index.html"> Login </a></li>
                    <li><a href="register.html"> Register </a></li>
                    <li><a href="forgot-password.html"> Forgot Password </a></li>
                    <li><a href="otp.html"> OTP </a></li>
                    <li><a href="lock-screen.html"> Lock Screen </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-exclamation-triangle"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="error-404.html">404 Error </a></li>
                    <li><a href="error-500.html">500 Error </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-history"></i> <span> Subscriptions </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="subscriptions.html"> Subscriptions (Admin) </a></li>
                    <li><a href="subscriptions-company.html"> Subscriptions (Company) </a></li>
                    <li><a href="subscribed-companies.html"> Subscribed Companies</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-columns"></i> <span> Pages </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="search.html"> Search </a></li>
                    <li><a href="faq.html"> FAQ </a></li>
                    <li><a href="terms.html"> Terms </a></li>
                    <li><a href="privacy-policy.html"> Privacy Policy </a></li>
                    <li><a href="blank-page.html"> Blank Page </a></li>
                    <li><a href="coming-soon.html"> Coming Soon </a></li>
                    <li><a href="under-maintenance.html"> Under Maintanance </a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>UI Interface</span>
            </li>
            <li class="submenu">
                <a href="#"><i class="lab la-uikit"></i> <span> Base UI </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="ui-alerts.html">Alerts</a></li>
                    <li><a href="ui-accordion.html">Accordion</a></li>
                    <li><a href="ui-avatar.html">Avatar</a></li>
                    <li><a href="ui-badges.html">Badges</a></li>
                    <li><a href="ui-borders.html">Border</a></li>
                    <li><a href="ui-buttons.html">Buttons</a></li>
                    <li><a href="ui-buttons-group.html">Button Group</a></li>
                    <li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
                    <li><a href="ui-cards.html">Card</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                    <li><a href="ui-colors.html">Colors</a></li>
                    <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                    <li><a href="ui-grid.html">Grid</a></li>
                    <li><a href="ui-images.html">Images</a></li>
                    <li><a href="ui-lightbox.html">Lightbox</a></li>
                    <li><a href="ui-media.html">Media</a></li>
                    <li><a href="ui-modals.html">Modals</a></li>
                    <li><a href="ui-notification.html">Notification</a></li>
                    <li><a href="ui-offcanvas.html">Offcanvas</a></li>
                    <li><a href="ui-pagination.html">Pagination</a></li>
                    <li><a href="ui-popovers.html">Popovers</a></li>
                    <li><a href="ui-progress.html">Progress</a></li>
                    <li><a href="ui-placeholders.html">Placeholders</a></li>
                    <li><a href="ui-rangeslider.html">Range Slider</a></li>
                    <li><a href="ui-spinner.html">Spinner</a></li>
                    <li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
                    <li><a href="ui-nav-tabs.html">Tabs</a></li>
                    <li><a href="ui-toasts.html">Toasts</a></li>
                    <li><a href="ui-tooltips.html">Tooltips</a></li>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-video.html">Video</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-eject"></i> <span> Advanced UI </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="ui-ribbon.html">Ribbon</a></li>
                    <li><a href="ui-clipboard.html">Clipboard</a></li>
                    <li><a href="ui-drag-drop.html">Drag & Drop</a></li>
                    <li><a href="ui-rangeslider.html">Range Slider</a></li>
                    <li><a href="ui-rating.html">Rating</a></li>
                    <li><a href="ui-text-editor.html">Text Editor</a></li>
                    <li><a href="ui-counter.html">Counter</a></li>
                    <li><a href="ui-scrollbar.html">Scrollbar</a></li>
                    <li><a href="ui-stickynote.html">Sticky Note</a></li>
                    <li><a href="ui-timeline.html">Timeline</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-chart-line"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="chart-apex.html">Apex Charts</a></li>
                    <li><a href="chart-js.html">Chart Js</a></li>
                    <li><a href="chart-morris.html">Morris Charts</a></li>
                    <li><a href="chart-flot.html">Flot Charts</a></li>
                    <li><a href="chart-peity.html">Peity Charts</a></li>
                    <li><a href="chart-c3.html">C3 Charts</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-icons"></i> <span> Icons </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
                    <li><a href="icon-feather.html">Feather Icons</a></li>
                    <li><a href="icon-ionic.html">Ionic Icons</a></li>
                    <li><a href="icon-material.html">Material Icons</a></li>
                    <li><a href="icon-pe7.html">Pe7 Icons</a></li>
                    <li><a href="icon-simpleline.html">Simpleline Icons</a></li>
                    <li><a href="icon-themify.html">Themify Icons</a></li>
                    <li><a href="icon-weather.html">Weather Icons</a></li>
                    <li><a href="icon-typicon.html">Typicon Icons</a></li>
                    <li><a href="icon-flag.html">Flag Icons</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-wpforms"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
                    <li><a href="form-input-groups.html">Input Groups </a></li>
                    <li><a href="form-horizontal.html">Horizontal Form </a></li>
                    <li><a href="form-vertical.html"> Vertical Form </a></li>
                    <li><a href="form-mask.html"> Form Mask </a></li>
                    <li><a href="form-validation.html"> Form Validation </a></li>
                    <li><a href="form-select2.html">Form Select2 </a></li>
                    <li><a href="form-fileupload.html">File Upload </a></li>
                    <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                    <li><a href="form-wizard.html">Form Wizard</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="tables-basic.html">Basic Tables </a></li>
                    <li><a href="data-tables.html">Data Table </a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>Extras</span>
            </li>
            <li>
                <a href="#"><i class="la la-file-alt"></i> <span>Documentation</span></a>
            </li>
            <li>
                <a href="javascript:void(0);"><i class="la la-info"></i> <span>Change Log</span> <span class="badge badge-primary ms-auto">v4.0</span></a>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);"><i class="la la-level-up-alt"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
                <ul>
                    <li class="submenu">
                        <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="javascript:void(0);">Level 3</a></li>
                                    <li><a href="javascript:void(0);">Level 3</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);"> <span>Level 1</span></a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</div>
</div>
<!-- /Sidebar -->

<!-- Two Col Sidebar -->
<div class="two-col-bar" id="two-col-bar">
<div class="sidebar sidebar-twocol" id="navbar-nav">
    <div class="sidebar-left slimscroll">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-dashboard-tab" title="Dashboard" data-bs-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="true">
                <span class="material-icons-outlined">
                    home
                </span>
            </a>
            <a class="nav-link" id="v-pills-apps-tab" title="Apps" data-bs-toggle="pill" href="#v-pills-apps" role="tab" aria-controls="v-pills-apps" aria-selected="false">
                <span class="material-icons-outlined">
                    dashboard
                </span>
            </a>
            <a class="nav-link" id="v-pills-employees-tab" title="Employees" data-bs-toggle="pill" href="#v-pills-employees" role="tab" aria-controls="v-pills-employees" aria-selected="false">
                <span class="material-icons-outlined">
                    people
                </span>
            </a>
            <a class="nav-link" id="v-pills-clients-tab" title="Clients" data-bs-toggle="pill" href="#v-pills-clients" role="tab" aria-controls="v-pills-clients" aria-selected="false">
                <span class="material-icons-outlined">
                    person
                </span>
            </a>
            <a class="nav-link" id="v-pills-projects-tab" title="Projects" data-bs-toggle="pill" href="#v-pills-projects" role="tab" aria-controls="v-pills-projects" aria-selected="false">
                <span class="material-icons-outlined">
                    topic
                </span>
            </a>
            <a class="nav-link" id="v-pills-leads-tab" title="CRM" data-bs-toggle="pill" href="#v-pills-leads" role="tab" aria-controls="v-pills-leads" aria-selected="false">
                <span class="material-icons-outlined">
                    leaderboard
                </span>
            </a>
            <a class="nav-link" id="v-pills-tickets-tab" title="Tickets" data-bs-toggle="pill" href="#v-pills-tickets" role="tab" aria-controls="v-pills-tickets" aria-selected="false">
                <span class="material-icons-outlined">
                    confirmation_number
                </span>
            </a>
            <a class="nav-link" id="v-pills-sales-tab" title="Sales" data-bs-toggle="pill" href="#v-pills-sales" role="tab" aria-controls="v-pills-sales" aria-selected="false">
                <span class="material-icons-outlined">
                    shopping_bag
                </span>
            </a>
            <a class="nav-link" id="v-pills-accounting-tab" title="Accounting" data-bs-toggle="pill" href="#v-pills-accounting" role="tab" aria-controls="v-pills-accounting" aria-selected="false">
                <span class="material-icons-outlined">
                    account_balance_wallet
                </span>
            </a>
            <a class="nav-link" id="v-pills-payroll-tab" title="Payroll" data-bs-toggle="pill" href="#v-pills-payroll" role="tab" aria-controls="v-pills-payroll" aria-selected="false">
                <span class="material-icons-outlined">
                    request_quote
                </span>
            </a>
            <a class="nav-link" id="v-pills-policies-tab" title="Policies" data-bs-toggle="pill" href="#v-pills-policies" role="tab" aria-controls="v-pills-policies" aria-selected="false">
                <span class="material-icons-outlined">
                    verified_user
                </span>
            </a>
            <a class="nav-link" id="v-pills-reports-tab" title="Reports" data-bs-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">
                <span class="material-icons-outlined">
                    report_gmailerrorred
                </span>
            </a>
            <a class="nav-link" id="v-pills-performance-tab" title="Performance" data-bs-toggle="pill" href="#v-pills-performance" role="tab" aria-controls="v-pills-performance" aria-selected="false">
                <span class="material-icons-outlined">
                    shutter_speed
                </span>
            </a>
            <a class="nav-link" id="v-pills-goals-tab" title="Goals" data-bs-toggle="pill" href="#v-pills-goals" role="tab" aria-controls="v-pills-goals" aria-selected="false">
                <span class="material-icons-outlined">
                    track_changes
                </span>
            </a>
            <a class="nav-link" id="v-pills-training-tab" title="Training" data-bs-toggle="pill" href="#v-pills-training" role="tab" aria-controls="v-pills-training" aria-selected="false">
                <span class="material-icons-outlined">
                    checklist_rtl
                </span>
            </a>
            <a class="nav-link" id="v-pills-promotion-tab" title="Promotions" data-bs-toggle="pill" href="#v-pills-promotion" role="tab" aria-controls="v-pills-promotion" aria-selected="false">
                <span class="material-icons-outlined">
                    auto_graph
                </span>
            </a>
            <a class="nav-link" id="v-pills-resignation-tab" title="Resignation" data-bs-toggle="pill" href="#v-pills-resignation" role="tab" aria-controls="v-pills-resignation" aria-selected="false">
                <span class="material-icons-outlined">
                    do_not_disturb_alt
                </span>
            </a>
            <a class="nav-link" id="v-pills-termination-tab" title="Termination" data-bs-toggle="pill" href="#v-pills-termination" role="tab" aria-controls="v-pills-termination" aria-selected="false">
                <span class="material-icons-outlined">
                    indeterminate_check_box
                </span>
            </a>
            <a class="nav-link" id="v-pills-assets-tab" title="Assets" data-bs-toggle="pill" href="#v-pills-assets" role="tab" aria-controls="v-pills-assets" aria-selected="false">
                <span class="material-icons-outlined">
                    web_asset
                </span>
            </a>
            <a class="nav-link " id="v-pills-jobs-tab" title="Jobs" data-bs-toggle="pill" href="#v-pills-jobs" role="tab" aria-controls="v-pills-jobs" aria-selected="false">
                <span class="material-icons-outlined">
                    work_outline
                </span>
            </a>
            <a class="nav-link" id="v-pills-knowledgebase-tab" title="Knowledgebase" data-bs-toggle="pill" href="#v-pills-knowledgebase" role="tab" aria-controls="v-pills-knowledgebase" aria-selected="false">
                <span class="material-icons-outlined">
                    school
                </span>
            </a>
            <a class="nav-link" id="v-pills-activities-tab" title="Activities" data-bs-toggle="pill" href="#v-pills-activities" role="tab" aria-controls="v-pills-activities" aria-selected="false">
                <span class="material-icons-outlined">
                    toggle_off
                </span>
            </a>
            <a class="nav-link" id="v-pills-users-tab" title="Users" data-bs-toggle="pill" href="#v-pills-users" role="tab" aria-controls="v-pills-users" aria-selected="false">
                <span class="material-icons-outlined">
                    group_add
                </span>
            </a>
            <a class="nav-link" id="v-pills-settings-tab" title="Settings" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                <span class="material-icons-outlined">
                    settings
                </span>
            </a>
            <a class="nav-link" id="v-pills-profile-tab" title="Profile" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                <span class="material-icons-outlined">
                    manage_accounts
                </span>
            </a>
            <a class="nav-link" id="v-pills-authentication-tab" title="Authentication" data-bs-toggle="pill" href="#v-pills-authentication" role="tab" aria-controls="v-pills-authentication" aria-selected="false">
                <span class="material-icons-outlined">
                    perm_contact_calendar
                </span>
            </a>
            <a class="nav-link" id="v-pills-errorpages-tab" title="Error Pages" data-bs-toggle="pill" href="#v-pills-errorpages" role="tab" aria-controls="v-pills-errorpages" aria-selected="false">
                <span class="material-icons-outlined">
                    announcement
                </span>
            </a>
            <a class="nav-link" id="v-pills-subscriptions-tab" title="Subscriptions" data-bs-toggle="pill" href="#v-pills-subscriptions" role="tab" aria-controls="v-pills-subscriptions" aria-selected="false">
                <span class="material-icons-outlined">
                    loyalty
                </span>
            </a>
            <a class="nav-link" id="v-pills-pages-tab" title="Pages" data-bs-toggle="pill" href="#v-pills-pages" role="tab" aria-controls="v-pills-pages" aria-selected="false">
                <span class="material-icons-outlined">
                    layers
                </span>
            </a>
            <a class="nav-link" id="v-pills-baseui-tab" title="Base UI" data-bs-toggle="pill" href="#v-pills-baseui" role="tab" aria-controls="v-pills-baseui" aria-selected="false">
                <span class="material-icons-outlined">
                    foundation
                </span>
            </a>
            <a class="nav-link" id="v-pills-elements-tab" title="Advanced UI" data-bs-toggle="pill" href="#v-pills-elements" role="tab" aria-controls="v-pills-elements" aria-selected="false">
                <span class="material-icons-outlined">
                    bento
                </span>
            </a>
            <a class="nav-link" id="v-pills-charts-tab" title="Charts" data-bs-toggle="pill" href="#v-pills-charts" role="tab" aria-controls="v-pills-charts" aria-selected="false">
                <span class="material-icons-outlined">
                    bar_chart
                </span>
            </a>
            <a class="nav-link" id="v-pills-icons-tab" title="Icons" data-bs-toggle="pill" href="#v-pills-icons" role="tab" aria-controls="v-pills-icons" aria-selected="false">
                <span class="material-icons-outlined">
                    grading
                </span>
            </a>
            <a class="nav-link" id="v-pills-forms-tab" title="Forms" data-bs-toggle="pill" href="#v-pills-forms" role="tab" aria-controls="v-pills-forms" aria-selected="false">
                <span class="material-icons-outlined">
                    view_day
                </span>
            </a>
            <a class="nav-link" id="v-pills-tables-tab" title="Tables" data-bs-toggle="pill" href="#v-pills-tables" role="tab" aria-controls="v-pills-tables" aria-selected="false">
                <span class="material-icons-outlined">
                    table_rows
                </span>
            </a>
            <a class="nav-link" id="v-pills-documentation-tab" title="Documentation" data-bs-toggle="pill" href="#v-pills-documentation" role="tab" aria-controls="v-pills-documentation" aria-selected="false">
                <span class="material-icons-outlined">
                    description
                </span>
            </a>
            <a class="nav-link" id="v-pills-changelog-tab" title="Changelog" data-bs-toggle="pill" href="#v-pills-changelog" role="tab" aria-controls="v-pills-changelog" aria-selected="false">
                <span class="material-icons-outlined">
                    sync_alt
                </span>
            </a>
            <a class="nav-link" id="v-pills-multilevel-tab" title="Multilevel" data-bs-toggle="pill" href="#v-pills-multilevel" role="tab" aria-controls="v-pills-multilevel" aria-selected="false">
                <span class="material-icons-outlined">
                    library_add_check
                </span>
            </a>
        </div>
    </div>

    <div class="sidebar-right">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
                <p>Dashboard</p>
                <ul>
                    <li>
                        <a href="admin-dashboard.html" class="active">Admin Dashboard</a>
                    </li>
                    <li>
                        <a href="employee-dashboard.html">Employee Dashboard</a>
                    </li>
                    <li><a href="deals-dashboard.html">Deals Dashboard</a></li>
                    <li><a href="leads-dashboard.html">Leads Dashboard</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-apps" role="tabpanel" aria-labelledby="v-pills-apps-tab">
                <p>App</p>
                <ul>
                    <li>
                        <a href="chat.html">Chat</a>
                    </li>
                    <li class="sub-menu">
                        <a href="#">Calls <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="voice-call.html">Voice Call</a></li>
                            <li><a href="video-call.html">Video Call</a></li>
                            <li><a href="outgoing-call.html">Outgoing Call</a></li>
                            <li><a href="incoming-call.html">Incoming Call</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="calender.html">Calendar</a>
                    </li>
                    <li>
                        <a href="contacts.html">Contacts</a>
                    </li>
                    <li>
                        <a href="inbox.html">Email</a>
                    </li>
                    <li>
                        <a href="file-manager.html">File Manager</a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-employees" role="tabpanel" aria-labelledby="v-pills-employees-tab">
                <p>Employees</p>
                <ul>
                    <li><a href="employees.html">All Employees</a></li>
                    <li><a href="holidays.html">Holidays</a></li>
                    <li><a href="leaves.html">Leaves (Admin) <span class="badge rounded-pill bg-primary float-end">1</span></a></li>
                    <li><a href="leaves-employee.html">Leaves (Employee)</a></li>
                    <li><a href="leave-settings.html">Leave Settings</a></li>
                    <li><a href="attendance.html">Attendance (Admin)</a></li>
                    <li><a href="attendance-employee.html">Attendance (Employee)</a></li>
                    <li><a href="departments.html">Departments</a></li>
                    <li><a href="designations.html">Designations</a></li>
                    <li><a href="timesheet.html">Timesheet</a></li>
                    <li><a href="shift-scheduling.html">Shift & Schedule</a></li>
                    <li><a href="overtime.html">Overtime</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-clients" role="tabpanel" aria-labelledby="v-pills-clients-tab">
                <p>Clients</p>
                <ul>
                    <li><a href="clients.html">Clients</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-projects" role="tabpanel" aria-labelledby="v-pills-projects-tab">
                <p>Projects</p>
                <ul>
                    <li><a href="projects.html">Projects</a></li>
                    <li><a href="tasks.html">Tasks</a></li>
                    <li><a href="task-board.html">Task Board</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-leads" role="tabpanel" aria-labelledby="v-pills-leads-tab">
                <p>CRM</p>
                <ul>
                    <li>
                        <a href="contact-list.html"> Contacts</a>
                    </li>
                    <li>
                        <a href="companies.html">Companies</a>
                    </li>
                    <li>
                        <a href="deals.html">  Deals</a>
                    </li>
                    <li>
                        <a href="leads.html"> Leads </a>
                    </li>
                    <li>
                        <a href="pipeline.html">Pipeline </a>
                    </li>
                    <li>
                        <a href="analytics.html">Analytics</a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-tickets" role="tabpanel" aria-labelledby="v-pills-tickets-tab">
                <p>Tickets</p>
                <ul>
                    <li><a href="tickets.html">Tickets</a></li>
                    <li><a href="ticket-details.html">Ticket Details</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-sales" role="tabpanel" aria-labelledby="v-pills-sales-tab">
                <p>Sales</p>
                <ul>
                    <li><a href="estimates.html">Estimates</a></li>
                    <li><a href="invoices.html">Invoices</a></li>
                    <li><a href="payments.html">Payments</a></li>
                    <li><a href="expenses.html">Expenses</a></li>
                    <li><a href="provident-fund.html">Provident Fund</a></li>
                    <li><a href="taxes.html">Taxes</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-accounting" role="tabpanel" aria-labelledby="v-pills-accounting-tab">
                <p>Accounting</p>
                <ul>
                    <li><a href="categories.html">Categories</a></li>
                    <li><a href="budgets.html">Budgets</a></li>
                    <li><a href="budget-expenses.html">Budget Expenses</a></li>
                    <li><a href="budget-revenues.html">Budget Revenues</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-payroll" role="tabpanel" aria-labelledby="v-pills-payroll-tab">
                <p>Payroll</p>
                <ul>
                    <li><a href="salary.html"> Employee Salary </a></li>
                    <li><a href="salary-view.html"> Payslip </a></li>
                    <li><a href="payroll-items.html"> Payroll Items </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-policies" role="tabpanel" aria-labelledby="v-pills-policies-tab">
                <p>Policies</p>
                <ul>
                    <li><a href="policies.html"> Policies </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                <p>Reports</p>
                <ul>
                    <li><a href="expense-reports.html"> Expense Report </a></li>
                    <li><a href="invoice-reports.html"> Invoice Report </a></li>
                    <li><a href="payments-reports.html"> Payments Report </a></li>
                    <li><a href="project-reports.html"> Project Report </a></li>
                    <li><a href="task-reports.html"> Task Report </a></li>
                    <li><a href="user-reports.html"> User Report </a></li>
                    <li><a href="employee-reports.html"> Employee Report </a></li>
                    <li><a href="payslip-reports.html"> Payslip Report </a></li>
                    <li><a href="attendance-reports.html"> Attendance Report </a></li>
                    <li><a href="leave-reports.html"> Leave Report </a></li>
                    <li><a href="daily-reports.html"> Daily Report </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-performance" role="tabpanel" aria-labelledby="v-pills-performance-tab">
                <p>Performance</p>
                <ul>
                    <li><a href="performance-indicator.html"> Performance Indicator </a></li>
                    <li><a href="performance.html"> Performance Review </a></li>
                    <li><a href="performance-appraisal.html"> Performance Appraisal </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-goals" role="tabpanel" aria-labelledby="v-pills-goals-tab">
                <p>Goals</p>
                <ul>
                    <li><a href="goal-tracking.html"> Goal List </a></li>
                    <li><a href="goal-type.html"> Goal Type </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-training" role="tabpanel" aria-labelledby="v-pills-training-tab">
                <p>Training</p>
                <ul>
                    <li><a href="training.html"> Training List </a></li>
                    <li><a href="trainers.html"> Trainers</a></li>
                    <li><a href="training-type.html"> Training Type </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-promotion" role="tabpanel" aria-labelledby="v-pills-promotion-tab">
                <p>Promotion</p>
                <ul>
                    <li><a href="promotion.html"> Promotion </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-resignation" role="tabpanel" aria-labelledby="v-pills-resignation-tab">
                <p>Resignation</p>
                <ul>
                    <li><a href="resignation.html"> Resignation </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-termination" role="tabpanel" aria-labelledby="v-pills-termination-tab">
                <p>Termination</p>
                <ul>
                    <li><a href="termination.html"> Termination </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-assets" role="tabpanel" aria-labelledby="v-pills-assets-tab">
                <p>Assets</p>
                <ul>
                    <li><a href="assets.html"> Assets </a></li>
                </ul>
            </div>
            <div class="tab-pane fade " id="v-pills-jobs" role="tabpanel" aria-labelledby="v-pills-jobs-tab">
                <p>Jobs</p>
                <ul>
                    <li><a href="user-dashboard.html" class="active"> User Dasboard </a></li>
                    <li><a href="jobs-dashboard.html"> Jobs Dasboard </a></li>
                    <li><a href="jobs.html"> Manage Jobs </a></li>
                    <li><a href="job-applicants.html"> Applied Jobs </a></li>
                    <li><a href="manage-resumes.html"> Manage Resumes </a></li>
                    <li><a href="shortlist-candidates.html"> Shortlist Candidates </a></li>
                    <li><a href="interview-questions.html"> Interview Questions </a></li>
                    <li><a href="offer_approvals.html"> Offer Approvals </a></li>
                    <li><a href="experiance-level.html"> Experience Level </a></li>
                    <li><a href="candidates.html"> Candidates List </a></li>
                    <li><a href="schedule-timing.html"> Schedule timing </a></li>
                    <li><a href="apptitude-result.html"> Aptitude Results </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-knowledgebase" role="tabpanel" aria-labelledby="v-pills-knowledgebase-tab">
                <p>Knowledgebase</p>
                <ul>
                    <li><a href="knowledgebase.html"> Knowledgebase </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-activities" role="tabpanel" aria-labelledby="v-pills-activities-tab">
                <p>Activities</p>
                <ul>
                    <li><a href="activities.html"> Activities </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-activities-tab">
                <p>Users</p>
                <ul>
                    <li><a href="users.html"> Users </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                <p>Settings</p>
                <ul>
                    <li><a href="settings.html"> Settings </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <p>Profile</p>
                <ul>
                    <li><a href="profile.html"> Employee Profile </a></li>
                    <li><a href="client-profile.html"> Client Profile </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-authentication" role="tabpanel" aria-labelledby="v-pills-authentication-tab">
                <p>Authentication</p>
                <ul>
                    <li><a href="index.html"> Login </a></li>
                    <li><a href="register.html"> Register </a></li>
                    <li><a href="forgot-password.html"> Forgot Password </a></li>
                    <li><a href="otp.html"> OTP </a></li>
                    <li><a href="lock-screen.html"> Lock Screen </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-errorpages" role="tabpanel" aria-labelledby="v-pills-errorpages-tab">
                <p>Error Pages</p>
                <ul>
                    <li><a href="error-404.html">404 Error </a></li>
                    <li><a href="error-500.html">500 Error </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-subscriptions" role="tabpanel" aria-labelledby="v-pills-subscriptions-tab">
                <p>Subscriptions</p>
                <ul>
                    <li><a href="subscriptions.html"> Subscriptions (Admin) </a></li>
                    <li><a href="subscriptions-company.html"> Subscriptions (Company) </a></li>
                    <li><a href="subscribed-companies.html"> Subscribed Companies</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-pages" role="tabpanel" aria-labelledby="v-pills-pages-tab">
                <p>Pages</p>
                <ul>
                    <li><a href="search.html"> Search </a></li>
                    <li><a href="faq.html"> FAQ </a></li>
                    <li><a href="terms.html"> Terms </a></li>
                    <li><a href="privacy-policy.html"> Privacy Policy </a></li>
                    <li><a href="blank-page.html"> Blank Page </a></li>
                    <li><a href="coming-soon.html"> Coming Soon </a></li>
                    <li><a href="under-maintenance.html"> Under Maintanance </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-baseui" role="tabpanel" aria-labelledby="v-pills-baseui-tab">
                <p>Base UI</p>
                <ul>
                    <li><a href="ui-alerts.html">Alerts</a></li>
                    <li><a href="ui-accordion.html">Accordion</a></li>
                    <li><a href="ui-avatar.html">Avatar</a></li>
                    <li><a href="ui-badges.html">Badges</a></li>
                    <li><a href="ui-borders.html">Border</a></li>
                    <li><a href="ui-buttons.html">Buttons</a></li>
                    <li><a href="ui-buttons-group.html">Button Group</a></li>
                    <li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
                    <li><a href="ui-cards.html">Card</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                    <li><a href="ui-colors.html">Colors</a></li>
                    <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                    <li><a href="ui-grid.html">Grid</a></li>
                    <li><a href="ui-images.html">Images</a></li>
                    <li><a href="ui-lightbox.html">Lightbox</a></li>
                    <li><a href="ui-media.html">Media</a></li>
                    <li><a href="ui-modals.html">Modals</a></li>
                    <li><a href="ui-notification.html">Notification</a></li>
                    <li><a href="ui-offcanvas.html">Offcanvas</a></li>
                    <li><a href="ui-pagination.html">Pagination</a></li>
                    <li><a href="ui-popovers.html">Popovers</a></li>
                    <li><a href="ui-progress.html">Progress</a></li>
                    <li><a href="ui-placeholders.html">Placeholders</a></li>
                    <li><a href="ui-rangeslider.html">Range Slider</a></li>
                    <li><a href="ui-spinner.html">Spinner</a></li>
                    <li><a href="ui-sweetalerts.html">Sweet Alerts</a></li>
                    <li><a href="ui-nav-tabs.html">Tabs</a></li>
                    <li><a href="ui-toasts.html">Toasts</a></li>
                    <li><a href="ui-tooltips.html">Tooltips</a></li>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-video.html">Video</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-elements" role="tabpanel" aria-labelledby="v-pills-elements-tab">
                <p>Advanced UI</p>
                <ul>
                    <li><a href="ui-ribbon.html">Ribbon</a></li>
                    <li><a href="ui-clipboard.html">Clipboard</a></li>
                    <li><a href="ui-drag-drop.html">Drag & Drop</a></li>
                    <li><a href="ui-rangeslider.html">Range Slider</a></li>
                    <li><a href="ui-rating.html">Rating</a></li>
                    <li><a href="ui-text-editor.html">Text Editor</a></li>
                    <li><a href="ui-counter.html">Counter</a></li>
                    <li><a href="ui-scrollbar.html">Scrollbar</a></li>
                    <li><a href="ui-stickynote.html">Sticky Note</a></li>
                    <li><a href="ui-timeline.html">Timeline</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-charts" role="tabpanel" aria-labelledby="v-pills-charts-tab">
                <p>Charts</p>
                <ul>
                    <li><a href="chart-apex.html">Apex Charts</a></li>
                    <li><a href="chart-js.html">Chart Js</a></li>
                    <li><a href="chart-morris.html">Morris Charts</a></li>
                    <li><a href="chart-flot.html">Flot Charts</a></li>
                    <li><a href="chart-peity.html">Peity Charts</a></li>
                    <li><a href="chart-c3.html">C3 Charts</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-icons" role="tabpanel" aria-labelledby="v-pills-icons-tab">
                <p>Icons</p>
                <ul>
                    <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
                    <li><a href="icon-feather.html">Feather Icons</a></li>
                    <li><a href="icon-ionic.html">Ionic Icons</a></li>
                    <li><a href="icon-material.html">Material Icons</a></li>
                    <li><a href="icon-pe7.html">Pe7 Icons</a></li>
                    <li><a href="icon-simpleline.html">Simpleline Icons</a></li>
                    <li><a href="icon-themify.html">Themify Icons</a></li>
                    <li><a href="icon-weather.html">Weather Icons</a></li>
                    <li><a href="icon-typicon.html">Typicon Icons</a></li>
                    <li><a href="icon-flag.html">Flag Icons</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-forms" role="tabpanel" aria-labelledby="v-pills-forms-tab">
                <p>Forms</p>
                <ul>
                    <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
                    <li><a href="form-input-groups.html">Input Groups </a></li>
                    <li><a href="form-horizontal.html">Horizontal Form </a></li>
                    <li><a href="form-vertical.html"> Vertical Form </a></li>
                    <li><a href="form-mask.html"> Form Mask </a></li>
                    <li><a href="form-validation.html"> Form Validation </a></li>
                    <li><a href="form-select2.html">Form Select2 </a></li>
                    <li><a href="form-fileupload.html">File Upload </a></li>
                    <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                    <li><a href="form-wizard.html">Form Wizard</a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-tables" role="tabpanel" aria-labelledby="v-pills-tables-tab">
                <p>Tables</p>
                <ul>
                    <li><a href="tables-basic.html">Basic Tables </a></li>
                    <li><a href="data-tables.html">Data Table </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-documentation" role="tabpanel" aria-labelledby="v-pills-documentation-tab">
                <p>Documentation</p>
                <ul>
                    <li><a href="#">Documentation </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-changelog" role="tabpanel" aria-labelledby="v-pills-changelog-tab">
                <p>Change Log</p>
                <ul>
                    <li><a href="#"><span>Change Log</span> <span class="badge badge-primary ms-auto">v4.0</span> </a></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="v-pills-multilevel" role="tabpanel" aria-labelledby="v-pills-multilevel-tab">
                <p>Multi Level</p>
                <ul>
                    <li class="sub-menu">
                        <a href="javascript:void(0);">Level 1 <span class="menu-arrow"></span></a>
                        <ul class="ms-3">
                            <li class="sub-menu">
                                <a href="javascript:void(0);">Level 1 <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="javascript:void(0);">Level 2</a></li>
                                    <li><a href="javascript:void(0);">Level 3</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);">Level 2</a></li>
                    <li><a href="javascript:void(0);">Level 3</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /Two Col Sidebar -->
