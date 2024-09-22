<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                <li class="menu-title"> 
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dashcube"></i> <span> Sub Admin Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('superadmindasboard')}}">Sub Admin Dashboard</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cube"></i> <span> Organisation</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('superadmin/active')}}">Active Organisation</a></li>
                        <li><a href="{{url('superadmin/notverify')}}">Not Verified Organisation</a></li>
                        <li><a href="{{url('superadmin/verify')}}">Verified Organisation</a></li>
                    </ul>
                </li>
                <li class="menu-title"> 
                    <span>Billing</span>
                </li>
                <li class="submenu">
                    <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Billing</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('superadmin/taxforbill')}}">Tax Master</a></li>
                        <li><a href="{{url('superadmin/billing')}}">Billing</a></li>
                        <li><a href="{{url('superadmin/payment-received')}}">Payment Received</a></li>
                        <li><a href="{{url('superadmin/billing-report')}}">Report</a></li>
                        <li><a href="{{url('superadmin/billing-search')}}">Billing Search</a></li>
                        <li><a href="{{url('superadmin/payment-search')}}">Payment Received Search</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>