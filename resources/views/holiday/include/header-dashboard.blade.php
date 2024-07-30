<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">
				
				<a href="{{url('employerdashboard')}}" class="logo">
					
					<!--<img src="assets/img/logo.svg" alt="navbar brand" class="navbar-brand">-->
					<h2 style="margin-top:5px;color:#1572e8"><img src="{{ asset('img/logo.png')}}" alt="" width="170"></h2>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
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
						<li><a href="{{url('employerdashboard')}}" data-toggle="tooltip" data-placement="bottom" title="Main Dashboard"><img src="{{ asset('assets/img/home.png')}}" alt="" style="width: 19px;
    "></a></li>
	<li><a href="{{url('holidaydashboard')}}" data-toggle="tooltip" data-placement="bottom" title="Holiday Dashboard"><img src="{{ asset('assets/img/dashboard.png')}}" alt="" width="19"></a></i>

						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<!-- <div class="avatar-sm">
										<img src="{{ asset('assets/img/profile.png')}}" class="avatar-img rounded-circle">
								</div> -->
								<a href="{{url('mainLogout')}}" data-toggle="tooltip" data-placement="bottom" title="Logout"><img src="{{ asset('assets/img/logout.png')}}" alt="" width="19"> 
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									
									<li>
										
										<a class="dropdown-item" href="{{url('employerdashboard')}}">Dashboard</a>
										
										@if(Session::get('admin_userp_user_type')=='user')
										<a class="dropdown-item" href="{{url('mainuesrLogout')}}">Logout</a>
											@else
											<a class="dropdown-item" href="{{url('mainLogout')}}">Logout</a>
												@endif
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>