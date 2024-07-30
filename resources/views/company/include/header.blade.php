<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">
				
			
					<a href="{{url('settingdashboard')}}"  class="logo">
					<h2 style="margin-top:2px;color:#1572e8"><img src="{{ asset('img/logo.png')}}" alt="" width="178px"></h2>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
					<i class="fas fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="fas fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
					<!--<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>
					</div>-->
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li><a href="{{url('employerdashboard')}}" data-toggle="tooltip" data-placement="bottom" title="Main Dashboard"><img src="{{ asset('assets/img/home.png')}}" alt="" width="19"></a></li>

						<li><a href="{{url('companydashboard')}}" data-toggle="tooltip" data-placement="bottom" title="Internal User Rota Dashboard"><img src="{{ asset('assets/img/dashboard.png')}}" alt="" width="19"></a></i>
							
						</a></li>

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