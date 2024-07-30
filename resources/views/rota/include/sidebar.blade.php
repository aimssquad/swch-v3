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
									
									Rota
									
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
					</div><?php
							
						
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
							<a href="{{url('rotadashboard')}}">
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
						<!--<li class="nav-item">
							<a href="company.php">
								<i class="fas fa-layer-group"></i>
								<p>Company</p>
								
							</a>
							
						</li>-->
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-user"></i>
								<p>Time Shift Management </p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
									<?php 
									
									if( $usetype=='employee'){
if(in_array('67', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/shift-management')}}">
											<span class="sub-item">Shift Management</span>
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
										<a href="{{url('rota/shift-management')}}">
											<span class="sub-item">Shift Management</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>

<?php 
									
									if( $usetype=='employee'){
if(in_array('68', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/late-policy')}}">
											<span class="sub-item">Late Policy</span>
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
										<a href="{{url('rota/late-policy')}}">
											<span class="sub-item">Late Policy</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>


<?php 
									
									if( $usetype=='employee'){
if(in_array('69', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/offday')}}">
											<span class="sub-item">Day Off</span>
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
										<a href="{{url('rota/offday')}}">
											<span class="sub-item">Day Off</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>
<?php 
									
									if( $usetype=='employee'){
if(in_array('70', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/grace-period')}}">
											<span class="sub-item">Grace Period</span>
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
										<a href="{{url('rota/grace-period')}}">
											<span class="sub-item">Grace Period</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>

<?php 
									
									if( $usetype=='employee'){
if(in_array('71', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/duty-roster')}}">
											<span class="sub-item">Duty Roster</span>
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
										<a href="{{url('rota/duty-roster')}}">
											<span class="sub-item">Duty Roster</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>

								
								</ul>
							</div>
						</li>
						
						
						
						
						
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayoutsvis">
								<i class="fas fa-user"></i>
								<p>Visitor</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayoutsvis">
								<ul class="nav nav-collapse">
								    
								    
								    <?php 
									
									if( $usetype=='employee'){
if(in_array('80', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/visitor-link')}}">
											<span class="sub-item">Visitor Register Link </span>
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
										<a href="{{url('rota/visitor-link')}}">
											<span class="sub-item">Visitor Register Link </span>
										</a>
									</li>
	
						
				<?php	
									}
									
?>

		  
								    <?php 
									
									if( $usetype=='employee'){
if(in_array('81', $arrrole))
{
	
	?>	<li>
										<a href="{{url('rota/visitor-regis')}}">
											<span class="sub-item">Visitor Register</span>
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
										<a href="{{url('rota/visitor-regis')}}">
											<span class="sub-item">Visitor Register </span>
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