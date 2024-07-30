<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('empassets/img/profile.png')}}	" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>Employee
									
									<!--<span class="user-level">Employee</span>-->
									<!--<span class="caret"></span>-->
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									
								<li>
										<a href="{{url('mainLogout')}}">
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
							<a href="{{url('employee/dashboard')}}">
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
							<?php 
									
									if( $usetype=='employee'){
if(in_array('1', $arrrole))
{
	
	?><li class="nav-item">
							<a href="{{url('employees')}}">
								<i class="fas fa-layer-group"></i>
								<p>Employee</p>
								
							</a>
							
						</li>

				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li class="nav-item">
							<a href="{{url('employees')}}">
								<i class="fas fa-layer-group"></i>
								<p>Employee</p>
								
							</a>
							
						</li>
						
				<?php	
									}
									
?>
						
						
						
					
<?php 
									
									if( $usetype=='employee'){
if(in_array('76', $arrrole))
{
	
	?><li class="nav-item">
							<a href="{{url('employee/change-of-circumstances')}}">
								<i class="fas fa-layer-group"></i>
								<p>Change Of Circumstances</p>
								
							</a>
							
						</li>

				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li class="nav-item">
							<a href="{{url('employee/change-of-circumstances')}}">
								<i class="fas fa-layer-group"></i>
								<p>Change Of Circumstances</p>
								
							</a>
							
						</li>
						
				<?php	
									}
									
?>					
			<?php 
									
									if( $usetype=='employee'){
if(in_array('78', $arrrole))
{
	
	?><li class="nav-item">
							<a href="{{url('employee/contract-agreement')}}">
								<i class="fas fa-layer-group"></i>
								<p>Contract Agreement</p>
								
							</a>
							
						</li>

				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li class="nav-item">
							<a href="{{url('employee/contract-agreement')}}">
								<i class="fas fa-layer-group"></i>
								<p>Contract Agreement</p>
								
							</a>
							
						</li>
						
				<?php	
									}
									
?>
										
						
						
								
						
						
						
					</ul>
				</div>
			</div>
		</div>