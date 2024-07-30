<div class="sidebar sidebar-style-2">
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
	   <div class="sidebar-content">
		  <div class="user">
			 <div class="avatar-sm float-left mr-2">
				<img src="{{ asset('assets/img/profile.png')}}" alt="..." class="avatar-img rounded-circle">
			 </div>
			 <div class="info">
				<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
				   <span>
					  Attendance
					  <!--<span class="user-level">Attendance</span>-->
					  <!--<span class="caret"></span>-->
				   </span>
				</a>
				<div class="clearfix"></div>
				<div class="collapse in" id="collapseExample">
				   <ul class="nav">
					  <li>
						 @if(Session::get('admin_userp_user_type')=='user')
						 <a href="{{url('mainuesrLogout')}}">
						 @else
						 <a href="{{url('mainLogout')}}">
						 @endif
						 <span class="link-collapse">Logout</span>
						 </a>
					  </li>
				   </ul>
				</div>
			 </div>
		  </div>
		  <?php
			 $usetype = Session::get('user_type'); 
			 if( $usetype=='employee'){
			 $usemail = Session::get('user_email'); 
			 $users_id = Session::get('users_id'); 
			 $dtaem=DB::table('users')      
					  
					   ->where('id','=',$users_id) 
					   ->first();
			 $Roles_auth = DB::table('role_authorization')      
						->where('emid','=',$dtaem->emid) 
					   ->where('member_id','=',$dtaem->email) 
					   ->get()->toArray();
			 $arrrole=array();
			 foreach($Roles_auth as $valrol){
			 $arrrole[]=$valrol->menu;
			 }	
			 
			 }
			 
			 
			 ?>
		  <ul class="nav nav-primary">
			 <li class="nav-item @if (Request::Segment(2)=='dashboard') active @endif">
				<a href="{{url('attendance/dashboard')}}">
				   <i class="fas fa-home"></i>
				   <p>Dashboard</p>
				</a>
			 </li>
			 <!--<li class="nav-item">
				<a href="company.php">
					<i class="fas fa-layer-group"></i>
					<p>Company</p>
					
				</a>
				
				</li>-->
			 <li class="nav-item @if (Request::Segment(2)=='add-montly-attendance-data-all') active @endif">
				<a data-toggle="collapse" href="#sidebarLayouts">
				   <i class="fas fa-user"></i>
				   <p>Attendance Management </p>
				   <span class="caret"></span>
				</a>
				<div class="collapse" id="sidebarLayouts">
				   <ul class="nav nav-collapse">
					<?php 
					if( $usetype=='employee'){
					if(in_array('79', $arrrole))
					{
					
					?>	
				 <li class="@if (Request::Segment(2)=='add-montly-attendance-data-all') active @endif">
					<a href="{{url('attendance/add-montly-attendance-data-all')}}">
					<span class="sub-item">Generate Attendance</span>
					</a>
				 </li>
				 <?php
					}else{
					?>
				 <?php
					}
						}else{
						?>
				 <li class="@if (Request::Segment(2)=='add-montly-attendance-data-all') active @endif">
					<a href="{{url('attendance/add-montly-attendance-data-all')}}">
					<span class="sub-item">Generate Attendance</span>
					</a>
				 </li>
				 <?php	
					}
					?>
					  <?php 
					  if( $usetype=='employee'){
					  if(in_array('79', $arrrole))
					  {
					  
					  ?>	
				   <li class="@if (Request::Segment(2)=='view-montly-attendance-data-all') active @endif">
					  <a href="{{url('attendance/view-montly-attendance-data-all')}}">
					  <span class="sub-item">Process Attendance</span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='view-montly-attendance-data-all') active @endif">
					  <a href="{{url('attendance/view-montly-attendance-data-all')}}">
					  <span class="sub-item">Process Attendance</span>
					  </a>
				   </li>
				   <?php	
					  }
					  ?>
				   </ul>
				</div>
			 </li>
			 <li class="nav-item @if (Request::Segment(2)=='report-monthly-attendance') active @endif">
				<a data-toggle="collapse" href="#sidebarReport">
				   <i class="fas fa-user"></i>
				   <p>Report Module </p>
				   <span class="caret"></span>
				</a>
				<div class="collapse" id="sidebarReport">
				   <ul class="nav nav-collapse">
					  <?php 
						 if( $usetype=='employee'){
						 if(in_array('79', $arrrole))
						 {
						 
						 ?>	
					  <li class="@if (Request::Segment(2)=='report-monthly-attendance') active @endif">
						 <a href="{{url('attendance/report-monthly-attendance')}}">
						 <span class="sub-item">View Attendance</span>
						 </a>
					  </li>
					  <?php
						 }else{
						 ?>
					  <?php
						 }
							 }else{
							 ?>
					  <li class="@if (Request::Segment(2)=='report-monthly-attendance') active @endif">
						 <a href="{{url('attendance/report-monthly-attendance')}}">
						 <span class="sub-item">View Attendance</span>
						 </a>
					  </li>
					  <?php	
						 }
						 ?>
				   </ul>
				</div>
			 </li>
		  </ul>
	   </div>
	</div>
 </div>