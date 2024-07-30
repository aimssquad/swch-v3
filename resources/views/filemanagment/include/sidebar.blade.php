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
					  File Management
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
            // dd($arrrole);
			 }


			 ?>
		  <ul class="nav nav-primary">
			 <li class="nav-item @if (Request::Segment(2)=='dashboard') active @endif">
				<a href="{{url('fileManagment/dashboard')}}">
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
			 <li class="nav-item @if (Request::Segment(2)=='fileManagment')  @endif">
				<a data-toggle="collapse" href="#sidebarLayouts">
				   <i class="fas fa-user"></i>
				   <p>File Management </p>
				   <span class="caret"></span>
				</a>
				<div class="collapse" id="sidebarLayouts">
				   <ul class="nav nav-collapse">
					<?php
					if( $usetype=='employee'){
					if(in_array('79', $arrrole))
					{

					?>
				 <!-- <li class="@if (Request::Segment(2)=='file-devision-list') active @endif">
					<a href="{{url('fileManagment/file-devision-list')}}">
					<span class="sub-item">File Division</span>
					</a>
				 </li> -->
				 <?php
					}else{
					?>
					<!-- <li class="@if (Request::Segment(2)=='file-devision-list') active @endif">
					<a href="{{url('fileManagment/file-devision-list')}}">
					<span class="sub-item">File Division</span>
					</a>
				 </li> -->
				 <?php
					}
						}else{
						?>
				 <li class="@if (Request::Segment(2)=='file-devision-list') active @endif">
					<a href="{{url('fileManagment/file-devision-list')}}">
					<span class="sub-item">File Division</span>
					</a>
				 </li>
				 <?php
					}
					?>

					  <?php
					  if( $usetype=='employee'){
					  if(in_array('92', $arrrole))
					  {

					  ?>
				   <li class="@if (Request::Segment(2)=='fileManagmentList') active @endif">
                    <a href="{{url('fileManagment/fileManagmentList')}}">
					  <span class="sub-item">File Manager</span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='fileManagmentList') active @endif">
					  <a href="{{url('fileManagment/fileManagmentList')}}">
					  <span class="sub-item">File Manager</span>
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
