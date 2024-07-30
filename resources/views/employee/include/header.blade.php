<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header">
				
				<a href="{{url('employerdashboard')}}" class="logo">
					
					<!--<img src="assets/img/logo.svg" alt="navbar brand" class="navbar-brand">-->
					<h2 style="margin-top:2px;color:#1572e8"><img src="{{ asset('img/logo.png')}}" alt="" width="150px"></h2>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
					
<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fas fa-ellipsis-v"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						
<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
				
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
							<li><a data-toggle="tooltip" data-placement="bottom" title="Main Dashboard" href="{{url('employerdashboard')}}"><img src="{{ asset('assets/img/home.png')}}" alt="" style="width: 19px;
   "></a></li>
    
    <li><a data-toggle="tooltip" data-placement="bottom" title="Employee Dashboard" href="{{url('employee/dashboard')}}"><img src="{{ asset('assets/img/dashboard.png')}}" alt="" style="width: 19px;
   "></a></li>
   
   	<li>
                        @if(Session::get('admin_userp_user_type')=='user')
							<a href="{{url('mainuesrLogout')}}" data-toggle="tooltip" data-placement="bottom" title="Logout"><img src="{{ asset('assets/img/logout.png')}}" alt="" width="19">
							
						</a>
                     @else
                     <a href="{{url('mainLogout')}}" data-toggle="tooltip" data-placement="bottom" title="Logout"><img src="{{ asset('assets/img/logout.png')}}" alt="" width="19"></a>
                     @endif
					</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>