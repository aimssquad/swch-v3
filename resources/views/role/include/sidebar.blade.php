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
									User Access 
									<!--<span class="user-level">User Access</span>-->
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
						<li class="nav-item active">
							<a href="{{url('useraccessdashboard')}}">
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
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="far fa-user"></i>
								<p>Role Management</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
								<?php 
									
									if( $usetype=='employee'){
if(in_array('72', $arrrole))
{
	
	?>	<li>
										<a href="{{url('role/vw-users')}}">
											<span class="sub-item">User Configuration</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
<li>
										<a href="{{url('role/vw-users')}}">
											<span class="sub-item">User Configuration</span>
										</a>
									</li>
						
				<?php	
									}
									
?>

<?php 
									
									if( $usetype=='employee'){
if(in_array('73', $arrrole))
{
	
	?>	<li>
										<a href="{{url('role/view-users-role')}}">
											<span class="sub-item">Role Management</span>
										</a>
									</li>
									
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
<li>
										<a href="{{url('role/view-users-role')}}">
											<span class="sub-item">Role Management</span>
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